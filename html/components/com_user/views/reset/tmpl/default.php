<?php defined('_JEXEC') or die; ?>

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
<?php endif; ?>
<br/>
<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=requestreset' ); ?>" method="post" class="josForm form-validate">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
		<tr>
			<td colspan="2" height="40">
				<p><?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?></p>
			</td>
		</tr>
		<tr>
			<td height="40" align="right">
				<label for="email" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TEXT'); ?>"><?php echo JText::_('Email Address'); ?>:&nbsp;&nbsp;</label>
			</td>
			<td>
				<input id="email" name="email" type="text" class="required validate-email" />
			</td>
		</tr>
	</table>

	<span style="position:relative; left:373px;"><button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button></span>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<br/><span style="position:relative; padding-right:5px; bottom:2px;"><img src="images/stories/blue_arrow_back.png" /></span><a class="reg" href="index.php?option=com_content&view=category&layout=blog&id=7&Itemid=10">Back to Wiki page</a>