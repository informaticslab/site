<?php
/**
 * JComments plugin for QuickFAQ (http://joomlacode.org/gf/project/quickfaq) articles support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_quickfaq extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__quickfaq_items WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
	        $link = '';

	        $quickFaqRouterPath = JPATH_SITE.DS.'components'.DS.'com_quickfaq'.DS.'helpers'.DS.'route.php';
	        
	        if (is_file($quickFaqRouterPath)) {
			require_once ($quickFaqRouterPath);

			$db = & JCommentsFactory::getDBO();
			
			$query = 'SELECT CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(\':\', i.id, i.alias) ELSE i.id END as slug,'
				. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as categoryslug'
				. ' FROM #__quickfaq_items AS i'
				. ' LEFT JOIN #__quickfaq_cats_item_relations AS rel ON rel.itemid = i.id'
				. ' LEFT JOIN #__quickfaq_categories AS c ON c.id = rel.catid'
				. ' WHERE i.id = '.$id
				;
			$db->setQuery($query);
			$row = $db->loadObject();
			
			$link = JRoute::_(QuickfaqHelperRoute::getItemRoute($row->slug, $row->categoryslug));
		}

		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__quickfaq_items WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT id AS `value`, title AS `text`"
			. "\n FROM #__quickfaq_categories"
			. (($filter != '') ? "\n WHERE id IN ( ".$filter." )" : '')
			. "\n ORDER BY title"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>