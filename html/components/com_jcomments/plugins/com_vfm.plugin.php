<?php
/**
 * JComments plugin for VFM support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_vfm extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, id FROM #__vfm_files WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		global $mainframe;

		$_Itemid = JCommentsPlugin::getItemid('com_vfm');

		$link = '';

		$vfm_core =  JOOMLATUNE_JPATH_SITE . DS . 'administrator'. DS . 'components' . DS . 'com_vfm' . DS . 'VFM_Core.class.php';
		if (is_file($vfm_core)) {
		 	require_once($vfm_core);
		 	$db = & JCommentsFactory::getDBO();
		 	$db->setQuery('SELECT filename FROM #__vfm_files WHERE id = ' . $id );
		 	$filename = $db->loadResult();
			$link = sefRelToAbs( 'index.php?option=com_vfm&amp;do=view&amp;file=' . VFM_Core::encodePath($filename) . '&amp;Itemid=' . $_Itemid );
                }
		return $link;
	}
}
?>