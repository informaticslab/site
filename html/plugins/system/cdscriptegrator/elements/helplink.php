<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		1.5.5
 * @copyright	Copyright (C) 2007 - 2011 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die( 'Restricted access' );

class JElementHelplink extends JElement {
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Helplink';

	function fetchElement($name, $value, &$node, $control_name) {
				
		$label = ( isset($node->_attributes['label']) )?$node->_attributes['label']:'';
		$help_title = ( isset($node->_attributes['help_title']) )?$node->_attributes['help_title']:'Show Help File';
		$help_title_link = ( isset($node->_attributes['help_title_link']) )?$node->_attributes['help_title_link']:'Show Help File';
		$url = ( isset($node->_attributes['url']) )?$node->_attributes['url']:'';
		$help_text = ( isset($node->_attributes['help_text']) )?$node->_attributes['help_text']:'';
		
		$html = '<div style="border: 3px double gray; padding: 3px; text-align: center">' . JText::_($help_text) . ' <a href="' . $url . '" title="' . JText::_($help_title_link) . '" target="_blank">' . JText::_($help_title) . '.</a></div>';

		return $html;
	}
}
?>