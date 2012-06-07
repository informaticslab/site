<?php
/**
 * JComments plugin for EventList
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_eventlist extends JCommentsPlugin 
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__eventlist_events WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__eventlist_events WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			$_Itemid = JCommentsPlugin::getItemid( 'com_eventlist' );
			$link = sefRelToAbs( "index.php?option=com_eventlist&amp;view=details&amp;id=" . $id . "&amp;Itemid=" . $_Itemid );
		} else {

			$db = & JCommentsFactory::getDBO();

			$query = 'SELECT a.id, CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
				. ' FROM #__eventlist_events AS a'
				. ' WHERE id = ' . $id
				;
			$db->setQuery($query);
			$slug = $db->loadResult();

			require_once(JPATH_SITE.DS.'includes'.DS.'application.php');

			$eventListRouter = JPATH_SITE.DS.'components'.DS.'com_eventlist'.DS.'helpers'.DS.'route.php';
			if (is_file($eventListRouter)) {
				require_once($eventListRouter);
				$link = JRoute::_( EventListHelperRoute::getRoute($slug) );
			} else {
				$link = JRoute::_( 'index.php?option=com_eventlist&view=details&id=' . $slug );
			}
		}

		return $link;
	}

	function getObjectOwner($id) {

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__eventlist_events WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}

	function getCategories($filter = '') {

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id AS `value`, CONCAT_WS( ' / ', 'EventList', c.catname) AS `text`"
			. "\n FROM #__eventlist_categories AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.catname"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>