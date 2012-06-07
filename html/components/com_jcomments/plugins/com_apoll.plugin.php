<?php
/**
 * JComments plugin for Joomla APoll component (http://apoll.genev.info)
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_apoll extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__apolls WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		// we need select primary key for JoomFish support
		$db->setQuery( 'SELECT title, id FROM #__apolls WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_apoll' );
		if (JCOMMENTS_JVERSION == '1.5') {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery( 'SELECT alias, id FROM #__apolls WHERE id = ' . $id );
			$alias = $db->loadResult();

			$link = 'index.php?option=com_apoll&task=view&view=apoll&id='. $id.':'.$alias;
			$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
			$link = JRoute::_($link);
		} else {
			$link = JoomlaTuneRoute::_( 'index.php?option=com_apoll&amp;task=view&amp;view=apoll&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		}
		return $link;
	}
}
?>