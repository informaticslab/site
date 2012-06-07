<?php
/**
 * JComments plugin for zOOm Media Gallery support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_zoom extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgname FROM #__zoomfiles WHERE imgid = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		global $mainframe;

		$_Itemid = JCommentsPlugin::getItemid( 'com_zoom' );

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT catid, imgid FROM #__zoomfiles WHERE imgid = ' . $id );
		$catid = $db->loadResult();

		$key = 0;

		$zoomCfg =  JOOMLATUNE_JPATH_SITE . DS . 'components' . DS . 'com_zoom' . DS . 'etc' . DS . 'zoom_config.php';

		if ( is_file( $zoomCfg ) ) {
			global $zoomConfig;

			require( $zoomCfg );

			$orderMethod = '';

			switch ($zoomConfig['orderMethod']) {
				case 1:
					$orderMethod = "imgdate ASC";
					break;
				case 2:
					$orderMethod = "imgdate DESC";
					break;
				case 3:
					$orderMethod = "imgfilename ASC";
					break;
				case 4:
					$orderMethod = "imgfilename DESC";
					break;
				case 5:
					$orderMethod = "imgname ASC";
					break;
				case 6:
					$orderMethod = "imgname DESC";
					break;
			}
			$db->setQuery( 'SELECT imgid FROM #__zoomfiles WHERE catid = ' . $catid . ' ORDER BY ' . $orderMethod );
			$rows = $db->loadObjectList();
			for($i=0,$n=count($rows);$i<$n;$i++) {
				if ($rows[$i]->imgid == $id) {
					$key = $i;
					break;
				}
			}
			unset( $rows );
		}

		$link = JoomlaTuneRoute::_('index.php?option=com_zoom&amp;page=view&amp;catid='.$catid.'&amp;PageNo=1&amp;key=' . $key . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>