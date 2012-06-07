<?php
/**
 * JComments plugin for JPortfolio support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_jportfolio extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, name as title FROM #__jportfolio_projects WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT name, id FROM #__jportfolio_projects WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_jportfolio' );
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT catid FROM #__jportfolio_projects WHERE id = ' . $id );
		$catid = $db->loadResult();
		$link = sefRelToAbs( 'index.php?option=com_jportfolio&amp;catid='.$catid.'&amp;project=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>