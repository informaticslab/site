<?php
/**
 * JComments plugin for mmsBlog support
 *
 * @version 2.0
 * @package JComments
 * @author majus (m_rausch@gmx.de)
 * @copyright (C) 2009 by majus
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_mmsblog extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, subject as title FROM #__mmsblog_item WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT subject, id FROM #__mmsblog_item WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_mmsblog');
		$link = JRoute::_('index.php?option=com_mmsblog&amp;view=item&amp;id='. $id .'&amp;Itemid='. $_Itemid);
		return $link;
	}
}
?>