<?php
/**
 * JComments plugin for ProjectLog (http://www.thethinkery.net)
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_projectlog extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__projectlog_projects WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT title, id FROM #__projectlog_projects WHERE id = $id" );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_projectlog' );
		$link = "index.php?option=com_projectlog&view=project&project_id=" . $id;
		$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
		$link = JRoute::_($link);
		return $link;
	}
}
?>