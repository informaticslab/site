<?php
/**
 * JComments plugin for Music Collection support
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_muscol_artist extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, artist_name as title FROM #__muscol_artists WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

        function getObjectTitle($id)
        {
                $db = & JCommentsFactory::getDBO();
                $db->setQuery( 'SELECT artist_name, id FROM #__muscol_artists WHERE id = ' . $id );
                return $db->loadResult();
        }

        function getObjectLink($id)
        {
		$link = 'index.php?option=com_muscol&amp;view=artist&amp;id=' . $id;
		$_Itemid = JCommentsPlugin::getItemid('com_muscol');
		$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
		$link = JRoute::_( $link );
                return $link;
        }
}
?>