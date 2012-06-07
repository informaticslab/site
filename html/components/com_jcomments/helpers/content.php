<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments content plugins
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
 * JComments Content Plugin Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsContentPluginHelper
{
	/**
	 *
	 * @access private
	 * @param object $row The content item object
	 * @param array $patterns
	 * @param array $replacements
	 * @param boolean $fromText Process 'text' field or introtext/fulltext fields?
	 * @return void
	 */
	function _processTags( &$row, $patterns = array(), $replacements = array(), $fromText = true )
	{
		if (count($patterns) > 0) {
			ob_start();
			if (true == $fromText) {
				$row->text = preg_replace($patterns, $replacements, $row->text);
			} else {
				if (isset($row->introtext)) {
					$row->introtext = preg_replace($patterns, $replacements, $row->introtext);
				}
				if (isset($row->fulltext)) {
					$row->fulltext = preg_replace($patterns, $replacements, $row->fulltext);
				}
			}
			ob_end_clean();
		}
	}
	
	/**
	 * Searches given tag in content object
	 *
	 * @access private
	 * @param object $row The content item object
	 * @param string $pattern
	 * @param boolean $fromText Process 'text' field or introtext/fulltext fields?
	 * @return boolean True if any tag found, False otherwise
	 */
	function _findTag( &$row, $pattern, $fromText = false )
	{
		if (true == $fromText) {
			return (isset($row->text) && preg_match($pattern, $row->text));
		} else {
			return ((isset($row->introtext) && preg_match($pattern, $row->introtext)) || (isset($row->fulltext) && preg_match($pattern, $row->fulltext)));
		}
	}
	
	/**
	 * Replaces or removes commenting systems tags like {moscomment}, {jomcomment} etc
	 *
	 * @static 
	 * @access public
	 * @param object $row The content item object
	 * @param boolean $removeTags Remove all 3rd party tags or replace it to JComments tags?
	 * @param boolean $fromText Process 'text' field or introtext/fulltext fields?
	 * @return void
	 */
	function processForeignTags( &$row, $removeTags = false, $fromText = true )
	{
		if (false == $removeTags) {
			$patterns = array('#\{(moscomment|mxc|jomcomment|easycomments)\}#is', '#\{\!jomcomment\}#is', '#\{mxc\:\:closed\}#is');
			$replacements = array('{jcomments on}', '{jcomments off}', '{jcomments lock}');
		} else {
			$patterns = array('#\{(moscomment|mxc|msc::closed|!jomcomment|jomcomment|easycomments)\}#is');
			$replacements = array('');
		}
		
		JCommentsContentPluginHelper::_processTags($row, $patterns, $replacements, $fromText);
	}
	
	/**
	 * Return true if one of text fields contains {jcomments on} tag
	 *
	 * @static
	 * @access public 
	 * @param object $row Content object
	 * @param boolean $fromText Look field 'text' or 'introtext' & 'fulltext' 
	 * @return boolean True if {jcomments on} found, False otherwise
	 */
	function isEnabled( &$row, $fromText = false )
	{
		return JCommentsContentPluginHelper::_findTag($row, '/{jcomments\s+on}/is', $fromText);
	}
	
	/**
	 * Return true if one of text fields contains {jcomments off} tag
	 *
	 * @static
	 * @access public 
	 * @param object $row Content object
	 * @param boolean $fromText Look field 'text' or 'introtext' & 'fulltext' 
	 * @return boolean True if {jcomments off} found, False otherwise
	 */
	function isDisabled( &$row, $fromText = false )
	{
		return JCommentsContentPluginHelper::_findTag($row, '/{jcomments\s+off}/is', $fromText);
	}
	
	/**
	 * Return true if one of text fields contains {jcomments lock} tag
	 *
	 * @static
	 * @access public 
	 * @param object $row Content object
	 * @param boolean $fromText Look field 'text' or 'introtext' & 'fulltext' 
	 * @return boolean True if {jcomments lock} found, False otherwise
	 */
	function isLocked( &$row, $fromText = false )
	{
		return JCommentsContentPluginHelper::_findTag($row, '/{jcomments\s+lock}/is', $fromText);
	}
	
	/**
	 * Clears all JComments tags from content item
	 *
	 * @static
	 * @access public 
	 * @param object $row Content object
	 * @param boolean $fromText Look field 'text' or 'introtext' & 'fulltext'
	 * @return void
	 */
	function clear( &$row, $fromText = false )
	{
		$patterns = array('/{jcomments\s+(off|on|lock)}/is');
		$replacements = array('');
		
		JCommentsContentPluginHelper::_processTags($row, $patterns, $replacements, $fromText);
	}

	/**
	 * Checks if comments are enabled for specified category
	 * 
	 * @static
	 * @access public
	 * @param  int $id Category ID
	 * @return boolean
	 */
	function checkCategory( $id )
	{
		$config = & JCommentsFactory::getConfig();
		$categories = $config->get('enable_categories', '');
		$ids = explode(',', $categories);
		
		return ($categories == '*' || ($categories != '' && in_array($id, $ids)));
	}
}
?>