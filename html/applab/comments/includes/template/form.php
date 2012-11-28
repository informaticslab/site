<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/
?>

<?php if (!defined("IN_COMMENTICS")) { die("Access Denied."); } ?>

<script type="text/javascript">
// <![CDATA[
function addTags(Tag,fTag,Comment) {

  var frm = document.forms['commentics'];
  
  //remember cursor position
  var scrollTop = frm.cmtx_comment.scrollTop;
  var scrollLeft = frm.cmtx_comment.scrollLeft;
  
  var obj = document.commentics.cmtx_comment;

  obj.focus();

  if (document.selection && document.selection.createRange)  // Internet Explorer
  {
sel = document.selection.createRange();
if (sel.parentElement() == obj)  sel.text = Tag + sel.text + fTag;
  }

  else if (typeof(obj) != "undefined")  // Firefox
  {
var longueur = parseInt(obj.value.length);
var selStart = obj.selectionStart;
var selEnd = obj.selectionEnd;

obj.value = obj.value.substring(0,selStart) + Tag + obj.value.substring(selStart,selEnd) + fTag + obj.value.substring(selEnd,longueur);
  }

  else obj.value += Tag + fTag;
  
  textCounter(frm.cmtx_comment,frm.cmtx_count,<?php echo $settings->comment_maximum_characters;?>);
  
  //set cursor position
  frm.cmtx_comment.scrollTop = scrollTop;
  frm.cmtx_comment.scrollLeft = scrollLeft;

  frm.cmtx_comment.focus();
  
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function textCounter(field, cntfield, maxlimit) {
<?php if ($settings->enabled_counter) { ?>
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else
cntfield.value = maxlimit - field.value.length;
<?php } ?>
}
// ]]>
</script>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_url) { ?>
<script type="text/javascript">
// <![CDATA[
function enterLink() {

var link = prompt("<?php echo CMTX_PROMPT_ENTER_LINK ?>","http://");

if (link != null && link != "" && link != "http://") {
	
	var text = prompt("<?php echo CMTX_PROMPT_ENTER_LINK_TITLE ?>","");
	
	if (text != null && text != "") {
		var tag = "[LINK=" + link + "]" + text + "[/LINK]";
		addTags('',tag)
	} else {
		var tag = "[LINK]" + link + "[/LINK]";
		addTags('',tag)
	}
	
}
}
// ]]>
</script>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_email) { ?>
<script type="text/javascript">
// <![CDATA[
function enterEmail() {

var email = prompt("<?php echo CMTX_PROMPT_ENTER_EMAIL ?>","");

if (email != null && email != "") {
	
	var text = prompt("<?php echo CMTX_PROMPT_ENTER_EMAIL_TITLE ?>","");
	
	if (text != null && text != "") {
		var tag = "[EMAIL=" + email + "]" + text + "[/EMAIL]";
		addTags('',tag)
	} else {
		var tag = "[EMAIL]" + email + "[/EMAIL]";
		addTags('',tag)
	}
	
}
}
// ]]>
</script>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_image) { ?>
<script type="text/javascript">
// <![CDATA[
function enterImage() {

var image = prompt("<?php echo CMTX_PROMPT_ENTER_IMAGE ?>","http://");

if (image != null && image != "" && image != "http://") {
	var tag = "[IMG]" + image + "[/IMG]";
	addTags('',tag)
}

}
// ]]>
</script>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_video) { ?>
<script type="text/javascript">
// <![CDATA[
function enterVideo() {

var video = prompt("<?php echo CMTX_PROMPT_ENTER_VIDEO ?>","http://");

if (video != null && video != "" && video != "http://") {
	var tag = "[VIDEO]" + video + "[/VIDEO]";
	addTags('',tag)
}

}
// ]]>
</script>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_list_bullet) { ?>
<script type="text/javascript">
// <![CDATA[
function enterBullet() {

var item = prompt("<?php echo CMTX_PROMPT_ENTER_BULLET ?>","");

if (item != null && item != "") {

	var tag = "[BULLET]\r\n";
	
	tag = tag + "[ITEM]" + item + "[/ITEM]\r\n";
	
	while (item != null && item != "") {
	
		var item = prompt("<?php echo CMTX_PROMPT_ENTER_ANOTHER_BULLET ?>","");
		
		if (item != null && item != "") {
			tag = tag + "[ITEM]" + item + "[/ITEM]\r\n";
		}
		
	}
	
	tag = tag + "[/BULLET]";
	
	addTags('',tag)
}

}
// ]]>
</script>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_bb_code_list_numeric) { ?>
<script type="text/javascript">
// <![CDATA[
function enterNumeric() {

var item = prompt("<?php echo CMTX_PROMPT_ENTER_NUMERIC ?>","");

if (item != null && item != "") {

	var tag = "[NUMERIC]\r\n";
	
	tag = tag + "[ITEM]" + item + "[/ITEM]\r\n";
	
	while (item != null && item != "") {
	
		var item = prompt("<?php echo CMTX_PROMPT_ENTER_ANOTHER_NUMERIC ?>","");
		
		if (item != null && item != "") {
			tag = tag + "[ITEM]" + item + "[/ITEM]\r\n";
		}
		
	}
	
	tag = tag + "[/NUMERIC]";
	
	addTags('',tag)
}

}
// ]]>
</script>
<?php } ?>

<script type="text/javascript">
// <![CDATA[
function enableSubmit() {

var frm = document.forms['commentics'];

<?php if ($settings->enabled_terms && !$settings->enabled_privacy) { ?>
if (frm.cmtx_terms.checked) {
frm.cmtx_submit.disabled = false
} else {
frm.cmtx_submit.disabled = true
}
<?php } else if (!$settings->enabled_terms && $settings->enabled_privacy) { ?>
if (frm.cmtx_privacy.checked) {
frm.cmtx_submit.disabled = false
} else {
frm.cmtx_submit.disabled = true
}
<?php } else if ($settings->enabled_terms && $settings->enabled_privacy) { ?>
if ( (frm.cmtx_terms.checked) && (frm.cmtx_privacy.checked) ) {
frm.cmtx_submit.disabled = false
} else {
frm.cmtx_submit.disabled = true
}
<?php } ?>
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function enablePreview() {

var frm = document.forms['commentics'];

<?php if ($settings->enabled_preview && $settings->agree_to_preview) { ?>

<?php if ($settings->enabled_terms && !$settings->enabled_privacy) { ?>
if (frm.cmtx_terms.checked) {
frm.cmtx_preview.disabled = false;
} else {
frm.cmtx_preview.disabled = true;
}
<?php } else if (!$settings->enabled_terms && $settings->enabled_privacy) { ?>
if (frm.cmtx_privacy.checked) {
frm.cmtx_preview.disabled = false;
} else {
frm.cmtx_preview.disabled = true;
}
<?php } else if ($settings->enabled_terms && $settings->enabled_privacy) { ?>
if ( (frm.cmtx_terms.checked) && (frm.cmtx_privacy.checked) ) {
frm.cmtx_preview.disabled = false;
} else {
frm.cmtx_preview.disabled = true;
}
<?php } ?>

<?php } ?>
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function disableEnterKey(e) {
var key;     
if (window.event) {
	key = window.event.keyCode; //IE
} else {
	key = e.which; //Firefox
}
return (key != 13);
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function processPreview() {

var frm = document.forms['commentics'];

frm.cmtx_submit.disabled = true;
frm.cmtx_submit.value = "<?php echo CMTX_PROCESSING_BUTTON ?>";

frm.cmtx_preview.disabled = true;
frm.cmtx_preview.value = "<?php echo CMTX_PROCESSING_BUTTON ?>";

frm.cmtx_sub_def.name = 'cmtx_sub';
frm.cmtx_prev_def.name = 'cmtx_prev';

document.commentics.submit();

return true;
}
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[
function processSubmit() {

var frm = document.forms['commentics'];

frm.cmtx_submit.disabled = true;
frm.cmtx_submit.value = "<?php echo CMTX_PROCESSING_BUTTON ?>";

<?php if ($settings->enabled_preview) { ?>
frm.cmtx_preview.disabled = true;
frm.cmtx_preview.value = "<?php echo CMTX_PROCESSING_BUTTON ?>";
<?php } ?>

frm.cmtx_sub_def.name = 'cmtx_sub';

document.commentics.submit();

return true;
}
// ]]>
</script>

<div class="height_above_form_heading"></div>

<h3 class="form_heading">
<a id="<?php echo str_ireplace("#", "", CMTX_ANCHOR_FORM); ?>" name="<?php echo str_ireplace("#", "", CMTX_ANCHOR_FORM); ?>">
<?php echo CMTX_FORM_HEADING; ?>
</a>
</h3>

<div class="height_below_form_heading"></div>

<?php
if (!cmtx_is_form_enabled(true)) { //if form is disabled
	return; //exit file
}
?>

<?php
if (isset($box) && !empty($box)) { //if a box exists
	echo $box . "<br />"; //display box
}
?>

<form name="commentics" id="commentics" class="form_styling" action="<?php echo htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . cmtx_get_query("form") . CMTX_ANCHOR_FORM; ?>" method="post">

<noscript>
<?php if ($settings->display_javascript_disabled) { ?>
<div class="javascript_disabled_message">
<?php echo CMTX_JAVASCRIPT_DISABLED ?>
</div>
<?php } ?>
</noscript>

<?php if ($settings->show_reply) { ?>
<div id="hide_reply" style="display:none">
<?php if (!isset($reply_id)) { $reply_id = 0; } ?>
<?php if (!isset($reply_message)) { $reply_message = ""; } ?>
<input type="hidden" name="cmtx_reply_id" id="cmtx_reply_id" value="<?php echo $reply_id; ?>"/>
<div class="reply_bar">
<span id="reply_message"><?php echo $reply_message; ?></span>
<a id="reset_reply" href="<?php echo CMTX_ANCHOR_RESET; ?>" onclick='this.style.display="none"; document.getElementById("cmtx_reply_id").value="0"; document.getElementById("reply_message").innerHTML="<?php echo CMTX_REPLY_NOBODY ?>";'><?php echo CMTX_REPLY_CANCEL ?></a>
</div>
<div style="clear: left;"></div>
<div class="height_below_reply_bar"></div>
</div>
<?php } ?>

<?php if ($settings->display_required_symbol_message && $settings->display_required_symbol) {
?><span class="required_symbol_message"><?php echo CMTX_REQUIRED_SYMBOL_MESSAGE ?></span>
<div class="height_below_required_symbol_message"></div>
<?php } ?>

<?php //get the security key and add to form as hidden input ?>
<input type="hidden" name="cmtx_security_key" value="<?php echo $settings->security_key; ?>"/>

<?php //these are hidden fields that are used as a workaround for preventing double submissions ?>
<input type="hidden" name="cmtx_sub_def" value=""/>
<input type="hidden" name="cmtx_prev_def" value=""/>

<?php
$elements = explode(",", $settings->sort_order_fields);
foreach ($elements as $element) {
	switch ($element) {
		case "1":
		cmtx_output_name();
		break;
		case "2":
		cmtx_output_email();
		break;
		case "3":
		cmtx_output_website();
		break;
		case "4":
		cmtx_output_town();
		break;
		case "5":
		cmtx_output_country();
		break;
		case "6":
		cmtx_output_rating();
		break;
	}
}
?>

<?php function cmtx_output_name () { ?>
<?php global $settings, $default_name; ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_NAME ?>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<input type="text" name="cmtx_name" title="<?php echo CMTX_TITLE_NAME; ?>" size="<?php echo $settings->field_size_name; ?>" maxlength="<?php echo $settings->field_maximum_name; ?>" value="<?php echo $default_name; ?>" onkeypress="return disableEnterKey(event)"/>
<?php } ?>

<?php function cmtx_output_email () { ?>
<?php global $settings, $default_email; ?>
<?php if ($settings->enabled_email) { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_EMAIL ?>
<?php if ($settings->required_email && $settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<input type="text" name="cmtx_email" title="<?php echo CMTX_TITLE_EMAIL; ?>" size="<?php echo $settings->field_size_email; ?>" maxlength="<?php echo $settings->field_maximum_email; ?>" value="<?php echo $default_email; ?>" onkeypress="return disableEnterKey(event)"/>
<?php if ($settings->display_email_note) { ?> <span class="email_note"><?php echo CMTX_NOTE_EMAIL ?></span> <?php } ?>
<?php } } ?>

<?php function cmtx_output_website () { ?>
<?php global $settings, $default_website; ?>
<?php if ($settings->enabled_website) { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_WEBSITE ?>
<?php if ($settings->required_website && $settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<input type="text" name="cmtx_website" title="<?php echo CMTX_TITLE_WEBSITE; ?>" size="<?php echo $settings->field_size_website; ?>" maxlength="<?php echo $settings->field_maximum_website; ?>" value="<?php echo $default_website; ?>" onkeypress="return disableEnterKey(event)"/>
<?php } } ?>

<?php function cmtx_output_town () { ?>
<?php global $settings, $default_town; ?>
<?php if ($settings->enabled_town) { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_TOWN ?>
<?php if ($settings->required_town && $settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<input type="text" name="cmtx_town" title="<?php echo CMTX_TITLE_TOWN; ?>" size="<?php echo $settings->field_size_town; ?>" maxlength="<?php echo $settings->field_maximum_town; ?>" value="<?php echo $default_town; ?>" onkeypress="return disableEnterKey(event)"/>
<?php } } ?>

<?php function cmtx_output_country () { ?>
<?php global $settings, $default_country, $path_to_comments_folder, $error; ?>
<?php if ($settings->enabled_country) { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_COUNTRY ?>
<?php if ($settings->required_country && $settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<?php
require $path_to_comments_folder . "includes/template/countries.php";
if ( (isset($_POST['cmtx_country'])) && ( ($error) || (isset($_POST['cmtx_preview'])) || (isset($_POST['cmtx_prev'])) ) ) {
	if ($_POST['cmtx_country'] != "blank") {
		$countries = str_ireplace("'".$_POST['cmtx_country']."'", "'".$_POST['cmtx_country']."' selected = 'selected'", $countries);
	}
} else {
	if (!empty($default_country)) {
		$countries = str_ireplace("'".$default_country."'", "'".$default_country."' selected = 'selected'", $countries);
	}
}

echo $countries;
?>
<?php } } ?>

<?php function cmtx_output_rating () { ?>
<?php global $settings, $default_rating, $path_to_comments_folder, $error, $mysql_table_prefix, $page_id; ?>
<?php if ($settings->enabled_rating) { ?>
<?php if ($settings->repeat_ratings == "hide" && cmtx_has_rated()) {} else { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_RATING ?>
<?php if ($settings->required_rating && $settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<?php
require $path_to_comments_folder . "includes/template/ratings.php";
if ($settings->repeat_ratings == "disable" && cmtx_has_rated()) {
	$ratings = str_ireplace("name='cmtx_rating'", "name='cmtx_rating' disabled='disabled'", $ratings);
}
if ( (isset($_POST['cmtx_rating'])) && ( ($error) || (isset($_POST['cmtx_preview'])) || (isset($_POST['cmtx_prev'])) ) ) {
	if ($_POST['cmtx_rating'] != "blank") {
		$ratings = str_ireplace("'".$_POST['cmtx_rating']."'","'".$_POST['cmtx_rating']."' selected = 'selected'",$ratings);
	}
} else {
	if (!empty($default_rating)) {
		$ratings = str_ireplace("'".$default_rating."'", "'".$default_rating."' selected = 'selected'", $ratings);
	}
}
echo $ratings;
?>
<?php } } } ?>

<?php if ($settings->enabled_bb_code || $settings->enabled_smilies) { ?>
<div class="height_above_bb_and_smilies"></div>
<?php } else { ?>
<div class="height_between_fields"></div>
<?php } ?>
<?php if ($settings->enabled_bb_code) { ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<?php if ($settings->enabled_bb_code_bold) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/bold.png";?>" title="Bold" alt="Bold" class="bb_code_image" onmousedown="addTags('[B]','[/B]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_italic) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/italic.png";?>" title="Italic" alt="Italic" class="bb_code_image" onmousedown="addTags('[I]','[/I]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_underline) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/underline.png";?>" title="Underline" alt="Underline" class="bb_code_image" onmousedown="addTags('[U]','[/U]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_strike) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/strike.png";?>" title="Strike" alt="Strike" class="bb_code_image" onmousedown="addTags('[STRIKE]','[/STRIKE]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_superscript) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/superscript.png";?>" title="Superscript" alt="Superscript" class="bb_code_image" onmousedown="addTags('[SUP]','[/SUP]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_subscript) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/subscript.png";?>" title="Subscript" alt="Subscript" class="bb_code_image" onmousedown="addTags('[SUB]','[/SUB]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_code) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/code.png";?>" title="Code" alt="Code" class="bb_code_image" onmousedown="addTags('[CODE]','[/CODE]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_php_code) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/php_code.png";?>" title="PHP Code" alt="PHP Code" class="bb_code_image" onmousedown="addTags('[PHP]','[/PHP]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_quote) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/quote.png";?>" title="Quote" alt="Quote" class="bb_code_image" onmousedown="addTags('[QUOTE]','[/QUOTE]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_line) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/line.png";?>" title="Insert line" alt="Insert line" class="bb_code_image" onmousedown="addTags('','[LINE]')"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_list_bullet) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/list_bullet.png";?>" title="Insert bullet list" alt="Bullet list" class="bb_code_image" onmousedown="enterBullet()"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_list_numeric) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/list_numeric.png";?>" title="Insert numeric list" alt="Numeric list" class="bb_code_image" onmousedown="enterNumeric()"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_url) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/link.png";?>" title="Insert web link" alt="Link" class="bb_code_image" onmousedown="enterLink()"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_email) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/email.png";?>" title="Insert email link" alt="Email" class="bb_code_image" onmousedown="enterEmail()"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_image) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/image.png";?>" title="Insert image" alt="Image" class="bb_code_image" onmousedown="enterImage()"/>
<?php } ?>
<?php if ($settings->enabled_bb_code_video) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/bb_code/video.png";?>" title="Insert video" alt="Video" class="bb_code_image" onmousedown="enterVideo()"/>
<?php } ?>
<?php } ?>

<?php if ($settings->enabled_bb_code && $settings->enabled_smilies) { ?>
<div class="height_between_bb_and_smilies"></div>
<?php } ?>

<?php if ($settings->enabled_smilies) { ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<?php if ($settings->enabled_smilies_smile) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/smile.gif";?>" title="Smile" alt="Smile" class="smiley_image" onmousedown="addTags('',':smile:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_sad) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/sad.gif";?>" title="Sad" alt="Sad" class="smiley_image" onmousedown="addTags('',':sad:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_huh) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/huh.gif";?>" title="Huh" alt="Huh" class="smiley_image" onmousedown="addTags('',':huh:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_laugh) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/laugh.gif";?>" title="Laugh" alt="Laugh" class="smiley_image" onmousedown="addTags('',':laugh:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_mad) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/mad.gif";?>" title="Mad" alt="Mad" class="smiley_image" onmousedown="addTags('',':mad:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_tongue) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/tongue.gif";?>" title="Tongue" alt="Tongue" class="smiley_image" onmousedown="addTags('',':tongue:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_crying) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/crying.gif";?>" title="Crying" alt="Crying" class="smiley_image" onmousedown="addTags('',':crying:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_grin) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/grin.gif";?>" title="Grin" alt="Grin" class="smiley_image" onmousedown="addTags('',':grin:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_wink) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/wink.gif";?>" title="Wink" alt="Wink" class="smiley_image" onmousedown="addTags('',':wink:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_scared) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/scared.gif";?>" title="Scared" alt="Scared" class="smiley_image" onmousedown="addTags('',':scared:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_cool) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/cool.gif";?>" title="Cool" alt="Cool" class="smiley_image" onmousedown="addTags('',':cool:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_sleep) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/sleep.gif";?>" title="Sleep" alt="Sleep" class="smiley_image" onmousedown="addTags('',':sleep:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_blush) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/blush.gif";?>" title="Blush" alt="Blush" class="smiley_image" onmousedown="addTags('',':blush:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_unsure) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/unsure.gif";?>" title="Unsure" alt="Unsure" class="smiley_image" onmousedown="addTags('',':unsure:')"/>
<?php } ?>
<?php if ($settings->enabled_smilies_shocked) { ?>
<img src="<?php echo $settings->url_to_comments_folder . "images/smilies/shocked.gif";?>" title="Shocked" alt="Shocked" class="smiley_image" onmousedown="addTags('',':shocked:')"/>
<?php } ?>
<?php } ?>

<?php if ($settings->enabled_bb_code || $settings->enabled_smilies) { ?>
<div class="height_below_bb_and_smilies"></div>
<?php } ?>

<label class="label">
<?php echo CMTX_LABEL_COMMENT ?>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<textarea name="cmtx_comment" title="<?php echo CMTX_TITLE_COMMENT; ?>" cols="<?php echo $settings->field_size_comment_columns; ?>" rows="<?php echo $settings->field_size_comment_rows; ?>" onkeydown="textCounter(document.commentics.cmtx_comment,document.commentics.cmtx_count,<?php echo $settings->comment_maximum_characters;?>)" 
onkeyup="textCounter(document.commentics.cmtx_comment,document.commentics.cmtx_count,<?php echo $settings->comment_maximum_characters;?>)"><?php echo $default_comment; ?></textarea>

<?php if ($settings->enabled_counter) { ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<input type="text" readonly="readonly" name="cmtx_count" class="counter" size="20" value="<?php echo $settings->comment_maximum_characters;?>"/>
<?php } ?>

<?php if ($settings->enabled_question) { ?>
<?php if (isset($_SESSION['cmtx_question']) && $_SESSION['cmtx_question'] == $settings->session_key) {} else { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_QUESTION ?>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<?php $question_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."questions` ORDER BY Rand() LIMIT 1"); ?>
<?php $question = mysql_fetch_array($question_query); ?>
<span class="question_part_question_text"><?php echo $question['question']; ?></span>
<input type="hidden" name="cmtx_real_answer" value="<?php echo $question['answer']; ?>"/>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<span class="question_part_answer_text"><?php echo CMTX_TEXT_QUESTION ?></span>
<input type="text" name="cmtx_supplied_answer" title="<?php echo CMTX_TITLE_QUESTION; ?>" size="<?php echo $settings->field_size_question; ?>" maxlength="<?php echo $settings->field_maximum_question; ?>" onkeypress="return disableEnterKey(event)"/>
<?php } } ?>

<?php if ($settings->enabled_captcha) { ?>
<?php if (isset($_SESSION['cmtx_captcha']) && $_SESSION['cmtx_captcha'] == $settings->session_key) {} else { ?>
<div class="height_between_fields"></div>
<label class="label">
<?php echo CMTX_LABEL_CAPTCHA ?>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
</label>
<?php echo '
<img id="siimage" style="float: left;" src="' . $settings->url_to_comments_folder . 'captcha/securimage_show.php?sid='.md5(uniqid(time())).'" alt="Captcha" title="' . CMTX_TITLE_CAPTCHA_IMAGE . '"/>
<a href="' . $settings->url_to_comments_folder . 'captcha/securimage_play.php" title="' . CMTX_TITLE_CAPTCHA_AUDIO . '" rel="nofollow"><img src="' . $settings->url_to_comments_folder . 'captcha/images/audio.png" alt="Audio" style="vertical-align: top; padding-left:4px; padding-bottom:4px;" onclick="this.blur()" /></a><br />
<a href="#" title="' . CMTX_TITLE_CAPTCHA_REFRESH . '" rel="nofollow" onclick="document.getElementById(\'siimage\').src = \'' . $settings->url_to_comments_folder . 'captcha/securimage_show.php?sid=\' + Math.random(); return false"><img src="' . $settings->url_to_comments_folder . 'captcha/images/refresh.png" alt="Refresh" style="vertical-align: bottom; padding-left:4px;" onclick="this.blur()" /></a>';
?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<span class="captcha_part_answer_text"><?php echo CMTX_TEXT_CAPTCHA ?></span>
<input type="text" name="cmtx_captcha" title="<?php echo CMTX_TITLE_CAPTCHA; ?>" size="<?php echo $settings->field_size_captcha; ?>" maxlength="<?php echo $settings->field_maximum_captcha; ?>" onkeypress="return disableEnterKey(event)"/>
<?php } } ?>

<?php if ( ($settings->enabled_notify && $settings->enabled_email) || ($settings->enabled_privacy) || ($settings->enabled_terms) ) { ?>
<div class='height_above_checkboxes'></div>
<?php } ?>

<?php if ($settings->enabled_notify && $settings->enabled_email) { ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<?php if ($default_notify) { ?>
<input type="checkbox" name="cmtx_notify" title="<?php echo CMTX_TITLE_NOTIFY; ?>" checked="checked"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_notify" title="<?php echo CMTX_TITLE_NOTIFY; ?>"/>
<?php } ?>
<span class="notify_text"><?php echo CMTX_TEXT_NOTIFY ?></span>
<?php } ?>

<?php if ($settings->enabled_privacy) { ?>
<?php if ($settings->enabled_notify && $settings->enabled_email) { ?> <br /> <?php } ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<?php if ($default_privacy) { ?>
<input type="checkbox" name="cmtx_privacy" title="<?php echo CMTX_TITLE_PRIVACY; ?>" checked="checked" onclick="enableSubmit();enablePreview();"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_privacy" title="<?php echo CMTX_TITLE_PRIVACY; ?>" onclick="enableSubmit();enablePreview();"/>
<?php } ?>
<span class="privacy_text"><?php echo CMTX_TEXT_PRIVACY ?></span>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
<?php } ?>

<?php if ($settings->enabled_terms) { ?>
<?php if ( ($settings->enabled_notify && $settings->enabled_email) || ($settings->enabled_privacy) ) { ?> <br /> <?php } ?>
<div style="clear: left;"></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<?php if ($default_terms) { ?>
<input type="checkbox" name="cmtx_terms" title="<?php echo CMTX_TITLE_TERMS; ?>" checked="checked" onclick="enableSubmit();enablePreview();"/>
<?php } else { ?>
<input type="checkbox" name="cmtx_terms" title="<?php echo CMTX_TITLE_TERMS; ?>" onclick="enableSubmit();enablePreview();"/>
<?php } ?>
<span class="terms_text"><?php echo CMTX_TEXT_TERMS ?></span>
<?php if ($settings->display_required_symbol) { ?><span class="required_symbol"><?php echo " " . CMTX_REQUIRED_SYMBOL ?></span><?php } ?>
<?php } ?>

<div style="clear: left;"></div>
<div class='height_above_buttons'></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>

<?php if ($is_admin) { $admin_button = "color: #050; font-weight: bold;"; } else { $admin_button = ""; } ?>

<?php
$elements = explode(",", $settings->sort_order_buttons);
foreach ($elements as $element) {
	switch ($element) {
		case "1":
		cmtx_output_submit();
		break;
		case "2":
		cmtx_output_preview();
		break;
	}
}
?>

<?php function cmtx_output_submit () { ?>
<?php global $settings, $admin_button; ?>
<?php if ($settings->enabled_terms || $settings->enabled_privacy) { ?>
<input type="submit" style="<?php echo $admin_button; ?>" name="cmtx_submit" title="<?php echo CMTX_TITLE_SUBMIT; ?>" disabled="disabled" onclick="return processSubmit()" value="<?php echo CMTX_SUBMIT_BUTTON ?>"/>
<?php } else { ?>
<input type="submit" style="<?php echo $admin_button; ?>" name="cmtx_submit" title="<?php echo CMTX_TITLE_SUBMIT; ?>" onclick="return processSubmit()" value="<?php echo CMTX_SUBMIT_BUTTON ?>"/>
<?php } } ?>

<?php function cmtx_output_preview () { ?>
<?php global $settings, $admin_button; ?>
<?php if ($settings->enabled_preview) { ?>
<?php if ( ($settings->enabled_terms || $settings->enabled_privacy) && ($settings->agree_to_preview) ) { ?>
<input type="submit" style="<?php echo $admin_button; ?>" name="cmtx_preview" disabled="disabled" title="<?php echo CMTX_TITLE_PREVIEW; ?>" onclick="return processPreview();" value="<?php echo CMTX_PREVIEW_BUTTON ?>"/>
<?php } else { ?>
<input type="submit" style="<?php echo $admin_button; ?>" name="cmtx_preview" title="<?php echo CMTX_TITLE_PREVIEW; ?>" onclick="return processPreview();" value="<?php echo CMTX_PREVIEW_BUTTON ?>"/>
<?php } } } ?>

<script type="text/javascript">textCounter(document.commentics.cmtx_comment,document.commentics.cmtx_count,<?php echo $settings->comment_maximum_characters;?>)</script>
<script type="text/javascript">enableSubmit()</script>
<script type="text/javascript">enablePreview()</script>

</form>

<?php if ($settings->powered_by_new_window) { $attribute = " target=\"_blank\""; } else { $attribute = ""; } ?>
<?php if ($settings->powered_by == "image") { ?>
<div style="clear: left;"></div>
<div class='height_above_powered'></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<a href="http://www.commentics.org"<?php echo $attribute; ?>><img src="<?php echo $settings->url_to_comments_folder . "images/commentics/powered_by.png";?>" title="Commentics" alt="Commentics"/></a>
<?php } else if ($settings->powered_by == "text") { ?>
<div style="clear: left;"></div>
<div class='height_above_powered'></div>
<div class="label"><span style="visibility: hidden;">blank</span></div>
<span class="powered_by"><?php echo CMTX_POWERED_BY . " "; ?><a href="http://www.commentics.org"<?php echo $attribute; ?>>Commentics</a></span>
<?php } ?>