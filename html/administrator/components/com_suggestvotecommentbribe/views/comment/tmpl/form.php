<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Views
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');
$db = &JFactory::getDBO();
/*
$db->setQuery('select*from #__suggestvotecommentbribe');
$settings=$db->loadObjectlist();
$settings=$settings[0];
*/
$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
$settings = new stdClass();
$settings->URL 			= $params->get("URL","");
$settings->email 		= $params->get("email","");
$settings->pubk 		= $params->get("pubk","");
$settings->prvk 		= $params->get("prvk","");
$settings->max_title 	= $params->get("max_title","");
$settings->max_desc 	= $params->get("max_desc","");

JHTML::_('behavior.tooltip');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>
<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><label for="name"> <?php echo JText::_( 'Suggestion' ); ?>:
		</label></td>
		<td colspan="2"><a
			href="index.php?option=com_suggestvotecommentbribe&controller=sugg&task=edit&cid[]=<?php echo $this->item->SID; ?>"><?php echo $this->item->Sname; ?></a>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="name"> <?php echo JText::_( 'Title' ); ?>:
		</label></td>
		<td colspan="2"><input class="text_area" type="text" name="title"
			id="title" size="32" maxlength="255"
			value="<?php  $this->item->title=str_replace('"', "&quot;",$this->item->title);$this->item->title=str_replace('&nbsp;', " ",$this->item->title); $this->item->title=htmlspecialchars_decode($this->item->title,ENT_NOQUOTES); echo $this->item->title;?>" />
		<br>
		<?php echo JText::_( 'MAX_TITLE_LENGTH' ); ?>: <?php echo $settings->max_title ?></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Published' ); ?>:
		</td>
		<td colspan="2"><?php echo $this->lists['published']; ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="adminform"><legend><?php echo JText::_( 'Description' ); ?></legend>
<table class="admintable">
	<tr>
		<td valign="top" colspan="3"><textarea name="description" cols="70"
			rows=10><?php if($_GET['ses'])
			{
				echo $_SESSION[$_GET['ses']];
			}
			else
			{
				$this->item->description=str_replace("<br />","",$this->item->description);
				$this->item->description=str_replace("&nbsp;"," ",$this->item->description);
				$this->item->description=htmlspecialchars_decode($this->item->description,ENT_NOQUOTES);
				echo $this->item->description;
			}?></textarea>
		<br>
		<?php echo JText::_( 'MAX_DESCRIPTION_LENGTH' ); ?>: <?php echo $settings->max_desc ?></td>
	</tr>
</table>
</fieldset>
<fieldset><?php
if($this->item->id==0&&$settings->captcha&&$user->id<1)
{
	require_once(JPATH_ROOT.'/components/com_suggestvotecommentbribe/recaptchalib.php');
	echo recaptcha_get_html($settings->pubk);
}
?></fieldset>
<?php if(!$this->item->SID)
{
	$this->item->SID=$SID;
}
?> <?php
if($this->item->id)
{
	$user =& JFactory::getUser($this->item->UID);
}
else
{
	$user =& JFactory::getUser();
}
?> <input type="hidden" name="SID" value="<?php echo $this->item->SID;?>" />
<input type="hidden" name="UID" value="<?php echo $this->item->UID;?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="option" value="com_suggestvotecommentbribe" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="comment" /></form>
<table width="100%">
	<tr>
		<td valign="middle" align="center"><?php JText::_('DONATE')?>
		<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="bursar@Interpreneurial.com">
		<input type="hidden" name="item_name" value="com_suggestvotecommentbribe donation">
		<input type="hidden" name="currency_code" value="USD">
		<input type="image" style='border: 0;' src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		</form>
		</td>
	</tr>
</table>
