<?php
/**
 * JComments plugin for IceGallery objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_icegallery extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgid as id, imgname as title FROM #__icefiles WHERE imgid IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT imgname, imgid FROM #__icefiles WHERE imgid = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_ice' );

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT catid, imgid FROM #__icefiles WHERE imgid = ' . $id );
		$catid = $db->loadResult();

		$link = JoomlaTuneRoute::_('index.php?option=com_ice&amp;page=view&amp;imgid=' . $id . '&amp;catid=' . $catid . '&amp;Itemid=' . $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT uid FROM #__icefiles WHERE imgid = ' . $id);
		$userid = $db->loadResult();
		return intval( $userid );
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT c.catid as `value`, c.catname AS `text`"
			. "\n FROM #__ice AS c"
			. (($filter != '') ? "\n WHERE c.catid IN ( ".$filter." )" : '')
			. "\n ORDER BY c.catname"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>