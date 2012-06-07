<?php
/**
 * JComments plugin for TPDugg objects support
 *
 * @version 1.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_tpdugg extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT title, id FROM #__tpdugg WHERE id IN ('.implode(',', $ids).')');
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JFactory::getDBO();
		$db->setQuery("SELECT title, id FROM #__tpdugg WHERE id='$id'");
		return $db->loadResult();
	}
 
	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_tpdugg');
		$link = JRoute::_('index.php?option=com_tpdugg&amp;task=detail&amp;id='.$id.'&amp;show=comments'.'&Itemid='. $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JFactory::getDBO();
		$db->setQuery("SELECT userid FROM #__tpdugg WHERE id='$id'");
		return $db->loadResult();
	}
}
?>