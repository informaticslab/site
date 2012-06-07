<?php
/**
 * JComments plugin for AFM (Adeptus File Manager)
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_afm extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT file_title FROM #__afm_files WHERE file_id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_afm' );

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT cat_id FROM #__afm_files WHERE file_id = ' . $id );
		$catid = $db->loadResult();

		$link = sefRelToAbs( 'index.php?option=com_afm&amp;task=answer&amp;catid='.$catid.'&amp;aid=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>