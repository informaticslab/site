<?php
/**
 * Element: License
 * Displays the License state
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * License Element
 *
 * Available extra parameters:
 * xml			The title
 * description		The description
 */
class JElementLicense extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'License';

	function fetchTooltip()
	{
		return;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$extension = $node->attributes( 'extension' );

		if( !strlen( $extension ) ) {
			return;
		}

		$html = '';
		// Import library dependencies
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'licenses.php';
		$licenses = NNLicenses::instance();

		return $licenses->getMessage( $extension );

	}
}

/* For backward compatibility */
if( !function_exists( 'NoNumber_License_outputState' ) ) {
	function NoNumber_License_outputState( $extension )
	{
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'licenses.php';
		$licenses = NNLicenses::instance();

		return $licenses->getMessage( $extension, 1 );
	}
}
if( !function_exists( 'NoNumber_License_getState' ) ) {
	function NoNumber_License_getState( $extension )
	{
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'licenses.php';
		$licenses = NNLicenses::instance();

		return $licenses->getState( $extension );
	}
}