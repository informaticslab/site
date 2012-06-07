<?php
/**
 * JComments plugin for EasyFAQ articles support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_easyfaq extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__easyfaq WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__easyfaq WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_easyfaq' );
		$link = JoomlaTuneRoute::_( 'index.php?option=com_easyfaq&amp;task=view&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__easyfaq WHERE id = ' . $id );
		$userid = $db->loadResult();
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT id AS `value`, name AS `text`"
			. "\n FROM #__easyfaq_categories"
			. (($filter != '') ? "\n WHERE id IN ( ".$filter." )" : '')
			. "\n ORDER BY name"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		return $rows;
	}
}
?>