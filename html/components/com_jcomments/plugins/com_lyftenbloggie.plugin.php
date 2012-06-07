<?php
/**
 * JComments plugin for LyftenBloggie entries support
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_lyftenbloggie extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, title FROM #__bloggies_entries WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__bloggies_entries WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$db = & JFactory::getDBO();
		$query = 'SELECT e.id, e.created,'
			. ' CASE WHEN CHAR_LENGTH(e.alias) THEN CONCAT_WS(":", e.id, e.alias) ELSE e.id END as slug'
			. ' FROM #__bloggies_entries AS e'
			. ' WHERE e.id = '.$id
			;
		$db->setQuery($query);
		$entry = $db->loadObject();
		$entry->archive	= (!empty($entry)) ? JHTML::_('date',  $entry->created, '&year=%Y&month=%m&day=%d') : '';

		include_once(JPATH_SITE.DS.'includes'.DS.'application.php');
		include_once(JPATH_SITE.DS.'components'.DS.'com_lyftenbloggie'.DS.'helpers'.DS.'route.php');
		include_once(JPATH_SITE.DS.'components'.DS.'com_lyftenbloggie'.DS.'router.php');

		$link = JRoute::_(LyftenBloggieHelperRoute::getEntryRoute($entry->archive, $entry->slug));
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__bloggies_entries WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>