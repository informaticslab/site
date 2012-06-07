<?php
/**
 * Element: Checkbox
 * Displays options as checkboxes
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
 * Checkbox Element
 */
class JElementCheckbox extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Checkbox';

	function fetchElement( $name, $values, &$node, $control_name )
	{
		$newlines =			$this->def( $node->attributes( 'newlines' ), 0 );
		$showcheckall =		$this->def( $node->attributes( 'showcheckall' ), 0 );

		$checkall = ( $values == '*' );

		if ( !$checkall ) {
			if ( !is_array( $values ) ) {
				$values = explode( ',', $values );
			}
		}

		$options = array();
		foreach ( $node->children() as $option ) {
			$text = $option->data();
			if ( isset( $option->_attributes['value'] ) ) {
				$val		= $option->attributes( 'value' );
				$disabled	= $option->attributes( 'disabled' );
				$option = '<input type="checkbox" class="nn_'.$control_name.$name.'" id="'.$control_name.$name.$val.'" name="'.$control_name.'['.$name.'][]" value="'.$val.'"';
				if ( $checkall || in_array( $val, $values ) ) {
					$option .= ' checked="checked"';
				}
				if ( $disabled ) {
					$option .= ' disabled="disabled"';
				}
				$option .= ' /> '.JText::_( $text );
			} else {
				$option = '<strong>'.JText::_( $text ).'</strong>';
			}
			$options[] = $option;
		}

		if ( $newlines ) {
			$options = implode( '<br />', $options );
		} else {
			$options = implode( '&nbsp;&nbsp;&nbsp;', $options );
		}

		if ( $showcheckall ) {
			$checkers = array();
			if ( $showcheckall ) {
				$checkers[] = '<input id="nn_checkall_'.$control_name.$name.'" type="checkbox" onclick="NoNumberElementsCheckAll( this, \'nn_'.$control_name.$name.'\' );" /> '.JText::_( 'All' );

				$document =& JFactory::getDocument();
				$js = "
					window.addEvent('domready', function() {
						$('nn_checkall_".$control_name.$name."').checked = NoNumberElementsAllChecked( 'nn_".$control_name.$name."' );
					});
				";
				$document->addScriptDeclaration( $js );
			}
			$options = implode( '&nbsp;&nbsp;&nbsp;', $checkers ).'<br />'.$options;
		}
		
		return $options;
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}