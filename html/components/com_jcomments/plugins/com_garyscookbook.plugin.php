<?php
/**
 * JComments plugin for Remository objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_garyscookbook extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgtitle FROM #__garyscookbook WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_garyscookbook' );
		$link = JoomlaTuneRoute::_('index.php?option=com_garyscookbook&amp;func=detail&amp;id=' . $id . '&amp;Itemid=' . $_Itemid);
		return $link;
	}
}
?>