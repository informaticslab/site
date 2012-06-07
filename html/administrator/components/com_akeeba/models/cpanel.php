<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: cpanel.php 271 2010-10-11 21:26:49Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');

/**
 * The Control Panel model
 *
 */
class AkeebaModelCpanel extends JModel
{
	/**
	 * Contructor; dummy for now
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get an array of icon definitions for the Control Panel
	 *
	 * @return array
	 */
	public function getIconDefinitions()
	{
		AEPlatform::load_version_defines();
		$core	= $this->loadIconDefinitions(JPATH_COMPONENT_ADMINISTRATOR.DS.'views');
		$pro	= $this->loadIconDefinitions(JPATH_COMPONENT_ADMINISTRATOR.DS.'plugins'.DS.'views');
		$ret = array_merge_recursive($core, $pro);

		return $ret;
	}

	private function loadIconDefinitions($path)
	{
		$ret = array();

		if(!@file_exists($path.DS.'views.ini')) return $ret;

		$ini_data = AEUtilINI::parse_ini_file($path.DS.'views.ini', true);
		if(!empty($ini_data))
		{
			foreach($ini_data as $view => $def)
			{
				$task = array_key_exists('task',$def) ? $def['task'] : null;
				$ret[$def['group']][] = $this->_makeIconDefinition($def['icon'], JText::_($def['label']), $view, $task);
			}
		}

		return $ret;
	}

	/**
	 * Returns a list of available backup profiles, to be consumed by JHTML in order to build
	 * a drop-down
	 *
	 * @return array
	 */
	public function getProfilesList()
	{
		$db =& $this->getDBO();
		$query = "SELECT ".$db->nameQuote('id').", ".$db->nameQuote('description').
				" FROM ".$db->nameQuote('#__ak_profiles').
				" ORDER BY ".$db->nameQuote('id')." ASC";
		$db->setQuery($query);
		$rawList = $db->loadAssocList();

		$options = array();
		if(!is_array($rawList)) return $options;

		foreach($rawList as $row)
		{
			$options[] = JHTML::_('select.option', $row['id'], $row['description']);
		}

		return $options;
	}

	/**
	 * Returns the active Profile ID
	 *
	 * @return int The active profile ID
	 */
	public function getProfileID()
	{
		$session =& JFactory::getSession();
		return $session->get('profile', null, 'akeeba');
	}

	/**
	 * Creates an icon definition entry
	 *
	 * @param string $iconFile The filename of the icon on the GUI button
	 * @param string $label The label below the GUI button
	 * @param string $view The view to fire up when the button is clicked
	 * @return array The icon definition array
	 */
	public function _makeIconDefinition($iconFile, $label, $view = null, $task = null )
	{
		return array(
			'icon'	=> $iconFile,
			'label'	=> $label,
			'view'	=> $view,
			'task'	=> $task
		);
	}

	/**
	 * Was the last backup a failed one? Used to apply magic settings as a means of
	 * troubleshooting.
	 *
	 * @return bool
	 */
	public function isLastBackupFailed()
	{
		// Get the last backup record ID
		$list = AEPlatform::get_statistics_list(0,1);
		if(empty($list)) return false;
		$id = $list[0];

		$statmodel->setId($id);
		$record = AEPlatform::get_statistics($id);

		return ($record['status'] == 'fail');
	}

	/**
	 * Checks that the media permissions are 0755 for directories and 0644 for files
	 * and fixes them if they are incorrect.
	 *
	 * @param $force	bool	Forcibly check subresources, even if the parent has correct permissions
	 *
	 * @return bool False if we couldn't figure out what's going on
	 */
	public function fixMediaPermissions($force = false)
	{
		// Are we on Windows?
		if (function_exists('php_uname'))
		{
			$isWindows = stristr(php_uname(), 'windows');
		}
		else
		{
			$isWindows = (DS == '\\');
		}

		// No point changing permissions on Windows, as they have ACLs
		if($isWindows) return true;

		// Check the parent permissions
		$parent = JPATH_ROOT.DS.'media'.DS.'com_akeeba';
		$parentPerms = fileperms($parent);

		// If we can't determine the parent's permissions, bail out
		if($parentPerms === false) return false;

		// Fix the parent's permissions if required
		if($parentPerms != 0755) {
			$this->chmod($parent, 0755);
		} else {
			if(!$force) return true;
		}

		// During development we use symlinks and we don't wanna see that big fat warning
		if(@is_link($parent)) return true;

		jimport('joomla.filesystem.folder');

		$result = true;

		// Loop through subdirectories
		$folders = JFolder::folders($parent,'.',3,true);
		foreach($folders as $folder) {
			$perms = fileperms($folder);
			if($perms != 0755) $result &= $this->chmod($folder, 0755);
		}

		// Loop through files
		$files = JFolder::files($parent,'.',3,true);
		foreach($files as $file) {
			$perms = fileperms($file);
			if($perms != 0755) $result &= $this->chmod($file, 0755);
		}

		return $result;
	}

	/**
	 * Tries to change a folder/file's permissions using direct access or FTP
	 *
	 * @param string	$path	The full path to the folder/file to chmod
	 * @param int		$mode	New permissions
	 */
	private function chmod($path, $mode)
	{
		if(is_string($mode))
		{
			$mode = octdec($mode);
			if( ($mode < 0600) || ($mode > 0777) ) $mode = 0755;
		}

		// Initialize variables
		jimport('joomla.client.helper');
		$ftpOptions = JClientHelper::getCredentials('ftp');

		// Check to make sure the path valid and clean
		$path = JPath::clean($path);

		if ($ftpOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = &JFTP::getInstance(
				$ftpOptions['host'], $ftpOptions['port'], null,
				$ftpOptions['user'], $ftpOptions['pass']
			);
		}

		if(@chmod($path, $mode))
		{
			$ret = true;
		} elseif ($ftpOptions['enabled'] == 1) {
			// Translate path and delete
			$path = JPath::clean(str_replace(JPATH_ROOT, $ftpOptions['root'], $path), '/');
			// FTP connector throws an error
			$ret = $ftp->chmod($path, $mode);
		} else {
			return false;
		}
	}

}