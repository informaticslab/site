<?php
/**
 * JComments plugin for DatsoGallery objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_datsogallery extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, imgtitle as title FROM #__datsogallery WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT imgtitle, id FROM #__datsogallery WHERE id = ' . $id);
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid('com_datsogallery');
		$link = JoomlaTuneRoute::_( 'index.php?option=com_datsogallery&amp;func=detail&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT u.id "
			. "\n FROM #__users AS u"
			. "\n INNER JOIN #__datsogallery AS dg ON dg.owner = u.username"
			. "\n WHERE dg.id = " . $id
			;
			
		$db->setQuery( $query );
		$userid = $db->loadResult();
		
		return intval( $userid );
	}

	function getCategories($filter = '') {

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.cid as `value`, c.name AS `text`"
			. "\n FROM #__datsogallery_catg AS c"
			. (($filter != '') ? "\n WHERE c.cid IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>