<?php
/**
 * JComments plugin for PhocaDownload
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_phocadownload_files extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__phocadownload WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__phocadownload WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		
		$db = & JCommentsFactory::getDBO();

		$link = '';

		$query = 'SELECT a.id as fid, c.id as catid,'
			.' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as catslug,'
			.' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug'
			.' FROM #__phocadownload AS a'
			.' LEFT JOIN #__phocadownload_categories AS c ON c.id = a.catid'
			.' WHERE a.id = '. $id
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if (count($rows)) {
			$row = $rows[0];

			$_Itemid = JCommentsPlugin::getItemid('com_phocadownload');
			$link = 'index.php?option=com_phocadownload&view=file&catid=' . $row->catslug . '&amp;id=' . $row->slug;
			$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
			$link = JRoute::_($link);
		}

		return $link;
	}
}
?>