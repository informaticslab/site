<?php
/**
 * NoNumber! Elements Helper File: Functions
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Functions
*/

class NNFunctions
{
	function &getFunctions()
	{
		static $instance;
		if ( !is_object( $instance ) ) {
			$instance = new NoNumberElementsFunctions;
		}
		return $instance;
	}
}
class NoNumberElementsFunctions
{
	function getJSVersion()
	{
		if (	defined( 'JVERSION' )
			&&	version_compare( JVERSION, '1.5', '>=' )
			&&	version_compare( JVERSION, '1.6', '<' )
		) {
			$app = JFactory::getApplication();
			if ( $app->get( 'MooToolsVersion', '1.11' ) != '1.11' ) {
				return '_1.2';
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}
