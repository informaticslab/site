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

if (JCOMMENTS_JVERSION == '1.5') {
	JLoader::register('JPaneTabs',  JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'pane.php');

	if (!class_exists('JCommentsTabs')) {

		class JCommentsTabs extends JPaneTabs
		{
			var $useCookies = false;

			function __construct( $useCookies )
			{
				parent::__construct( array('useCookies' => $useCookies) );
			}

			function startTab( $tabText, $paneid )
			{
				echo $this->startPanel( $tabText, $paneid);
			}

			function endTab()
			{
				echo $this->endPanel();
			}

			function startPane( $tabText )
			{
				echo parent::startPane( $tabText );
			}

			function endPane()
			{
				echo parent::endPane();
			}
		}
	}
} else if (JCOMMENTS_JVERSION == '1.0') {
	class JCommentsTabs extends mosTabs
	{
		function JCommentsTabs($useCookies, $xhtml=NULL)
		{
			global $mainframe;

			$cssPath = $mainframe->getCfg('live_site') . '/administrator/components/com_jcomments/assets/tabpane.css';
			if ($xhtml) {
				$mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="' . $cssPath . '" id="luna-tab-style-sheet" />');
			} else {
				echo '<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="' . $cssPath . '" />';
			}
			
			$tabpaneFilename = 'tabpane_mini.js';

			if (defined('_ISO2')) {
				$charset = strtolower(_ISO2);
				if ($charset == 'utf-8' || $charset == 'utf8') {
					$tabpaneFilename = 'tabpane.js';
				}
			}

			echo '<script type="text/javascript" src="'. $mainframe->getCfg('live_site') . '/includes/js/tabs/'.$tabpaneFilename.'"></script>';
			$this->useCookies = $useCookies;
		}
	}
}

class HTML_JComments
{
	function show( $lists )
	{
		global $mainframe, $my;

		$config = & JCommentsFactory::getConfig();

		$filter = '';
		$filterClear = '';

		if (isset($lists['fog'])) {
			$filter .= ' ' . $lists['fog'];
			$filterClear .= "document.getElementById('fog').value='';";
		}
		if (isset($lists['flang'])) {
			$filter .= ' ' . $lists['flang'];
			$filterClear .= "document.getElementById('flang').value='';\n";
		}
		if (isset($lists['foid'])) {
			$filter .= ' ' . $lists['foid'];
			$filterClear .= "document.getElementById('foid').value='';\n";
		}
		if (isset($lists['fauthor']) && $lists['fauthor'] != '') {
			$filter .= ' ' . $lists['fauthor'];
			$filterClear .= "document.getElementById('fauthor').value='';\n";
		}
		if (isset($lists['fstate'])) {
			$filter .= ' ' . $lists['fstate'];
			$filterClear .= "document.getElementById('fstate').value='';\n";
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			mosCommonHTML::loadOverlib();
		} else if (JCOMMENTS_JVERSION == '1.5') {
			JHTML::_('behavior.tooltip');
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
	<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/jcomments48x48.png" width="48" height="48" align="middle" />&nbsp;<?php echo JText::_('Comments'); ?></th>
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
<?php
		if (JCOMMENTS_JVERSION == '1.5') {
?>
			<th width="5" class="title">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $lists['rows'] );?>);" /></th>
			<th width="50%" class="title">
<?php
			if ($config->getInt('comment_title') > 0) {
?>
				<?php echo JHTML::_( 'grid.sort', 'A_COMMENT_TITLE', 'c.title', $lists['order_Dir'], $lists['order']); ?>
<?php
			} else {
?>
				<?php echo JText::_('A_COMMENT_TEXT'); ?>
<?php
			}
?>
			</th>
			<th width="12" align="center">@</th>
			<th width="10%" align="left" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'A_COMMENT_NAME', 'c.name', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="25%" align="left"><?php echo JText::_('A_COMMENT_OBJECT_TITLE'); ?></th>
			<th width="5%" align="left"><?php echo JHTML::_( 'grid.sort', 'A_COMPONENT', 'c.object_group', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'A_COMMENT_DATE', 'c.date', $lists['order_Dir'], $lists['order']); ?></th>
			<th width="5%" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'A_PUBLISHING', 'c.published', $lists['order_Dir'], $lists['order']); ?></th>
<?php
		} else {
?>
			<th width="5" class="title">#</th>
			<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $lists['rows'] );?>);" /></th>
			<th width="50%" class="title"><?php echo ($config->getInt('comment_title') > 0 ? JText::_('A_COMMENT_TITLE') : JText::_('A_COMMENT_TEXT')); ?></th>
			<th width="12" align="center">@</th>
			<th width="10%" align="left" nowrap="nowrap"><?php echo JText::_('A_COMMENT_NAME'); ?></th>
			<th width="25%" align="left"><?php echo JText::_('A_COMMENT_OBJECT_TITLE'); ?></th>
			<th width="5%" align="left"><?php echo JText::_('A_COMPONENT'); ?></th>
			<th width="5%" nowrap="nowrap"><?php echo JText::_('A_COMMENT_DATE'); ?></th>
			<th width="5%"><?php echo JText::_('A_PUBLISHING'); ?></th>
<?php
		}
?>
		</tr>
	</thead>
	<tbody>
<?php
		$config = & JCommentsFactory::getConfig();
		$word_maxlength = $config->getInt('word_maxlength');

		for ($i = 0, $k = 0, $n = count($lists['rows']); $i < $n; $i++) {
			/**
			 *  @var $row JCommentsDB
			 */
			$row =& $lists['rows'][$i];
			$task = $row->published ? 'unpublish' : 'publish';
			$img = $row->published ? 'tick.png' : 'publish_x.png';

			$subscribed = '';
			$email_icon = '';

			if ($row->subscription > 0) {
				$email_icon = 'subscribed.gif';
			} else if($row->email != '') {
				$email_icon = 'mail.gif';
			}

			if ($email_icon != '') {
				$subscribed = ' <a href="mailto:'.$row->email.'" target="_blank"><img src="'.$mainframe->getCfg( 'live_site' ).'/administrator/components/com_jcomments/assets/'.$email_icon.'" alt="" border="0" /></a>';
			}

			$object_title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group, $row->lang);

			//JComments::prepareComment($row);
			$commentText = $row->comment;
			$commentText = str_replace('<br />', "\n", $commentText);
			$commentText = JCommentsText::cleanText($commentText);
			$commentText = str_replace("\n", '<br />', $commentText);
			$commentText = JCommentsText::fixLongWords($commentText, $word_maxlength, ' ');
			$commentText = JCommentsText::substr($commentText, 200);

			if ($config->getInt('comment_title') > 0) {
				if ($row->title != '') {
					$commentTitle = $row->title;				
				} else {
					$commentTitle = JText::_('Re') . ' ' . $object_title;
				}
				$commentText = '<span style="font-weight: bold;">'. $commentTitle . '</span><br />' . $commentText;
			}

			$row->link = $mainframe->getCfg('live_site') . '/' . JCOMMENTS_INDEX . '?option=com_jcomments&task=go2object&object_id=' . $row->object_id . '&object_group=' . $row->object_group . '&no_html=1';

			$link 	= JCOMMENTS_INDEX . '?option=com_jcomments&task=edit&hidemainmenu=1&cid='. $row->id;

			$checked = JCommentsHTML::CheckedOutProcessing($row, $i);
?>
	<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $i+1+$lists['pageNav']->limitstart;?></td>
			<td width="20"><?php echo $checked; ?></td>
			<td align="left">
<?php
			if ($row->checked_out && ($row->checked_out != $my->id)) {
				echo $commentText;
			} else {
				$link_title = (JCOMMENTS_JVERSION == '1.5') ? JText::_('Edit') : _E_EDIT;
?>
				<a href="<?php echo $link; ?>" title="<?php echo $link_title; ?>"><?php echo $commentText; ?></a>
<?php
			}
?>
			</td>
			<td align="left"><?php echo $subscribed; ?></td>
			<td align="left"><?php echo JComments::getCommentAuthorName($row); ?><br />
			<a href="http://www.ripe.net/perl/whois?searchtext=<?php echo $row->ip; ?>" target="_blank" title="Whois"><?php echo $row->ip; ?></a></td>
			<td align="left">
<?php
			if (isset($row->link)) {
?>
				<a href="<?php echo $row->link; ?>" title="<?php echo htmlspecialchars($row->title); ?>" target="_blank"><?php echo $object_title; ?></a>
<?php
			} else {
				echo $object_title;
			}
?>
			</td>
			<td align="left">[<?php echo $row->object_group; ?>]</td>
			<td align="center" nowrap="nowrap"><?php echo JCommentsText::formatDate(strtotime($row->date), JText::_('DATETIME_FORMAT')); ?></td>
			<td align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" border="0" alt="<?php echo ($row->published ? JText::_('UNPUBLISH') : JText::_('PUBLISH')); ?>" /></a></td>
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
<input type="hidden" name="task" value="view" />
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
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if ( form.comment.value == "" ) {
		alert( "<?php echo JText::_('ERROR_EMPTY_COMMENT'); ?>" );
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
		<th style="background-image: none; padding: 0;">
			<img src="./components/com_jcomments/assets/jcomments48x48.png" width="48" height="48" align="middle" alt="" />&nbsp;<?php echo JText::_('EDIT');?>
		</th>
	</tr>
</table>
<?php
		}
?>
<table cellpadding="4" cellspacing="1" border="0" width="100%"	class="adminform">
	<tr valign="top" align="left">
		<td width="15%"><?php echo JText::_('A_COMPONENT'); ?></td>
		<td><?php echo $row->object_group; ?></td>
	</tr>
<?php
		if ($row->object_title != '') {
?>
<tr valign="top" align="left">
		<td><?php echo JText::_('A_COMMENT_OBJECT_TITLE'); ?></td>
		<td>
<?php
			if (isset($row->link)) {
?>
		<a href="<?php echo $row->link; ?>" target="_blank"><?php echo $row->object_title ;?></a>
<?php
			} else {
				echo $row->object_title;
			}
?>
		</td>
	</tr>
<?php
		}
?>
	<tr valign="top" align="left">
		<td><?php echo JText::_('A_COMMENT_DATE'); ?></td>
		<td><?php echo JCommentsText::formatDate(strtotime($row->date), '%Y-%m-%d %H:%M'); ?></td>
	</tr>
	<tr valign="top" align="left">
		<td><label for="author_name"><?php echo JText::_('A_COMMENT_NAME'); ?></label></td>
		<td>
<?php
		if ( $row->userid != 0) {
			echo $row->name;
		} else {
?>
        		<input type="text" class="editbox long" size="35" id="author_name" name="name" value="<?php echo $row->name; ?>" />
<?php
		}
?>
	</td>
	</tr>
<?php
		if ($row->email != '') {
?>
	<tr valign="top" align="left">
		<td><label for="author_email"><?php echo JText::_('A_COMMENT_EMAIL'); ?></label></td>
		<td><input type="text" class="editbox long" size="35" id="author_email" name="email" value="<?php echo $row->email; ?>" /></td>
	</tr>
<?php
		}
		if ($row->homepage != '') {
?>
	<tr valign="top" align="left">
		<td><label for="author_homepage"><?php echo JText::_('FORM_HOMEPAGE'); ?></label></td>
		<td><input type="text" class="editbox long" size="35" id="author_homepage" name="homepage" value="<?php echo $row->homepage; ?>" /></td>
	</tr>
<?php
		}
?>
	<tr valign="top" align="left">
		<td>IP:</td>
		<td><?php echo $row->ip; ?></td>
	</tr>

<?php
		if ($row->title != '') {
?>
	<tr valign="top" align="left">
		<td><label for="comment_title"><?php echo JText::_('A_COMMENT_TITLE'); ?></label></td>
		<td><input type="text" class="editbox long" size="35" id="comment_title" name="title" value="<?php echo $row->title; ?>" /></td>
	</tr>
<?php
		}
?>
	<tr valign="top" align="left">
		<td><label for="comment_text"><?php echo JText::_('A_COMMENT_TEXT'); ?></label></td>
		<td><textarea class="editbox long" cols="25" rows="10" id="comment_text" name="comment"><?php echo $row->comment; ?></textarea></td>
	</tr>
	<tr valign="top" align="left">
		<td><?php echo JText::_('A_PUBLISHING'); ?></td>
		<td><?php echo JCommentsHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published, JText::_('A_YES'), JText::_('A_NO') ); ?></td>
	</tr>
</table>
<input type="hidden" name="option" value="com_jcomments" />
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
<?php
	}

	function _smileItem($id, $code, $image, $imageList)
	{
		global $mainframe;

		if ($image == '') {
			$image_src = $mainframe->getCfg( 'live_site' ) . "/images/blank.png";
		} else {
			$image_src = $mainframe->getCfg( 'live_site' ) . "/components/com_jcomments/images/smiles/". $image;
		}
?>
<div style="white-space: nowrap; height: 24px;" id="jc_smile_<?php echo $id; ?>">
    <a href="javascript:jc_smileDelete('<?php echo $id; ?>')" id="jc_smileDelete_<?php echo $id; ?>" title="<?php echo JText::_('A_SMILES_DELETE'); ?>">
        <img style="vertical-align: middle;" src="./components/com_jcomments/assets/delete.gif" alt="<?php echo JText::_('A_SMILES_DELETE'); ?>" width="17" height="17" border="0" />
    </a>
    <a href="javascript:jc_smileUp('<?php echo $id; ?>')" id="jc_smileUp_<?php echo $id; ?>" title="<?php echo JText::_('A_SMILES_MOVE_UP'); ?>">
        <img style="vertical-align: middle;" src="./components/com_jcomments/assets/up.gif" alt="<?php echo JText::_('A_SMILES_MOVE_UP'); ?>" width="14" height="12" border="0" />
    </a>
    <a href="javascript:jc_smileDown('<?php echo $id; ?>')" id="jc_smileDown_<?php echo $id; ?>" title="<?php echo JText::_('A_SMILES_MOVE_DOWN'); ?>">
        <img style="vertical-align: middle;" src="./components/com_jcomments/assets/down.gif" alt="<?php echo JText::_('A_SMILES_MOVE_DOWN'); ?>" width="14" height="12" border="0" />
    </a>
    <input class="inputbox" name="cfg_smile_codes[<?php echo $id; ?>]" id="jc_smileCode_<?php echo $id; ?>" value="<?php echo htmlspecialchars($code); ?>" style="border: 1px solid #999;" type="text" />
    &nbsp;<?php echo JText::_('A_SMILES_REPLACE_WITH'); ?>&nbsp;
    <select class="inputbox" name="cfg_smile_images[<?php echo $id; ?>]" id="jc_smileImage_<?php echo $id; ?>" onchange="jc_smilePreview(this.getAttribute('id'), this.value)">
	    <option value="" selected="selected"></option>
<?php
		foreach($imageList as $img) {
?>
        <option value="<?php echo $img; ?>" <?php echo (($img == $image) ? 'selected="selected"' : ''); ?>><?php echo $img; ?></option>
<?php
		}
?>
    </select>&nbsp;<img src="<?php echo $image_src; ?>" id="jc_smilePreview_<?php echo $id; ?>" alt="" style="vertical-align: middle;" border="0" />&nbsp;</div>
<?php
	}

	function showSettings( &$lists )
	{
		global $mainframe;

		$config = & JCommentsFactory::getConfig();

		$order[] = JCommentsHTML::makeOption('DESC', JText::_('AP_ORDER_DESCENDING'));
		$order[] = JCommentsHTML::makeOption( 'ASC', JText::_('AP_ORDER_ASCENDING') );
		$lists["order"] = JCommentsHTML::selectList( $order, 'cfg_comments_order', 'class="inputbox"', 'value', 'text', $config->get('comments_order'));

		$pagination[] = JCommentsHTML::makeOption('top', JText::_('AP_PAGINATION_TOP'));
		$pagination[] = JCommentsHTML::makeOption('bottom', JText::_('AP_PAGINATION_BOTTOM'));
		$pagination[] = JCommentsHTML::makeOption('both', JText::_('AP_PAGINATION_BOTH'));
		$lists["pagination"] = JCommentsHTML::selectList($pagination, 'cfg_comments_pagination', 'class="inputbox"', 'value', 'text', $config->get('comments_pagination'));

		$display_author[] = JCommentsHTML::makeOption('name', JText::_('AP_DISPLAY_AUTHOR_NAME'));
		$display_author[] = JCommentsHTML::makeOption('username', JText::_('AP_DISPLAY_AUTHOR_USERNAME'));
		$lists["display_author"] = JCommentsHTML::selectList($display_author, 'cfg_display_author', 'class="inputbox"', 'value', 'text', $config->get('display_author'));

		$field[] = JCommentsHTML::makeOption('0', JText::_('A_DISABLE'));
		$field[] = JCommentsHTML::makeOption('1', JText::_('A_UNREQUIRED'));
		$field[] = JCommentsHTML::makeOption('2', JText::_('A_REQUIRED_FOR_UNREGISTERED'));
		$lists["author_email"] = JCommentsHTML::selectList($field, 'cfg_author_email', 'class="inputbox"', 'value', 'text', $config->get('author_email'));

		$field[] = JCommentsHTML::makeOption('3', JText::_('A_REQUIRED_FOR_ALL'));
		$lists["author_homepage"] = JCommentsHTML::selectList($field, 'cfg_author_homepage', 'class="inputbox"', 'value', 'text', $config->get('author_homepage'));

		$field = array();
		$field[] = JCommentsHTML::makeOption('0', JText::_('A_DISABLE'));
		$field[] = JCommentsHTML::makeOption('1', JText::_('A_UNREQUIRED'));
		$field[] = JCommentsHTML::makeOption('3', JText::_('A_REQUIRED_FOR_ALL'));
		$lists["comment_title"] = JCommentsHTML::selectList($field, 'cfg_comment_title', 'class="inputbox"', 'value', 'text', $config->get('comment_title'));

		$form_show = array();
		$form_show[] = JCommentsHTML::makeOption('1', JText::_('AP_FORM_SHOW_FORM'));
		$form_show[] = JCommentsHTML::makeOption('0', JText::_('AP_FORM_SHOW_LINK'));
		$form_show[] = JCommentsHTML::makeOption('2', JText::_('AP_FORM_SHOW_LINK_IF_ANY_COMMENTS_EXIST'));
		$lists["form_show"] = JCommentsHTML::selectList($form_show, 'cfg_form_show', 'class="inputbox"', 'value', 'text', $config->get('form_show'));
		
		$template_view[] = JCommentsHTML::makeOption('list', JText::_('AP_TEMPLATE_VIEW_LIST'));
		$template_view[] = JCommentsHTML::makeOption('tree', JText::_('AP_TEMPLATE_VIEW_TREE'));
		$lists["template_view"] = JCommentsHTML::selectList($template_view, 'cfg_template_view', 'class="inputbox" onchange="jc_show_template_view(this.value);"', 'value', 'text', $config->get('template_view'));

		$notification = array();
		$notification[] = JCommentsHTML::makeOption(0, JText::_('A_NO'));
		$notification[] = JCommentsHTML::makeOption(1, JText::_('A_YES'));
		$lists["notification"] = JCommentsHTML::selectList($notification, 'cfg_enable_notification', 'class="inputbox" onchange="jc_show_notification_email(this.value);"', 'value', 'text', $config->get('enable_notification'));

		$ntypes = explode(',', $config->get('notification_type'));
		$types = array();
		foreach($ntypes as $type) {
			$t = new StdClass();
			$t->value = $type;
			$types[] = $t;
		}
		unset($ntypes);

		$notification_type[] = JCommentsHTML::makeOption(1, JText::_('Notifications'));
		$notification_type[] = JCommentsHTML::makeOption(2, JText::_('Reports'));
		$lists["notification_type"] = JCommentsHTML::selectList($notification_type, 'cfg_notification_type[]', 'class="inputbox" size="2" multiple="multiple"', 'value', 'text', $types);

		$quick_moderation[] = JCommentsHTML::makeOption(0, JText::_('A_NO'));
		$quick_moderation[] = JCommentsHTML::makeOption(1, JText::_('A_YES'));
		$lists["quick_moderation"] = JCommentsHTML::selectList($quick_moderation, 'cfg_enable_quick_moderation', 'class="inputbox"', 'value', 'text', $config->get('enable_quick_moderation'));

		$gnames = array();
		foreach($lists['group_names'] as $group) {
			$gnames[] = $group->text;
		}

		if (JCOMMENTS_JVERSION == '1.0') {
			mosCommonHTML::loadOverlib();
		} else if (JCOMMENTS_JVERSION == '1.5') {
			JHTML::_('behavior.tooltip');
		}

		$ajaxUrl = JCommentsFactory::getLink('ajax-backend');
?>
<script type="text/javascript" src="<?php echo $mainframe->getCfg( 'live_site' );?>/components/com_jcomments/libraries/joomlatune/ajax.js?v=2"></script>
<script type="text/javascript" src="<?php echo $mainframe->getCfg( 'live_site' );?>/administrator/components/com_jcomments/assets/jcomments-backend-v2.1.js"></script>
<script type="text/javascript">
<!--
function JCommentsSaveSettingsAJAX(func) {
	try{
		var r=requestURI='<?php echo $ajaxUrl; ?>';
		jtajax.setup({url:requestURI});
		var params = 'jtxf=' + jtajax.encode(func);
		var frm = jtajax.$('adminForm');
		if (frm && frm.tagName.toUpperCase() == 'FORM') {
			var e = frm.elements, query = [];
			for (var i=0; i < e.length; i++) {
				var name = e[i].name, value;
				if (!name) continue;
				if (e[i].type && ('radio' == e[i].type || 'checkbox' == e[i].type) && false === e[i].checked) continue;
				if ('select-multiple' == e[i].type) {
					for (var j = 0; j < e[i].length; j++) {
						if (true === e[i].options[j].selected)
							query.push(name+"="+jtajax.encode(e[i].options[j].value));
					}
				} else { query.push(name+"="+jtajax.encode(e[i].value)); 
				}
			}
			params += '&jtx64=' + encodeURIComponent(jcbackend.base64_encode(query.join('&')));
		}
		jtajax.ajax({type: 'post', data: params});
		return true;

	}catch(e){
		return false;
	}
}

function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if(jtajax) {
		if (pressbutton == 'settings.save') {
			JCommentsSaveSettingsAJAX('JCommentsSaveSettingsAjax');
		} else if (pressbutton == 'settings.restore') {
			if (confirm('<?php echo addslashes(JText::_('Are you sure you would like to restore the default settings?'));?>')) {
				submitform( pressbutton );
			}
		} else {
			submitform( pressbutton );
		}
	} else {
		submitform( pressbutton );
	}
}
function jc_show_notification_email(v){
	var e=document.getElementById('notification_type');if(e){e.style.display=((v==1)?'':'none');}
	e=document.getElementById('notification_email');if(e){e.style.display=((v==1)?'':'none');}
	e=document.getElementById('quick_moderation');if(e){e.style.display=((v==1)?'':'none');}
}

function jc_show_template_view(v){
	var params = new Array('list_params_order','list_params_per_page','list_params_page_limit','list_params_pagination');
	for(var n in params) {
		var e=document.getElementById(params[n]);
		if(e){e.style.display=((v=='list')?'':'none');}
	}
}

var jc_usergroups = new Array("<?php echo implode('","', $gnames); ?>");
var jc_selected_group = jc_usergroups[0].replace(' ', '_').toLowerCase();
function jc_showgroup(value) {
	var gn,ge,ce,he = document.getElementById('groupheader');

	if (value == '') {
		value = jc_usergroups[0].toLowerCase();
	}
	value = value.replace(' ', '_').toLowerCase();

	for(i=0;i<jc_usergroups.length;i++) {
		gn = jc_usergroups[i].replace(' ', '_').toLowerCase();
		ge = document.getElementById(gn);
		ce = document.getElementById('jc_'+gn);
		if (gn == value) {
			document.cookie = "jcommentsadmin_group=" + jc_usergroups[i] + "; path=/";
			he.innerHTML = '<?php echo addslashes(JText::_('A_RIGHTS_GROUP_DESC')); ?>'+' <span style="color: green">'+jc_usergroups[i]+'</span>';
			ge.style.display = '';
			ce.className = 'active';
		}
	}

	if (jc_selected_group != value) {
		ge = document.getElementById(jc_selected_group);
		ce = document.getElementById('jc_'+jc_selected_group);
		ge.style.display = 'none';
		ce.className = 'nonactive';
	}

	jc_selected_group = value;
}
//-->
</script>
<style type="text/css">

#jcomments-message {padding: 0 0 0 25px;margin: 0; width: auto; float: right; font-size: 14px; font-weight: bold;}
.jcomments-message-error {background: transparent url(components/com_jcomments/assets/error.gif) no-repeat 4px 50%; color: red;}
.jcomments-message-info {background: transparent url(components/com_jcomments/assets/info.gif) no-repeat 4px 50%; color: green;}

#jc img { vertical-align: middle; }
#jc textarea { border: 1px solid #ccc; }
#jc .inputbox { border: 1px solid #ccc; padding: 2px 2px 2px 2px; margin: 2px 0; }
#jc input:focus,#jc select:focus,#jc textarea:focus { background-color: #ffd }

table.rights td.active,table.rights td.nonactive,table.rights td.container,table.rights td.top-spacer,table.rights td.bottom-spacer { margin: 0; width: 150px;}
table.rights td.top-spacer { border-right: 1px solid #5194CB; line-height: 3px; height: 3px; }
table.rights td.bottom-spacer { border-right: 1px solid #5194CB; height: 100%; }
table.rights td.nonactive { padding: 0 0 0 8px; cursor: pointer; border-right: 1px solid #5194CB; }
table.rights td.active { padding: 0 0 0 5px; border-top: 1px solid #5194CB; border-bottom: 1px solid #5194CB; border-left: 3px solid #5194CB; border-right: 1px solid #fff; background-color: #fff; }
table.rights td.container { margin: 0; padding: 5px; border-top: 1px solid #5194CB; border-bottom: 1px solid #5194CB; border-right: 1px solid #5194CB; background-color: #fff; }
* html ul.tabs { margin: 10px -3px 0 0 !important; }
* html .rights_table { margin: 0 0 0 -3px !important; }
* html .rights_table input.inputbox { border: 0 !important; background-color: #fff !important; }
</style>
<div id="jc">
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm" id="adminForm">
<?php
		if (JCOMMENTS_JVERSION == '1.0') {
?>
<table class="adminheading">
	<tr>
		<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/settings48x48.png" width="48" height="48" align="middle">&nbsp;<?php echo JText::_('A_SETTINGS'); ?></th>
	</tr>
</table>
<?php
		}
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left">
<?php
		if (isset($lists['languages'])) {
?>
			<div style="text-align:left;">
				<?php echo JText::_('JoomFish Language:') . ' ' .  $lists['languages']; ?>
			</div>
<?php
                        // TODO: add an option to disable comments separation by language(multilingual_support)
		} else {
			echo '&nbsp;';
		}
?>
		</td>
		<td width="50%" align="right"><div id="jcomments-message-holder">&nbsp;</div></td>
	</tr>
</table>

<?php
		$tabs = new JCommentsTabs( 1 );
		$tabs->startPane( 'com_jcomments' );
		$tabs->startTab(JText::_('A_COMMON'), "common");
?>
<fieldset class="adminform"><legend><?php echo JText::_('A_CATEGORIES')?></legend>
<table class="admintable" width="100%">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_CATEGORIES'); ?></td>
		<td width="30%"><?php echo $lists['categories']; ?></td>
		<td width="50%"><?php echo JText::_('AP_CATEGORIES_DESC'); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_NOTIFICATIONS'); ?></legend>
<table class="admintable" width="100%">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_ENABLE_NOTIFICATION'); ?></td>
		<td width="30%"><?php echo $lists["notification"]; ?></td>
		<td width="50%"><?php echo JText::_('AP_ENABLE_NOTIFICATION_DESC'); ?></td>
	</tr>
<?php
	$style = ($config->getInt('enable_notification') == 0) ? 'style="display: none"' : '';
?>
	<tr align="left" valign="top" id="notification_type" <?php echo $style; ?>>
		<td width="20%"><?php echo JText::_('Notification Types'); ?></td>
		<td width="30%"><?php echo $lists["notification_type"]; ?></td>
		<td width="50%"></td>
	</tr>
	<tr align="left" valign="top" id="notification_email" <?php echo $style; ?>>
		<td><?php echo JText::_('AP_ENABLE_NOTIFICATION_EMAIL'); ?></td>
		<td><input type="text" class="inputbox" size="35" name="cfg_notification_email" value="<?php echo $config->get('notification_email'); ?>" /></td>
		<td><?php echo JText::_('AP_ENABLE_NOTIFICATION_EMAIL_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top" id="quick_moderation" <?php echo $style; ?>>
		<td><?php echo JText::_('AP_ENABLE_QUICK_MODERATION'); ?></td>
		<td><?php echo $lists["quick_moderation"]; ?></td>
		<td><?php echo JText::_('AP_ENABLE_QUICK_MODERATION_DESC'); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_MISC'); ?></legend>
<table class="admintable" width="100%">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_ENABLE_RSS'); ?></td>
		<td width="30%"><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_rss', 'class="inputbox"', $config->get('enable_rss'), JText::_('A_YES'), JText::_('A_NO')  ); ?></td>
		<td width="50%"><?php echo JText::_('AP_ENABLE_RSS_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_USE_MAMBOTS'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_mambots', 'class="inputbox"', $config->get('enable_mambots'), JText::_('A_YES'), JText::_('A_NO')  ); ?></td>
		<td><?php echo JText::_('AP_USE_MAMBOTS_DESC'); ?></td>
	</tr>
</table>
</fieldset>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('A_LAYOUT'), "layout");
?>
<fieldset class="adminform"><legend><?php echo JText::_('A_VIEW'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_TEMPLATE'); ?></td>
		<td width="30%"><?php echo $lists["templates"]; ?></td>
		<td width="50%"><?php echo JText::_('AP_TEMPLATE_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_ENABLE_SMILES'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_smiles', 'class="inputbox"', $config->get('enable_smiles'), JText::_('A_YES'), JText::_('A_NO')  ); ?></td>
		<td><?php echo JText::_('AP_ENABLE_SMILES_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_ENABLE_CUSTOM_BBCODE'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_custom_bbcode', 'class="inputbox"', $config->get('enable_custom_bbcode'), JText::_('A_YES'), JText::_('A_NO')  ); ?></td>
		<td><?php echo JText::_('AP_ENABLE_CUSTOM_BBCODE_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_ENABLE_VOTING'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_voting', 'class="inputbox"', $config->get('enable_voting'), JText::_('A_YES'), JText::_('A_NO')  ); ?></td>
		<td><?php echo JText::_('AP_ENABLE_VOTING_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_DISPLAY_AUTHOR'); ?></td>
		<td><?php echo $lists["display_author"]; ?></td>
		<td><?php echo JText::_('AP_DISPLAY_AUTHOR_DESC'); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_LIST_PARAMS'); ?></legend>

<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_TEMPLATE_VIEW'); ?></td>
		<td width="30%"><?php echo $lists["template_view"]; ?></td>
		<td width="50%"><?php echo JText::_('AP_TEMPLATE_VIEW_DESC'); ?></td>
	</tr>
<?php
		$style = ($config->get('template_view', 'list') == 'tree') ? 'style="display: none"' : '';
?>
	<tr align="left" valign="top" <?php echo $style; ?>
		id="list_params_order">
		<td><?php echo JText::_('AP_ORDER'); ?></td>
		<td><?php echo $lists["order"]; ?></td>
		<td><?php echo JText::_('AP_ORDER_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top" <?php echo $style; ?>
		id="list_params_per_page">
		<td><?php echo JText::_('AP_COMMENTS_PER_PAGE'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_comments_per_page" value="<?php echo $config->getInt('comments_per_page'); ?>" /></td>
		<td><?php echo JText::_('AP_COMMENTS_PER_PAGE_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top" <?php echo $style; ?>
		id="list_params_page_limit">
		<td><?php echo JText::_('AP_COMMENTS_PAGE_LIMIT'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_comments_page_limit" value="<?php echo $config->getInt('comments_page_limit'); ?>" /></td>
		<td><?php echo JText::_('AP_COMMENTS_PAGE_LIMIT_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top" <?php echo $style; ?>
		id="list_params_pagination">
		<td><?php echo JText::_('AP_PAGINATION'); ?></td>
		<td><?php echo $lists["pagination"]; ?></td>
		<td><?php echo JText::_('AP_PAGINATION_DESC'); ?></td>
	</tr>
</table>

</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_FORM_PARAMS'); ?></legend>

<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_FORM_SHOW'); ?></td>
		<td width="30%"><?php echo $lists["form_show"]; ?></td>
		<td width="50%"><?php echo JText::_('AP_FORM_SHOW_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_AUTHOR_EMAIL'); ?></td>
		<td><?php echo $lists["author_email"]; ?></td>
		<td rowspan="2"><?php echo JText::_('AP_AUTHOR_EMAIL_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_AUTHOR_HOMEPAGE'); ?></td>
		<td><?php echo $lists["author_homepage"]; ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_COMMENT_TITLE'); ?></td>
		<td><?php echo $lists["comment_title"]; ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('CAPTCHA'); ?></td>
		<td><?php echo $lists["captcha"]; ?></td>
	</tr>
</table>

</fieldset>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('A_RIGHTS'),"rights");
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="adminForm">
<tr>
	<th align="left"><?php echo JText::_('A_RIGHTS_GROUPS'); ?></th>
	<th align="left"><span id="groupheader"><?php echo JText::_('A_RIGHTS_DESC'); ?></span></th>
</tr>
<tr align="left" valign="top">
	<td colspan="2">
		<table class="rights" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="top-spacer">&nbsp;</td>
			<td rowspan="<?php echo count($lists['group_names']) + 2; ?>" class="container">
<?php
                $i = 0;
		foreach($lists['groups'] as $gname=>$glist) {
			$pgColumns = 3;
			$groupName = strtolower(str_replace(' ', '_',$gname));
?>
				<div id="<?php echo $groupName; ?>" style="display: none">
					<table>
					<tr valign="top">
<?php

			$j = 1;
			foreach($glist as $pname=>$plist) {

?>
						<td width="<?php echo round(100/$pgColumns); ?>%" nowrap="nowrap"><strong><?php echo $pname; ?></strong><br />
<?php
				foreach($plist as $param) {
					$inputName = 'cfg_' . $param['name'] . '[' . $i . ']';
					$inputId = 'cfg_' . $param['name'] . '_' . $i;

					$caption = addslashes(strip_tags($param['label']));
					$message = addslashes($param['note']);
?>
							<input type="checkbox" name="<?php echo $inputName; ?>" id="<?php echo $inputId; ?>" value="<?php echo $param['group'] ?>" <?php echo (($param['value'] == '1') ? 'checked="checked"' : '');  ?> <?php echo (($param['value'] == '-1') ? 'disabled="disabled"' : ''); ?> />
<?php
					if ( JCOMMENTS_JVERSION == '1.5' ) {
?>
							<label for="<?php echo $inputId; ?>"><span class="hasTip" title="<?php echo $caption; ?>::<?php echo $message; ?>"><?php echo $param['label']; ?></span></label>
<?php
					} else {
?>
							<label for="<?php echo $inputId; ?>" onmouseover="return overlib('<?php echo $message; ?>', CAPTION, '<?php echo $caption; ?>', WIDTH, 300);" onmouseout='return nd();'><span class='editlinktip'><?php echo $param['label']; ?></span></label>
<?php
					}
?>			
<?php
					if ($param['error'] != '') {
						HTML_JComments::showWarning($param['error']);
					}
?>
							<br />
<?php
				}
				$i++;
?>
						</td>
<?php
				if ($j%$pgColumns == 0 && $j != count($glist)) {
?>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr valign="top">
<?php
				}
				$j++;
			}
?>
					</tr>
					</table>
				</div>
<?php
		}
?>
                        </td>
		</tr>
<?php
		$activeGroup = '';

		if (isset($_COOKIE['jcommentsadmin_group'])) {
			$activeGroup = $_COOKIE['jcommentsadmin_group'];
		}

		$i = 0;
		foreach($lists['group_names'] as $group) {
			if ((($activeGroup == '')&&($i==0))
			|| (($activeGroup != '')&&($group->text == $activeGroup))) {
				$selected = 'class="active"';
			} else {
				$selected = 'class="nonactive"';
			}
			$groupName = strtolower(str_replace(' ', '_',$group->text));
?>
                <tr>
			<td <?php echo $selected; ?> id="jc_<?php echo $groupName; ?>" onclick="jc_showgroup('<?php echo $groupName; ?>')"><?php echo $group->text; ?></td>
		</tr>
<?php
                	$i++;
		}
?>
		<tr>
			<td class="bottom-spacer">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('A_RESTRICTIONS'),"restrictions");
?>
<fieldset class="adminform"><legend><?php echo JText::_('A_RESTRICTIONS'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_USERNAME_MAXLENGTH'); ?></td>
		<td width="30%"><input type="text" class="inputbox" size="5" name="cfg_username_maxlength" value="<?php echo $config->getInt('username_maxlength'); ?>" /></td>
		<td width="50%"><?php echo JText::_('AP_USERNAME_MAXLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_COMMENT_MINLENGTH'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_comment_minlength" value="<?php echo $config->getInt('comment_minlength'); ?>" /></td>
		<td><?php echo JText::_('AP_COMMENT_MINLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_COMMENT_MAXLENGTH'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_comment_maxlength" value="<?php echo $config->getInt('comment_maxlength'); ?>" /></td>
		<td><?php echo JText::_('AP_COMMENT_MAXLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_SHOW_COMMENTLENGTH'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_show_commentlength', 'class="inputbox"', $config->getInt('show_commentlength'), JText::_('A_SHOW'), JText::_('A_HIDE')  ); ?></td>
		<td><?php echo JText::_('AP_SHOW_COMMENTLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_WORD_MAXLENGTH'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_word_maxlength" value="<?php echo $config->getInt('word_maxlength'); ?>" /></td>
		<td><?php echo JText::_('AP_WORD_MAXLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_LINK_MAXLENGTH'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_link_maxlength" value="<?php echo $config->getInt('link_maxlength'); ?>" /></td>
		<td><?php echo JText::_('AP_LINK_MAXLENGTH_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_FLOOD_TIME'); ?></td>
		<td><input type="text" class="inputbox" size="5" name="cfg_flood_time" value="<?php echo $config->getInt('flood_time'); ?>" /></td>
		<td><?php echo JText::_('AP_FLOOD_TIME_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_ENABLE_NESTED_QUOTES'); ?></td>
		<td><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_nested_quotes', 'class="inputbox"', $config->get('enable_nested_quotes'), JText::_('A_YES'), JText::_('A_NO')); ?></td>
		<td><?php echo JText::_('AP_ENABLE_NESTED_QUOTES_DESC'); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_SECURITY'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_ENABLE_USERNAME_CHECK'); ?></td>
		<td width="30%"><?php echo JCommentsHTML::yesnoSelectList( 'cfg_enable_username_check', 'class="inputbox"', $config->get('enable_username_check'), JText::_('A_YES'), JText::_('A_NO')); ?></td>
		<td width="50%"><?php echo JText::_('AP_ENABLE_USERNAME_CHECK_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_FORBIDDEN_NAMES_LIST'); ?></td>
		<td><textarea class="inputbox" cols="25" rows="5" name="cfg_forbidden_names"><?php echo $config->get('forbidden_names'); ?></textarea></td>
		<td><?php echo JText::_('AP_FORBIDDEN_NAMES_LIST_DESC'); ?></td>
	</tr>
</table>
</fieldset>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('A_CENSOR'),"censor");
?>
<fieldset class="adminform"><legend><?php echo JText::_('A_CENSOR_DESC'); ?></legend>

<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td width="20%"><?php echo JText::_('AP_BAD_WORDS_LIST'); ?></td>
		<td width="30%"><textarea class="inputbox" cols="25" rows="8" name="cfg_badwords"><?php echo htmlspecialchars($config->get('badwords'), ENT_QUOTES );?></textarea></td>
		<td width="50%"><?php echo JText::_('AP_BAD_WORDS_LIST_DESC'); ?></td>
	</tr>
	<tr align="left" valign="top">
		<td><?php echo JText::_('AP_CENSOR_REPLACE_WORD'); ?></td>
		<td><input type="text" class="inputbox" size="30" name="cfg_censor_replace_word" value="<?php echo htmlspecialchars($config->get('censor_replace_word'), ENT_QUOTES ); ?>" /></td>
		<td></td>
	</tr>
</table>

</fieldset>
<?php
		$tabs->endTab();
		$tabs->startTab(JText::_('A_MESSAGES'), "messages");
?>
<fieldset class="adminform"><legend><?php echo JText::_('A_MESSAGES_POLICY_POST'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td><textarea class="inputbox" cols="50" rows="5" name="cfg_message_policy_post"><?php echo stripslashes($config->get('message_policy_post')); ?></textarea></td>
		<td width="50%"><?php echo JText::_('A_MESSAGES_POLICY_POST_DESC'); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_MESSAGES_POLICY_WHOCANCOMMENT'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td><textarea class="inputbox" cols="50" rows="5" name="cfg_message_policy_whocancomment"><?php echo stripslashes($config->get('message_policy_whocancomment')); ?></textarea></td>
		<td width="50%"><?php echo JText::sprintf('A_MESSAGES_POLICY_WHOCANCOMMENT_DESC', JText::_('A_MESSAGES_POLICY_WHOCANCOMMENT_DEFAULT')); ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_('A_MESSAGES_LOCKED'); ?></legend>
<table width="100%" border="0" cellpadding="4" cellspacing="2">
	<tr align="left" valign="top">
		<td><textarea class="inputbox" cols="50" rows="5" name="cfg_message_locked"><?php echo stripslashes($config->get('message_locked')); ?></textarea></td>
		<td width="50%"><?php echo JText::_('A_MESSAGES_LOCKED_DESC'); ?></td>
	</tr>
</table>
</fieldset>
<?php
		$tabs->endTab();
		$tabs->endPane();
?>
<script type="text/javascript">
<!--
jc_showgroup('<?php echo $activeGroup; ?>');
//-->
</script>
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_jcomments" />
</form>
</div>
<?php
	}

	function showSmiles( &$lists ) {
		global $mainframe;

		$lastSmileId = count($lists['smiles']) + 1;
?>
<style type="text/css">
#jc input {border: 1px solid #ccc; padding: 2px 2px 2px 2px;}
#jc img {vertical-align: middle;}
#jc textarea {border: 1px solid #ccc;}
#jc input:focus,#jc select:focus,#jc textarea:focus {background-color: #ffd}
</style>
<script type="text/javascript">
<!--
var jc_lastSmileId = <?php echo $lastSmileId; ?>;

function jc_addSmile() {
	var elField = document.getElementById('jc_smile_' + jc_lastSmileId).cloneNode(true);
	document.getElementById('jc_smile_' + jc_lastSmileId).setAttribute('id', 'jc_smile_'+(jc_lastSmileId+1));
	document.getElementById('jc_smileCode_'+jc_lastSmileId).setAttribute('name', 'cfg_smile_codes['+(jc_lastSmileId+1)+']');
	document.getElementById('jc_smileCode_'+jc_lastSmileId).setAttribute('id', 'jc_smileCode_'+(jc_lastSmileId+1));
	document.getElementById('jc_smileImage_'+jc_lastSmileId).setAttribute('name', 'cfg_smile_images['+(jc_lastSmileId+1)+']');
	document.getElementById('jc_smileImage_'+jc_lastSmileId).setAttribute('id', 'jc_smileImage_'+(jc_lastSmileId+1));
	document.getElementById('jc_smilePreview_'+jc_lastSmileId).setAttribute('id', 'jc_smilePreview_'+(jc_lastSmileId+1));
	document.getElementById('jc_smileDelete_'+jc_lastSmileId).setAttribute('href', 'javascript:jc_smileDelete('+(jc_lastSmileId+1)+')');
	document.getElementById('jc_smileDelete_'+jc_lastSmileId).setAttribute('id', 'jc_smileDelete_'+(jc_lastSmileId+1));
	document.getElementById('jc_smileUp_'+jc_lastSmileId).setAttribute('href', 'javascript:jc_smileUp('+(jc_lastSmileId+1)+')');
	document.getElementById('jc_smileUp_'+jc_lastSmileId).setAttribute('id', 'jc_smileUp_'+(jc_lastSmileId+1));
	document.getElementById('jc_smileDown_'+jc_lastSmileId).setAttribute('href', 'javascript:jc_smileDown('+(jc_lastSmileId+1)+')');
	document.getElementById('jc_smileDown_'+jc_lastSmileId).setAttribute('id', 'jc_smileDown_'+(jc_lastSmileId+1));
	jc_lastSmileId = jc_lastSmileId + 1;
	document.getElementById('jc_smileContainer').appendChild(elField);
}

function jc_smileDelete(id) {
	document.getElementById('jc_smileContainer').removeChild(document.getElementById('jc_smile_'+id));
}

function jc_smileUp(id) {
	var elField1 = document.getElementById('jc_smile_'+id);
	var elField2 = document.getElementById('jc_smile_'+id).cloneNode(true);
	for (i = 0; i < document.getElementById('jc_smileImage_'+id).childNodes.length; i++) {
		if (document.getElementById('jc_smileImage_'+id).childNodes[i].selected) {
			elFieldType1 = i;
			break;
		}
	}

	var elField3 = document.getElementById('jc_smile_'+id).previousSibling;
	if (elField3) {
		while (elField3.nodeType != 1) {
			elField3 = elField3.previousSibling;
			if (!elField3) {
				return;
			}
		}
	} else {
		return;
	}

	document.getElementById('jc_smileContainer').removeChild(elField1);
	document.getElementById('jc_smileContainer').insertBefore(elField2, elField3);
	document.getElementById('jc_smileImage_'+elField2.getAttribute('id').substr(9)).childNodes[elFieldType1].selected = true;
}

function jc_smileDown(id) {
	var elField1 = document.getElementById('jc_smile_'+id).cloneNode(true);

	for (i = 0; i < document.getElementById('jc_smileImage_'+id).childNodes.length; i++) {
		if (document.getElementById('jc_smileImage_'+id).childNodes[i].selected) {
			elFieldType1 = i;
			break;
		}
	}

	var elField2 = document.getElementById('jc_smile_'+id).nextSibling;
	if (elField2) {
		while (elField2.nodeType != 1) {
			elField2 = elField2.nextSibling;
			if (!elField2) {
				return;
			}
		}
	} else {
		return;
	}

	for (i = 0; i < document.getElementById('jc_smileImage_'+elField2.getAttribute('id').substr(9)).childNodes.length; i++) {
		if (document.getElementById('jc_smileImage_'+elField2.getAttribute('id').substr(9)).childNodes[i].selected) {
			elFieldType2 = i;
			break;
		}
	}

	elField3 = elField2;
	elField2 = elField2.cloneNode(true);

	document.getElementById('jc_smileContainer').removeChild(document.getElementById('jc_smile_'+id));
	document.getElementById('jc_smileContainer').replaceChild(elField1, elField3);
	document.getElementById('jc_smileContainer').insertBefore(elField2, document.getElementById('jc_smile_'+id));
	document.getElementById('jc_smileImage_'+id).childNodes[elFieldType1].selected = true;
	document.getElementById('jc_smileImage_'+elField2.getAttribute('id').substr(9)).childNodes[elFieldType2].selected = true;
}

function jc_smilePreview(el, type) {
    var img = document.getElementById('jc_smilePreview_'+el.substr(14));
    if (type != '') {
		img.src = '<?php echo $mainframe->getCfg( 'live_site' ) . "/components/com_jcomments/images/smiles/"; ?>' + type;
	} else {
		img.src = '<?php echo $mainframe->getCfg( 'live_site' ) . "/images/blank.png"; ?>';
	}
}
//-->
</script>
<div style="display: none;">
	<?php HTML_JComments::_smileItem( $lastSmileId, '', '', $lists['images']); ?>
</div>

<div id="jc">

<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_jcomments">
<input type="hidden" name="task" value="">

<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
<table class="adminheading">
	<tr>
		<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/smiles48x48.png" width="48" height="48" align="middle" alt="" />&nbsp;<?php echo JText::_('A_SMILES'); ?></th>
	</tr>
</table>
<?php
		}
?>

<table width="100%" border="0" cellpadding="4" cellspacing="2"
	class="adminform">
	<tr>
		<td>
		<div id="jc_smileContainer">
<?php
        if (is_array($lists['smiles'])) {
            $i = 1;
			foreach($lists['smiles'] as $code=>$image) {
				HTML_JComments::_smileItem( $i, $code, $image, $lists['images']);
				$i++;
			}
		}
?>
		</div>
		<br />
		<br />
		<input type="button" onclick="jc_addSmile()" name="addSmile" value="<?php echo JText::_('A_SMILES_ADD'); ?>" /></td>
	</tr>
</table>
</form>
</div>
<?php
	}

	function showAbout()
	{
		global $mainframe;

		include_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'installer.php');

		$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
?>
<script type="text/javascript">
<!--
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
<link rel="stylesheet" href="<?php echo $mainframe->getCfg('live_site'); ?>/administrator/components/com_jcomments/assets/style.css" type="text/css" />

<div id="jc">

<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">

<table width="95%" border="0" cellpadding="0" cellspacing="0" style="padding: 0; margin: 0;">
	<tr valign="top" align="left">
		<td width="50px"><img src="<?php echo $mainframe->getCfg( 'live_site' ); ?>/administrator/components/com_jcomments/assets/jcomments48x48.png" border="0" alt="JComments" /></td>
		<td><span class="componentname">JComments <?php echo $versionInfo->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $versionInfo->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-<?php echo date('Y'); ?> smart (<a href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br /></span></td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td><span class="installheader"><?php echo JText::_('AI_ABOUT_TESTERS'); ?></span>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
			<li>Joomlaportal.ru Team (<a href="http://joomlaportal.ru" target="_blank">Joomlaportal.ru</a>)</li>
			<li>MAMAHTEHOK, Dutch, OnTheFly, Mitrich, boston</li>
			<li>bzzik, beliyadm, Sulpher, Darkick, Garun, iT)ZevS(, PaLyCH, Yurii Smetana</li>
			<li>Warpc, Vzx, abbyevg, Taila, Aleks_El_Dia, doctorgrif, DWolf</li>
			<li>Covino Giuseppe, Helge Johnsen, Dan Partac, Selim Alamo Bocaz</li>
		</ul>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td><span class="installheader"><?php echo JText::_('AI_ABOUT_TRANSLATORS'); ?></span>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
            <li>Belorussian - Samsonau Siarhei, Dmitry Tsesluk</li>
            <li>Bulgarian - Ana Vasileva, Alexander Sidorov aka spiteful_troll, Georgi Gerov</li>
            <li>Catalan - Xavier Montana Carreras</li>
            <li>Croatian - Tomislav Kikic</li>
            <li>Czech - Ale&#353; Drnovsk&yacute;</li>
            <li>Danish - ot2sen, Martin Podolak</li>
            <li>Dutch - Aapje, Eleonora van Nieuwburg, Pieter Agten, Kaizer M. (Mirjam)</li>
            <li>English - Alexey Brin, 7th rider</li>
            <li>French - Saber, Jean-Marie Chauvel, Eric Lamy</li>
            <li>German - Denis Panschinski</li>
            <li>Greek - Lazaros Giannakidis</li>
            <li>Hungarian - J&oacute;zsef Tam&aacute;s Herczeg</li>
            <li>Italian - Marco a.k.a. Vamba, Giuse Covino</li>
            <li>Latvian - Igors Maslakovs, Igor Vetruk, Dmitrijs Rekuns</li>
            <li>Norwegian - Helge Johnsen</li>
            <li>Polish - Tomasz Zi&oacute;&#322;czy&#324;ski, Jamniq</li>
            <li>Portuguese - Paulo Izidoro, Pedro Jesus</li>
            <li>Portuguese-Brazilian - Daniel Gomes</li>
            <li>Romanian - zlideni, Dan Partac</li>
            <li>Serbian - Ivan Krkotic</li>
            <li>Slovak - Vladim&iacute;r Proch&aacute;zka</li>
            <li>Slovenian - Dorjano Baruca</li>
            <li>Spanish - Selim Alamo Bocaz</li>
            <li>Swedish - MulletMidget</li>
            <li>Thai - Thammatorn Kraikokit</li>
            <li>Turkish - Tolga Sanci</li>
            <li>Ukrainian - Denys Nosov, Yurii Smetana</li>
		</ul>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td><span class="installheader"><?php echo JText::_('AI_ABOUT_LOGO_DESIGN'); ?></span>
		</td>
	</tr>
	<tr valign="top" align="left">
		<td></td>
		<td>
		<ul style="padding: 0 0 0 20px; margin: 0;">
			<li>Dmitry Zuzin aka MrDenim</li>
		</ul>
		</td>
	</tr>
</table>

</div>
<div class="b">
<div class="b">
<div class="b"></div>
</div>
</div>
</div>
</div>
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_jcomments" />
	<input type="hidden" name="task" value="" />
</form>
<?php
	}

	function showWarning($message) 
	{
		if ( JCOMMENTS_JVERSION == '1.5' ) {
?>
	<span class="error hasTip" title="<?php echo JText::_('Warning');?>::<?php echo $message; ?>">
		<img src="./components/com_jcomments/assets/warning.png" alt="" border="" hspace="6" vspace="0" />
	</span>
<?php
        	} else {
?>
	<span onmouseover="return overlib('<?php echo $message; ?>');" onmouseout='return nd();' class="editlinktip">
		<img src="./components/com_jcomments/assets/warning.png" alt="" border="" hspace="6" vspace="0" />
	</span>
<?php
        	}
	}
}
?>