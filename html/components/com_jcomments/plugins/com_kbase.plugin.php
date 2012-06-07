<?php
/**
 * JComments plugin for KBase (http://www.jmds.eu) support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_kbase extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__kbase_articles WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__kbase_articles WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$link = JRoute::_('index.php?option=com_kbase&view=article&id='. $id );
		return $link;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();
		$query = "SELECT id AS `value`, title AS `text`"
			. "\n FROM #__kbase_categories"
			. (($filter != '') ? "\n WHERE id IN ( ".$filter." )" : '')
			. "\n ORDER BY name"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>