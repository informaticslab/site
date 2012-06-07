<?php
/**
 * JComments plugin for AutoBB objects support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2009 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_autobb extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT CONCAT( 'Комментарии для ',v.title,' ',m.title,' ',a.year,' г/в') as title"
			."\n FROM #__autobb_messages as a"
			."\n LEFT JOIN #__autobb_vendors as v ON v.id=a.vendor"
			."\n LEFT JOIN #__autobb_models as m ON m.id=a.model"
			."\n WHERE a.id='$id'"
			."\n GROUP BY a.id"
			."\n LIMIT 1"
			;
		$db->setQuery( $query );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		global $Itemid;

		$_Itemid = $Itemid;

		$db = & JCommentsFactory::getDBO();

		$query = "SELECT m.id as category_itemid, v.itemid as vendor_itemid, m1.itemid as model_itemid"
		."\n FROM #__menu as m"
		."\n LEFT JOIN #__categories as c ON m.params LIKE CONCAT('%category_id=',c.id,'%')"
		."\n LEFT JOIN #__autobb_messages as a ON c.id=a.category"
		."\n LEFT JOIN #__autobb_vendors as v ON a.vendor=v.id"
		."\n LEFT JOIN #__autobb_models as m1 ON a.model=m1.id"
		."\n WHERE m.type='components' AND m.link='index.php?option=com_autobb' AND c.section='com_autobb' and m.published=1 and a.id={$id}"
		."\n GROUP BY a.id"
		."\n LIMIT 1";
		$db->setQuery( $query );

		$result = null;

		if (JCOMMENTS_JVERSION == '1.5') {
			$config = &JFactory::getConfig();
			if($config->getValue('config.legacy')) {
				$db->loadObject( $result );
			} else {		
				$result = $db->loadObject();
			}
		} else {
			$db->loadObject($result);
		}


		if ($result != null) {
			if($result->model_itemid) {
				$_Itemid = $result->model_itemid;
			} else if ($result->model_itemid) {
				$_Itemid = $result->vendor_itemid;
			} else if ($result->category_itemid) {
				$_Itemid = $result->category_itemid;
			}
		}

		$link = sefRelToAbs( "index.php?option=com_autobb&amp;Itemid={$_Itemid}&amp;task=show&amp;id={$id}" );
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT userid FROM #__autobb_messages WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}
}
?>