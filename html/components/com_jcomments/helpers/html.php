<?php
/**
 * JComments - Joomla Comment System
 * 
 * @version 2.1
 * @package JComments
 * @subpackage Helpers
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

/**
 * JComments Html Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsHTML
{
	function makeOption( $value, $text = '', $value_name = 'value', $text_name = 'text' )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JHTML::_('select.option', $value, $text, $value_name, $text_name);
		}
		return mosHTML::makeOption($value, $text, $value_name, $text_name);
	}
	
	function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected = NULL, $idtag = false, $flag = false )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JHTML::_('select.genericlist', $arr, $tag_name, $tag_attribs, $key, $text, $selected, $idtag, $flag);
		}
		return mosHTML::selectList($arr, $tag_name, $tag_attribs, $key, $text, $selected);
	}
	
	function yesnoRadioList( $tag_name, $tag_attribs, $selected, $yes = 'yes', $no = 'no', $id = false )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JHTML::_('select.booleanlist', $tag_name, $tag_attribs, $selected, $yes, $no, $id);
		}
		return mosHTML::yesnoRadioList($tag_name, $tag_attribs, $selected, $yes, $no);
	}
	
	function yesnoSelectList( $tag_name, $tag_attribs, $selected, $yes = 'yes', $no = 'no' )
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			$arr = array(JCommentsHTML::makeOption(0, $no), JCommentsHTML::makeOption(1, $yes));
		} else if (JCOMMENTS_JVERSION == '1.5') {
			$arr = array(JCommentsHTML::makeOption(0, JText::_($no)), JCommentsHTML::makeOption(1, JText::_($yes)));
		}
		return JCommentsHTML::selectList($arr, $tag_name, $tag_attribs, 'value', 'text', (int) $selected);
	}
	
	function CheckedOutProcessing( &$row, $i )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JHTML::_('grid.checkedout', $row, $i);
		}
		return mosCommonHTML::CheckedOutProcessing($row, $i);
	}
}
?>