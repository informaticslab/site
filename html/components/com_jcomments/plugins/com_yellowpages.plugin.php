<?php
/**
 * JComments plugin for Yellowpages component objects support
 *
 * @version 1.4
 * @package JComments
 * @author tumtum (tumtum@mail.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_yellowpages extends JCommentsPlugin
{
	function getObjectTitle( $id )
	{
		global $database;

		$database->setQuery( "SELECT title, id FROM #__jyp_entries WHERE id='$id'");
		return $database->loadResult();
	}
 
	function getObjectLink( $id )
	{
		$_Itemid = JCommentsPlugin::getItemid( 'com_yellowpages' );

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT catid FROM #__jyp_entries WHERE id = ' . $id );
		$catid = $db->loadResult();


		$link = sefRelToAbs( 'index.php?option=com_yellowpages&Itemid='. $_Itemid.'&task=view&catid='. $catid .'&id=' . $id );
		return $link;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT id AS value, name AS text"
			. "\n FROM #__categories"
			. "\n WHERE section = 'com_yellowpages'"
			. "\n AND published = 1"
			. (($filter != '') ? "\n AND id IN ( ".$filter." )" : '')
			. "\n ORDER BY name"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>