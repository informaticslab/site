<?php
/**
 * JComments - Joomla Comment System
 *
 * Search plugin
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

global $mainframe;

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
} else {
	global $mosConfig_absolute_path;
	include_once ($mosConfig_absolute_path.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
}
	
// if component doesnt exists (may be already uninstalled) - return
if (!defined('JCOMMENTS_JVERSION')) {
	return;
}

if (JCOMMENTS_JVERSION == '1.0') {
	global $_MAMBOTS;
	$_MAMBOTS->registerFunction('onSearch', 'plgSearchJComments');
} else if (JCOMMENTS_JVERSION == '1.5') {
	$mainframe->registerEvent('onSearch', 'plgSearchJComments');
	$mainframe->registerEvent('onSearchAreas', 'plgSearchJCommentsAreas');

	JPlugin::loadLanguage( 'plg_search_jcomments' );
}

if (!function_exists('sefreltoabs')) {
	function sefRelToAbs( $s )
	{
		return $s;
	}
}

/**
 * @return array An array of search areas
 */
function &plgSearchJCommentsAreas()
{
	static $areas = array('comments' => 'Comments');
	return $areas;
}

/**
* Comments Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string matching option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
* @param mixed An array if restricted to areas, null if search all
*/
function plgSearchJComments( $text, $phrase='', $ordering='', $areas = null )
{
	$text = trim($text);
	
	if ($text == '') {
		return array();
	}
	
	if (is_array($areas)) {
		if (!array_intersect($areas, array_keys(plgSearchJCommentsAreas()))) {
			return array();
		}
	}
	if (file_exists(JCOMMENTS_BASE.DS.'jcomments.php')) {

		require_once (JCOMMENTS_BASE.DS.'jcomments.php');
		require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
		require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
		require_once (JCOMMENTS_HELPERS.DS.'content.php');
		require_once (JCOMMENTS_HELPERS.DS.'object.php');

		$db = & JCommentsFactory::getDBO();
	
		$pluginParams = JCommentsPluginHelper::getParams('jcomments', 'search');
		$limit = $pluginParams->def('search_limit', 50);
		
		switch ($phrase) {
			case 'exact':
				$where = "LOWER(comment) LIKE '%$text%' OR LOWER(title) LIKE '%$text%'";
				break;
			case 'all':
			case 'any':
			default:
				$words = explode(' ', $text);
				$wheres = array();
				foreach ($words as $word) {
					$wheres2 = array();
					$wheres2[] = "LOWER(name) LIKE '%$word%'";
					$wheres2[] = "LOWER(comment) LIKE '%$word%'";
					$wheres2[] = "LOWER(title) LIKE '%$word%'";
					$wheres[] = implode(' OR ', $wheres2);
				}
				$where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
				break;
		}
		
		switch ($ordering) {
			case 'oldest':
				$order = 'date ASC';
				break;
			case 'newest':
			default:
				$order = 'date DESC';
				break;
		}

		$query = "SELECT "
				. "\n  comment AS text"
				. "\n, date AS created"
				. "\n, '2' AS browsernav"
				. "\n, '" . JText::_('Comments') . "' AS section"
				. "\n, ''  AS href"
				. "\n, id"
				. "\n, object_id"
				. "\n, object_group"
				. "\nFROM #__jcomments "
				. "\nWHERE published='1'"
				. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
				. "\n AND ($where) "
				. "\nORDER BY object_id, $order";

		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		
		$result = array();
		$cnt = count($rows);

		if ($cnt > 0) {
			$last_object_id = -1;
			$object_link = '';
			
			$acl = & JCommentsFactory::getACL();

			$lang = JCommentsMultilingual::isEnabled() ? JCommentsMultilingual::getLanguage() : null;
			
			for ($i = 0; $i < $cnt; $i++) {
				if ($rows[$i]->object_id != $last_object_id) {
					$last_object_id = $rows[$i]->object_id;
					$object_link = JCommentsObjectHelper::getLink($rows[$i]->object_id, $rows[$i]->object_group);
					$object_title = JCommentsObjectHelper::getTitle($rows[$i]->object_id, $rows[$i]->object_group, $lang);
				}
				
				$rows[$i]->href = $object_link . '#comment-' . $rows[$i]->id;
				
				$comment = JCommentsText::cleanText($rows[$i]->text);
				
				if ($acl->check('enable_autocensor')) {
					$comment = JCommentsText::censor($comment);
				}

				if ($comment != '') {
					$rows[$i]->title = $object_title;
					$rows[$i]->text = $comment;
					$result[] = $rows[$i];
				}
			}
		}
		unset($rows);
		
		return $result;
	}
	return array();
} 
?>