<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend install handler
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

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

function com_install()
{
	if (defined('_JEXEC') && class_exists('JApplication')) {
		$config = &JFactory::getConfig();
		$config->setValue('config.live_site', substr_replace(JURI::root(), '', -1, 1));
		$url = JURI::root() . 'administrator/index.php?option=com_jcomments&task=postinstall';
	} else {
		global $mainframe;

		$msg = '';

		$componentPath = $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments';
		require_once ($componentPath.DS.'libraries'.DS.'joomlatune'.DS.'filesystem.php');
		require_once ($componentPath.DS.'jcomments.legacy.php');

		// install libraries for Joomla 1.0
		require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'installer.php');
		JCommentsInstallerHelper::extractJCommentsLibraryConvert();

		if (is_file($componentPath.DS.'libraries'.DS.'convert'.DS.'utf8.class.php')) {
		        // prepare language files
			require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'language.php');
			JCommentsInstallerLanguageHelper::convertLanguages();	
		} else {
			$msg = 'Error unpacking JCommentsUtf8 library!';
		}
		
		$url = $mainframe->getCfg('live_site') . '/administrator/index2.php?option=com_jcomments&task=postinstall';

		if ($msg != '') {
			$url = $url . '&mosmsg=' . $msg;
		}
	}

	if (headers_sent()) {
		echo ("<script>document.location.href='$url';</script>\n");
	} else {
		header('Location: ' . $url);
	}
}
?>