<?php
/**
 * Joes Word Cloud Module Entry Point
 *
 * @package    Joes Joomla
 * @subpackage Modules
 * @link www.joellipman.com
 * @license        GNU GPL v3
 * Displays a cluster of the words from your Joomla! articles (core content not meta data).  What makes this one different to other module tag clouds is that this doesn\'t use tags or meta data and instead gets its words from your Joomla! articles.  Does not use any javascript or fancy effects so as to minimize any overheads in bandwidth and server interactions.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$hello = modJoesWordCloudHelper::getModuleContent( $params );
require( JModuleHelper::getLayoutPath( 'mod_joeswordcloud' ) );
?>
