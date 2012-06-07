<?php 
/********************************************************************
Copyright 2009-2010 Chris Gaebler
Version :	3.xx
Date    :	7 December 2010
Description:  A flexible contact component with configurable fields
Please see the pdf documentation at http://extensions.lesarbresdesign.info
*********************************************************************
This file is part of FlexiContact
FlexiContact is free software. You can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation.
*********************************************************************/
defined('_JEXEC') or die('Restricted Access'); 

define("LA_COMPONENT_VERSION", "3.14");
define("LA_COMPONENT", "com_flexicontact");
define("LA_COMPONENT_NAME", "FlexiContact");
define("LA_COMPONENT_LINK", "index.php?option=".LA_COMPONENT);

if (file_exists(JPATH_ROOT.DS.'LA.php'))
	require_once JPATH_ROOT.DS.'LA.php';

$webPath = JURI::root();						// Base path of site on the web
if ($webPath[strlen($webPath)-1] != '/')
	$webPath = $webPath.'/';					// $webPath now always ends with /
	
define ("WEB_PATH", $webPath);
define ("LOG_FILENAME", "flexicontact_log.txt");
define ("FILEPATH_LOG", '../components/com_flexicontact/'.LOG_FILENAME);
define ("FILEPATH_IMAGES", '../components/com_flexicontact/images/');

require_once(JApplicationHelper::getPath('admin_html'));

$task = JRequest::getCmd('task');

switch ($task)
	{
	case 'show_log':
		flexicontact_html::showLog();
		break;
		
	case 'delete_log':
		@unlink(FILEPATH_LOG);
		$mainframe->redirect(LA_COMPONENT_LINK);
		break;
		
	case 'delete_file':
		$file_name = JRequest::getVar('file_name');
		@unlink(FILEPATH_IMAGES.DS.$file_name);
		$task = 'manage_images';
		$mainframe->redirect(LA_COMPONENT_LINK."&task=images");
		break;
		
	case 'images':
		flexicontact_html::manageImages();
		break;
		
	case 'help':
	default:
		flexicontact_html::showHelpScreen();
	}

?>
