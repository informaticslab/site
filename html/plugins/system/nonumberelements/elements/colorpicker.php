<?php
/**
 * Element: ColorPicker
 * Displays a textfield with a color picker
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
 * ColorPicker Element
 *
 * Available extra parameters:
 * title			The title
 */
class JElementColorPicker extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'ColorPicker';

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$document =& JFactory::getDocument();
		$document->addStyleSheet( JURI::root(true).'/plugins/system/nonumberelements/elements/colorpicker/js_color_picker_v2.css' );
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/elements/colorpicker/color_functions.js' );
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/elements/colorpicker/js_color_picker_v2.js' );

		$value = strtoupper( preg_replace( '#[^a-z0-9]#si', '', $value ) );
		$color = $value;
		if ( !$color ) {
			$color = 'DDDDDD';
		}

		$html = '# <input onclick="showColorPicker(this,this)" onchange="this.style.borderColor=\'#\'+this.value" style="border: 3px solid #'.$color.'" type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" class="nn_color" maxlength="6" size="8" />';

		return $html;
	}
}