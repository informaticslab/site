<?php
/**
 * JComments plugin for sCatalog component
 *
 * @version 2.0
 * @package JComments
 * @author Constantine Poltyrev (shprota@gmail.com)
 * @copyright (C) 2006-2009 by Constantine Poltyrev (http://shprota.rallycars.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_scatalog extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__scatalog_products WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT title, id FROM #__scatalog_products WHERE id = $id" );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_scatalog' );

		$db = & JCommentsFactory::getDBO();
		$id = intval($id);
		$db->setQuery( "SELECT cat_id FROM #__scatalog_catproduct_xref WHERE product_id=$id LIMIT 1" );
		$catid = $db->loadResult();
		$link = JoomlaTuneRoute::_("index.php?option=com_scatalog&amp;view=product&amp;catid=$catid&amp;id=" . $id . "&amp;Itemid=" . $_Itemid);
		return $link;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id as `value`, title AS `text`"
			. "\n FROM #__scatalog_categories AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>