<?php
/**
 * Element: Version
 * Displays the version check
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
 * Version Element
 *
 * Available extra parameters:
 * xml			The title
 * description		The description
 */
class JElementVersion extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Version';

	function fetchTooltip()
	{
		return;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$xml =			$node->attributes( 'xml' );
		$extension =	$node->attributes( 'extension' );

		$user = JFactory::getUser();

		if( !strlen( $extension ) || !strlen( $xml ) || ( $user->usertype != 'Super Administrator' && $user->usertype != 'Administrator' ) ) {
			return;
		}

		$html = '';

		// Import library dependencies
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
		$versions = NNVersions::instance();

		return $versions->getMessage( $extension, $xml );
	}
}