<?php
/**
 * JComments plugin for PhocaGallery
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class jc_com_phocagallery_images extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__phocagallery WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__phocagallery WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$db = & JCommentsFactory::getDBO();

		$link = '';

		$query = 'SELECT a.id, as imgid c.id as catid,'
			.' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as catslug,'
			.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
			.' FROM #__phocagallery AS a'
			.' LEFT JOIN #__phocagallery_categories AS c ON c.id = a.catid'
			.' WHERE a.id = '. $id
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if (count($rows)) {
			$row = $rows[0];

			$_Itemid = JCommentsPlugin::getItemid('com_phocagallery');
			
			// Comment is displayed in popup window so we must create link to category view
			// Because of possible pagination only this one image will be displayed not all
			
			$link = 'index.php?option=com_phocagallery&view=category&id=' . $row->catslug.'&amp;cimgid=' . $row->slug;
			// Does not make any sense :-(
			//$link = 'index.php?option=com_phocagallery&view=comment&catid=' . $row->catslug . '&amp;id=' . $row->slug;
			$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
			$link = JRoute::_($link);
		}

		return $link;
	}
}
?>