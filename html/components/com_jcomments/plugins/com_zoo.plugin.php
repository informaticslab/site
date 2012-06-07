<?php
/**
 * JComments plugin for Zoo (zoo.yootheme.com) objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_zoo extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JFactory::getDBO();
		$db->setQuery( 'SELECT id, name as title FROM #__zoo_core_item WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JFactory::getDBO();
		$db->setQuery('SELECT name, id FROM #__zoo_core_item WHERE id = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$link = 'index.php?option=com_zoo&view=item&item_id='. $id;

		require_once(JPATH_SITE.DS.'includes'.DS.'application.php');

		$component = & JComponentHelper::getComponent('com_zoo');
		$menus	= & JSite::getMenu();
		$items	= $menus->getItems('componentid', $component->id);

		if (count($items)) {
			$link .= "&Itemid=" . $items[0]->id;
		}

		$link = JRoute::_($link);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JFactory::getDBO();
		$db->setQuery("SELECT created_by, id FROM #__zoo_core_item WHERE id = " . $id);
		$userid = $db->loadResult();
		
		return intval($userid);
	}
}
?>