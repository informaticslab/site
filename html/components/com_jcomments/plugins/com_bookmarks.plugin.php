<?php
/**
 * JComments plugin for Bookmarks component objects support
 *
 * @version 1.4
 * @package JComments
 * @author tumtum (tumtum@mail.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_bookmarks extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__bookmarks WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle( $id )
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT title FROM #__bookmarks WHERE id='$id'");
		return $db->loadResult();
	}
 
	function getObjectLink( $id )
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_bookmarks' );
		$link = JoomlaTuneRoute::_('index.php?option=com_bookmarks&Itemid='. $_Itemid.'&task=detail&navstart=0&mode=0&id='. $id .'&search=*');
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by FROM #__bookmarks WHERE id = ' . $id );
		$userid = $db->loadResult();
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT id AS `value`, title AS `text`"
			. "\n FROM #__bookmarks_categories"
			. (($filter != '') ? "\n WHERE id IN ( ".$filter." )" : '')
			. "\n ORDER BY title"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		return $rows;
	}
}
?>