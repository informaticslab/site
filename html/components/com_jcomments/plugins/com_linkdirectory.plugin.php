<?php
/**
 * JComments plugin for LinkDirectory support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_linkdirectory extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__ldlinks WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_linkdirectory' );
		$link = sefRelToAbs( "index.php?option=com_linkdirectory&amp;task=detail&amp;id=" . $id . "&amp;Itemid=" . $_Itemid );
		return $link;
	}
}
?>