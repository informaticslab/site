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

<h3><?php echo CMTX_TITLE_EDIT_SUBSCRIBER ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$id = $_GET['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$page_id = $_POST['page_id'];
$confirmed = $_POST['confirmed'];
$active = $_POST['active'];

$id = sanitize($id);
$name = sanitize($name);
$email = sanitize($email);
$page_id = sanitize($page_id);

mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET name = '$name' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET email = '$email' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET page_id = '$page_id' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_confirmed = '$confirmed' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_active = '$active' WHERE id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_SUB_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
$id = $_GET['id'];
$id = sanitize($id);
$subscriber_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE id = '$id'");
$subscriber_result = mysql_fetch_assoc($subscriber_query);
$name = $subscriber_result["name"];
$email = $subscriber_result["email"];
$confirmed = $subscriber_result["is_confirmed"];
$active = $subscriber_result["is_active"];
$time = date("g:ia", strtotime($subscriber_result["dated"]));
$date = date("jS M Y", strtotime($subscriber_result["dated"]));

$page_id = $subscriber_result["page_id"];
$page_reference_query = mysql_query("SELECT reference FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
$page_reference_result = mysql_fetch_assoc($page_reference_query);
$page_reference = $page_reference_result["reference"];
?>

<p />

<?php $settings = new Settings; ?>

<form name="edit_subscriber" id="edit_subscriber" action="index.php?page=edit_subscriber&id=<?php echo $id ?>" method="post">
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_NAME ?></label> <input type="text" name="name" size="20" maxlength="250" value="<?php echo htmlentities($name, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_EMAIL ?></label> <input type="text" name="email" size="31" maxlength="250" value="<?php echo htmlentities($email, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_PAGE ?></label> <select name="page_id"><?php
$pages = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` ORDER BY id ASC");
while ($page = mysql_fetch_assoc($pages)) { ?>
<option value='<?php echo $page['id'];?>' <?php if ($page_id == $page['id']) { echo "selected='selected'"; } ?>><?php echo $page['reference']; ?></option>
<?php } ?>
</select>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_CONFIRMED ?></label>
<?php if ($confirmed) { ?>
<select name='confirmed'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='confirmed'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_ACTIVE ?></label>
<?php if ($active) { ?>
<select name='active'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='active'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input readonly="readonly" type="text" class="readonly" name="time" size="5" maxlength="250" value="<?php echo $time; ?>"/>
<p />
<label class='edit_subscriber'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <input readonly="readonly" type="text" class="readonly" name="date" size="12" maxlength="250" value="<?php echo $date; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_confirmation()){window.location='index.php?page=manage_subscribers&action=delete&id=<?php echo $id ?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>

<p />

<a href="index.php?page=manage_subscribers"><?php echo CMTX_LINK_BACK ?></a>