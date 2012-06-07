<?php
/**
 * JComments plugin for Community Polls
 *
 * @version 1.0
 * @package JComments
 * @author CoreJoomla (support@corejoomla.com)
 * @copyright (C) 2008-2009 by CoreJoomla (http://www.corejoomla.com)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_communitypolls extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__jcp_polls WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JFactory::getDBO();
		// we need select primary key for JoomFish support
		$db->setQuery( 'SELECT title, id FROM #__jcp_polls WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		require_once(JPATH_ROOT.DS.'components'.DS.'com_communitypolls'.DS.'router.php');
		
		$query = 'SELECT a.id,' .
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug'.
				' FROM #__jcp_polls AS a' .
				' WHERE a.id = ' . $id;

		$db = & JFactory::getDBO();
		$db->setQuery( $query );
		$row = $db->loadObject();

		$menu = &JSite::getMenu();
		$mnuitems	= $menu->getItems('link', 'index.php?option=com_communitypolls&controller=polls');
		$itemid = isset($mnuitems[0]) ? '&amp;Itemid='.$mnuitems[0]->id : '';
		
		$link = JRoute::_( 'index.php?option=com_communitypolls&amp;controller=polls&amp;task=viewpoll&amp;id='. $row->slug.$itemid );
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__jcp_polls WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>