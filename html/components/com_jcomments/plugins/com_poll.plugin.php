<?php
/**
 * JComments plugin for Joomla com_poll component
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_poll extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__polls WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__polls WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_poll' );
		if (JCOMMENTS_JVERSION == '1.5') {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery( 'SELECT alias FROM #__polls WHERE id = ' . $id );
			$alias = $db->loadResult();

			$link = 'index.php?option=com_poll&id='. $id.':'.$alias;
			$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
			$link = JRoute::_($link);
		} else {
			$link = sefRelToAbs( 'index.php?option=com_poll&amp;task=results&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		}
		return $link;
	}
}
?>