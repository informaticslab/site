<?php
/**
 * Element: Custom Field Value
 * Displays a custom key field ( use in combination with customfieldkey)
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
 * Radio List Element
 */
class JElementCustomFieldValue extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CustomFieldValue';

	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		$html = '<span id="span_'.$control_name.$name.'"></span>';
		return $html;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$size = ( $node->attributes( 'size' ) ? 'size="'.$node->attributes( 'size' ).'"' : '' );
		$class = ( $node->attributes( 'class' ) ? 'class="'.$node->attributes( 'class' ).'"' : 'class="text_area"' );
		$value = htmlspecialchars( html_entity_decode( $value, ENT_QUOTES), ENT_QUOTES );

		return '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}