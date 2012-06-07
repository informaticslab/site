<?php
/**
 * JComments plugin for DocMan objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_docman extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, dmname as title FROM #__docman WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT dmname, id FROM #__docman WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		static $_Itemid = null;

		if (!isset($_Itemid)) {
			if (JCOMMENTS_JVERSION == '1.5') {
				$needles = array('gid' => (int) $id);
				if ($item = jc_com_docman::_findItem($needles)) {
					$_Itemid = $item->id;
				} else {
					$_Itemid = '';
				}
			} else {
				$_Itemid = JCommentsPlugin::getItemid('com_docman');
			}
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			$link = JoomlaTuneRoute::_("index.php?option=com_docman&amp;task=doc_details&amp;gid=" . $id . "&amp;Itemid=" . $_Itemid);
		} else {
			include_once(JPATH_SITE.DS.'includes'.DS.'application.php');

			$link = 'index.php?option=com_docman&task=doc_details&gid=' . $id;

			if ($_Itemid != '') {
				$link .= '&Itemid=' . $_Itemid;
			};

			$router = JPATH_SITE . DS . 'components' . DS . 'com_docman' . DS . 'router.php';
			if (is_file($router)) {
				include_once($router);
			}
			$link = JRoute::_($link);
		}
		return $link;
	}

	function _findItem($needles)
	{
		$component =& JComponentHelper::getComponent('com_docman');

		$menus	= & JSite::getMenu();
		$items	= $menus->getItems('componentid', $component->id);
		$user 	= & JFactory::getUser();
		$access = (int)$user->get('aid');

		foreach ($needles as $needle => $id) {
			if (is_array($items)) {
				foreach ($items as $item) {
					if ($item->published == 1 && $item->access <= $access) {
						return $item;
					}
				}
			}
		}

		return false;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT dmsubmitedby FROM #__docman WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>