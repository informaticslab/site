<?php
/**
 * JComments plugin for FlippingBook component (www.page-flip-tools.com)
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_flippingbook extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__flippingbook_books WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT title, id FROM #__flippingbook_books WHERE id = $id" );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_flippingbook' );

		$db = & JCommentsFactory::getDBO();
		$id = intval($id);

		$query = 'SELECT b.id,' .
				' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", a.id, b.alias) ELSE b.id END as slug,'.
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as catslug'.
				' FROM #__flippingbook_books AS b' .
				' LEFT JOIN #__flippingbook_categories AS c ON c.id = b.category_id' .
				' WHERE b.id = ' . $id;
		$db->setQuery( $query );
		$row = $db->loadObject();

		$link = "index.php?option=com_flippingbook&amp;view=book&amp;id=" . $row->slug . "&amp;catid=" . $row->catslug;
		$link .= ($_Itemid > 0) ? ('&amp;Itemid=' . $_Itemid) : '';
		$link = JRoute::_($link);
		return $link;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id as `value`, title AS `text`"
			. "\n FROM #__flippingbook_categories AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>