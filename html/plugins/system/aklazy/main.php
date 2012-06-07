<?php
/*
 *  Akeeba Backup Lazy Scheduling
 *  Copyright (C) 2010  Nicholas K. Dionysopoulos / AkeebaBackup.com
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 *  Thank you notice:
 *  Many thanks to Jean-Sebastien Gervais of LazyBackup.net for proving that
 *  backup triggered by visitor activity is possible, essentially inspiring the
 *  functionality of this plugin.
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class plgSystemAklazy extends JPlugin
{
	/** @var string A nonce (token) to validate requests */
	private $nonce = null;

	private $locked = 0;

	private $tstamp = 0;

	/** @var bool Did the last backup crash? */
	private $isCrashed = false;

	private $debugInfo = '';

	public function __construct(& $subject, $config = array())
	{
		// Use the parent constructor to create the plugin object
		parent::__construct($subject, $config);

		// Check if we have to disable ourself
		$akreset = JRequest::getCmd('akreset','');
		$defaultpw = $this->params->get('resetpw','');
		if( ($akreset == $defaultpw) && !empty($defaultpw) )
		{
			// Disable the plugin
			$db = JFactory::getDBO();

			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
				$sql = 'UPDATE `#__extensions` SET `enabled` = 0 WHERE `type` = \'plugin\' AND `element` = \'aklazy\'';
			} else {
				$sql = 'UPDATE #__plugins SET `published` = 0 WHERE `element` = \'aklazy\'';
			}
			$db->setQuery($sql);
			$db->query();

			// Load the configuration
			$profile = (int)$this->params->get('profile',1);
			if($profile <= 0) $profile = 1;
			$session =& JFactory::getSession();
			$session->set('profile', $profile, 'akeeba');
			AEPlatform::load_configuration($profile);

			// Remove the log files
			$logfile = AEUtilLogger::logName(null);
			@unlink($logfile);
			AEUtilLogger::ResetLog('lazy');
			
			// Clear lock
			$this->unsetLock();
			$this->unsetNonce();

			// Reset pending backups
			AECoreKettenrad::reset();

			// Redirect
			$app = JFactory::getApplication();
			$app->redirect('index.php');

			return;
		}

		// Hijack the application to do the backup steps if aklazy and nonce
		// params are defined in the URL query
		$aklazy = JRequest::getCmd('aklazy',null);
		$nonce = JRequest::getCmd('nonce',null);

		// Load the settings
		$profile = (int)$this->params->get('profile',1);
		if($profile <= 0) $profile = 1;
		AEPlatform::load_configuration($profile);
		$config = AEFactory::getConfiguration();
		$this->locked = $config->get('lazy.lock.status', 0);
		$this->tstamp = $config->get('lazy.lock.stamp', 0);
		$this->nonce = $config->get('lazy.nonce', null);

		// When aklazy is 'check', it returns a backup URL, or dies if there's
		// no need to start/step a backup.
		if( ($aklazy == 'check') )
		{
			// Do a backup necessity check and return a URL or nothing at all
			$state = $this->getBackupState();
			if($state != 'none')
			{
				$url = JURI::base().'index.php?aklazy='.$state.'&nonce='.$this->nonce;
			}
			else
			{
				$url = '';
			}
			@ob_end_clean(); // Just in case...
			echo('###'.$url.'###');
			die();
		}

		if( (in_array($aklazy, array('start','step','ajaxstart','ajaxstep'))) && !empty($nonce) )
		{
			// Make sure we're not locked
			if($this->isLocked()) return;

			// Get the saved nonce and compare it to the one in the URL
			$this->getNonce();
			if(empty($this->nonce)) return;
			if($this->nonce != $nonce) return;

			// Lock the backup process
			if($this->isLocked()) return;
			$this->setLock();

			// Update the nonce
			$this->setNonce();

			// Try to convince PHP to not abort the request when the user is disconnected
			if(function_exists('ignore_user_abort')) {
				ignore_user_abort(true);
			}

			// Define the basic constants for the Akeeba Engine
			if(!defined('AKEEBA_BACKUP_ORIGIN')) {
				define('AKEEBA_BACKUP_ORIGIN','lazy'); // Set the backup origin
			}
			if(!defined('AKEEBAENGINE')) {
				define('AKEEBAENGINE', 1); // Required for accessing Akeeba Engine's factory class
				define('AKEEBAPLATFORM', 'joomla15'); // So that platform-specific stuff can get done!
			}
			// Load the Akeeba Engine factory
			require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php';

			// Load the language files
			$jlang =& JFactory::getLanguage();
			$jlang->load('com_akeeba', JPATH_SITE, 'en-GB', true);
			$jlang->load('com_akeeba', JPATH_SITE, $jlang->getDefault(), true);
			$jlang->load('com_akeeba', JPATH_SITE, null, true);
			$jlang->load('com_akeeba', JPATH_ADMINISTRATOR, 'en-GB', true);
			$jlang->load('com_akeeba', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
			$jlang->load('com_akeeba', JPATH_ADMINISTRATOR, null, true);

			// Set the profile and load the configuration
			$profile = (int)$this->params->get('profile',1);
			if($profile <= 0) $profile = 1;
			$session =& JFactory::getSession();
			$session->set('profile', $profile, 'akeeba');
			AEPlatform::load_configuration($profile);

			$isDone = false;
			register_shutdown_function('AkeebaBackupLazyShutdown');
			if(in_array($aklazy,array('start','ajaxstart')))
			{
				// Start a new backup
				AECoreKettenrad::reset();
				$kettenrad =& AECoreKettenrad::load(AKEEBA_BACKUP_ORIGIN);
				$user =& JFactory::getUser();
				$userTZ = $user->getParam('timezone',0);
				$dateNow = new JDate();
				$dateNow->setOffset($userTZ);
				if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
					$description = JText::_('BACKUP_DEFAULT_DESCRIPTION').' '.$dateNow->format(JText::_('DATE_FORMAT_LC2'), true);
				} else {
					$description = JText::_('BACKUP_DEFAULT_DESCRIPTION').' '.$dateNow->toFormat(JText::_('DATE_FORMAT_LC2'));
				}
				$options = array(
					'description'	=> $description,
					'comment'		=> ''
				);
				$kettenrad->setup($options);
				$array = $kettenrad->tick();
			}
			else
			{
				// Run a backup step
				$kettenrad =& AECoreKettenrad::load(AKEEBA_BACKUP_ORIGIN);
				$array = $kettenrad->tick();
			}
			AECoreKettenrad::save(AKEEBA_BACKUP_ORIGIN);

			// Parse the return array
			if($array['Error'] != '')
			{
				// An error occured. Reset the engine and unset the nonce.
				$this->unsetNonce();
				AECoreKettenrad::reset();
				$isDone = true;
			}
			elseif($array['HasRun'] == false)
			{
				// All done. Clean up and unset the nonce.
				$this->unsetNonce();
				AEFactory::nuke();
				AEUtilTempvars::reset();
				$isDone = true;
			}

			// Unlock the process
			$this->unsetLock();

			// Do we need to forward to the new step?
			if(in_array($aklazy, array('start','step')))
			{
				// IFRAME handling
				if(!$isDone)
				{
					$url = JURI::base().'index.php?aklazy=step&nonce='.$this->nonce;
					die("<html><head><meta http-equiv=\"refresh\" content=\"0;$url\" /></head><body></body></html>");
				}
			}
			else
			{
				if(!$isDone)
				{
					die('###'.$this->nonce.'###');
				}
			}

			// Stop processing
			die();
		}
	}

	/**
	 * Checks if it's necessary to add background backup code to the page
	 */
	function onAfterRender()
	{
		$caching = $this->getCachingState();

		$debug = '';
		$html = '';

		if($caching)
		{
			// If caching is enabled, use Javascript code
			$html = $this->getJavascript();
		}
		else
		{
			// If caching is disabled, create a hidden backup iFrame if we need
			// to start or continue a backup job
			$action = $this->getBackupState();
			if(JDEBUG) {
				$debug = '<pre style="background:white; color: black; border: thick solid red; margin: 2em;">'.$this->debugInfo.'</pre>';
			}
			if($action != 'none') {
				$url = JURI::base().'index.php?aklazy='.$action.'&nonce='.$this->nonce;
				$html = '<iframe src="'.$url.'" style="display:none;" width="0" height="0">&nbsp;</iframe>';
			}
		}

		if(empty($html) && empty($debug)) return;

		// Add the extra HTML to the page
		$buffer = JResponse::getBody();
		$pos = strpos($buffer, "</body>");
		if($pos > 0)
		{
			$buffer = substr($buffer, 0, $pos).$debug.$html.substr($buffer, $pos);
			JResponse::setBody($buffer);
		}
	}

	/**
	 * Returns the backup state ('none','start', or 'step')
	 */
	private function getBackupState()
	{
		$this->debugInfo = '<h6>Akeeba Backup Lazy Mode</h6><hr/>';
		// Make sure we're not locked
		if($this->isLocked()) {
			$this->debugInfo .= 'Backup locked';
			// If the backup has crashed, clean up
			if($this->isCrashed)
			{
				$this->debugInfo .= 'Crashed backup detected';
				AEFactory::nuke();
				AEUtilTempvars::reset();
				$this->unsetNonce();
				$this->unsetLock();
			}
			else
			{
				return 'none';
			}
		}

		// Is there a backup running?
		$this->getNonce();

		$action = empty($this->nonce) ? 'start' : 'step';
		$this->debugInfo .= '<br/>Action: '.$action;

		// If there is no running backup, try to figure out if we should start
		// a new backup.
		if($action == 'start')
		{
			// Get the last backup time
			$lastBackup = $this->getLastBackupTime();
			$this->debugInfo .= '<br/>Last backup: '.$lastBackup.' ('.date('Y/m/d H:i:s',$lastBackup).' GMT)';

			// Remove the time part of the backup time (we want the date starting at midnight!)
			$deconstructedDate = getdate($lastBackup);
			$lastBackup = mktime( 0,0,0, $deconstructedDate['mon'], $deconstructedDate['mday'], $deconstructedDate['year'] );
			$this->debugInfo .= '<br/>Adjusted last backup time: '.$lastBackup.' ('.date('Y/m/d H:i:s',$lastBackup).' GMT)';

			// Get the preferences and calculate the next backup time
			$daysfreq = (int)$this->params->get('daysfreq',1);
			if($daysfreq <= 0) $daysfreq = 1;
			$this->debugInfo .= '<br/>Days frequency: '.$daysfreq;
			$daysfreq *= 86400;
			$backuptime = $this->params->get('backuptime','00:00');
			$this->debugInfo .= '<br/>Backup time: '.$backuptime;

			$backuptime = trim($backuptime);
			$parts = explode(':',$backuptime);
			if(count($parts) != 2) {
				$backuptime = 0;
			} else {
				$hours = (int)$parts[0];
				$mins = (int)$parts[1];
				$backuptime = $hours * 3600 + $mins * 60;
			}
			$this->debugInfo .= ' ('.$backuptime.' seconds)';
			$nextBackup = $lastBackup + $daysfreq + $backuptime;
			$this->debugInfo .= '<br/>Next Backup: '.$nextBackup.' ('.date('Y/m/d H:i:s',$nextBackup).' GMT)';

			// The next backup time is in GMT. Convert to local.
			jimport('joomla.utilities.date');
			$date = new JDate($nextBackup, 0);
			$jreg =& JFactory::getConfig();
			$offset = $jreg->getValue('config.offset');
			$date->setOffset($offset);
			$nextBackup = $date->toUnix(true);

			$this->debugInfo .= '<br/>Next Backup: '.$nextBackup.' ('.date('Y/m/d H:i:s',$nextBackup).' LOCAL)';
			$this->debugInfo .= '<br/>Time Now: '.time().' ('.date('Y/m/d H:i:s').' LOCAL)';

			// Is it time for the next backup to run?
			if( time() < $nextBackup ) {
				$this->debugInfo .= '<br/>I will not start a new backup.';
			} else {
				$this->debugInfo .= '<br/><strong>Starting new backup.</strong>';
			}
			if( time() < $nextBackup ) return 'none';

			// Create a new nonce
			$this->setNonce();
		}

		return $action;
	}

	private function getCachingState()
	{
		// The exceptions to caching, as per plugins/system/cache.php
		if(defined(JDEBUG)) if(JDEBUG) return false;
		if (JFactory::getUser()->get('aid')) return false;
		if ($_SERVER['REQUEST_METHOD'] != 'GET') return false;

		// In any other case, caching is on if the cache plugin is on
		jimport('joomla.plugin.helper');
		return JPluginHelper::isEnabled('system','cache');
	}

	/**
	 * Creates a new nonce and saves it to the configuration
	 */
	private function setNonce()
	{
		jimport('joomla.user.helper');
		$nonce = JUserHelper::genRandomPassword(64);
		$this->nonce = $nonce;

		// Set the profile and load the configuration
		$profile = (int)$this->params->get('profile',1);
		if($profile <= 0) $profile = 1;
		AEPlatform::load_configuration($profile);
		$config = AEFactory::getConfiguration();
		$config->set('lazy.nonce', $this->nonce);
		AEPlatform::save_configuration($profile);
	}

	/**
	 * Read the nonce from the database file and set the object's property
	 */
	private function getNonce()
	{
		return $this->nonce;
	}

	/**
	 * Remove the old nonce
	 */
	private function unsetNonce()
	{
		// Set the profile and load the configuration
		$profile = (int)$this->params->get('profile',1);
		if($profile <= 0) $profile = 1;
		AEPlatform::load_configuration($profile);
		$config = AEFactory::getConfiguration();
		$config->set('lazy.nonce', null);
		AEPlatform::save_configuration($profile);
	}

	/**
	 * Checks if there is a lock record
	 * @return bool
	 */
	private function isLocked()
	{
		if($this->locked != 1) return false;

		if($this->tstamp != 0)
		{
			jimport('joomla.utilities.date');
			$date = new JDate();
			$now = $date->toUNIX();

			$diff = abs( $now - $this->tstamp );
			if($diff > 180)
			{
				$this->isCrashed = true;
			}
		}
		return true;
	}

	/**
	 * Removes a lock record
	 */
	private function unsetLock()
	{
		// Set the profile and load the configuration
		$profile = (int)$this->params->get('profile',1);
		if($profile <= 0) $profile = 1;
		AEPlatform::load_configuration($profile);
		$config = AEFactory::getConfiguration();
		$config->set('lazy.lock.status', 0);
		$config->set('lazy.lock.stamp', 0);
		AEPlatform::save_configuration($profile);
	}

	/**
	 * Creates a lock record
	 */
	private function setLock()
	{
		// Set the profile and load the configuration
		$profile = (int)$this->params->get('profile',1);
		if($profile <= 0) $profile = 1;
		AEPlatform::load_configuration($profile);
		$config = AEFactory::getConfiguration();

		jimport('joomla.filesystem.date');
		$date = new JDate();
		$tstamp = $date->toUnix();

		$config->set('lazy.lock.status', 1);
		$config->set('lazy.lock.stamp', $tstamp);
		AEPlatform::save_configuration($profile);

		$this->locked = 1;
		$this->tstamp = $tstamp;
	}

	/**
	 * When was the last backup time using this plugin?
	 * @return int The timestamp of the last backup
	 */
	private function getLastBackupTime()
	{
		// If we're in test mode, the last backup time is always 0, so as to
		// trigger a backup.
		if( $this->params->get('test',0) == 1 )
		{
			return 0;
		}

		$db = JFactory::getDBO();
		$sql = 'SELECT `backupstart` FROM `#__ak_stats` WHERE `origin` = "lazy" AND NOT(`status` = "failed") ORDER BY `backupstart` DESC LIMIT 0,1';
		$db->setQuery($sql);
		$tstamp = $db->loadResult();
		if(empty($tstamp)) return 0;

		jimport('joomla.utilities.date');
		$date = new JDate($tstamp);

		return $date->toUnix();
	}

	/**
	 * Get the Javascript to create the iFrame in the background, when page
	 * caching is enabled.
	 * @return string
	 */
	private function getJavascript()
	{
		$proxyurl = JURI::base().'index.php?aklazy=check';

		return <<<ENDJS
	<script type="text/javascript">
	function aklazyinit()
	{
		var xhr = undefined;
		if (typeof XMLHttpRequest == "undefined")
		{
			try { xhr = new ActiveXObject("Msxml2.XMLHTTP.6.0"); }
			  catch (e) {}
			if(xhr == 'undefined') try { xhr = ActiveXObject("Msxml2.XMLHTTP.3.0"); }
			  catch (e) {}
			if(xhr == 'undefined') try { xhr = new ActiveXObject("Msxml2.XMLHTTP"); }
			  catch (e) {}
		}
		else
		{
			xhr = new XMLHttpRequest();
			xhr.open('GET', '$proxyurl', true);
			xhr.onreadystatechange = function (aEvt) {
				if (xhr.readyState == 4) {
					if(xhr.status == 200)
					{
						var msg = xhr.responseText;

						// Start processing the message
						var junk = null;
						var message = "";

						// Get rid of junk before the data
						var valid_pos = msg.indexOf('###');
						if( valid_pos == -1 ) {
							return;
						} else if( valid_pos != 0 ) {
							// Data is prefixed with junk
							junk = msg.substr(0, valid_pos);
							message = msg.substr(valid_pos);
						}
						else
						{
							message = msg;
						}
						message = message.substr(3); // Remove triple hash in the beginning

						// Get of rid of junk after the data
						var valid_pos = message.lastIndexOf('###');
						if( valid_pos == -1 ) {
							return;
						} else if( valid_pos == 0 )
						{
							// No data
							return;
						}
						message = message.substr(0, valid_pos); // Remove triple hash in the end

						// Create the iFrame
						var iframe = document.createElement('iframe');
						iframe.setAttribute('width', '0');
						iframe.setAttribute('height', '0');
						iframe.setAttribute('src', message);
						document.body.appendChild(iframe);
					}
				}
			};
			xhr.send(null);
		}
	}
	window.onload=aklazyinit;
	</script>

ENDJS;
	}

}

function AkeebaBackupLazyShutdown()
{
	if(connection_status() >= CONNECTION_TIMEOUT )
	{
		// Oops! We timed out. Try to clean up.
		$this->unsetLock();
		$this->unsetNonce();
		AECoreKettenrad::reset();
	}
}