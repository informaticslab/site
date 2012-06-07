<?php
/**
 * JComments plugin for Joomla com_weblinks component
 *
 * @version 1.4, based on the one for com_poll by Sergey M. Litvinov
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru), Tommy Nilsson, tommy@architechtsoftomorrow.com
 * @copyright (C) 2006-2008 by Sergey M. Litvinov (http://www.joomlatune.ru), 2009 Tommy Nilsson www.architechtsoftomorrow.com
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_weblinks extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__categories WHERE section = "com_weblinks" and IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__categories WHERE section = "com_weblinks" and id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery( 'SELECT alias FROM #__categories WHERE section = "com_weblinks" and id = ' . $id );
			$alias = $db->loadResult();
			
			$link = 'index.php?option=com_weblinks&view=category&id='. $id.':'.$alias;

			require_once(JPATH_SITE.DS.'includes'.DS.'application.php');

			$component = & JComponentHelper::getComponent('com_weblinks');
			$menus	= & JSite::getMenu();
			$items	= $menus->getItems('componentid', $component->id);

			if (count($items)) {
				$link .= "&Itemid=" . $items[0]->id;
			}

			$link = JRoute::_($link);

		} else {
			$_Itemid = JCommentsPlugin::getItemid( 'com_weblinks' );
			$link = sefRelToAbs( 'index.php?option=com_weblinks&amp;view=category&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		}
		return $link;
	}
}
?>