<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend Installer
 *
 * @version 2.1
 * @package JComments
 * @subpackage Installer
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'installer.php');

class JCommentsInstaller
{
	function postInstall()
	{
		global $mainframe;

		$db = & JCommentsFactory::getDBO();

		$installer = new HTML_JCommentsInstaller();

		JCommentsInstallerHelper::extractJCommentsPlugins();
		JCommentsInstallerHelper::setPermissions(JCOMMENTS_BASE.DS.'tpl', '0644');

		// create database tables
		if (JCOMMENTS_JVERSION == '1.0') {
			$installSQL = dirname(__FILE__).DS.'install'.DS.'sql'.DS.'install.mysql.nonutf8.sql';
			JCommentsInstaller::executeSQL($installSQL);
		} else if (JCOMMENTS_JVERSION == '1.5') {
			require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'filesystem.php');

			$config = & JFactory::getConfig();
			$mainframe = & JFactory::getApplication();

			if ($config->getValue('config.legacy')) {
				$installSQL = dirname(__FILE__).DS.'install'.DS.'sql'.DS.'install.mysql.utf8.sql';
				JCommentsInstaller::executeSQL($installSQL);

				// path to languages directory
				$path = JCOMMENTS_BASE.DS.'languages';
				$jpath = JPATH_ROOT.DS.'language';
				$languages = JoomlaTuneFS::readDirectory($path);

				if(!is_writable($jpath)) {
					@chmod($jpath, 0755);
				}

				foreach ($languages as $language) {
					if (preg_match('#[a-z]{2}\-[A-Z]{2}\.com_jcomments.ini#is', (string) $language)) {
						$languageCode = substr((string) $language, 0, 5);
						$languageDir = $jpath.DS.$languageCode;

						if (!is_dir($languageDir)) {
							if (!JFolder::create($languageDir)) {
								continue;
							}
						}

						if (is_dir($languageDir)) {
							@chmod($languageDir, 0755);
							$languageSrc = $path.DS.$language;
							$languageDestination = $languageDir.DS.$language;

							if (!(@copy($languageSrc, $languageDestination))) {
								$errorMessage = JText::sprintf('Unable to copy file %s to language folder. Please set write persmission to language folder (%s) and press the Refresh/Reload button of your browser.' , $language, $languageDir );
								$installer->addError($errorMessage);
								continue;
							}
						}
					}
				}
				unset($languages);

				$language = & JFactory::getLanguage();
				$language->load('com_jcomments', JPATH_SITE, null, true);
			}

			@ob_start();

			// install JomSocial Rule
			$jomSocialRuleSrc = dirname(__FILE__).DS.'install'.DS.'xml'.DS.'jomsocial_rule.xm';
			$jomSocialRuleDst = JCOMMENTS_BASE.DS.'jomsocial_rule.xml';
			if (!is_file($jomSocialRuleDst)) {
				JCommentsInstallerHelper::copyFile($jomSocialRuleSrc, $jomSocialRuleDst);
				JCommentsInstallerHelper::setPermissions($jomSocialRuleDst, 0755);
			}

			// remove language files
			$path = JCOMMENTS_BASE.DS.'languages';
			$filter = '\.ini';
			$files = JoomlaTuneFS::readDirectory($path, $filter, false, true);
			foreach($files as $file) {
				JCommentsInstallerHelper::deleteFile($file);
			}

			if (is_dir($path)) {
				JCommentsInstallerHelper::deleteFolder($path);
			}

			// remove plugins.zip
			if (is_file(JCOMMENTS_BASE.DS.'plugins'.DS.'plugins.zip')) {
				JCommentsInstallerHelper::deleteFile(JCOMMENTS_BASE.DS.'plugins'.DS.'plugins.zip');
			}

			@ob_end_clean();
		}

		$jxml10 = dirname(__FILE__).DS.'jcomments10.xml';
		$jxml15 = dirname(__FILE__).DS.'jcomments15.xml';
		$jxml = dirname(__FILE__).DS.'jcomments.xml';

		if (is_file($jxml10)) {
			@rename($jxml10, $jxml);
		} else if (is_file($jxml15)) {
			@rename($jxml15, $jxml);
		}
		unset($jxml10, $jxml15, $jxml);

		
		// small stuff for future update system
		$db->setQuery('SELECT `version` FROM `#__jcomments_version`');
		$version = $db->loadResult();

		$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
		$currentVersion = $versionInfo->releaseVersion;
		$currentDate = date('Y-m-d H:i:s');

		if (empty($version)) {
			$db->setQuery("INSERT IGNORE INTO `#__jcomments_version` (`version`,`installed`) VALUES ('$currentVersion', '$currentDate')");
			@$db->query();
			// if version isn't specified - we think that it was 1.4.0.9 or earlier...
			$version = '1.4.0.9';
		} else {
			$db->setQuery("UPDATE `#__jcomments_version` SET `version` = '$currentVersion', `updated` = '$currentDate';");
			@$db->query();
		}

		if (version_compare($version, '2.1.0.0') < 0) {
			JCommentsInstallerHelper::uninstallPlugin('jcomments.content', 'content');
			JCommentsInstallerHelper::uninstallPlugin('jcomments.search', 'search');
			JCommentsInstallerHelper::uninstallPlugin('jcomments.system', 'system');
		}

		// install content plugin
		JCommentsInstallerHelper::installPlugin(
			'Content - JComments', 
			'jcomments', 
			'content', 
			array(), 
			'AI_INSTALL_CONTENTBOT',
			'AI_INSTALL_CONTENTBOT_WARNING',
			1,
			$installer
		);

		// install search plugin
		JCommentsInstallerHelper::installPlugin(
			'Search - JComments', 
			'jcomments', 
			'search', 
			array(), 
			'AI_INSTALL_CONTENTSEARCHBOT',
			'AI_INSTALL_CONTENTSEARCHBOT_WARNING',
			1,
			$installer
		);

		// install system plugin
		JCommentsInstallerHelper::installPlugin(
			'System - JComments', 
			'jcomments', 
			'system', 
			array(), 
			'AI_INSTALL_SYSTEMBOT',
			'AI_INSTALL_SYSTEMBOT_WARNING',
			1,
			$installer
		);

		// install editor buttons
		JCommentsInstallerHelper::installPlugin(
			'Editor Button - JComments ON', 
			'jcommentson', 
			'editors-xtd', 
			array('jcommentson.gif'), 
			'',
			'',
			1,
			$installer
		);

		JCommentsInstallerHelper::installPlugin(
			'Editor Button - JComments OFF', 
			'jcommentsoff', 
			'editors-xtd', 
			array('jcommentsoff.gif'), 
			'',
			'',
			1,
			$installer
		);

		if (JCOMMENTS_JVERSION == '1.5') {
			// install user plugin
			JCommentsInstallerHelper::installPlugin(
				'User - JComments', 
				'jcomments', 
				'user', 
				array(), 
				'',
				'',
				1,
				$installer
			);
		}

		// Fix component menu icon
		if (JCOMMENTS_JVERSION == '1.0') {
			
			$menuiconpath = $mainframe->getCfg('absolute_path').DS.'includes'.DS.'js'.DS.'ThemeOffice';
			$adminIconsPath = '../administrator/components/com_jcomments/assets';
			
			if (is_writable($menuiconpath)) {
				$currentIconsPath = dirname(__FILE__).DS.'images';
				
				ob_start();
				$res1 = $res2 = $res3 = $res4 = $res5 = false;
				$res1 = @copy($currentIconsPath.DS.'jcomments16x16.png', $menuiconpath.DS.'jcomments16x16.png');
				$res2 = @copy($currentIconsPath.DS.'import16x16.png', $menuiconpath.DS.'import16x16.png');
				$res3 = @copy($currentIconsPath.DS.'settings16x16.png', $menuiconpath.DS.'settings16x16.png');
				$res4 = @copy($currentIconsPath.DS.'smiles16x16.png', $menuiconpath.DS.'smiles16x16.png');
				$res5 = @copy($currentIconsPath.DS.'comments16x16.png', $menuiconpath.DS.'comments16x16.png');
				$res6 = @copy($currentIconsPath.DS.'subscriptions16x16.png', $menuiconpath.DS.'subscriptions16x16.png');
				$res7 = @copy($currentIconsPath.DS.'custombbcodes16x16.png', $menuiconpath.DS.'custombbcodes16x16.png');
				ob_end_clean();
				
				$result = $res1 && $res2 && $res3 && $res4 && $res5 && $res6 && $res7;
				
				if ($result && is_file($menuiconpath.DS.'jcomments16x16.png')) {
					$adminIconsPath = 'js/ThemeOffice';
				}
			}
			
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/jcomments16x16.png' " . "\n WHERE admin_menu_link='option=com_jcomments'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/comments16x16.png', name='" . JText::_('AI_MENU_COMMENTS') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=comments'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/settings16x16.png', name='" . JText::_('AI_MENU_SETTINGS') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=settings'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/smiles16x16.png', name='" . JText::_('AI_MENU_SMILES') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=smiles'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/subscriptions16x16.png', name='" . JText::_('AI_MENU_SUBSCRIPTIONS') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=subscriptions'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/custombbcodes16x16.png', name='" . JText::_('Custom BBCode') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=custombbcodes'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/import16x16.png', name='" . JText::_('AI_MENU_IMPORT') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=import'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/jcomments16x16.png', name='" . JText::_('AI_MENU_ABOUT') . "'" . "\n WHERE admin_menu_link='option=com_jcomments&task=about'");
			@$db->query();
			
			// clear Joostina administrative menu cache
			if (function_exists('js_menu_cache_clear')) {
				@js_menu_cache_clear();
			}
		} else {
			$adminIconsPath = 'components/com_jcomments/assets';

			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/jcomments16x16.png' WHERE admin_menu_link='option=com_jcomments' OR admin_menu_link='option=com_jcomments&task=about'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/comments16x16.png' WHERE admin_menu_link='option=com_jcomments&task=comments'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/settings16x16.png' WHERE admin_menu_link='option=com_jcomments&task=settings'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/smiles16x16.png' WHERE admin_menu_link='option=com_jcomments&task=smiles'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/subscriptions16x16.png' WHERE admin_menu_link='option=com_jcomments&task=subscriptions'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/custombbcodes16x16.png' WHERE admin_menu_link='option=com_jcomments&task=custombbcodes'");
			@$db->query();
			$db->setQuery("UPDATE #__components SET admin_menu_img='$adminIconsPath/import16x16.png' WHERE admin_menu_link='option=com_jcomments&task=import'");
			@$db->query();
		}
		
		$installer->addMessage(JText::_('AI_UPDATE_MENU_ICONS'), true);
		
		
		// update db tables
		$dbStructureChanged = (version_compare($version, '2.2.0.0') <= 0);
		if ($dbStructureChanged) {
			require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'database.php');

			$upgradeStructure2000 = false;

			if ((version_compare($version, '2.0.0.0') < 0)) {
				// auto upgrade old table structure
				$upgradeStructure2000 = JCommentsInstallerDatabaseHelper::upgradeStructure();
			}

			$upgradeStructure2200 = JCommentsInstallerDatabaseHelper::upgradeStructure2200();
			if ($upgradeStructure2200) {
				// TODO upgrade tree structure during installation process
				// JCommentsInstallerDatabaseHelper::updateCommentsLevel();
				// JCommentsInstallerDatabaseHelper::updateCommentsPath();
			}

			if ($upgradeStructure2000 || $upgradeStructure2200) {
				$installer->addMessage(JText::_('AI_UPGRADE_TABLES'), true);
			}
		}

		// upgrade subscriptions to new comments
		$subscriptionsChanged = (version_compare($version, '2.1.0.0') < 0);
		if ($subscriptionsChanged) {
			$upgradeSubs = JCommentsInstaller::upgradeSubscriptions($version);
			if ($upgradeSubs) {
				$installer->addMessage(JText::_('Upgrade subscriptions'), true);
			}
		}

		// collation synchronization (for MySQL 4.1.2 or higher)
		if (version_compare(preg_replace('~\-.+?$~', '', $db->getVersion()), '4.1.2') >= 0) {
			require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'database.php');
			JCommentsInstallerDatabaseHelper::setupCollation();			
		}
		
		$db->setQuery("SELECT `name`, `value` FROM `#__jcomments_settings`");
		$paramsList = $db->loadObjectList('name');
		
		if (count($paramsList) == 0) {
			$defaultSettings = dirname(__FILE__).DS.'install'.DS.'sql'.DS.'settings.sql';
			JCommentsInstaller::executeSQL($defaultSettings);
		} else {
			JCommentsInstaller::checkParam($paramsList, 'comment_title', '0');
			JCommentsInstaller::checkParam($paramsList, 'enable_custom_bbcode', '0');
			JCommentsInstaller::checkParam($paramsList, 'enable_bbcode_quote', 'Unregistered,Registered,Author,Editor,Publisher,Manager,Administrator,Super Administrator');
			JCommentsInstaller::checkParam($paramsList, 'notification_type', '1,2');
			JCommentsInstaller::checkParam($paramsList, 'captcha_engine', 'kcaptcha');
			JCommentsInstaller::checkParam($paramsList, 'comment_minlength', '0');
		}
		
		unset($paramsList);
		
		$joomfish = $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
		if (is_file($joomfish)) {
			JCommentsInstaller::upgradeLanguages();
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			// Update Artio JoomSEF configuration (add option to skip JComments urls)
			JCommentsInstaller::updateArtio();
		}

		$db->setQuery("SELECT COUNT(*) FROM `#__jcomments_custom_bbcodes`;");
		$cnt = $db->loadResult();
		if ($cnt == 0) {
			$sql = dirname(__FILE__).DS.'install'.DS.'sql'.DS.'custom_bbcodes.sql';
			JCommentsInstaller::executeSQL($sql);
		}

		$installer->showInstallLog();
		
		JCommentsCache::cleanCache('com_jcomments');
	}

	function checkParam( $list, $param, $value, $required = false )
	{
		$dbo = & JCommentsFactory::getDBO();
		
		if (!isset($list[$param])) {
			$dbo->setQuery("INSERT INTO `#__jcomments_settings` VALUES ('', '', '$param', '$value');");
			@$dbo->query();
		} else if ($required && $list[$param]->value == '') {
			$dbo->setQuery("UPDATE `#__jcomments_settings` SET `value` = '$value' WHERE name = '$param';");
			@$dbo->query();
		}
	}

	function upgradeSubscriptions()
	{
		$dbo = & JCommentsFactory::getDBO();
		$dbo->setQuery("SELECT COUNT(*) FROM #__jcomments_subscriptions");
		$cnt = $dbo->loadResult();

		if ($cnt == 0) {
			$query = "INSERT INTO #__jcomments_subscriptions (`object_id`, `object_group`, `lang`, `userid`, `name`, `email`, `hash`, `published`)"
					. "\nSELECT DISTINCTROW `object_id`, `object_group`, `lang`, `userid`, `name`, `email`, md5(CONCAT(`object_id`,`object_group`,`email`)), 1"
					. "\nFROM #__jcomments"
					. "\nWHERE subscribe = 1"
					;
			$dbo->setQuery($query);
			$dbo->query();
			return true;
		} else {
			$query = 'UPDATE #__jcomments_subscriptions'
					. 'SET hash = MD5(CONCAT(CAST(object_id AS CHAR), object_group, CAST(userid AS CHAR), email, lang))';
			$dbo->query();
			return true;
		}
	}
	
	function upgradeLanguages()
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$languages = JLanguage::getKnownLanguages(JPATH_SITE);
			$dbo = & JCommentsFactory::getDBO();
			
			foreach ($languages as $language) {
				$backward = $language['backwardlang'];
				$tag = $language['tag'];
				
				if ($backward != '' && $tag != '') {
					$dbo->setQuery("UPDATE #__jcomments SET lang = '$tag' WHERE lang = '$backward'");
					$dbo->query();
				}
			}
		}
	}
	
	function updateArtio()
	{
		global $mainframe;

		ob_start();

		$result = false;

		$artioSefPath = $mainframe->getCfg('absolute_path').DS.'administrator'.DS.'components'.DS.'com_sef';
		$artioSefCfg = $artioSefPath.DS.'config.sef.php';
		$artioSefClass = $artioSefPath.DS.'sef.class.php';

		if (!is_file($artioSefCfg)) {
			$artioSefCfg = $artioSefPath.DS.'configuration.php';
			$artioSefClass = $artioSefPath.DS.'classes'.DS.'config.php';
		}

		if (is_file($artioSefCfg) && is_writable($artioSefCfg)) {
			global $sef_config_file;

			if (empty($sef_config_file)) {
				$sef_config_file = $artioSefCfg;
			}

			include_once($artioSefClass);

			if (class_exists('SEFConfig')) {
				$sefConfig = new SEFConfig();

				if (!in_array('com_jcomments', $sefConfig->skip)) {
					$sefConfig->skip[] = 'com_jcomments';
					$sefConfig->saveConfig(0, 1);
					$fn = dirname(__FILE__).DS.'configuration.php';
					if (is_file($fn)) {
						@rename($fn, $artioSefCfg);
					}
					$result = true;
				}
			}
		}

		ob_get_contents();
		ob_end_clean();

		return $result;
	}
	
	function executeSQL( $filename = '' )
	{
		if (is_file($filename)) {
			$buffer = file_get_contents($filename);
			
			if ($buffer === false) {
				return false;
			}
			
			$db = & JCommentsFactory::getDBO();
			
			$queries = JCommentsInstaller::splitSql($buffer);
			foreach ($queries as $query) {
				$query = trim((string) $query);
				if ($query != '') {
					$db->setQuery($query);
					@$db->query();
				}
			}
		}
		return true;
	}
	
	/**
	 * Splits a string of queries into an array of individual queries
	 *
	 * @access public
	 * @param string The queries to split
	 * @return array queries
	 */
	function splitSql( $queries )
	{
		$start = 0;
		$open = false;
		$open_char = '';
		$end = strlen($queries);
		$query_split = array();
		for ($i = 0; $i < $end; $i++) {
			$current = substr($queries, $i, 1);
			if (($current == '"' || $current == '\'')) {
				$n = 2;
				while (substr($queries, $i - $n + 1, 1) == '\\' && $n < $i) {
					$n++;
				}
				if ($n % 2 == 0) {
					if ($open) {
						if ($current == $open_char) {
							$open = false;
							$open_char = '';
						}
					} else {
						$open = true;
						$open_char = $current;
					}
				}
			}
			if (($current == ';' && !$open) || $i == $end - 1) {
				$query_split[] = substr($queries, $start, ($i - $start + 1));
				$start = $i + 1;
			}
		}
		
		return $query_split;
	}
}

class HTML_JCommentsInstaller
{
	var $releaseDate = null;
	var $releaseVersion = '2.0';
	var $messages = array();
	var $warnings = array();
	var $errors = array();

	function HTML_JCommentsInstaller()
	{
		$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
		$this->releaseDate = $versionInfo->releaseDate;
		$this->releaseVersion = $versionInfo->releaseVersion;
	}
	
	function addMessage( $message, $status = true )
	{
		$msg['text'] = $message;
		$msg['status'] = $status;
		$this->messages[] = $msg;
	}
	
	function addWarning( $message )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$message = str_replace('/mambots/', '/plugins/', $message);
		}
		
		$msg['text'] = $message;
		$this->warnings[] = $msg;
	}

	function addError( $message ) {
		$msg['text'] = $message;
		$this->errors[] = $msg;
	}

	function showInstallLog()
	{
		global $mainframe;

		if (JCOMMENTS_JVERSION == '1.5') {
			$mainframe = & JFactory::getApplication();
		}
?>
<script type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	submitform( pressbutton );
}
//-->
</script>
<link rel="stylesheet" href="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/assets/style.css" type="text/css" />

<div id="jc">

<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">


<table width="95%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top" align="left">
		<td width="50px"><img src="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/assets/jcomments48x48.png" border="0" alt="" /></td>
		<td><span class="componentname">JComments <?php echo $this->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $this->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-<?php echo date('Y'); ?> smart (<a href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br />
		</span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

<?php
		if (count($this->errors)) {
?>
<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('Errors'); ?></span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
<?php
			foreach($this->errors as $error) {
?>
		<li style="padding: 0 0 5px;"><span style="color: red; font-size: 12px;"><?php echo $error['text']; ?></span></li>
<?php
			}
?>
		</ul>
		</td>
	</tr>
<?php
        	} else {
			if (count($this->messages)) {
?>

<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('AI_LOG'); ?></span>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
<?php
				foreach($this->messages as $message) {
					$status_class = $message['status'] ? 'ok' : 'err';
					$status_text  = $message['status'] ? JText::_('AI_OK') : JText::_('AI_ERROR');
?>
			<li><?php echo $message['text']; ?>: <span
				class="status<?php echo $status_class; ?>"><?php echo $status_text; ?></span></li>
<?php
				}
?>
			<li><span class="statusok"><strong><?php echo JText::_('AI_INSTALLED'); ?></strong></span></li>
		</ul>
		</td>
	</tr>
<?php
        		}
			if (count($this->warnings)) {
?>
<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td><span class="installheader"><?php echo JText::_('AI_WARNINGS'); ?></span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
<?php
				foreach($this->warnings as $warning) {
?>
		<li style="padding: 0 0 5px;"><?php echo $warning['text']; ?></li>
<?php
				}
?>
		</ul>
		</td>
	</tr>
<?php
        		}
?>
<tr valign="top" align="right">
		<td></td>
		<td align="center" style="text-align: right;"><div class="button-left"><div class="next"><a href="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/<?php echo JCOMMENTS_INDEX; ?>?option=com_jcomments&task=settings"><?php echo JText::_('AI_NEXT'); ?></a></div></div></td>
</tr>
<?php
		}
?>

</table>

</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>

</div>

<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
<input type="hidden" name="option" value="com_jcomments" />
<input type="hidden" name="task" value="" />
</form>
<?php
	}
}
?>