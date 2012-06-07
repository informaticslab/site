<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend content viewer
 *
 * @version 2.1
 * @package JComments
 * @subpackage Admin
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

class JCommentsAdminSubscriptionManager
{
	function show()
	{
		global $mainframe;

		$option = JCommentsInput::getVar('option');

		$object_group = trim($mainframe->getUserStateFromRequest("fog{$option}", 'fog', ''));
		$object_id = intval($mainframe->getUserStateFromRequest("foid{$option}", 'foid', 0));
		$flang = trim($mainframe->getUserStateFromRequest("flang{$option}", 'flang', ''));
		$fauthor = trim($mainframe->getUserStateFromRequest("fauthor{$option}", 'fauthor', ''));
		$fstate = trim($mainframe->getUserStateFromRequest("fstate{$option}", 'fstate', ''));
		$limit = intval($mainframe->getUserStateFromRequest("view{$option}limit", 'limit', $mainframe->getCfg('list_limit')));
		$limitstart = intval($mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0));

		$filter_order     = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'js.name' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'asc' );
		$search	= trim($mainframe->getUserStateFromRequest($option.'subscriptions.search', 'search', ''));

		if (JCOMMENTS_JVERSION == '1.5') {
			$search	= JString::strtolower($search);
		} else {
			$search	= strtolower($search);
		}

		if ($filter_order == "") {
			$filter_order = 'js.name';
		}
		if ($filter_order_Dir == "") {
			$filter_order_Dir = 'asc';
		}

	        $lists['order'] = $filter_order;
	        $lists['order_Dir'] = $filter_order_Dir;
	        $lists['search'] = $search;

		$db = & JCommentsFactory::getDBO();

		$where = array();

		if ($object_group != '') {
			$where[] = 'js.object_group = "' . $object_group . '"';
		}

		if ($object_id != 0) {
			$where[] = 'js.object_id = ' . $object_id;
		}

		if ($flang != '') {
			$where[] = 'js.lang = "' . $flang . '"';
		}

		if (trim($fauthor) != '') {
			$where[] = 'js.name = "' . $fauthor . '"';
		}

		if (trim($fstate) != '' && trim($fstate) != '-1') {
			$where[] = 'js.published = "' . intval($fstate) . '"';
		}

		if ($search != '') {
			$where[] = '(js.name like "%' . $search. '%" OR js.email like "%' . $search. '%")';
		}

		$query = "SELECT COUNT(*)"
			. "\nFROM #__jcomments_subscriptions AS js"
			. (count($where) ? ("\nWHERE " . implode(' AND ', $where)) : "" )
			;
		$db->setQuery($query);
		$total = $db->loadResult();

		if ( JCOMMENTS_JVERSION == '1.0' ) {
			require_once ($mainframe->getCfg('absolute_path').DS.'administrator'.DS.'includes'.DS.'pageNavigation.php');
			$lists['pageNav'] = new mosPageNav($total, $limitstart, $limit);
		} else {
			jimport('joomla.html.pagination');
			$lists['pageNav'] = new JPagination( $total, $limitstart, $limit );
		}

		$query = "SELECT js.*, u.name AS editor"
			. "\nFROM #__jcomments_subscriptions AS js"
			. "\n LEFT JOIN #__users AS u ON u.id = js.userid"
			. (count($where) ? ("\nWHERE " . implode(' AND ', $where)) : "" )
			. "\nORDER BY " . $filter_order . ' ' . $filter_order_Dir
			;
		$db->setQuery( $query, $lists['pageNav']->limitstart, $lists['pageNav']->limit );
		$lists['rows'] = $db->loadObjectList();

		// Filter by object_group (component)
		$query = "SELECT DISTINCT(object_group) AS name, object_group AS value "
			. "\nFROM #__jcomments_subscriptions"
			. "\nORDER BY name"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$cnt = count($rows);

		if ($cnt > 1 || ($cnt == 1 && $total = 0)) {
			array_unshift($rows, JCommentsHTML::makeOption('', JText::_('A_FILTER_ALL_COMPONENTS'), 'name', 'value'));
			$lists['fog'] = JCommentsHTML::selectList($rows, 'fog', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'name', 'value', $object_group);
		} else if ($cnt == 1) {
			if ($object_group == '') {
				$object_group = $rows[0]->name;
			}
		}
		unset($rows);

		if ($object_group != '') {
			$query = "SELECT DISTINCT(object_id) AS value "
				. "\nFROM #__jcomments_subscriptions "
				. "\nWHERE object_group = '" . $object_group . "'"
				. (($flang != '') ? "AND lang = '" . $flang . "'" : "")
				;
			$db->setQuery($query);
			$rows = $db->loadObjectList();

			for ($i = 0, $n = count($rows); $i < $n; $i++) {
				$rows[$i]->name = JCommentsObjectHelper::getTitle($rows[$i]->value, $object_group, $flang);
				if ($rows[$i]->name == '') {
					$rows[$i]->name = 'Untitled' . $rows[$i]->value;
				}
			}

			// Don't show filter if we have more than 100 objects
			if (count($rows) < 100) {
				usort($rows, create_function('$a, $b', 'return strcasecmp( $a->name, $b->name);'));
				array_unshift($rows, JCommentsHTML::makeOption('', '', 'name', 'value'));
				$lists['foid'] = JCommentsHTML::selectList($rows, 'foid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'name', $object_id);
				unset($rows);
			}
		}

		// Filter by language
		$query = "SELECT DISTINCT(lang) AS text, lang AS value "
			. "\nFROM #__jcomments_subscriptions"
			. "\nORDER BY lang"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if (count($rows) > 1) {
			array_unshift($rows, JCommentsHTML::makeOption('', '', 'text', 'value'));
			$lists['flang'] = JCommentsHTML::selectList($rows, 'flang', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'text', 'value', $flang);
		}
		unset($rows);

		// Filter by published state
		$stateOptions = array();
		$stateOptions[] = JCommentsHTML::makeOption('', JText::_('Select state'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('-1', JText::_('All'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('1', JText::_('Published'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('0', JText::_('Unpublished'), 'text', 'value');
		$lists['fstate'] = JCommentsHTML::selectList($stateOptions, 'fstate', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'text', 'value', $fstate);
		unset($stateOptions);

		// Filter by author
		$lists['fauthor'] = '';

		$db->setQuery("SELECT COUNT(DISTINCT(name)) FROM #__jcomments_subscriptions;");
		$usersCount = $db->loadResult();

		// Don't show filter if we have more than 100 comments' authors
		if ($usersCount > 0 && $usersCount < 100) {
			$query = "SELECT DISTINCT(name) AS author, name AS value "
				. "\nFROM #__jcomments_subscriptions"
				. "\nORDER BY name"
				;
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if (count($rows) > 1) {
				array_unshift($rows, JCommentsHTML::makeOption('', JText::_('A_FILTER_ALL_AUTHORS'), 'author', 'value'));
				$lists['fauthor'] = JCommentsHTML::selectList($rows, 'fauthor', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'author', 'value', $fauthor);
			}
			unset($rows);
		}

		HTML_JCommentsAdminSubscriptionManager::show($lists);
	}

	function edit()
	{
		global $mainframe;

		$id = JCommentsInput::getVar('cid', 0);
		if (is_array($id)) {
			$id = $id[0];
		}

		$db = & JCommentsFactory::getDBO();

		require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');

		$row = new JCommentsSubscriptionsDB($db);

		if ($id) {
			$row->load($id);
			$row->object_title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group, $row->lang);
			$row->link = $mainframe->getCfg('live_site') . '/' . JCOMMENTS_INDEX . '?option=com_jcomments&task=go2object&object_id=' . $row->object_id . '&object_group=' . $row->object_group . '&no_html=1';
		}

		HTML_JCommentsAdminSubscriptionManager::edit($row);
	}

	function save()
	{
		$task = JCommentsInput::getVar('task');
		$id = (int) JCommentsInput::getVar('id', 0);

		$bbcode = & JCommentsFactory::getBBCode();
		$db = & JCommentsFactory::getDBO();

		require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');

		$row = new JCommentsSubscriptionsDB($db);
		if ($id) {
			$row->load($id);
		}

		$row->object_id = (int) JCommentsInput::getVar('object_id');
		$row->object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.\*]#is', '', trim(strip_tags(JCommentsInput::getVar('object_group'))));
		$row->name = preg_replace("/[\'\"\>\<\(\)\[\]]?+/i", '', strip_tags(JCommentsInput::getVar('name')));
		$row->email = trim(strip_tags(JCommentsInput::getVar('email')));
		$row->store();

		JCommentsCache::cleanCache('com_jcomments');

		switch ($task) {
			case 'subscription.apply':
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=subscription.edit&hidemainmenu=1&cid[]=' . $row->id);
				break;
			case 'subscription.save':
			default:
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=subscriptions');
				break;
		}
	}

	function publish( $publish )
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("UPDATE #__jcomments_subscriptions SET published='$publish' WHERE id IN ($ids)");
			$db->query();
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=subscriptions');
	}

	function cancel()
	{
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=subscriptions');
	}

	function remove()
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("DELETE FROM #__jcomments_subscriptions WHERE id IN ($ids)");
			$db->query();
			JCommentsCache::cleanCache('com_jcomments');
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=subscriptions');
	}
}

class HTML_JCommentsAdminSubscriptionManager
{
	function show( $lists )
	{
		global $mainframe;

		$filter = '';
		$filterClear = '';

		if (isset($lists['fog'])) {
			$filter .= ' ' . $lists['fog'];
			$filterClear .= "document.getElementById('fog').value='';";
		}
		if (isset($lists['flang'])) {
			$filter .= ' ' . $lists['flang'];
			$filterClear .= "document.getElementById('flang').value='';";
		}
		if (isset($lists['foid'])) {
			$filter .= ' ' . $lists['foid'];
			$filterClear .= "document.getElementById('foid').value='';";
		}
		if (isset($lists['fauthor']) && $lists['fauthor'] != '') {
			$filter .= ' ' . $lists['fauthor'];
			$filterClear .= "document.getElementById('fauthor').value='';";
		}
		if (isset($lists['fstate'])) {
			$filter .= ' ' . $lists['fstate'];
			$filterClear .= "document.getElementById('fstate').value='';\n";
		}

		if (JCOMMENTS_JVERSION == '1.5') {
?>
<script type="text/javascript">
<!--
function tableOrdering( order, dir, task )
{
        var form = document.adminForm;
        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
}
//-->
</script>
<?php
		}
?>
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
<table class="adminheading" width="100%">
	<tr>
<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
	<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/subscriptions48x48.png" width="48" height="48" align="middle" />&nbsp;<?php echo JText::_('A_SUBSCRIPTIONS'); ?></th>
<?php
		}
?>
	<td nowrap="nowrap" align="left" width="50%">
		<label for="search"><?php echo JText::_('A_FILTER'); ?>:</label>
		<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';<?php echo $filterClear; ?>this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
	<td nowrap="nowrap" align="right" width="50%">
<?php
		if (trim($filter) != '') {
			echo $filter;
		}
?>
	</td>
	</tr>
</table>
<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="5" class="title"><label for="toggle">#</label></th>
			<th width="5"><input type="checkbox" id="toggle" name="toggle" value="" onclick="checkAll(<?php echo count( $lists['rows'] );?>);" /></th>
<?php
		if (JCOMMENTS_JVERSION == '1.5') {
?>
			<th width="20%" align="left" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'Name', 'js.name', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="20%" align="left"><?php echo JHTML::_( 'grid.sort', 'E-mail', 'js.email', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="40%" align="left"><?php echo JText::_('A_COMMENT_OBJECT_TITLE'); ?></th>
			<th width="10%" align="left"><?php echo JHTML::_( 'grid.sort', 'A_COMPONENT', 'js.object_group', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="10%" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'State', 'js.published', $lists['order_Dir'], $lists['order']); ?></th>
<?php
		} else {
?>
			<th width="20%" align="left" nowrap="nowrap"><?php echo JText::_('Name'); ?></th>
			<th width="20%" align="left"><?php echo JText::_('E-mail'); ?></th>
			<th width="40%" align="left"><?php echo JText::_('A_COMMENT_OBJECT_TITLE'); ?></th>
			<th width="10%" align="left"><?php echo JText::_('A_COMPONENT'); ?></th>
			<th width="10%" nowrap="nowrap"><?php echo JText::_('State'); ?></th>
<?php
		}
?>
		</tr>
	</thead>
	<tbody>
<?php
		for ($i = 0, $k = 0, $n = count($lists['rows']); $i < $n; $i++) {
			$row =& $lists['rows'][$i];
			$task = $row->published ? 'subscription.unpublish' : 'subscription.publish';
			$img = $row->published ? 'tick.png' : 'publish_x.png';

			$row->title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group, $row->lang);
			$row->link = $mainframe->getCfg('live_site') . '/' . JCOMMENTS_INDEX . '?option=com_jcomments&task=go2object&object_id=' . $row->object_id . '&object_group=' . $row->object_group . '&no_html=1';

			$link 	= JCOMMENTS_INDEX . '?option=com_jcomments&task=subscription.edit&hidemainmenu=1&cid='. $row->id;
			$link_title = (JCOMMENTS_JVERSION == '1.5') ? JText::_('Edit') : _E_EDIT;

			$statusTitle = ($row->published ? JText::_('A_DISABLE') : JText::_('A_ENABLE'));
?>
<tr class="<?php echo "row$k"; ?>">
	<td><label for="cb<?php echo $i; ?>"><?php echo $i+1+$lists['pageNav']->limitstart;?></label></td>
	<td width="20"><input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
	<td align="left"><a href="<?php echo $link; ?>" title="<?php echo $link_title; ?>"><?php echo $row->name; ?></a></td>
	<td align="left"><?php echo $row->email; ?></td>
	<td align="left"><a href="<?php echo $row->link; ?>" title="<?php echo htmlspecialchars($row->title); ?>" target="_blank"><?php echo $row->title; ?></a></td>
	<td align="left">[<?php echo $row->object_group; ?>]</td>
	<td align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')" title="<?php echo $statusTitle; ?>"><img src="images/<?php echo $img;?>" border="0" alt="<?php echo $statusTitle; ?>" /></a></td>
</tr>
<?php
			$k = 1 - $k;
		}
?>
</tbody>
	<tfoot>
		<tr>
			<td colspan="15"><?php echo $lists['pageNav']->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>
<input type="hidden" name="option" value="com_jcomments" />
<input type="hidden" name="task" value="subscriptions" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
<?php
	}

	function edit( $row )
	{
?>
<style type="text/css">
.editbox {border: 1px solid #ccc;padding: 2px;}
.short {width: 40px;}
.long {width: 450px;}
</style>
<script type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'subscription.cancel') {
		submitform( pressbutton );
		return;
	}
	if ( form.email.value == "" ) {
		alert( "<?php echo JText::_('ERROR_EMPTY_EMAIL'); ?>" );
	} else {
		submitform( pressbutton );
	}
}
//-->
</script>
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
<table class="adminheading">
	<tr>
		<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/subscriptions48x48" width="48" height="48" align="middle">&nbsp;<?php echo JText::_('EDIT');?></th>
	</tr>
</table>
<?php
		}
?>
<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
<tr valign="top" align="left">
	<td><label for="object_group"><?php echo JText::_('Component'); ?></label></td>
	<td><input type="text" class="editbox long" size="35" id="object_group" name="object_group" value="<?php echo $row->object_group; ?>"></td>
</tr>
<tr valign="top" align="left">
	<td><label for="object_id"><?php echo JText::_('Object ID'); ?></label></td>
	<td><input type="text" class="editbox short" size="35" id="object_id" name="object_id" value="<?php echo $row->object_id; ?>"></td>
</tr>
<tr valign="top" align="left">
	<td><label for="name"><?php echo JText::_('Name'); ?></label></td>
	<td><input type="text" class="editbox long" size="35" id="name" name="name" value="<?php echo $row->name; ?>"></td>
</tr>
<tr valign="top" align="left">
	<td><label for="email"><?php echo JText::_('E-mail'); ?></label></td>
	<td><input type="text" class="editbox long" size="35" id="email" name="email" value="<?php echo $row->email; ?>"></td>
</tr>
<tr valign="top" align="left">
	<td><?php echo JText::_('State'); ?></td>
	<td><?php echo JCommentsHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published, JText::_('A_YES'), JText::_('A_NO') ); ?></td>
</tr>
</table>
<input type="hidden" name="option" value="com_jcomments" />
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
<?php
	}
}
?>