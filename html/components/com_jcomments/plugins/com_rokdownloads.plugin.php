<?php
/**
 * JComments plugin for RokDownloads objects support
 *
 * @version 1.0
 * @package JComments
 * @author Aleksandar Bogdanovic (albog@banitech.com)
 * @copyright (C) 2006-2009 by Aleksandar Bogdanovic (http://www.banitech.com)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_rokdownloads extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT id, displayname as title FROM #__rokdownloads WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT displayname, id FROM #__rokdownloads WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_rokdownloads' );
		if (JCOMMENTS_JVERSION == '1.0') {
			$link = JoomlaTuneRoute::_('index.php?option=com_rokdownloads&amp;view=file&amp;Itemid=' . $_Itemid . '&amp;id=' .$id);
		}else{
			include_once(JPATH_SITE.DS.'includes'.DS.'application.php');

			$link = 'index.php?option=com_rokdownloads&amp;view=file&amp;Itemid=' . $_Itemid . '&amp;id=' .$id;

			$router = JPATH_SITE . DS . 'components' . DS . 'com_rokdownloads' . DS . 'router.php';
			if (is_file($router)) {
				include_once($router);
			}
			$link = JRoute::_($link);
		}
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT created_by, id FROM #__rokdownloads WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>