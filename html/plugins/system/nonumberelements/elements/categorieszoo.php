<?php
/**
 * Element: CategoriesZOO
 * Displays a multiselectbox of available ZOO categories
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
 * CategoriesZOO Element
 */
class JElementCategoriesZOO extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CategoriesZOO';

	function fetchElement( $name, $value, &$node, $control_name)
	{
		if ( !file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zoo'.DS.'zoo.php' ) ) {
			return 'ZOO files not found...';
		}

		$db =& JFactory::getDBO();
		$sql = "SHOW tables like '".$db->getPrefix()."zoo_category'";
		$db->setQuery( $sql );
		$tables = $db->loadObjectList();

		if ( !count( $tables ) ) {
			return 'ZOO category table not found in database...';
		}

		$multiple =			$node->attributes( 'multiple' );
		$size =				$this->def( $node->attributes( 'size' ), 0 );

		if ( !is_array( $value ) ) {
			$value = explode( ',', $value );
		}

		$sql = "SELECT id, name FROM #__zoo_application";
		$db->setQuery( $sql );
		$apps = $db->loadObjectList();

		$options =	array();
		foreach ( $apps as $i => $app ) {			
			$sql = "SELECT id, parent, name FROM #__zoo_category WHERE published = 1 AND application_id = ".(int) $app->id;
			$db->setQuery( $sql );
			$menuItems = $db->loadObjectList();

			if ( $i ) {
				$options[] = JHTML::_( 'select.option', '-', '&nbsp;', 'value', 'text', 1 );
			}
			
			// establish the hierarchy of the menu
			// TODO: use node model
			$children = array();

			if ( $menuItems)
			{
				// first pass - collect children
				foreach ( $menuItems as $v )
				{
					$pt =	$v->parent;
					$list =	@$children[$pt] ? $children[$pt] : array();
					array_push( $list, $v );
					$children[$pt] = $list;
				}
			}

			// second pass - get an indent list of the items
			require_once JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'html'.DS.'menu.php';
			$list = JHTMLMenu::treerecurse( 0, '', array(), $children, 9999, 0, 0 );

			// assemble items to the array
			$options[] = JHTML::_( 'select.option', 'app'.$app->id, '['.$app->name.']', 'value', 'text', 0 );
			foreach ( $list as $item )
			{
				$options[] = JHTML::_( 'select.option', $item->id, '&nbsp;&nbsp;&nbsp;'.$item->treename, 'value', 'text', 0 );
			}
		}

		$attribs = 'class="inputbox"';
		if ( $size ) {
			$attribs .= ' size="'.$size.'"';
		} else {
			$attribs .= ' size="'.( ( count( $options) > 10 ) ? 10 : count( $options) ).'"';
		}
		if( $multiple ) $attribs .= ' multiple="multiple"';

		return JHTML::_( 'select.genericlist', $options, ''.$control_name.'['.$name.'][]', $attribs, 'value', 'text', $value, $control_name.$name );
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}