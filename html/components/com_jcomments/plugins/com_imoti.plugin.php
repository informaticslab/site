<?php
/**
 * JComments plugin for ImotiPro support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_imoti extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT name, id FROM #__hp_properties WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_imoti' );
		$link = sefRelToAbs( 'index.php?option=com_imoti&amp;task=view&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>