<?php
/**
 * JComments plugin for JComments ;)
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_jcomments extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
	        $title = 'JComments';

	        $menu = jc_com_jcomments::getMenuItem($id);

	        if ($menu != '') {
	        	if (JCOMMENTS_JVERSION == '1.5') {
				$params = new JParameter($menu->params);
			} else {
				$params = new mosParameters($menu->params);			
			}
			$title = $params->get('page_title');

			if ($title == '') {
				$title = $menu->name;
			}
	        }
		return $title;
	}

	function getObjectLink($id)
	{
	        $link = '';
	        $menu = jc_com_jcomments::getMenuItem($id);

	        if ($menu != null) {
			$link = JoomlaTuneRoute::_('index.php?option=com_jcomments&amp;Itemid='.$menu->id);
	        }

		return $link;
	}

	function getMenuItem($id)
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT m.*"
			. "\nFROM `#__menu` AS m"
			. "\nJOIN `#__components` AS c ON c.id = m.componentid"
			. "\nWHERE m.type = 'component'"
			. "\nAND c.option = 'com_jcomments'"
			. "\nAND c.parent = 0"
			. "\nAND m.params LIKE '%object_id=" . $id . "%'"
			;			

		$db->setQuery($query);
		$menus = $db->loadObjectList();

		if (count($menus)) {
			return $menus[0];
		} else {
			return null;
		}
	}
}
?>