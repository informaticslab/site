<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend event handler
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

ob_start();

global $mainframe;

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// include legacy class
if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
} else {
	require_once ($mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
}

if (!defined('JCOMMENTS_ENCODING')) {
	DEFINE('JCOMMENTS_ENCODING', strtolower(preg_replace('/charset=/', '', _ISO)));
	if (JCOMMENTS_ENCODING == 'utf-8') {
		// pattern strings are treated as UTF-8
		DEFINE('JCOMMENTS_PCRE_UTF8', 'u');
	} else {
		DEFINE('JCOMMENTS_PCRE_UTF8', '');
	}
}

if (JCOMMENTS_JVERSION == '1.0') {
	global $acl, $my;
	DEFINE('JCOMMENTS_INDEX', 'index2.php');

	// ensure user has access to this function
	if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all') | $acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'com_jcomments'))) {
		require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
		JCommentsRedirect('index2.php', _NOT_AUTH);
	}
} else {
	DEFINE('JCOMMENTS_INDEX', 'index.php');

	$acl = & JFactory::getACL();
	$option = JRequest::getCmd('option');
	$task = JRequest::getCmd('task');
	$mainframe = & JFactory::getApplication();
}

$result = ob_get_contents();
ob_end_clean();

// save PHP error reporting settings
$_error_reporting = @error_reporting(0);

require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
require_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
require_once (JCOMMENTS_BASE.DS.'model'.DS.'jcomments.php');
require_once (JCOMMENTS_HELPERS.DS.'object.php');
require_once (JCOMMENTS_HELPERS.DS.'html.php');
require_once (dirname(__FILE__).DS.'admin.jcomments.html.php');

if ($task != 'postinstall') {
	$config = & JCommentsFactory::getConfig();
}

if (!function_exists('sefRelToAbs')){
	if (!defined('_URL_SCHEMES')) {
		$url_schemes = 'data:, file:, ftp:, gopher:, imap:, ldap:, mailto:, news:, nntp:, telnet:, javascript:, irc:, mms:';
		DEFINE( '_URL_SCHEMES', $url_schemes );
	}

	function sefRelToAbs( $string )
	{
		global $mainframe;

		if ( (strpos( $string, $mainframe->getCfg( 'live_site' ) ) !== 0) ) {
			if (strncmp($string, '/', 1) == 0) {
				$live_site_parts = array();
				eregi('^(https?:[\/]+[^\/]+)(.*$)', $mainframe->getCfg( 'live_site' ), $live_site_parts);
				$string = $live_site_parts[1] . $string;
			} else {
				$check = 1;
				$url_schemes 	= explode( ', ', _URL_SCHEMES );
				$url_schemes[] 	= 'http:';
				$url_schemes[] 	= 'https:';

				foreach ( $url_schemes as $url ) {
					if ( strpos( $string, $url ) === 0 ) {
						$check = 0;
					}
				}
				if ( $check ) {
					$string = $mainframe->getCfg( 'live_site' ) .'/'. $string;
				}
			}
		}
		return $string;
	}
}

if ($option == 'com_jcomments') {

	if (isset($_REQUEST['jtxf'])) {
		require_once (JCOMMENTS_BASE.DS.'jcomments.ajax.php');

		$jtx = new JoomlaTuneAjax();
		$jtx->setCharEncoding(JCOMMENTS_ENCODING);
		$jtx->registerFunction(array('JCommentsSaveSettingsAjax', 'JCommentsAdmin', 'saveSettingsAjax'));
		$jtx->registerFunction(array('JCommentsRestoreSettingsAjax', 'JCommentsAdmin', 'restoreSettingsAjax'));
		$jtx->registerFunction(array('JCommentsImportCommentsAjax', 'JCommentsAdmin', 'importCommentsAjax'));
		$jtx->processRequests();

	} else if (isset($_REQUEST['no_html']) && intval($_REQUEST['no_html']) == 1) {
		require_once (JCOMMENTS_BASE.DS.'jcomments.php');
	} else {

		switch ($task) {
			case "comments":
				JCommentsAdmin::checkPhpVersion();
				JCommentsAdmin::show();
				break;
			case 'edit':
				JCommentsAdmin::edit();
				break;
			case 'apply':
			case 'save':
				JCommentsAdmin::save();
				break;
			case 'cancel':
				JCommentsAdmin::cancel();
				break;
			case 'publish':
				JCommentsAdmin::publish(1);
				break;
			case 'unpublish':
				JCommentsAdmin::publish(0);
				break;
			case 'remove':
				JCommentsAdmin::remove();
				break;
			case "settings":
				JCommentsAdmin::checkPhpVersion();
				JCommentsAdmin::showSettings();
				break;
			case "settings.cancel":
				JCommentsAdmin::cancelSettings();
				break;
			case "settings.save":
				JCommentsAdmin::saveSettingsDefault();
				break;
			case "settings.restore":
				JCommentsAdmin::restoreSettingsDefault();
				break;
			case "smiles":
				JCommentsAdmin::checkPhpVersion();
				JCommentsAdmin::showSmiles();
				break;
			case "savesmiles":
				JCommentsAdmin::saveSmiles();
				break;
			case "about":
				require_once (dirname(__FILE__).DS.'admin.jcomments.installer.php');
				JCommentsAdmin::showAbout();
				break;
			case "import":
				JCommentsAdmin::checkPhpVersion();
				require_once (dirname(__FILE__).DS.'admin.jcomments.migration.php');
				JCommentsMigrationTool::showImport();
				break;
			case "doimport":
				JCommentsAdmin::importCommentsDefault();
				break;
			case "postinstall":
				JCommentsAdmin::checkPhpVersion();
				require_once (dirname(__FILE__).DS.'admin.jcomments.installer.php');
				JCommentsInstaller::postInstall();
				break;
			case "rebuildtree":
				JCommentsAdmin::rebuildTree();
				break;
			case 'subscriptions':
				JCommentsAdmin::checkPhpVersion();
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::show();
				break;
			case 'subscription.publish':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::publish(1);
				break;
			case 'subscription.unpublish':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::publish(0);
				break;
			case 'subscription.new':
			case 'subscription.edit':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::edit();
				break;
			case 'subscription.apply':
			case 'subscription.save':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::save();
				break;
			case 'subscription.delete':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::remove();
				break;
			case 'subscription.cancel':
				require_once (dirname(__FILE__).DS.'admin.jcomments.subcription.php');
				JCommentsAdminSubscriptionManager::cancel();
				break;
			case 'custombbcode':
			case 'custombbcodes':
				JCommentsAdmin::checkPhpVersion();
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::show();
				break;
			case 'custombbcode.publish':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::publish(1);
				break;
			case 'custombbcode.unpublish':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::publish(0);
				break;
			case 'custombbcode.enable_button':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::enableButton(1);
				break;
			case 'custombbcode.disable_button':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::enableButton(0);
				break;
			case 'custombbcode.new':
			case 'custombbcode.edit':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::edit();
				break;
			case 'custombbcode.apply':
			case 'custombbcode.save':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::save();
				break;
			case 'custombbcode.delete':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::remove();
				break;
			case 'custombbcode.copy':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::copy();
				break;
			case 'custombbcode.orderup':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::order(-1);
				break;
			case 'custombbcode.orderdown':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::order(1);
				break;
			case 'custombbcode.cancel':
				require_once (dirname(__FILE__).DS.'admin.jcomments.custombbcodes.php');
				JCommentsACustomBBCodes::cancel();
				break;

			default:
				JCommentsAdmin::checkPhpVersion();
				JCommentsAdmin::show();
				break;
		}
	}
}

class JCommentsAdmin
{
	function show()
	{
		global $mainframe;

		require_once (JCOMMENTS_BASE.DS.'jcomments.php');

		$option = JCommentsInput::getVar('option');

		$object_group = trim($mainframe->getUserStateFromRequest("fog{$option}", 'fog', ''));
		$object_id = intval($mainframe->getUserStateFromRequest("foid{$option}", 'foid', 0));
		$flang = trim($mainframe->getUserStateFromRequest("flang{$option}", 'flang', ''));
		$fauthor = trim($mainframe->getUserStateFromRequest("fauthor{$option}", 'fauthor', ''));
		$fstate = trim($mainframe->getUserStateFromRequest("fstate{$option}", 'fstate', ''));
		$limit = intval($mainframe->getUserStateFromRequest("view{$option}limit", 'limit', $mainframe->getCfg('list_limit')));
		$limitstart = intval($mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0));

        	$filter_order     = $mainframe->getUserStateFromRequest( $option.'.comments.filter_order', 'filter_order', 'c.date' );
	        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'.comments.filter_order_Dir', 'filter_order_Dir', 'desc' );
		$search	= trim($mainframe->getUserStateFromRequest($option.'.comments.search', 'search', ''));

		if ($filter_order == "") {
			$filter_order = 'c.date';
		}
		if ($filter_order_Dir == "") {
			$filter_order_Dir = 'desc';
		}

		if (JCOMMENTS_JVERSION == '1.5') {
			$search	= JString::strtolower($search);
		} else {
			$search	= strtolower($search);
		}

	        $lists['order'] = $filter_order;
	        $lists['order_Dir'] = $filter_order_Dir;
	        $lists['search'] = $search;

		$db = & JCommentsFactory::getDBO();

		// load object_groups (components)
		$query = "SELECT DISTINCT(object_group) AS name, object_group AS value "
			. "\nFROM #__jcomments "
			. "\nORDER BY object_group"
			;
		$db->setQuery($query);
		$objectGroups = $db->loadObjectList('name');

		$cnt = count($objectGroups);

		if ($cnt == 0 || ($cnt > 0 && !in_array($object_group, array_keys($objectGroups)))) {
			$mainframe->setUserState("fog{$option}", '');
			$mainframe->setUserState("foid{$option}", '');
			$object_group = '';
		}

		$where = array();

		if ($object_group != '') {
			$where[] = 'c.object_group = "' . $object_group . '"';
		} else {
			$object_id = 0;
			$mainframe->setUserState("foid{$option}", '');
		}

		if ($object_id != 0) {
			$where[] = 'c.object_id = ' . $object_id;
		}

		if ($flang != '') {
			$where[] = 'c.lang = "' . $flang . '"';
		}

		if (trim($fauthor) != '') {
			$where[] = 'c.name = "' . $fauthor . '"';
		}

		if (trim($fstate) != '' && trim($fstate) != '-1') {
			$where[] = 'c.published = "' . intval($fstate) . '"';
		}

		if ($search != '') {
			$where[] = '('
					. 'LOWER(c.comment) like "%' . $search. '%" OR '
					. 'LOWER(c.title) like "%' . $search. '%" OR '
					. 'LOWER(c.name) like "%' . $search. '%" OR '
					. 'LOWER(c.username) like "%' . $search. '%" OR '
					. 'LOWER(c.email) like "%' . $search. '%"'
					. ')'
					;
		}

		$query = "SELECT COUNT(*)"
			. "\nFROM #__jcomments AS c"
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

		$query = "SELECT c.*, u.name AS editor, js.id as subscription"
			. "\nFROM #__jcomments AS c"
			. "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
			. "\n LEFT JOIN #__jcomments_subscriptions AS js ON js.object_id = c.object_id AND js.object_group = c.object_group AND ((c.userid > 0 AND js.userid = c.userid) OR (js.email <> '' AND c.email <> '' AND js.email = c.email)) AND js.lang = c.lang"
			. (count($where) ? ("\nWHERE " . implode(' AND ', $where)) : "" )
			. "\nORDER BY " . $filter_order . ' ' . $filter_order_Dir
			;
		$db->setQuery( $query, $lists['pageNav']->limitstart, $lists['pageNav']->limit );
		$lists['rows'] = $db->loadObjectList();

		// Filter by object_group (component)
		$cnt = count($objectGroups);

		if (JCOMMENTS_JVERSION == '1.0') {
			$a = array();
			if (is_array($objectGroups)) {
				foreach($objectGroups as $o) {
					$a[] = $o;
				}
			}
			$objectGroups = $a;
		}

		if ($cnt > 1 || ($cnt == 1 && $total = 0)) {
			array_unshift($objectGroups, JCommentsHTML::makeOption('', JText::_('A_FILTER_ALL_COMPONENTS'), 'name', 'value'));
			$lists['fog'] = JCommentsHTML::selectList($objectGroups, 'fog', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'name', 'value', $object_group);
		} else if ($cnt == 1) {
			if ($object_group == '') {
				$aGroups = array_keys($objectGroups);
				$object_group = array_pop($aGroups);
			}
		}
		unset($objectGroups);


		// TODO: found more simple way to get commented objects titles
		/*
		$lists['foid'] = '';

		if ($object_group != '') {
			$query = "SELECT DISTINCT(object_id) AS value "
				. "\nFROM #__jcomments "
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

			if (count($rows) > 0) {
				usort($rows, create_function('$a, $b', 'return strcasecmp( $a->name, $b->name);'));
				array_unshift($rows, JCommentsHTML::makeOption('', '', 'name', 'value'));
				$lists['foid'] = JCommentsHTML::selectList($rows, 'foid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'name', $object_id);
				unset($rows);
			}
		}
		*/

		// Filter by published state
		$stateOptions = array();
		$stateOptions[] = JCommentsHTML::makeOption('', JText::_('Select state'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('-1', JText::_('All'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('1', JText::_('Published'), 'text', 'value');
		$stateOptions[] = JCommentsHTML::makeOption('0', JText::_('Unpublished'), 'text', 'value');
		$lists['fstate'] = JCommentsHTML::selectList($stateOptions, 'fstate', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'text', 'value', $fstate);
		unset($stateOptions);

		// Filter by language
		$query = "SELECT DISTINCT(lang) AS text, lang AS value "
			. "\nFROM #__jcomments"
			. "\nORDER BY lang"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if (count($rows) > 1) {
			array_unshift($rows, JCommentsHTML::makeOption('', '', 'text', 'value'));
			$lists['flang'] = JCommentsHTML::selectList($rows, 'flang', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'text', 'value', $flang);
		}
		unset($rows);

		// Filter by author
		$lists['fauthor'] = '';

		$db->setQuery("SELECT COUNT(DISTINCT(name)) FROM #__jcomments;");
		$usersCount = $db->loadResult();

		// Don't show filter if we have more than 100 comments' authors
		if ($usersCount > 0 && $usersCount < 100) {
			$query = "SELECT DISTINCT(name) AS author, name AS value "
				. "\nFROM #__jcomments"
				. "\nWHERE name <> ''"
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

		HTML_JComments::show($lists);
	}

	function edit()
	{
		global $my, $mainframe;

		$id = JCommentsInput::getVar('cid', 0);
		if (is_array($id)) {
			$id = $id[0];
		}

		$db = & JCommentsFactory::getDBO();

		$row = new JCommentsDB($db);
		if ($row->load($id)) {
			$row->checkout($my->id);

			$row->comment = JCommentsText::br2nl($row->comment);
			$row->comment = htmlspecialchars($row->comment);
			$row->comment = JCommentsText::nl2br($row->comment);
			$row->comment = strip_tags(str_replace('<br />', "\n", $row->comment));
			$row->object_title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group, $row->lang);
			$row->link = $mainframe->getCfg('live_site') . '/' . JCOMMENTS_INDEX . '?option=com_jcomments&task=go2object&object_id=' . $row->object_id . '&object_group=' . $row->object_group . '&no_html=1';

			HTML_JComments::edit($row);
		} else {
			JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=comments');
		}
	}

	function save()
	{
		$task = JCommentsInput::getVar('task');
		$id = (int) JCommentsInput::getVar('id', 0);

		$bbcode = & JCommentsFactory::getBBCode();
		$db = & JCommentsFactory::getDBO();

		$row = new JCommentsDB($db);
		if ($row->load($id)) {

			$row->homepage = trim(strip_tags(JCommentsInput::getVar('homepage')));
			$row->email = trim(strip_tags(JCommentsInput::getVar('email')));
			$row->title = trim(strip_tags(JCommentsInput::getVar('title')));
			$row->comment = JCommentsInput::getVar('comment');
			$row->published = (int) JCommentsInput::getVar('published');

			if ($row->userid == 0) {
				$row->name = strip_tags(JCommentsInput::getVar('name'));
				$row->name = preg_replace("/[\'\"\>\<\(\)\[\]]?+/i", '', $row->name);

				if ($row->username != $row->name) {
					$row->username = $row->name;
				}

				$row->username = preg_replace("/[\'\"\>\<\(\)\[\]]?+/i", '', $row->username);
			} else {
				if ($row->name == '' || $row->username == '' || $row->email == '') {
					$user = JCommentsFactory::getUser($row->userid);
					$row->name = $row->name == '' ? $user->name : $row->name;
					$row->username = $row->username == '' ? $user->username : $row->username;
					$row->email = $row->email == '' ? $user->email : $row->email;
				}
			}

			// handle magic quotes compatibility
			if (get_magic_quotes_gpc() == 1) {
				$row->title = stripslashes($row->title);
				$row->comment = stripslashes($row->comment);
			}

			$row->comment = JCommentsText::nl2br($row->comment);
			$row->comment = $bbcode->filter($row->comment);
			$row->store();
			$row->checkin();

			JCommentsCache::cleanCache('com_jcomments');
			JCommentsCache::cleanCache($row->object_group);
		}

		switch ($task) {
			case 'apply':
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=edit&hidemainmenu=1&cid[]=' . $row->id);
				break;
			case 'save':
			default:
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=comments');
				break;
		}
	}

	function publish( $publish )
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("UPDATE #__jcomments SET published='$publish' WHERE id IN ($ids)");
			$db->query();
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=comments');
	}

	function cancel()
	{
		$db = & JCommentsFactory::getDBO();
		$row = new JCommentsDB($db);
		$row->bind($_POST);
		$row->checkin();

		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=comments');
	}

	function remove()
	{
		$id = JCommentsInput::getVar('cid', array());
		if (is_array($id) && (count($id) > 0)) {
			JCommentsModel::deleteCommentsByIds($id);
			JCommentsCache::cleanCache('com_jcomments');
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=comments');
	}

	function showSmiles()
	{
		require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'filesystem.php');
		$imageFiles = JoomlaTuneFS::readDirectory(JCOMMENTS_BASE.DS.'images'.DS.'smiles' . DS);

		$lists['images'] = array();
		foreach ($imageFiles as $file) {
			if (preg_match("/(gif|jpg|png)/i", (string) $file)) {
				$lists['images'][] = $file;
			}
		}

		$config = & JCommentsFactory::getConfig();
		$lists['smiles'] = $config->get('smiles');

		HTML_JComments::showSmiles($lists);
	}

	function showSettings()
	{
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		// check current site template for afterDisplayContent event
		if (JCOMMENTS_JVERSION == '1.5') {
			$db->setQuery('SELECT template FROM #__templates_menu WHERE client_id = 0 AND menuid = 0', 0, 1);
			$template = $db->loadResult();

			$articleTemplate = JPATH_SITE.DS.'templates'.DS.$template.DS.'html'.DS.'com_content'.DS.'article'.DS.'default.php';
			if (is_file($articleTemplate)) {
				$tmpl = implode('', file($articleTemplate));
				if (strpos($tmpl, 'afterDisplayContent') === false) {
					JError::raiseWarning(500, JText::_('Your current site template doesn\'t have afterDisplayContent event!'));
				}
			}
		}

		$languages = array();

		$joomfish = JOOMLATUNE_JPATH_SITE.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';

		if (is_file($joomfish)) {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery("SELECT `name`, `code` as value FROM `#__languages` WHERE `active` = 1");
			$languages = $db->loadObjectList();

			if (is_array($languages)) {
				$lang = trim(JCommentsInput::getVar('lang', ''));

				if ($lang == '') {
					if (JCOMMENTS_JVERSION == '1.5') {
						$params = JComponentHelper::getParams('com_languages');
						$lang = $params->get("site", 'en-GB');
					}

					if ($lang == '') {
					 	$lang = JCommentsMultilingual::getLanguage();
					}
				}

				// reload configuration
				$config = & JCommentsFactory::getConfig($lang);

				$lists['languages'] = JCommentsHTML::selectList( $languages, 'lang', 'class="inputbox" size="1" onchange="submitform(\'settings\');"', 'value', 'name', $lang );
			}
		}

		$forbiddenNames = $config->get('forbidden_names');
		$forbiddenNames = preg_replace('#,+#', "\n", $forbiddenNames);
		$config->set('forbidden_names', $forbiddenNames);

		$badWords = $config->get('badwords');
		if ($badWords != '') {
			$config->set('badwords', implode("\n", $badWords));
		}

		require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'filesystem.php');

		// path to images directory
		$path = JCOMMENTS_BASE.DS.'tpl'.DS;
		$items = JoomlaTuneFS::readDirectory($path);
		$templates = array();

		foreach( $items as $item ) {
			if ( is_dir( $path . $item ) ) {
			        $tpl = new StdClass;
				$tpl->text = $item;
				$tpl->value = $item;
				$templates[] = $tpl;
                	}
		}

		$currentTemplate = $config->get('template');
		$lists['templates'] = JCommentsHTML::selectList($templates, 'cfg_template', 'class="inputbox"', 'value', 'text', $currentTemplate);

		$rows = JCommentsAdmin::getAllGroups();
		$exclude = JCommentsAdmin::getHigherGroups();

		if (count($exclude)) {
			// remove users 'above' me
			$i = 0;
			while ( $i < count( $rows ) ) {
				if (in_array( $rows[$i]->group_id, $exclude ) ) {
					array_splice( $rows, $i, 1 );
				} else {
					$i++;
				}
			}
		}

		$captchaError = '';
		$captchaExclude = array();
		if (!extension_loaded('gd') || !function_exists('imagecreatefrompng')) {
			if ($config->get('captcha_engine', 'kcaptcha') != 'recaptcha') {
				foreach($rows as $row) {
					$captchaExclude[] = $row->value;
				}
				$captchaError = JText::_('GD library is not installed!');
			}
		}

		$lists['group_names'] = $rows;

		$groups = array();

		// Post
		JCommentsAdmin::loadParam( $groups, 'can_comment', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_CAN_COMMENT')
					, JText::_('AP_CAN_COMMENT_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'can_reply', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_CAN_REPLY')
					, JText::_('AP_CAN_REPLY_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'autopublish', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_AUTOPUBLISH')
					, JText::_('AP_AUTOPUBLISH_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'show_policy', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_SHOW_POLICY')
					, JText::_('AP_SHOW_POLICY_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_captcha', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_ENABLE_CAPTCHA')
					, JText::_('AP_ENABLE_CAPTCHA_DESC')
					, $captchaExclude
					, $captchaError
					);
		JCommentsAdmin::loadParam( $groups, 'floodprotection', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_ENABLE_FLOODPROTECTION')
					, JText::_('AP_ENABLE_FLOODPROTECTION_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_comment_length_check', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_ENABLE_COMMENT_LENGTH_CHECK')
					, JText::_('AP_ENABLE_COMMENT_LENGTH_CHECK_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_autocensor', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_ENABLE_AUTOCENSOR')
					, JText::_('AP_ENABLE_AUTOCENSOR_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_subscribe', $rows
					, JText::_('A_RIGHTS_POST')
					, JText::_('AP_ENABLE_SUBSCRIBE')
					, JText::_('AP_ENABLE_SUBSCRIBE_DESC')
					);

		// BBCodes
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_b', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_B')
					, JText::_('AP_ENABLE_BBCODE_B_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_i', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_I')
					, JText::_('AP_ENABLE_BBCODE_I_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_u', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_U')
					, JText::_('AP_ENABLE_BBCODE_U_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_s', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_S')
					, JText::_('AP_ENABLE_BBCODE_S_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_url', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_URL')
					, JText::_('AP_ENABLE_BBCODE_URL_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_img', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_IMG')
					, JText::_('AP_ENABLE_BBCODE_IMG_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_list', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_LIST')
					, JText::_('AP_ENABLE_BBCODE_LIST_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_hide', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_HIDE')
					, JText::_('AP_ENABLE_BBCODE_HIDE_DESC')
					, array('Unregistered' )
					);
		JCommentsAdmin::loadParam( $groups, 'enable_bbcode_quote', $rows
					, JText::_('A_RIGHTS_BBCODE')
					, JText::_('AP_ENABLE_BBCODE_QUOTE')
					, JText::_('AP_ENABLE_BBCODE_QUOTE_DESC')
					);

		// View
		JCommentsAdmin::loadParam( $groups, 'autolinkurls', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_ENABLE_AUTOLINKURLS')
					, JText::_('AP_ENABLE_AUTOLINKURLS_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'emailprotection', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_ENABLE_EMAILPROTECTION')
					, JText::_('AP_ENABLE_EMAILPROTECTION_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'enable_gravatar', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_ENABLE_GRAVATAR')
					, JText::_('AP_ENABLE_GRAVATAR_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'can_view_email', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_CAN_VIEW_AUTHOR_EMAIL')
					, JText::_('AP_CAN_VIEW_AUTHOR_EMAIL_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'can_view_homepage', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_CAN_VIEW_AUTHOR_HOMEPAGE')
					, JText::_('AP_CAN_VIEW_AUTHOR_HOMEPAGE_DESC')
					);
		JCommentsAdmin::loadParam( $groups, 'can_view_ip', $rows
					, JText::_('A_RIGHTS_VIEW')
					, JText::_('AP_CAN_VIEW_AUTHOR_IP')
					, JText::_('AP_CAN_VIEW_AUTHOR_IP_DESC')
					, array('Unregistered', 'Registered' )
					);


		// Edit
		JCommentsAdmin::loadParam( $groups, 'can_edit_own', $rows
					, JText::_('A_RIGHTS_EDIT')
					, JText::_('AP_CAN_EDIT_OWN')
					, JText::_('AP_CAN_EDIT_OWN_DESC')
					, array('Unregistered' )
					);
		JCommentsAdmin::loadParam( $groups, 'can_delete_own', $rows
					, JText::_('A_RIGHTS_EDIT')
					, JText::_('AP_CAN_DELETE_OWN')
					, JText::_('AP_CAN_DELETE_OWN_DESC')
					, array('Unregistered' )
					);

		// Administration
		JCommentsAdmin::loadParam( $groups, 'can_edit', $rows
					, JText::_('A_RIGHTS_ADMINISTRATION')
					, JText::_('AP_CAN_EDIT')
					, JText::_('AP_CAN_EDIT_DESC')
					, array('Unregistered', 'Registered' )
					);
		JCommentsAdmin::loadParam( $groups, 'can_publish', $rows
					, JText::_('A_RIGHTS_ADMINISTRATION')
					, JText::_('AP_CAN_PUBLISH')
					, JText::_('AP_CAN_PUBLISH_DESC')
					, array('Unregistered', 'Registered' )
					);
		JCommentsAdmin::loadParam( $groups, 'can_delete', $rows
					, JText::_('A_RIGHTS_ADMINISTRATION')
					, JText::_('AP_CAN_DELETE')
					, JText::_('AP_CAN_DELETE_DESC')
					, array('Unregistered', 'Registered' )
					);

		// Votes
		JCommentsAdmin::loadParam( $groups, 'can_vote', $rows
					, JText::_('A_RIGHTS_MISC')
					, JText::_('AP_CAN_VOTE')
					, JText::_('AP_CAN_VOTE_DESC')
					);

		$reportError = '';
		$reportExclude = array();
		if ($config->getInt('enable_notification') == 0 || $config->check('notification_type', 2) == false) {
			foreach($rows as $row) {
				$reportExclude[] = $row->value;
			}
			$reportError = JText::_('Notifications are disabled! Please, enable notifications first.');
		}

		JCommentsAdmin::loadParam( $groups, 'can_report', $rows
					, JText::_('A_RIGHTS_MISC')
					, JText::_('AP_CAN_REPORT')
					, JText::_('AP_CAN_REPORT_DESC')
					, $reportExclude
					, $reportError
					);

		$lists['groups'] =& $groups;

		if ($config->get('enable_categories') != '') {
			$query = "SELECT c.id AS `value`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
				. "\n FROM #__sections AS s"
				. "\n INNER JOIN #__categories AS c ON c.section = s.id"
				. "\n WHERE c.id IN ( " . $config->get('enable_categories') . " )"
				. "\n ORDER BY s.name,c.name"
				;
			$db->setQuery( $query );
			$lookup = $db->loadObjectList();
		} else {
			$lookup = '';
		}

		$query = "SELECT c.id AS `value`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
			. "\n FROM #__sections AS s"
			. "\n INNER JOIN #__categories AS c ON c.section = s.id"
			. "\n ORDER BY s.name,c.name"
			;
		$db->setQuery( $query );
		$categories = $db->loadObjectList();

		if (!is_array($categories)) {
			$categories = array();
		}
		$lists['categories'] = JCommentsHTML::selectList($categories, 'cfg_enable_categories[]', 'class="inputbox" size="10" multiple="multiple"', 'value', 'text', $lookup);

		$captcha = array();
		$captcha[] = JCommentsHTML::makeOption('kcaptcha', 'KCAPTCHA');

		require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
		JCommentsPluginHelper::importPlugin('jcomments');
		$enginesList = JCommentsPluginHelper::trigger('onJCommentsCaptchaEngines');

		foreach($enginesList as $engines) {
			foreach($engines as $code=>$text) {
				$captcha[] = JCommentsHTML::makeOption($code, $text);
			}
		}

		$disabledCAPTCHA = count($captcha) == 1 ? ' disabled="disabled"' : '';

		$lists["captcha"] = JCommentsHTML::selectList($captcha, 'cfg_captcha_engine', 'class="inputbox"' . $disabledCAPTCHA, 'value', 'text', $config->get('captcha_engine'));


		HTML_JComments::showSettings($lists);
	}

	function getAllGroups()
	{
		global $acl;

		$unregistered = new stdClass();
		$unregistered->value = 'Unregistered';
		$unregistered->text = JText::_('Unregistered');
		$unregistered->group_id = -1;

		$rows[] = $unregistered;

		if (JCOMMENTS_JVERSION == '1.0') {
			$front_users = $acl->_getBelow('#__core_acl_aro_groups', 'g1.name as value, g1.name as text, g1.group_id', 'g1.name', null, 'Public Frontend', false);
			$backend_users = $acl->_getBelow('#__core_acl_aro_groups', 'g1.name as value, g1.name as text, g1.group_id', 'g1.name', null, 'Public Backend', false);
			$rows = array_merge((array) $rows, (array) $front_users);
			$rows = array_merge((array) $rows, (array) $backend_users);
		} else {
			$auth = JFactory::getACL();

			$front_users = $auth->_getBelow('#__core_acl_aro_groups', 'g1.name as value, g1.name as text', 'g1.name', null, 'Public Frontend', true);
			array_shift($front_users);

			$backend_users = $auth->_getBelow('#__core_acl_aro_groups', 'g1.name as value, g1.name as text', 'g1.name', null, 'Public Backend', true);
			array_shift($backend_users);

			$rows = array_merge((array) $rows, (array) $front_users);
			$rows = array_merge((array) $rows, (array) $backend_users);
		}

		return $rows;
	}

	function getHigherGroups()
	{
		global $my, $acl;

		if (JCOMMENTS_JVERSION == '1.0') {
			// ensure user can't add group higher than themselves
			$my_groups = $acl->get_object_groups('users', $my->id, 'ARO');
			if (is_array($my_groups) && count($my_groups) > 0) {
				$ex_groups = $acl->get_group_children($my_groups[0], 'ARO', 'RECURSE');
			} else {
				$ex_groups = array();
			}
		} else {
			$ex_groups = array();
		}
		return $ex_groups;
	}

	function loadParam( &$plist, $name, $groups, $pgroup, $label, $note, $exclude = array(), $errorMessage = '')
	{
		$config = & JCommentsFactory::getConfig();

		$params = explode(",", $config->get($name));
		$lkeys = array_keys($plist);

		for ($i = 0; $i < count($groups); $i++) {
			$group = $groups[$i]->value;
			$value = 0;

			if (in_array($group, $params)) {
				$value = 1;
			}

			if (in_array($group, $exclude)) {
				$value = -1;
			}
			if (!in_array($group, $lkeys)) {
				$plist[$group] = array();
			}
			if (!in_array($pgroup, array_keys($plist[$group]))) {
				$plist[$group][$pgroup] = array();
			}

			$param['name'] = $name;
			$param['label'] = $label;
			$param['note'] = $note;
			$param['value'] = $value;
			$param['group'] = $group;
			$param['error'] = $errorMessage;
			$plist[$group][$pgroup][] = $param;
		}
	}

	function getGroupsList( $name, $label, $note, $groups, $params, $exclude = array() ){

		$result['name'] = $name;
		$result['label'] = $label;
		$result['note'] = $note;
		$result['groups'] = array();

		for ( $i=0; $i < count( $groups ); $i++ ) {
			$group = $groups[$i]->value;
			if (in_array( $group, $params ) ) {
				$result['groups'][$group] = 1;
			} else {
				$result['groups'][$group] = 0;
			}
			if (in_array( $group, $exclude ) ) {
				$result['groups'][$group] = -1;
			}
		}
		return $result;
	}

	function saveSmiles()
	{
	        global $mainframe;

		$db = & JCommentsFactory::getDBO();

		$smile_codes = JCommentsInput::getVar('cfg_smile_codes', array());
		$smile_images = JCommentsInput::getVar('cfg_smile_images', array());

		$smilesValues = array();

		foreach ($smile_codes as $k => $code) {
			$image = trim($smile_images[$k]);
			$code = trim($code);

			if ($code != '' && $image != '') {
				$smilesValues[] = $code . "\t" . $image;
			}
		}

		$values = count($smilesValues) ? implode("\n", $smilesValues) : '';

	   	$db->setQuery( "SELECT name FROM #__jcomments_settings WHERE component=''" );
	   	$dbParams = $db->loadResultArray();

		if (in_array( 'smiles', $dbParams)) {
			$query = "UPDATE #__jcomments_settings SET `value` = '" . $db->getEscaped($values) . "' WHERE `name` = 'smiles'";
		} else {
			$query = "INSERT INTO #__jcomments_settings SET `value` = '" . $db->getEscaped($values) . "', `name` = 'smiles'";
		}
		$db->setQuery($query);
		$db->query();

		$message = JText::_('AE_SETTINGS_SAVED');

		// Clean all caches for components with comments
		if ($mainframe->getCfg('caching') == 1) {
			$db->setQuery("SELECT DISTINCT(object_group) AS name FROM #__jcomments");
			$rows = $db->loadObjectList();

			foreach ($rows as $row) {
				JCommentsCache::cleanCache($row->name);
			}
			unset($rows);
		}
		JCommentsCache::cleanCache( 'com_jcomments' );

		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=smiles', $message );
	}

	function importCommentsAjax()
	{
		$response = & JCommentsFactory::getAjaxResponse();

		require_once (dirname(__FILE__).DS.'admin.jcomments.migration.php');
		$message = JCommentsMigrationTool::doImport();

		$vars = JCommentsInput::getVar('vars', array());
		$code = strtolower($vars['import']);

		$response->addScript("jcbackend.showMessage('$message', 'info', 'jcomments-message-$code');");
		return $response;
	}

	function importCommentsDefault()
	{
		require_once (dirname(__FILE__).DS.'admin.jcomments.migration.php');
		$message = JCommentsMigrationTool::doImport();

		JCommentsRedirect( JCOMMENTS_INDEX . '?option=com_jcomments&task=import' , $message );
	}

	function cancelSettings()
	{
		$lang = JCommentsAdmin::loadSettingsByLanguage(JCommentsInput::getVar('lang', ''));
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=settings' . ($lang != '' ? "&lang=$lang" : ''), $message);
	}

	function saveSettingsAjax()
	{
		$response = & JCommentsFactory::getAjaxResponse();

		$jtx64 = JCommentsInput::getVar('jtx64', '');
		if ($jtx64 != '') {
			$jtx64 = base64_decode(urldecode($jtx64));
			$data = array();
			parse_str($jtx64, $data);

			if (JCOMMENTS_JVERSION == '1.0') {
				require_once (JCOMMENTS_BASE.DS.'jcomments.ajax.php');
				$data = JCommentsAJAX::convertEncoding($data);
			}

			$_POST = array_merge($_POST, $data);
			$_REQUEST = array_merge($_REQUEST, $data);
		}

		$lang = JCommentsAdmin::loadSettingsByLanguage(JCommentsInput::getVar('lang', ''));
		$message = JCommentsAdmin::saveSettings($lang);
		$response->addScript("jcbackend.showMessage('$message', 'info', 'jcomments-message-holder');");

		return $response;
	}

	function saveSettingsDefault()
	{
		$lang = JCommentsAdmin::loadSettingsByLanguage(JCommentsInput::getVar('lang', ''));
		$message = JCommentsAdmin::saveSettings($lang);
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=settings' . ($lang != '' ? "&lang=$lang" : ''), $message);
	}

	function loadSettingsByLanguage($language='')
	{
		$lang = '';

		$joomfish = JOOMLATUNE_JPATH_SITE.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';

		if (is_file($joomfish)) {
			$lang = $language;

			if ($lang == '') {
			 	$lang = JCommentsMultilingual::getLanguage();
			}

			// reload configuration
			JCommentsFactory::getConfig($lang);
		}
		return $lang;
	}

	function restoreSettingsAjax()
	{
		$response = & JCommentsFactory::getAjaxResponse();

		$message = JCommentsAdmin::restoreSettings();
		$response->addScript("jcbackend.showMessage('$message', 'info', 'jcomments-message-holder');");
		return $response;
	}

	function restoreSettingsDefault()
	{
		$lang = JCommentsInput::getVar('lang', '');
        $message = JCommentsAdmin::restoreSettings();
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=settings' . ($lang != '' ? "&lang=$lang" : ''), $message);
	}

	function restoreSettings()
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery("DELETE FROM `#__jcomments_settings`");
		$db->query();

		require_once (dirname(__FILE__).DS.'admin.jcomments.installer.php');

		$defaultSettings = dirname(__FILE__).DS.'install'.DS.'sql'.DS.'settings.sql';

		JCommentsInstaller::executeSQL($defaultSettings);

		return JText::_('The default settings have been restored!');
	}

	function saveSettings($lang)
	{
		global $mainframe;

		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$groups = JCommentsAdmin::getAllGroups();
		$exclude = JCommentsAdmin::getHigherGroups();

		if (count($exclude)) {
			// left all users 'above' me
			$i = 0;
			while ( $i < count( $groups ) ) {
				if ( !in_array( $groups[$i]->group_id, $exclude ) ) {
					array_splice( $groups, $i, 1 );
				} else {
					$i++;
				}
			}
		}
		$c_params = $config->getKeys();
		$p_params = array_keys($_POST);
		$i_params = array('smiles', 'merge_time', 'use_plural_forms', 'load_cached_comments', 'enable_geshi');

		foreach ($c_params as $param) {
			if ((!in_array('cfg_' . $param, $p_params)) && (!in_array($param, $i_params))) {
				$_POST['cfg_' . $param] = '';
			}
		}

		$db->setQuery("SELECT name FROM #__jcomments_settings WHERE component=''" . ($lang != '' ? " AND lang ='$lang'" : ''));
		$dbParams = $db->loadResultArray();

		$query = 'SELECT * FROM #__jcomments_settings WHERE name IN ("' . implode('", "', $i_params) . '")';
		$db->setQuery($query);
		$systemVars = $db->loadObjectList('name');

		foreach ($i_params as $p) {
			if (!in_array($p, $dbParams)) {
				if (isset($systemVars[$p])) {
					$_POST['cfg_' . $p] = $systemVars[$p]->value;
				}
			}
		}

		if (!isset($_POST['cfg_comment_minlength'])) {
			$_POST['cfg_comment_minlength'] = 0;
		}

		if (!isset($_POST['cfg_comment_maxlength'])) {
			$_POST['cfg_comment_maxlength'] = 0;
		}

		if ($_POST['cfg_comment_minlength'] > $_POST['cfg_comment_maxlength']) {
			$_POST['cfg_comment_minlength'] = 0;
		}

		foreach ($_POST as $k=>$v) {
			if (strpos( $k, 'cfg_' ) === 0 ) {
				$paramName = substr($k, 4);
				if (($paramName == 'smile_codes') || ($paramName == 'smile_images')) {
					continue;
				}

				if (is_array($v)) {
					$config->set($paramName, '');

					foreach ($groups as $group) {
						if (strpos($config->get($paramName), $group->value) !== false) {
							$v[] = $group->text;
						}
					}
					$v = implode(',', $v);
				}

				if (!get_magic_quotes_gpc()) {
					$v = addslashes($v);
				}

				if ($paramName == 'forbidden_names') {
					$v = preg_replace("#[\n|\r]+#", ',', $v);
					$v = preg_replace("#,+#", ',', $v);
				} else if ($paramName == 'badwords') {
					$v = preg_replace('#[\s|\,]+#i', "\n", $v);
					$v = preg_replace('#[\n|\r]+#i', "\n", $v);
				}

				$v = trim($v);
				$config->set($paramName, $v);

				if (in_array($paramName, $dbParams)) {
					$query = "UPDATE #__jcomments_settings"
						. "\n SET `value` = '" . $v . "'"
						. "\n WHERE `name` = '" . $paramName . "'"
						. ($lang != '' ? " AND `lang` = '$lang'" : '' )
						;
				} else {
					$query = "INSERT INTO #__jcomments_settings"
						. "\n SET `value` = '" . $v . "'"
						. "\n , `name` = '" . $paramName . "'"
						. ($lang != '' ? " , `lang` = '$lang'" : '' )
						;
				}

				$db->setQuery($query);
				$db->query();
			}
	   	}

		$message = JText::_('AE_SETTINGS_SAVED');

		// clean all caches for components with comments
		if ($mainframe->getCfg('caching') == 1) {
			$db->setQuery("SELECT DISTINCT(object_group) AS name FROM #__jcomments");
			$rows = $db->loadObjectList();

			foreach ($rows as $row) {
				JCommentsCache::cleanCache($row->name);
			}
			unset($rows);
		}
		JCommentsCache::cleanCache('com_jcomments');

		return $message;
	}

	function rebuildTree()
	{
		require_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'database.php');
		JCommentsInstallerDatabaseHelper::updateCommentsLevel();
		JCommentsInstallerDatabaseHelper::updateCommentsPath();
		JCommentsCache::cleanCache('com_jcomments');

		$message = JText::_('Tree structure successfully updated!');

		JCommentsRedirect( JCOMMENTS_INDEX . '?option=com_jcomments&task=comments', $message );
	}

	function showAbout()
	{
		HTML_JComments::showAbout();
	}

	function checkPhpVersion()
	{
		// check PHP version (we will stop supporting PHP4 in nearest future)
		if ((version_compare(phpversion(), '5.1.0') < 0)) {
			if (JCOMMENTS_JVERSION == '1.5') {
				JError::raiseWarning(500, JText::sprintf('You are using outdated PHP version: %s. The next release of JComments will require at least PHP 5.1.0', phpversion()));
			}
		}
	}
}

// restore PHP error reporting settings
@error_reporting( $_error_reporting);
?>