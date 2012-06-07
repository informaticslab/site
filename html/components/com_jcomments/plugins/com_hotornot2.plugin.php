<?php
/**
 * JComments plugin for HotOrNot2 objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_hotornot2 extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title FROM #__hotornot_pictures WHERE idx = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_hotornot2' );
		$link = sefRelToAbs( "index.php?option=com_hotornot2&amp;task=display&amp;idx=" . $id . "&amp;Itemid=" . $_Itemid );
		return $link;
	}
}
?>