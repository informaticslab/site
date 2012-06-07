<?php
/**
 * Element: Custom Field Key
 * Displays a custom key field ( use in combination with customfieldvalue)
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
class JElementCustomFieldKey extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CustomFieldKey';

	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		return;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$size = ( $node->attributes( 'size' ) ? 'size="'.$node->attributes( 'size' ).'"' : '' );
		$class = ( $node->attributes( 'class' ) ? 'class="'.$node->attributes( 'class' ).'"' : 'class="text_area"' );
		$value = htmlspecialchars( html_entity_decode( $value, ENT_QUOTES), ENT_QUOTES );

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'functions.php';
		$this->functions =& NNFunctions::getFunctions();
		$mt_version = $this->functions->getJSVersion();

		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/js/script'.$mt_version.'.js' );

		$val_name = $control_name.str_replace( '_key', '_value', $name );
		$script = "
			window.addEvent( 'domready', function() {
				if ( $( 'span_".$val_name."' ) ) {
					$( 'span_".$control_name.$name."' ).injectInside( $( 'span_".$val_name."' ) );
				}
			});
		";
		$document->addScriptDeclaration( $script );

		$html =  '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
		$html .= '<span id="span_'.$control_name.$name.'">'.$html.'</span>';
		$random = rand( 100000, 999999 );
		$html .= '<div id="end-'.$random.'"></div><script type="text/javascript">NoNumberElementsHideTD( "end-'.$random.'" );</script>';
		return $html;
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}