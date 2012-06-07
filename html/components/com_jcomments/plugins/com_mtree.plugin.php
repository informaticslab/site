<?php
/**
 * JComments plugin for Mosets tree support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_mtree extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT link_id as id, link_name as title FROM #__mt_links WHERE link_id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT link_name, link_id FROM #__mt_links WHERE link_id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			$_Itemid = JCommentsPlugin::getItemid('com_mtree');
			$link = sefRelToAbs('index.php?option=com_mtree&amp;task=viewlink&amp;link_id=' . $id . '&amp;Itemid=' . $_Itemid);
		} else {
			$link = 'index.php?option=com_mtree&amp;task=viewlink&amp;link_id=' . $id;
			$_Itemid = JCommentsPlugin::getItemid('com_mtree');
			$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
			$link = JRoute::_( $link );
		}

		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT user_id FROM #__mt_links WHERE link_id = ' . $id );
		$userid = $db->loadResult();
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT cat_id AS `value`, cat_name AS `text`"
			. "\n FROM #__mt_cats"
			. (($filter != '') ? "\n WHERE cat_id IN ( ".$filter." )" : '')
			. "\n ORDER BY cat_name"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>