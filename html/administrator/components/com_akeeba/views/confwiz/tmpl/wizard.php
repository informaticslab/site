<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 303 2010-11-17 12:24:26Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

?>
<!-- jQuery & jQuery UI detection. Also shows a big, fat warning if they're missing -->
<div id="nojquerywarning" style="margin: 1em; padding: 1em; background: #ffff00; border: thick solid red; color: black; font-size: 14pt;">
	<h1 style="margin: 1em 0; color: red; font-size: 22pt;">ERROR</h1>
	<p>jQuery and/or jQuery UI have not been loaded. This usually means that you have to change the permissions
	of media/com_akeeba and <u>all of its contents</u> to a least 0644. Alternatively, click on
	&quot;Parameters&quot; and set the source for both of them to &quot;Google AJAX API&quot;.</p>
	<p>If you do not do that, the component <strong><u>will not work</u></strong>.</p>
</div>
<script type="text/javascript">
	if(typeof akeeba.jQuery == 'function')
	{
		if(typeof akeeba.jQuery.ui == 'object')
		{
			akeeba.jQuery('#nojquerywarning').css('display','none');
			akeeba.jQuery('#notfixedperms').css('display','none');
		}
	}
</script>

<div id="backup-progress-pane" class="ui-widget" style="display: none">
	<div class="ui-state-highlight" style="padding: 0.3em; margin: 0.3em 0.2em; font-weight: bold;">
			<span class="ui-icon ui-icon-notice" style="float: left;"></span>
			<?php echo JText::_('AKEEBA_WIZARD_INTROTEXT'); ?>
	</div>
	<div id="backup-progress-header" class="ui-corner-tl ui-corner-tr ui-widget-header">
		<?php echo JText::_('AKEEEBA_WIZARD_PROGRESS') ?>
	</div>
	<div id="backup-progress-content" class="ui-corner-bl ui-corner-br ui-widget-content">
		<div id="backup-steps" class="ui-corner-all">
			<div id="step-ajax" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_AJAX'); ?></div>
			<div id="step-minexec" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_MINEXEC'); ?></div>
			<div id="step-directory" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_DIRECTORY'); ?></div>
			<div id="step-dbopt" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_DBOPT'); ?></div>
			<div id="step-maxexec" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_MAXEXEC'); ?></div>
			<div id="step-splitsize" class="step-pending"><?php echo JText::_('AKEEBA_CONFWIZ_SPLITSIZE'); ?></div>
		</div>
		<div id="backup-status" class="ui-corner-all">
			<div id="backup-substep"></div>
		</div>
		<div id="response-timer" class="ui-corner-all">
			<div class="color-overlay" style="display: none"></div>
			<div class="text"></div>
		</div>
	</div>
	<span id="ajax-worker"></span>
</div>

<div id="error-panel" class="ui-widget" style="display:none">
	<h1 class="ui-widget-header ui-state-error">
		<?php echo JText::_('AKEEBA_WIZARD_HEADER_FAILED'); ?>
	</h1>
	<div id="errorframe" class="ui-widget-content">
		<p id="backup-error-message" class="ui-state-error ui-corner-tl ui-corner-tr">
		</p>
	</div>
</div>

<div id="backup-complete" class="ui-widget" style="display: none">
	<h1 class="ui-widget-header">
		<?php echo JText::_('AKEEBA_WIZARD_HEADER_FINISHED'); ?>
	</h1>
	<div id="finishedframe" class="ui-widget-content">
		<div style="min-height: 32px">
			<div class="ak-icon ak-icon-ok" style="float: left; margin: 0 1em 0 0 !important;"></div>
			<p>
				<?php echo JText::_('AKEEBA_WIZARD_CONGRATS') ?>
			</p>
		</div>

		<a href="<?php echo JURI::base() ?>index.php?option=com_akeeba&view=backup" class="akbutton ui-state-default ui-corner-all">
			<div class="ak-icon ak-icon-backup" style="margin: 0 1em 0 0 !important"></div>
			<div class="text">
				<?php echo JText::_('BACKUP'); ?>
			</div>
		</a>
		<a href="<?php echo JURI::base() ?>index.php?option=com_akeeba&view=config" class="akbutton ui-state-default ui-corner-all">
			<div class="ak-icon ak-icon-configuration" style="margin: 0 1em 0 0 !important"></div>
			<div class="text">
				<?php echo JText::_('CONFIGURATION'); ?>
			</div>
		</a>
	</div>
</div>

<script type="text/javascript">
akeeba_ajax_url = 'index.php?option=com_akeeba&view=confwiz&task=ajax&format=raw';
<?php
	$keys = array('tryajax','tryiframe','cantuseajax','minexectry','cantsaveminexec','saveminexec','cantdetermineminexec',
		'cantfixdirectories','cantdbopt','exectoolow','savingmaxexec','cantsavemaxexec','cantdeterminepartsize','partsize');
	foreach($keys as $key):
?>
akeeba_translations['UI-<?php echo strtoupper($key)?>']="<?php echo JText::_('AKEEBA_WIZARD_UI_'.strtoupper($key)) ?>";
<?php endforeach; ?>
akeeba_confwiz_boot();
</script>