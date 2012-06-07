<?php
/**
 * Uninstallation File
 * Performs some extra tasks when uninstalling the component
 *
 * @package     ReReplacer
 * @version     2.13.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Delete plugin files and folders
$file = JPATH_PLUGINS.DS.'system'.DS.'rereplacer.php';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$file = JPATH_PLUGINS.DS.'system'.DS.'rereplacer.xml';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$folder = JPATH_PLUGINS.DS.'system'.DS.'rereplacer';
if( JFolder::exists( $folder ) ) {
	JFolder::delete( $folder );
}
$file = JPATH_PLUGINS.DS.'content'.DS.'rereplacer.php';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$file = JPATH_PLUGINS.DS.'content'.DS.'rereplacer.xml';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$folder = JPATH_PLUGINS.DS.'content'.DS.'rereplacer';
if( JFolder::exists( $folder ) ) {
	JFolder::delete( $folder );
}

// Delete plugin language files
$lang_folder = JPATH_ADMINISTRATOR.DS.'language';
$languages = JFolder::folders( $lang_folder );
foreach ( $languages as $lang ) {
	$file = $lang_folder.DS.$lang.DS.$lang.'.plg_system_rereplacer.ini';
	if( JFile::exists( $file ) ) {
		JFile::delete( $file );
	}
	$file = $lang_folder.DS.$lang.DS.$lang.'.plg_content_rereplacer.ini';
	if( JFile::exists( $file ) ) {
		JFile::delete( $file );
	}
}