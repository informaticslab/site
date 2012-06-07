<?php
// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

class jtt_tpl_report_form extends JoomlaTuneTemplate
{
	function render() 
	{
?>
<h4><?php echo JText::_('Report to administrator'); ?></h4>
<form id="comments-report-form" name="comments-report-form" action="javascript:void(null);">
<?php
		if ($this->getVar('isGuest', 1) == 1) {
?>
<p>
	<input id="comments-report-form-name" type="text" name="name" value="" maxlength="255" size="22" />
	<label for="comments-report-form-name"><?php echo JText::_('Name'); ?></label>
</p>
<?php
		}
?>
<p>
	<input id="comments-report-form-reason" type="text" name="reason" value="" maxlength="255" size="22" />
	<label for="comments-report-form-reason"><?php echo JText::_('Reason'); ?></label>
</p>
<div id="comments-report-form-buttons">
	<div class="btn"><div><a href="#" onclick="jcomments.saveReport();return false;" title="<?php echo JText::_('Submit'); ?>"><?php echo JText::_('Submit'); ?></a></div></div>
	<div class="btn"><div><a href="#" onclick="jcomments.cancelReport();return false;" title="<?php echo JText::_('Cancel'); ?>"><?php echo JText::_('Cancel'); ?></a></div></div>
	<div style="clear:both;"></div>
</div>
<input type="hidden" name="commentid" value="<?php echo $this->getVar('comment-id'); ?>" />
</form>
<?php
	}
}
?>