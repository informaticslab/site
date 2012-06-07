<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<?php
	if(isset($this->message)){
		$this->display('message');
	}
?>


<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php endif; ?>
<br/>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
	<td width="19%" height="40" align="right">
		<label id="namemsg" for="name">
			<?php echo JText::_( 'Name' ); ?>:&nbsp;&nbsp;
		</label>
	</td>
  	<td>
  		<input type="text" name="name" id="name" size="40" value="<?php echo $this->escape($this->user->get( 'name' ));?>" class="inputbox required" maxlength="50" /> <span style="color:#ad0707">*</span>
  	</td>
</tr>
<tr>
	<td height="40" align="right">
		<label id="usernamemsg" for="username">
			<?php echo JText::_( 'User name' ); ?>:&nbsp;&nbsp;
		</label>
	</td>
	<td>
		<input type="text" id="username" name="username" size="40" value="<?php echo $this->escape($this->user->get( 'username' ));?>" class="inputbox required validate-username" maxlength="25" /> <span style="color:#ad0707">*</span>
	</td>
</tr>
<tr>
	<td height="40" align="right">
		<label id="emailmsg" for="email">
			<?php echo JText::_( 'Email' ); ?>:&nbsp;&nbsp;
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="40" value="<?php echo $this->escape($this->user->get( 'email' ));?>" class="inputbox required validate-email" maxlength="100" /> <span style="color:#ad0707">*</span>
	</td>
</tr>
<tr>
	<td height="40" align="right">
		<label id="pwmsg" for="password">
			<?php echo JText::_( 'Password' ); ?>:&nbsp;&nbsp;
		</label>
	</td>
  	<td>
  		<input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> <span style="color:#ad0707">*</span>&nbsp;&nbsp;<span style="font-size:10px; color:gray;">(Password must be at least 4 characters.)</span>
  	</td>
</tr>
<tr>
	<td height="40" align="right">
		<label id="pw2msg" for="password2">
			<?php echo JText::_( 'Verify Password' ); ?>:&nbsp;&nbsp;
		</label>
	</td>
	<td>
		<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> <span style="color:#ad0707">*</span>
	</td>
</tr>
<tr>
	<td colspan="2" height="40"><span style="color:#ad0707; font-size:10px;">
		<?php echo JText::_( 'REGISTER_REQUIRED' ); ?>
	</td></span>
</tr>
</table>
	<span style="position:relative; right:177px; bottom:10px;"><button class="button validate" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo JText::_('Register'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></span>
	<input type="hidden" name="task" value="register_save" />
	<input type="hidden" name="id" value="0" />
	<input type="hidden" name="gid" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<br/><br/><br/><br/>


<div class="notes"><img src="images/stories/green_arrow.png"/>&nbsp;If your registration was successful, you will be redirected to the <span style="font-weight:bold; color:green;">Wiki</span> page. You may then log in.
<br/><br/><img src="images/stories/red_arrow_bullet.png"/>&nbsp;If you are <span style="font-weight:bold; color:#ad0707;">NOT</span> redirected, your registration was not successful. Please see the <span style="font-weight:bold; color:#ad0707;">red</span> fields and try again.</div>

