<?php
/**
 * JComments plugin for Smart Blog objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_blog extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, post_title as title FROM #__blog_postings WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT post_title, id FROM #__blog_postings WHERE id = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$link = 'index.php?option=com_blog&view=comments&pid='. $id;

		require_once(JPATH_SITE.DS.'includes'.DS.'application.php');

		$component = & JComponentHelper::getComponent('com_blog');
		$menus	= & JSite::getMenu();
		$items	= $menus->getItems('componentid', $component->id);

		if (count($items)) {
			$link .= "&Itemid=" . $items[0]->id;
		}

		$link = JRoute::_($link);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT user_id FROM #__blog_postings WHERE id = " . $id;
		$db->setQuery( $query );
		$userid = $db->loadResult();
		
		return intval( $userid );
	}
}
?>