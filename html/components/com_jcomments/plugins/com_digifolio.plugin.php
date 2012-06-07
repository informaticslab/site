<?php
/**
 * JComments plugin for DigiFolio projects support
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_digifolio extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, name as title FROM #__digifolio_projects WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

        function getObjectTitle($id)
        {
                $db = & JCommentsFactory::getDBO();
                $db->setQuery( 'SELECT name, id FROM #__digifolio_projects WHERE id = ' . $id );
                return $db->loadResult();
        }

        function getObjectLink($id)
        {
                $db = & JCommentsFactory::getDBO();
	        $query = "SELECT CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(':', a.id, a.alias) ELSE a.id END as slug "
                	 . "\n FROM #__digifolio_projects as a "
                	 . "\n WHERE id = " . $id
	                 ;
                $db->setQuery($query);
                $slug = $db->loadResult();

		$link = 'index.php?option=com_digifolio&amp;view=project&amp;id=' . $slug;
		$_Itemid = JCommentsPlugin::getItemid('com_digifolio');
		$link .= ($_Itemid > 0) ? ('&Itemid=' . $_Itemid) : '';
		$link = JRoute::_( $link );
                return $link;
        }

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__digifolio_projects WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>