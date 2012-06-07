<?php
/**
 * JComments plugin for JoomGallery objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_joomgallery extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, imgtitle as title FROM #__joomgallery WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgtitle, id FROM #__joomgallery WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_joomgallery' );
		$link = JoomlaTuneRoute::_('index.php?option=com_joomgallery&amp;func=detail&amp;id=' . $id . '&amp;Itemid=' . $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT owner FROM #__joomgallery WHERE id = ' . $id);
		$userid = $db->loadResult();
		return intval( $userid );
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT c.cid as `value`, name AS `text`"
			. "\n FROM #__joomgallery_catg AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		return $rows;
	}
}
?>