<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: default.php 201 2010-08-01 21:04:43Z nikosdion $
 * @since 1.3
 */

defined('_JEXEC') or die('Restricted access');
?>

<div id="dialog" title="<?php echo JText::_('FSFILTER_ERROR_TITLE') ?>">
</div>

<div class="activeprofile2 ui-widget-header ui-corner-all">
		<p>
			<?php echo JText::_('CPANEL_PROFILE_TITLE'); ?>: #<?php echo $this->profileid; ?>
			<?php echo $this->profilename; ?>
		</p>
</div>
<div style="clear:both;"></div>

<div id="ak_top_container" class="ui-corner-tl ui-corner-tr ui-widget-header">
	<div id="ak_roots_container">
		<span><?php echo JText::_('FSFILTER_LABEL_ROOTDIR') ?></span>
		<span><?php echo $this->root_select; ?></span>
	</div>
	<div id="ak_crumbs_container">
		<div id="ak_crumbs_label"><?php echo JText::_('FSFILTER_LABEL_CURDIR'); ?></div>
		<div id="ak_crumbs"></div>
	</div>
	<div>
		<p>
			<span onclick="fsfilter_nuke();" class="actionbutton ui-state-default">
				<?php echo JText::_('FSFILTER_LABEL_NUKEFILTERS'); ?>
			</span>
		</p>
	</div>
</div>
<div id="ak_main_container" class="ui-corner-bl ui-corner-br ui-widget-content">
	<div id="ak_folder_container">
		<div id="ak_folder_header" class="ui-widget-header ui-corner-tl ui-corner-tr">
			<div class="ui-icon ui-icon-folder-collapsed" style="float:left; margin-left: 3px;"></div>
			<?php echo JText::_('FSFILTER_LABEL_DIRS'); ?>
		</div>
		<div id="folders" class="ui-widget-content ui-corner-bl ui-corner-br"></div>
	</div>
	<div id="ak_files_container">
		<div id="ak_files_header" class="ui-widget-header ui-corner-tl ui-corner-tr">
			<div class="ui-icon ui-icon-document" style="float:left; margin-left: 3px;"></div>
			<?php echo JText::_('FSFILTER_LABEL_FILES'); ?>
		</div>
		<div id="files" class="ui-widget-content ui-corner-bl ui-corner-br"></div>
	</div>
	<div id="ak_clr"></div>
</div>

<script type="text/javascript">
/**
 * Callback function for changing the active root in Filesystem Filters
 */
function akeeba_active_root_changed()
{
	(function($){
		var data = new Object;
		data.root = $('#active_root').val();
		data.crumbs = new Array();
		data.node = '';
		fsfilter_load(data);
	})(akeeba.jQuery);
}

akeeba.jQuery(document).ready(function($){
	// Set the AJAX proxy URL
	akeeba_ajax_url = '<?php echo AkeebaHelperEscape::escapeJS('index.php?option=com_akeeba&view=fsfilter&format=raw&task=ajax') ?>';
	// Set the media root
	akeeba_ui_theme_root = '<?php echo $this->mediadir ?>';
	// Create the dialog
	$("#dialog").dialog({
		autoOpen: false,
		closeOnEscape: false,
		height: 200,
		width: 300,
		hide: 'slide',
		modal: true,
		position: 'center',
		show: 'slide'
	});
	// Create an AJAX error trap
	akeeba_error_callback = function( message ) {
		var dialog_element = $("#dialog");
		dialog_element.html(''); // Clear the dialog's contents
		dialog_element.dialog('option', 'title', '<?php echo AkeebaHelperEscape::escapeJS(JText::_('CONFIG_UI_AJAXERRORDLG_TITLE')) ?>');
		$(document.createElement('p')).html('<?php echo AkeebaHelperEscape::escapeJS(JText::_('CONFIG_UI_AJAXERRORDLG_TEXT')) ?>').appendTo(dialog_element);
		$(document.createElement('pre')).html( message ).appendTo(dialog_element);
		dialog_element.dialog('open');
	};
	// Push translations
	akeeba_translations['UI-ROOT'] = '<?php echo AkeebaHelperEscape::escapeJS(JText::_('FILTERS_LABEL_UIROOT')) ?>';
	akeeba_translations['UI-ERROR-FILTER'] = '<?php echo AkeebaHelperEscape::escapeJS(JText::_('FILTERS_LABEL_UIERRORFILTER')) ?>';
<?php
	$filters = array('directories', 'skipfiles', 'skipdirs', 'files');
	foreach($filters as $type)
	{
		echo "\takeeba_translations['UI-FILTERTYPE-".strtoupper($type)."'] = '".
			AkeebaHelperEscape::escapeJS(JText::_('FSFILTER_TYPE_'.strtoupper($type))).
			"';\n";
	}
?>
	// Bootstrap the page display
	var data = JSON.parse('<?php echo AkeebaHelperEscape::escapeJS($this->json,"'"); ?>');
	fsfilter_render(data);
});
</script>