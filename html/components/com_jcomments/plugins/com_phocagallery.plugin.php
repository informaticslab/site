<?php
/**
 * JComments plugin for PhocaGallery
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_phocagallery extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__phocagallery_categories WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__phocagallery_categories WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$db = & JCommentsFactory::getDBO();
		$query = 'SELECT cc.id, CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as slug'
			. ' FROM #__phocagallery_categories AS cc'
			. ' WHERE cc.id = ' . $id
			;
		$db->setQuery($query);
		$slug = $db->loadResult();

		$_Itemid = JCommentsPlugin::getItemid('com_phocagallery');
		$link = 'index.php?option=com_phocagallery&view=category&id=' . $slug;
		$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
		$link = JRoute::_($link);

		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT userid #__phocagallery_user_category WHERE catid = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>