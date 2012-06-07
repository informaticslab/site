<?php
/**
 * JComments plugin for BeeHeard
 *
 * @version 1.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_beeheardlite extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__beeheard_suggestions WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__beeheard_suggestions WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_beeheardlite');
		$_Itemid = $_Itemid > 0 ? '&amp;Itemid='.$_Itemid : '';
		
		$link = JRoute::_('index.php?option=com_beeheardlite&controller=suggestions&suggestion_id='.$id.$_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT user_id FROM #__beeheard_suggestions WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>