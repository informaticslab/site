<?php
/**
 * Main Administrator Component File
 * This defines what controller to use and what task to execute.
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

// Loads English language file as fallback (for undefined stuff in other language file)
$lang =& JFactory::getLanguage();
$lang->_load( JPATH_ADMINISTRATOR.DS.'language'.DS.'en-GB'.DS.'en-GB.com_rereplacer.ini', 'com_rereplacer', 0 );

jimport( 'joomla.filesystem.file' );

// return if NoNumber! Elemets plugin is not installed
if ( !JFile::exists( JPATH_PLUGINS.DS.'system'.DS.'nonumberelements.php' ) ) {
	$mainframe->_messageQueue = array();
	$mainframe->enqueueMessage( JText::_( 'RR_NONUMBER_ELEMENTS_PLUGIN_NOT_INSTALLED' ), 'error' );
	return;
}

// give notice if NoNumber! Elemets plugin is not enabled
$nnep = JPluginHelper::getPlugin( 'system', 'nonumberelements' );
if ( !isset( $nnep->name ) ) {
	$mainframe->_messageQueue = array();
	$mainframe->enqueueMessage( JText::_( 'RR_NONUMBER_ELEMENTS_PLUGIN_NOT_ENABLED' ), 'notice' );
}

// Dependency
require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'elements'.DS.'dependency.php';
JElementDependency::setMessage( '/plugins/system/rereplacer.php', 'RR_THE_SYSTEM_PLUGIN' );

// Version check
require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
$versions = NNVersions::instance();
$version = '';
$xml = JApplicationHelper::parseXMLInstallFile( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rereplacer'.DS.'com_rereplacer.xml' );
if ( $xml && isset( $xml['version'] ) ) {
	$version = $xml['version'];
}
$versions->setMessage( $version, 'version_rereplacer', 'http://www.nonumber.nl/versions', 'http://www.nonumber.nl/rereplacer/download' );

// If no controller then default controller = 'list'
$controller = JRequest::getCmd( 'controller', 'list' );

// Set the controller page
require_once JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

// Create the controller rereplacerController
$classname = 'ReReplacerController'.$controller;

// Create a new class of classname and set the default task: display
$controller = new $classname( array( 'default_task'=>'display' ) );

// Perform the Request task
$controller->execute( JRequest::getCmd( 'task' ) );

// Redirect if set by the controller
$controller->redirect();

// Place Commercial License Code check
require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'licenses.php';
$licenses = NNLicenses::instance();
echo $licenses->getMessage( 'ReReplacer' );

echo '<p style="text-align:center;">'.JText::_( 'REREPLACER' );
if ( $version ) {
	echo ' v'.$version;
}
echo ' - '.JText::_( 'COPYRIGHT' ).' (C) 2010 NoNumber! '.JText::_( 'ALL_RIGHTS_RESERVED' ).'</p>';