<?php
/**
 * JComments plugin for Cinema support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_cinema extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgtitle FROM #__cinema WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_cinema' );
		$link = sefRelToAbs( 'index.php?option=com_cinema&amp;task=detail&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>