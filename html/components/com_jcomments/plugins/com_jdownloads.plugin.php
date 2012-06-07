<?php
/**
 * JComments plugin for JDownloads objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_jdownloads extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT file_id as id, file_title as title FROM #__jdownloads_files WHERE file_id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT file_title, file_id FROM #__jdownloads_files WHERE file_id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_jdownloads' );
		$link = JoomlaTuneRoute::_('index.php?option=com_jdownloads&amp;task=view.download&amp;cid=' . $id . '&amp;Itemid=' . $_Itemid);
		return $link;
	}
}
?>