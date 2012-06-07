<?php
/**
 * JComments plugin for VirtueMart objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_virtuemart extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT product_id as id, product_name as title FROM #__vm_product WHERE product_id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT product_name, product_id FROM #__vm_product WHERE product_id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid =  JCommentsPlugin::getItemid('com_virtuemart');
		if ($_Itemid != 0) {
			$_Itemid = '&Itemid=' . $_Itemid;
		} else {
			$_Itemid = '';
		}

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT CONCAT('index.php?option=com_virtuemart&page=shop.product_details&flypage=', c.category_flypage,'&category_id=',c.category_id,'&product_id=', a.product_id, '".$_Itemid."' )"
			. "\n FROM #__vm_product AS a"
			. "\n LEFT JOIN #__vm_product_category_xref AS b ON b.product_id = a.product_id"
			. "\n LEFT JOIN #__vm_category AS c ON b.category_id = c.category_id"
			. "\n WHERE a.product_id = '$id'"
			;
		$db->setQuery($query);
		$link = JoomlaTuneRoute::_($db->loadResult());
		return $link;
	}
}
?>