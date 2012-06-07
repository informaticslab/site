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
$db->setQuery('select*from #__suggestvotecommentbribe');
$settings=$db->loadObjectlist();
$settings=$settings[0];
$user =& JFactory::getUser();
$SID=JRequest::get();
if(empty($SID['SID']))
$SID=$this->item->SID;
else $SID=$SID['SID'];
JHTML::_('behavior.tooltip');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform"><legend><?php echo JText::_( 'clickvote' ); ?></legend>
</fieldset>
<fieldset><?php
if($this->item->id==0&&$settings->captcha&&$user->id<1)
{
	require_once(JPATH_ROOT.'/components/com_suggestvotecommentbribe/recaptchalib.php');
	echo recaptcha_get_html($settings->pubk);
}
?></fieldset>

<input type="submit" value="<?php echo JText::_("VOTEBUTTONTEXT");?>">
<input type="hidden" name="value" value="1" />
<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="option" value="com_suggestvotecommentbribe" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="SID" value="<?php echo $SID;?>" />
<input type="hidden" name="controller" value="vote" />
<input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
</form>
