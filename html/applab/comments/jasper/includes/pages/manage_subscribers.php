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

<h3><?php echo CMTX_TITLE_SUBSCRIBERS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$name = $_POST['name'];
$email = $_POST['email'];
$page_id = $_POST['page_id'];

$is_unique = FALSE; //initialise flag as false
while (!$is_unique) { //while the token is not unique
	$token = get_random_key(20); //create new token
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token'")) == 0) { //if the token does not already exist
		$is_unique = TRUE; //the created token is unique
	}
}

$name = sanitize($name);
$email = sanitize($email);
$page_id = sanitize($page_id);

mysql_query("INSERT INTO `".$mysql_table_prefix."subscribers` (name, email, page_id, token, is_confirmed, is_active, last_action, dated) VALUES ('$name', '$email', '$page_id', '$token', '1', '1', NOW(), NOW());");
?>
<div class="success"><?php echo CMTX_MSG_SUB_ADDED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
if ( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && ctype_digit($_GET['id']) ) {
if ($settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else {
$id = $_GET['id'];
$id = sanitize($id);
mysql_query("DELETE FROM `".$mysql_table_prefix."subscribers` WHERE id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_SUB_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<?php $settings = new Settings; ?>

<form name="add_subscriber" id="add_subscriber" action="index.php?page=manage_subscribers" method="post">
<?php echo CMTX_FIELD_LABEL_NAME ?> <input type="text" name="name" size="12" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_EMAIL ?> <input type="text" name="email" size="30" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_PAGE ?> <select name="page_id"> <?php
$pages = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` ORDER BY id ASC");
while ($page = mysql_fetch_assoc($pages)) { ?>
<option value='<?php echo $page['id'];?>'><?php echo $page['reference']; ?></option>
<?php } ?>
</select>&nbsp;
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_ADD_SUB ?>" value="<?php echo CMTX_BUTTON_ADD_SUB ?>"/>
</form>

<br />

<table id="data" class="display" summary="Subscribers">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_NAME ?></th>
            <th><?php echo CMTX_TABLE_EMAIL ?></th>
            <th><?php echo CMTX_TABLE_PAGE ?></th>
			<th><?php echo CMTX_TABLE_CONFIRMED ?></th>
			<th><?php echo CMTX_TABLE_ACTIVE ?></th>
			<th><?php echo CMTX_TABLE_DATE_TIME ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$subscribers = mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` ORDER BY dated DESC");
while ($subscriber = mysql_fetch_assoc($subscribers)) {
?>
    	<tr>
        	<td><?php echo htmlentities($subscriber["name"], ENT_NOQUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlentities($subscriber["email"], ENT_NOQUOTES, 'UTF-8'); ?></td>
			<?php
			$page_id = $subscriber["page_id"];
			$page_reference_query = mysql_query("SELECT reference FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
			$page_reference_result = mysql_fetch_assoc($page_reference_query);
			?>
			<td><?php echo $page_reference_result["reference"]; ?></td>
			<td><?php if ($subscriber["is_confirmed"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
			<td><?php if ($subscriber["is_active"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($subscriber["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($subscriber["dated"])); ?></td>
			<td>
			<a href="<?php echo "index.php?page=edit_subscriber&id=" . $subscriber["id"];?>"><img src="images/buttons/edit.png" class="button_edit" title="Edit" alt="Edit"></a>
			<a href="<?php echo "index.php?page=manage_subscribers&action=delete&id=" . $subscriber["id"];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_confirmation()" title="Delete" alt="Delete"></a>
			</td>
        </tr>	
<?php } ?>

    </tbody>
</table>