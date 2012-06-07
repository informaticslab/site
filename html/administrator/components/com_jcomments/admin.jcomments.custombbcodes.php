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

class JCommentsCustomBBCodeDB extends JoomlaTuneDBTable
{
	/** @var int Primary key */
	var $id = null;
	/** @var string */
	var $name = null;
	/** @var string */
	var $pattern = null;
	/** @var string */
	var $replacement_html = null;
	/** @var string */
	var $replacement_text = null;
	/** @var string */
	var $simple_pattern = null;
	/** @var string */
	var $simple_replacement_html = null;
	/** @var string */
	var $simple_replacement_text = null;
	/** @var string */
	var $button_acl = null;
	/** @var string */
	var $button_open_tag = null;
	/** @var string */
	var $button_close_tag = null;
	/** @var string */
	var $button_title = null;
	/** @var string */
	var $button_prompt = null;
	/** @var string */
	var $button_image = null;
	/** @var string */
	var $button_css = null;
	/** @var boolean */
	var $button_enabled = null;
	/** @var int */
	var $ordering = null;
	/** @var boolean */
	var $published = null;

	/**
	* @param database A database connector object
	* @access public
	* @return JCommentsCustomBBCodeDB
	*/
	function JCommentsCustomBBCodeDB( &$db ) {
		$this->JoomlaTuneDBTable('#__jcomments_custom_bbcodes', 'id', $db);
	}
}

class JCommentsACustomBBCodes
{
	function show()
	{
		global $mainframe;

		$option = JCommentsInput::getVar('option');

		$limit = intval($mainframe->getUserStateFromRequest("view{$option}limit", 'limit', $mainframe->getCfg('list_limit')));
		$limitstart = intval($mainframe->getUserStateFromRequest("view{$option}limitstart", 'limitstart', 0));

		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT COUNT(*) FROM #__jcomments_custom_bbcodes');
		$total = $db->loadResult();

		if ( JCOMMENTS_JVERSION == '1.0' ) {
			require_once ($mainframe->getCfg('absolute_path').DS.'administrator'.DS.'includes'.DS.'pageNavigation.php');
			$lists['pageNav'] = new mosPageNav($total, $limitstart, $limit);
		} else {
			jimport('joomla.html.pagination');
			$lists['pageNav'] = new JPagination($total, $limitstart, $limit);
		}

		$query = "SELECT * FROM #__jcomments_custom_bbcodes ORDER BY ordering";
		$db->setQuery($query, $lists['pageNav']->limitstart, $lists['pageNav']->limit);
		$lists['rows'] = $db->loadObjectList();

		HTML_JCommentsACustomBBCodes::show($lists);
	}

	function edit()
	{
		$id = JCommentsInput::getVar('cid', 0);
		if (is_array($id)) {
			$id = $id[0];
		}

		$db = & JCommentsFactory::getDBO();

		$row = new JCommentsCustomBBCodeDB($db);
		if ($id) {
			$row->load($id);
		}

		$groups = JCommentsAdmin::getAllGroups();
		$exclude = JCommentsAdmin::getHigherGroups();

		if (count($exclude)) {
			// remove users 'above' me
			$i = 0;
			while ($i < count($groups)) {
				if (in_array($groups[$i]->group_id, $exclude)) {
					array_splice($groups, $i, 1);
				} else {
					$i++;
				}
			}
		}

		$userGroups = explode(",", $row->button_acl);

		$lists['groups'] = array();

		foreach($groups as $group) {
			$lists['groups'][$group->text] = (int) in_array($group->text, $userGroups);
		}

		HTML_JCommentsACustomBBCodes::edit($row, $lists);
	}

	function save()
	{
		$task = JCommentsInput::getVar('task');
		$id = JCommentsInput::getVar('id', 0);
		$acl = JCommentsInput::getVar('button_acl', array());

		$db = & JCommentsFactory::getDBO();
		$row = new JCommentsCustomBBCodeDB($db);

		$old_simple_pattern = '';
		$old_simple_replacement_html = '';
		$old_simple_replacement_text = '';

		if ($id) {
			$row->load($id);
			$old_simple_pattern = $row->simple_pattern;
			$old_simple_replacement_html = $row->simple_replacement_html;
			$old_simple_replacement_text = $row->simple_replacement_text;
		}

		$row->bind($_POST);

		$row->name = trim(strip_tags($row->name));
		$row->button_acl = implode(',', $acl);

		$row->button_open_tag = trim(strip_tags($row->button_open_tag));
		$row->button_close_tag = trim(strip_tags($row->button_close_tag));
		$row->button_title = trim(strip_tags($row->button_title));
		$row->button_prompt = trim(strip_tags($row->button_prompt));
		$row->button_image = trim(strip_tags($row->button_image));
		$row->button_css = trim(strip_tags($row->button_css));

		// handle magic quotes compatibility
		if ( JCOMMENTS_JVERSION == '1.5' ) {
			if (get_magic_quotes_gpc() == 1) {
				$row->pattern = stripslashes($row->pattern);	
				$row->replacement_html = stripslashes($row->replacement_html);
				$row->replacement_text = stripslashes($row->replacement_text);
				$row->simple_pattern = stripslashes($row->simple_pattern);	
				$row->simple_replacement_html = stripslashes($row->simple_replacement_html);
				$row->simple_replacement_text = stripslashes($row->simple_replacement_text);
			}
		}

		if ($row->simple_replacement_text == '') {
			$row->simple_replacement_text = strip_tags($row->simple_replacement_html);
		}

		if ($row->simple_pattern != '' && $row->simple_replacement_html != '') {
			$tokens = array();

			$pattern = $row->simple_pattern;

			$tokens = array();
			$tokens['TEXT'] = array('([\w0-9-\+\=\!\?\(\)\[\]\{\}\&\%\*\#\.,_ ]+)' => '$1');
			$tokens['SIMPLETEXT'] = array('([\A-Za-z0-9-\+\.,_ ]+)' => '$1');
			$tokens['IDENTIFIER'] = array('([\w0-9-_]+)' => '$1');
			$tokens['NUMBER'] = array('([0-9]+)' => '$1');
			$tokens['ALPHA'] = array('([A-Za-z]+)' => '$1');

			$pattern = preg_quote($row->simple_pattern, '#');
			$replacement_html = $row->simple_replacement_html;
			$replacement_text = $row->simple_replacement_text;

			$m = array();
			$pad = 0;
			$match = '';
			$replace = '';

			if (preg_match_all('/\{(' . implode('|', array_keys($tokens)) . ')[0-9]*\}/im', $row->simple_pattern, $m)) {
				foreach ($m[0] as $n => $token) {
					$token_type = $m[1][$n];

					reset($tokens[strtoupper($token_type)]);
					list($match, $replace) = each($tokens[strtoupper($token_type)]);

					$repad = array();
					if (preg_match_all('/(?<!\\\\)\$([0-9]+)/', $replace, $repad)) {
						$repad = $pad + sizeof(array_unique($repad[0]));
						$replace = preg_replace('/(?<!\\\\)\$([0-9]+)/e', "'\${' . (\$1 + \$pad) . '}'", $replace);
						$pad = $repad;
					}

					$pattern = str_replace(preg_quote($token, '#'), $match, $pattern);
					$replacement_html = str_replace($token, $replace, $replacement_html);
					$replacement_text = str_replace($token, $replace, $replacement_text);
				}
			}

			// if simple pattern not changed but pattern changed - clear simple
			if ($old_simple_pattern != $row->simple_pattern || $row->pattern == '') {
				$row->pattern = $pattern;
			}

			// if simple replacement not changed but pattern changed - clear simple
			if ($old_simple_replacement_html != $row->simple_replacement_html || $row->replacement_html == '') {
				$row->replacement_html = $replacement_html;
			}

			// if simple replacement not changed but pattern changed - clear simple
			if ($old_simple_replacement_text != $row->simple_replacement_text || $row->replacement_text == '') {
				$row->replacement_text = $replacement_text;
			}
		}

		if (!$row->id) {
			$db->setQuery("SELECT max(ordering) FROM #__jcomments_custom_bbcodes");
			$row->ordering = intval($db->loadResult()) + 1;
		}

		$row->store();

		JCommentsCache::cleanCache('com_jcomments');

		switch ($task) {
			case 'custombbcode.apply':
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcode.edit&hidemainmenu=1&cid[]=' . $row->id);
				break;
			case 'custombbcode.save':
			default:
				JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
				break;
		}
	}

	function publish( $publish )
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("UPDATE #__jcomments_custom_bbcodes SET published='$publish' WHERE id IN ($ids)");
			$db->query();
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

	function enableButton( $publish )
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("UPDATE #__jcomments_custom_bbcodes SET button_enabled='$publish' WHERE id IN ($ids)");
			$db->query();
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

	function cancel()
	{
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

	function remove()
	{
		$id = JCommentsInput::getVar('cid', array());

		if (is_array($id) && (count($id) > 0)) {
			$ids = implode(',', $id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery("DELETE FROM #__jcomments_custom_bbcodes WHERE id IN ($ids)");
			$db->query();
			JCommentsCache::cleanCache('com_jcomments');
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

	function copy()
	{
		$cids = JCommentsInput::getVar('cid', array());
		if (is_array($cids)) {
			$db = & JCommentsFactory::getDBO();
			foreach($cids as $cid) {
				$row = new JCommentsCustomBBCodeDB($db);
				if ($row->load($cid)) {
					$row->id = 0;
					$row->name = JText::sprintf('Copy of %s', $row->name);
					$row->button_enabled = 0;
					$row->published = 0;
					$row->ordering += 1;
					$row->store();
					$row->reorder();
				}
			}
		}
		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

	function order( $inc )
	{
		$id = JCommentsInput::getVar('cid', 0);
		$id = count($id) ? $id[0] : 0;

		$db = & JCommentsFactory::getDBO();
		$row = new JCommentsCustomBBCodeDB($db);
		
		if ($row->load($id)) {
			$row->move($inc);
			JCommentsCache::cleanCache('com_jcomments');
		}

		JCommentsRedirect(JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcodes');
	}

}

class HTML_JCommentsACustomBBCodes
{
	function show( $lists )
	{
		global $mainframe;

		include_once (JCOMMENTS_HELPERS.DS.'system.php');
		$link = JCommentsSystemPluginHelper::getCSS();

		if (JCOMMENTS_JVERSION == '1.5') {
			$document =& JFactory::getDocument();
			$document->addStyleSheet($link);
		} else if (JCOMMENTS_JVERSION == '1.0') {
			$mainframe->addCustomHeadTag('<link href="' . $link . '" rel="stylesheet" type="text/css" />');
		}
?>
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
<table class="adminheading">
	<tr>
<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
	<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/custombbcode48x48.png" width="48" height="48" align="middle" />&nbsp;<?php echo JText::_('Custom BBCode'); ?></th>
<?php
		}
?>
	<td nowrap="nowrap" align="right"></td>
	</tr>
</table>
<table id="jc" class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="2%" class="title">#</th>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $lists['rows'] );?>);" /></th>
			<th width="30%" align="left" nowrap="nowrap"><?php echo JText::_('Name'); ?></th>
			<th width="50%" class="title"><?php echo JText::_('Pattern'); ?></th>
			<th width="16" align="center"><?php echo JText::_('Icon'); ?></th>
			<th width="10%" colspan="2"><?php echo JText::_( 'Ordering' ); ?></th>
			<th width="5%"><?php echo JText::_('Button'); ?></th>
			<th width="5%"><?php echo JText::_('A_PUBLISHING'); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
		for ($i = 0, $k = 0, $n = count($lists['rows']); $i < $n; $i++) {
			$row =& $lists['rows'][$i];
			$task = $row->published ? 'custombbcode.unpublish' : 'custombbcode.publish';
			$img = $row->published ? 'tick.png' : 'publish_x.png';

			$button_task = $row->button_enabled ? 'custombbcode.disable_button' : 'custombbcode.enable_button';
			$button_img = $row->button_enabled ? 'tick.png' : 'publish_x.png';

			$icon = '';

			if ($row->button_image != '') {
				$icon = '<img src="' . $mainframe->getCfg('live_site') . '/' . $row->button_image .  '" alt="" />';
			} else if ($row->button_css != '') {
				$icon = '<span class="bbcode" style="width: 23px;"><a href="#" onclick="return false;" class="' . $row->button_css . '"></a></span>';
			}

			$link 	= JCOMMENTS_INDEX . '?option=com_jcomments&task=custombbcode.edit&hidemainmenu=1&cid='. $row->id;
			$link_title = (JCOMMENTS_JVERSION == '1.5') ? JText::_('Edit') : _E_EDIT;
?>
<tr valign="middle" class="<?php echo "row$k"; ?>">
	<td><label for="cb<?php echo $i; ?>"><?php echo $i+1+$lists['pageNav']->limitstart;?></label></td>
	<td width="20"><input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
	<td align="left"><a href="<?php echo $link; ?>" title="<?php echo $link_title; ?>"><?php echo $row->name; ?></a></td>
	<td align="left"><?php echo $row->simple_pattern; ?></td>
	<td align="center"><?php echo $icon; ?></td>
	<td align="right"><?php echo $lists['pageNav']->orderUpIcon( $i, true, 'custombbcode.orderup' ); ?></td>
	<td align="left"><?php echo $lists['pageNav']->orderDownIcon( $i, $n, true, 'custombbcode.orderup' ); ?></td>
	<td align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $button_task;?>')"><img src="images/<?php echo $button_img;?>" border="0" alt="<?php echo ($row->button_enabled ? JText::_('A_DISABLE') : JText::_('A_ENABLE')); ?>" /></a></td>
	<td align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" border="0" alt="<?php echo ($row->published ? JText::_('Unpublish') : JText::_('Publish')); ?>" /></a></td>
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
<input type="hidden" name="task" value="custombbcode" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" /></form>
<?php
	}

	function edit( $row, $lists )
	{
?>
<style type="text/css">
.editbox {border: 1px solid #ccc;padding: 2px;}
.short {width: 60px;}
.long {width: 450px;}
</style>
<script language="javascript" type="text/javascript">
<!--
function jc_insertText(id,text) {
	var ta=document.getElementById(id);
	if(typeof(ta.caretPos)!="undefined"&&ta.createTextRange){ta.focus();var sel=document.selection.createRange();sel.text=sel.text+text;ta.focus();}
	else if(typeof(ta.selectionStart)!="undefined"){
		var ss=ta.value.substr(0, ta.selectionStart);
		var se=ta.value.substr(ta.selectionEnd),sp=ta.scrollTop;
		ta.value=ss+text+se;
		if(ta.setSelectionRange){ta.focus();ta.setSelectionRange(ss.length+text.length,ss.length+text.length);}
		ta.scrollTop=sp;
	} else {ta.value+=text;ta.focus(ta.value.length-1);}
}

function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	submitform( pressbutton );
}
//-->
</script>
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
<table class="adminheading">
	<tr>
		<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/custombbcode48x48.png" width="48" height="48" align="middle">&nbsp;<?php echo JText::_('EDIT');?></th>
	</tr>
</table>
<?php
		}
?>
<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('A_COMMON'); ?></legend>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="10%"><?php echo JText::_('name'); ?></td>
					<td><input type="text" class="editbox long" size="35" name="name" onChange="return generate_tag();" value="<?php echo $row->name; ?>"></td>
				</tr>
				<tr valign="top" align="left">
					<td><?php echo JText::_('A_PUBLISHING'); ?></td>
					<td><?php echo JCommentsHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published, JText::_('A_YES'), JText::_('A_NO') ); ?></td>
					<td></td>
				</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('Pattern'); ?></legend>
<?php
		$tabs = new JCommentsTabs( 1 );
		$tabs->startPane('com_jcomments_custom_bbcode_pattern' );
		$tabs->startTab(JText::_('Simple'), "simple_pattern_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="4" id="simple_pattern" name="simple_pattern"><?php echo $row->simple_pattern; ?></textarea>
						<br />
						<?php echo JText::_('Available tokens');?>
						<abbr onclick="jc_insertText('simple_pattern', '{SIMPLETEXT}');" title="<?php echo JText::_('TOKEN SIMPLETEXT')?>">{SIMPLETEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_pattern', '{TEXT}');" title="<?php echo JText::_('TOKEN TEXT')?>">{TEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_pattern', '{IDENTIFIER}');" title="<?php echo JText::_('TOKEN IDENTIFIER')?>">{IDENTIFIER}</abbr>
						<abbr onclick="jc_insertText('simple_pattern', '{NUMBER}');" title="<?php echo JText::_('TOKEN NUMBER')?>">{NUMBER}</abbr>
					</td>
					<td align="left"><?php echo JText::_('Simple pattern description')?><br />
						<br /><?php echo JText::_('Example'); ?> [highlight={SIMPLETEXT1}]{SIMPLETEXT2}[/highlight]
					</td>
				</tr>
				</table>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('Advanced (Regular Expression)'), "regexp_pattern_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="4" name="pattern"><?php echo $row->pattern; ?></textarea>
					</td>
					<td align="left">
						<?php echo JText::_('PATTERN_DESC'); ?><br />
						<br /><?php echo JText::_('Example'); ?> \[highlight\=([a-zA-Z0-9].?)\](*.?)\[\/highlight\]
					</td>
				</tr>
				</table>
<?php
		$tabs->endTab();
		$tabs->endPane();
?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('Replacement'); ?> (<?php echo JText::_('HTML'); ?>)</legend>
<?php

		$tabs2 = new JCommentsTabs( 1 );
		$tabs2->startPane( 'com_jcomments_custom_bbcode_replacement_html' );
		$tabs2->startTab(JText::_('Simple'), "simple_replacement_html_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="4" id="simple_replacement_html" name="simple_replacement_html"><?php echo $row->simple_replacement_html; ?></textarea>
						<br />
						<?php echo JText::_('Available tokens');?>
						<abbr onclick="jc_insertText('simple_replacement_html', '{SIMPLETEXT}');" title="<?php echo JText::_('TOKEN SIMPLETEXT')?>">{SIMPLETEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_replacement_html', '{TEXT}');" title="<?php echo JText::_('TOKEN TEXT')?>">{TEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_replacement_html', '{IDENTIFIER}');" title="<?php echo JText::_('TOKEN IDENTIFIER')?>">{IDENTIFIER}</abbr>
						<abbr onclick="jc_insertText('simple_replacement_html', '{NUMBER}');" title="<?php echo JText::_('TOKEN NUMBER')?>">{NUMBER}</abbr>
					</td>
					<td align="left">
						<?php echo JText::_('Simple html replacement description')?><br />
						<br /><?php echo JText::_('Example'); ?> &lt;span style="background-color: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;
					</td>
				</tr>
				</table>
<?php
		$tabs2->endTab();
		$tabs2->startTab(JText::_('Advanced (Regular Expression)'), "regexp_replacement_html_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="4" name="replacement_html"><?php echo $row->replacement_html; ?></textarea>
					</td>
					<td align="left">
						<?php echo JText::_('PATTERN_DESC'); ?><br />
						<br /><?php echo JText::_('Example'); ?> &lt;span style="background-color: ${1};"&gt;${2}&lt;/span&gt;
					</td>
				</tr>
				</table>
<?php
		$tabs2->endTab();
		$tabs2->endPane();
?>
			</fieldset>
		</td>
	</tr>

	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('Replacement'); ?> (<?php echo JText::_('Plain text'); ?>)</legend>
<?php

		$tabs2 = new JCommentsTabs( 1 );
		$tabs2->startPane( 'com_jcomments_custom_bbcode_replacement_text' );
		$tabs2->startTab(JText::_('Simple'), "simple_replacement_text_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="3" id="simple_replacement_text" name="simple_replacement_text"><?php echo $row->simple_replacement_text; ?></textarea>
						<br />
						<?php echo JText::_('Available tokens');?>
						<abbr onclick="jc_insertText('simple_replacement_text', '{SIMPLETEXT}');" title="<?php echo JText::_('TOKEN SIMPLETEXT')?>">{SIMPLETEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_replacement_text', '{TEXT}');" title="<?php echo JText::_('TOKEN TEXT')?>">{TEXT}</abbr>,
						<abbr onclick="jc_insertText('simple_replacement_text', '{IDENTIFIER}');" title="<?php echo JText::_('TOKEN IDENTIFIER')?>">{IDENTIFIER}</abbr>
						<abbr onclick="jc_insertText('simple_replacement_text', '{NUMBER}');" title="<?php echo JText::_('TOKEN NUMBER')?>">{NUMBER}</abbr>
					</td>
					<td align="left">
						<?php echo JText::_('Simple text replacement description')?><br />
						<br /><?php echo JText::_('Example'); ?> {SIMPLETEXT2}
					</td>
				</tr>
				</table>
<?php
		$tabs2->endTab();
		$tabs2->startTab(JText::_('Advanced (Regular Expression)'), "regexp_replacement_text_tab");
?>
				<table width="100%">
				<tr valign="top" align="left">
					<td width="30%">
						<textarea class="editbox long" rows="3" name="replacement_text"><?php echo $row->replacement_text; ?></textarea>
					</td>
					<td align="left">
						<?php echo JText::_('PATTERN_DESC'); ?><br />
						<br /><?php echo JText::_('Example'); ?> ${2}
					</td>
				</tr>
				</table>
<?php
		$tabs2->endTab();
		$tabs2->endPane();
?>
			</fieldset>
		</td>
	</tr>

	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('Button'); ?></legend>

				<table width="100%">
				<tr valign="top" align="left">
					<td width="10%"><label for="button_title"><?php echo JText::_('Title'); ?></label></td>
					<td><input type="text" class="editbox long" size="35" id="button_title" name="button_title" value="<?php echo $row->button_title; ?>"></td>
					<td><?php echo JText::_('Title for this button'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><label for="button_prompt"><?php echo JText::_('Help line'); ?></label></td>
					<td><input type="text" class="editbox long" size="35" id="button_prompt" name="button_prompt" value="<?php echo $row->button_prompt; ?>"></td>
					<td><?php echo JText::_('Help line for this button'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><label for="button_image"><?php echo JText::_('Icon'); ?></label></td>
					<td><input type="text" class="editbox long" size="35" id="button_image" name="button_image" value="<?php echo $row->button_image; ?>"></td>
					<td><?php echo JText::_('Path to button icon'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><label for="button_css"><?php echo JText::_('CSS class'); ?></label></td>
					<td><input type="text" class="editbox short" size="35" id="button_css" name="button_css" value="<?php echo $row->button_css; ?>"></td>
					<td><?php echo JText::_('CSS class name for this button'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><label for="button_open_tag"><?php echo JText::_('Open tag'); ?></label></td>
					<td><input type="text" class="editbox short" size="35" id="button_open_tag" name="button_open_tag" value="<?php echo $row->button_open_tag; ?>"></td>
					<td><?php echo JText::_('The opening tag for this BBCode'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><label for="button_close_tag"><?php echo JText::_('Close tag'); ?></label></td>
					<td><input type="text" class="editbox short" size="35" id="button_close_tag" name="button_close_tag" value="<?php echo $row->button_close_tag; ?>"></td>
					<td><?php echo JText::_('The closing tag of the BBCode'); ?></td>
				</tr>
				<tr valign="top" align="left">
					<td><?php echo JText::_('Enable button'); ?></td>
					<td><?php echo JCommentsHTML::yesnoRadioList( 'button_enabled', 'class="inputbox"', $row->button_enabled, JText::_('A_YES'), JText::_('A_NO') ); ?></td>
					<td></td>
				</tr>
				</table>
			</fieldset>
		</td>
	</tr>

	<tr valign="top" align="left">
		<td>
			<fieldset>
				<legend><?php echo JText::_('Permissions'); ?></legend>

				<table width="100%">
				<tr valign="top" align="left">
					<td>
<?php
		foreach($lists['groups'] as $k=>$v) {
?>
						<input type="checkbox" name="button_acl[]" value="<?php echo $k; ?>" <?php echo (($v == '1') ? 'checked' : '');  ?> />
						<label for="<?php echo $k; ?>"><?php echo $k?></label>
						<br />
<?php
		}
?>					
					</td>
				</tr>
				</table>
			</fieldset>
		</td>
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