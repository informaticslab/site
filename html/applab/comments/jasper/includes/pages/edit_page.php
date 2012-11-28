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

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<h3><?php echo CMTX_TITLE_EDIT_PAGE ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$id = $_GET['id'];
$custom_id = $_POST['custom_id'];
$reference = $_POST['reference'];
$url = $_POST['url'];
$form_enabled = $_POST['form_enabled'];

$id = sanitize($id);
$custom_id = sanitize($custom_id);
$reference = sanitize($reference);
$url = sanitize($url);

if (!empty($custom_id) && mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE custom_id = '$custom_id' AND id != '$id'"))) {

?>
<div class="error"><?php echo CMTX_MSG_PAGE_EXISTS ?></div>
<div style="clear: left;"></div>
<?php

} else {

mysql_query("UPDATE `".$mysql_table_prefix."pages` SET custom_id = '$custom_id' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."pages` SET reference = '$reference' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."pages` SET url = '$url' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."pages` SET is_form_enabled = '$form_enabled' WHERE id = '$id'");

?>
<div class="success"><?php echo CMTX_MSG_PAGE_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php } ?>

<?php
$id = $_GET['id'];
$id = sanitize($id);
$page_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE id = '$id'");
$page_result = mysql_fetch_assoc($page_query);
$custom_id = $page_result["custom_id"];
$reference = $page_result["reference"];
$url = $page_result["url"];
$form_enabled = $page_result["is_form_enabled"];
$time = date("g:ia", strtotime($page_result["dated"]));
$date = date("jS M Y", strtotime($page_result["dated"]));
?>

<p />

<?php $settings = new Settings; ?>

<form name="edit_page" id="edit_page" action="index.php?page=edit_page&id=<?php echo $id ?>" method="post">
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_ID ?></label> <input readonly="readonly" type="text" class="readonly" name="id" size="1" maxlength="10" value="<?php echo $id; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_CUSTOM_ID ?></label> <input type="text" name="custom_id" size="30" maxlength="250" value="<?php echo $custom_id; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_REFERENCE ?></label> <input type="text" name="reference" size="30" maxlength="250" value="<?php echo $reference; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_URL ?></label> <input type="text" name="url" size="45" maxlength="250" value="<?php echo $url; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_FORM_ENABLED ?></label>
<?php if ($form_enabled) { ?>
<select name='form_enabled'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='form_enabled'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input readonly="readonly" type="text" class="readonly" name="time" size="5" maxlength="250" value="<?php echo $time; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <input readonly="readonly" type="text" class="readonly" name="date" size="12" maxlength="250" value="<?php echo $date; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_page_confirmation()){window.location='index.php?page=manage_pages&action=delete&id=<?php echo $id ?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>

<p />

<a href="index.php?page=manage_pages"><?php echo CMTX_LINK_BACK ?></a>