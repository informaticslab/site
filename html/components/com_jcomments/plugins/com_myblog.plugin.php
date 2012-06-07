<?php
/**
 * JComments plugin for SunBlog support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_myblog extends JCommentsPlugin
{
	function getObjectTitle( $id )
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT title, id FROM #__content WHERE id='$id'");
		return $db->loadResult();
	}
 
	function getObjectLink( $id )
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_myblog' );
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT permalink FROM #__myblog_permalinks WHERE contentid='$id'");
		$permalink = $db->loadResult();
		$link = JoomlaTuneRoute::_('index.php?option=com_myblog&show=' . $permalink . '&Itemid=' . $_Itemid);
		return $link;
	}
}
?>