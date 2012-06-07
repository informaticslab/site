<?php
/**
 * JComments plugin for SOBI2 objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_sobi2 extends JCommentsPlugin
{
	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT itemid as id, title FROM #__sobi2_item WHERE itemid IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
	        global $mainframe;

		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT title, itemid FROM #__sobi2_item WHERE itemid = ' . $id );
		$title = $db->loadResult();
 
		return jc_com_sobi2::getSobiStr($title);
	}

	function getObjectLink($id)
	{
		global $mainframe;


		if (!isset($GLOBALS['jc_sobi2itemid'])) {

		        $_requestOption = JCommentsInput::getVar('option', '');
		        $_requestItemid = (int) JCommentsInput::getVar('Itemid', 0);
			$_Itemid = null;

			$db = & JCommentsFactory::getDBO();
		    	$query = "SELECT `configValue`"
		    		. "\nFROM `#__sobi2_config`"
		    		. "\nWHERE `configKey` = 'forceMenuId'"
		    		. "\n  AND `sobi2Section` = 'general'"
		    		;
			$db->setQuery($query);
			$forceMenuId = (int) $db->loadResult();

			if ($_requestOption == 'com_sobi2' && !$forceMenuId) {
			        $_Itemid = $_requestItemid;
			} else {
				$_Itemid = JCommentsPlugin::getItemid('com_sobi2');
			}

			$GLOBALS['jc_sobi2itemid'] = $_Itemid;
		}

		$_Itemid = $GLOBALS['jc_sobi2itemid'];

		if ($_Itemid != null) {
			$_Itemid = '&amp;Itemid=' . $_Itemid;
		} else {
			$_Itemid = '';
		}

		$link = JoomlaTuneRoute::_('index.php?option=com_sobi2&amp;sobi2Task=sobi2Details&amp;sobi2Id=' . $id . $_Itemid);
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT owner FROM #__sobi2_item WHERE itemid = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id as `value`, name AS `text`"
			. "\n FROM #__sobi2_categories	 AS c"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY c.ordering"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}

	/**
	 * reversing MySQL injection filter
	 *
	 * @param string $string - string to decode
	 * @return string
	 */
	function getSobiStr( $string )
	{
		if( $string ) {
			$iso = defined("_ISO") ? explode( '=', _ISO ) : array( null, "UTF-8");
			if(strtoupper($iso[1]) != "UTF-8" ) {
				$string = stripslashes(stripslashes(html_entity_decode($string, ENT_COMPAT, 'UTF-8')));
			}
			else {
				$string = stripslashes(stripslashes($string));
			}
			if( !strstr( "<script", $string  ) ) {
				$string = str_replace( "& ", "&amp; ", $string );
			}
		}
		return  $string;
	}
}
?>