<?php
/**
 * Element: Modules
 * Displays an article id field with a button
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
 * Modules Element
 */
class JElementModules extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Modules';

	function fetchElement( $name, $value, &$node, $control_name )
	{
		JHTML::_( 'behavior.modal', 'a.modal' );

		$size		= $node->attributes( 'size' );
		$multiple	= $node->attributes( 'multiple');
		$showtype	= $node->attributes( 'showtype' );
		$showid	= $node->attributes( 'showid' );
		$showinput	= $node->attributes( 'showinput' );

		$db =& JFactory::getDBO();


		// load the list of modules
		$query = 'SELECT id, title, position, module, published'
			.' FROM #__modules'
			.' WHERE client_id = 0'
			.' ORDER BY position, ordering, id'
			;
		$db->setQuery($query);
		$modules = $db->loadObjectList();

		// assemble menu items to the array
		$options 	= array();

		$p = '';
		foreach ( $modules as $item ) {
			if ( $p != $item->position ) {
				$options[]	= JHTML::_( 'select.option', '-', '[ '.$item->position.' ]', 'value', 'text', true );
			}
			$p = $item->position;
			
			$item_name = $item->title;
			$item_id = $item->id;
			$style = 'padding-left:1em;';
			if ( $showtype ) {
				$item_name .= ' ['.$item->module.']';
			}
			if ( $showinput || $showid ) {
				$item_name .= ' ['.$item->id.']';
			}
			if ( $item->published == 0 ) {
				$item_name = '*'.$item_name.' ('.JText::_( 'Unpublished' ).')';
				$style  .= 'font-style:italic;';
			}
			if ( $style ) {
				$item_name = '[[:'.$style.':]]'.$item_name;
			}
			$options[] = JHTML::_( 'select.option', $item_id, $item_name, 'value', 'text' );
		}

		$attribs = 'class="inputbox"';

		if ( $showinput) {
			array_unshift( $options,JHTML::_( 'select.option', '-', '&nbsp;', 'value', 'text', true) );
			array_unshift( $options, JHTML::_( 'select.option', '-', '- '.JText::_('Select Item').' -') );

			if( $multiple ) {
				$onchange = 'if ( this.value ) { if ( '.$control_name.$name.'.value ) { '.$control_name.$name.'.value+=\',\'; } '.$control_name.$name.'.value+=this.value; } this.value=\'\';';
			} else {
				$onchange = 'if ( this.value ) { '.$control_name.$name.'.value=this.value;'.$control_name.$name.'_text.value=this.options[this.selectedIndex].innerHTML.replace( /^((&|&amp;|&#160;)nbsp;|-)*/gm, \'\' ).trim(); } this.value=\'\';';
			}
			$attribs .= ' onchange="'.$onchange.'"';

			$html 		= '<table cellpadding="0" cellspacing="0"><tr><td style="padding: 0px;">'."\n";
			if( !$multiple ) {
				$value_name = $value;
				if ( $value ) {
					foreach ( $modules as $item ) {
						if ( $item->id == $value ) {
							$value_name = $item->title;
							if ( $showtype ) {
								$value_name .= ' ['.$item->module.']';
							}
							$value_name .= ' ['.$value.']';
							break;
						}
					}
				}
				$html 	.= '<input type="text" id="'.$control_name.$name.'_text" value="'.$value_name.'" class="inputbox" size="'.$size.'" disabled="disabled" />';
				$html 	.= '<input type="hidden" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" />';
			} else {
				$html 	.= '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" class="inputbox" size="'.$size.'" />';
			}
			$html 		.= '</td><td style="padding: 0px;"padding-left: 5px;>'."\n";
			$html 		.= JHTML::_('select.genericlist', $options, '', $attribs, 'value', 'text', '', '');
			$html 		.= '</td></tr></table>'."\n";
		} else {
			if( $size ) {
				$attribs .= ' size="'.$size.'"';
			}else {
				$attribs .= ' size="'.( ( count( $options) > 10 ) ? 10 : count( $options) ).'"';
			}
			if( $multiple ) {
				if ( !is_array( $value ) ) {
					$value = explode( ',', $value );
				}
				$attribs .= ' multiple="multiple"';
			}

			$html = JHTML::_( 'select.genericlist', $options, ''.$control_name.'['.$name.'][]', $attribs, 'value', 'text', $value, $control_name.$name );
		}
		$html = preg_replace( '#>\[\[\:(.*?)\:\]\]#si', ' style="\1">', $html );
		return $html;
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}