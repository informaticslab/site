<?php
/**
 * JComments plugin for yvCommodity objects support
 *
 * @version 2.0
 * @package JComments
 * @author Victor M. Yunoshev (yv-soft@ukr.net)
 * @copyright (C) 2009 by Victor M. Yunoshev
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_yvcommodity extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__yvc WHERE itemid IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT title, id FROM #__yvc WHERE id = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_yvcommodity');
		$link = JoomlaTuneRoute::_('index.php?option=com_yvcommodity&amp;task=commodity&amp;id=' . $id . '&amp;Itemid=' . $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT u.id "
			. "\n FROM #__users AS u"
			. "\n INNER JOIN #__yvc AS yvc ON yvc.owner = u.username"
			. "\n WHERE yvc.id = " . $id
			;

		$db->setQuery( $query );
		$userid = $db->loadResult();

		return intval( $userid );
	}

	function getCategories($filter = '') {

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.cat_id as `value`, name AS `text`, c.cat_id"
			. "\n FROM #__yvc_catg AS c"
			. (($filter != '') ? "\n WHERE c.cat_id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>