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

<h3><?php echo CMTX_TITLE_COMMENTS ?></h3>
<hr class="title">

<?php
if (isset($_GET['notice']) && $_GET['notice'] == "dismiss") {
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '0' WHERE title = 'notice_limit_comments'");
} else {
if ($settings->notice_limit_comments) { ?>
<div class="info"><?php echo CMTX_MSG_NOTICE_LIMIT_COMMENTS ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<?php
if (isset($_POST['spam']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['spam'])) {

$id = $_POST['id'];
$comment_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
$comment_result = mysql_fetch_assoc($comment_query);
$name = $comment_result["name"];
$email = $comment_result["email"];
$website = $comment_result["website"];
$ip_address = $comment_result["ip_address"];

if ($_POST['delete'] == "delete_this") {
	mysql_query("DELETE FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	delete_replies($id);
	mysql_query("DELETE FROM `".$mysql_table_prefix."voters` WHERE comment_id = '$id'");
	mysql_query("DELETE FROM `".$mysql_table_prefix."reports` WHERE comment_id = '$id'");
} else { //delete all
	$spam_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE ip_address = '$ip_address'");
	while ($spam = mysql_fetch_assoc($spam_query)) {
		$id = $spam["id"];
		mysql_query("DELETE FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
		delete_replies($id);
		mysql_query("DELETE FROM `".$mysql_table_prefix."voters` WHERE comment_id = '$id'");
		mysql_query("DELETE FROM `".$mysql_table_prefix."reports` WHERE comment_id = '$id'");
	}
}

if ($_POST['ban'] == "do_ban") {
	mysql_query("INSERT INTO `".$mysql_table_prefix."bans` (ip_address, reason, unban, dated) VALUES ('$ip_address', '" . CMTX_FIELD_VALUE_SPAM . "', '0', NOW());");
}

if (isset($_POST['ban_name'])) {
	$file = "../includes/words/banned_names.txt";
	$handle = fopen($file, "a");
	fputs($handle, "\r\n" . $name);
	fclose($handle);
}

if (isset($_POST['ban_email'])) {
	$file = "../includes/words/banned_emails.txt";
	$handle = fopen($file, "a");
	fputs($handle, "\r\n" . $email);
	fclose($handle);
}

if (isset($_POST['ban_website'])) {
	$file = "../includes/words/banned_websites.txt";
	$handle = fopen($file, "a");
	fputs($handle, "\r\n" . $website);
	fclose($handle);
}
?>
<div class="success"><?php echo CMTX_MSG_SPAM_REMOVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && ctype_digit($_GET['id'])) {
if ($settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else {
$id = $_GET['id'];
$id = sanitize($id);
mysql_query("DELETE FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
delete_replies($id);
mysql_query("DELETE FROM `".$mysql_table_prefix."voters` WHERE comment_id = '$id'");
mysql_query("DELETE FROM `".$mysql_table_prefix."reports` WHERE comment_id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_COMMENT_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<table id="data" class="display" summary="Comments">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_NAME ?></th>
			<th><?php echo CMTX_TABLE_PAGE ?></th>
			<th><?php echo CMTX_TABLE_COMMENT ?></th>
			<th><?php echo CMTX_TABLE_APPROVED ?></th>
			<?php if ($settings->enabled_notify) { ?>
			<th><?php echo CMTX_TABLE_SENT ?></th>
			<?php } ?>
			<?php if ($settings->show_flag) { ?>
			<th><?php echo CMTX_TABLE_REPORTS ?></th>
			<th><?php echo CMTX_TABLE_FLAGGED ?></th>
			<?php } ?>
			<th><?php echo CMTX_TABLE_DATE_TIME ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$comments = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` ORDER BY dated DESC LIMIT " . $settings->limit_comments);
while ($comment = mysql_fetch_assoc($comments)) {
?>
    	<tr>
			<?php $id = $comment["id"]; ?>
			<td><?php echo htmlentities($comment["name"], ENT_NOQUOTES, 'UTF-8'); ?></td>
			<?php
			$page_id = $comment["page_id"];
			$page_reference_query = mysql_query("SELECT reference FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
			$page_reference_result = mysql_fetch_assoc($page_reference_query);
			?>
			<td><?php echo $page_reference_result["reference"]; ?></td>
			<td><?php echo substr(htmlentities($comment["comment"], ENT_NOQUOTES, 'UTF-8'), 0, 75); ?></td>
			<td><?php if ($comment["is_approved"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
			<?php if ($settings->enabled_notify) { ?>
			<td><?php if ($comment["is_sent"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
			<?php } ?>
			<?php if ($settings->show_flag) {
			$query = mysql_query("SELECT comment_id FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
			$count = mysql_num_rows($query);
			echo "<td>" . $count . "</td>";
			echo "<td>";
			if ($comment["is_flagged"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; }
			echo "</td>";
			}
			?>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($comment["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($comment["dated"])); ?></td>
			<td>
			<a href="<?php echo "index.php?page=edit_comment&id=" . $comment["id"];?>"><img src="images/buttons/edit.png" class="button_edit" title="Edit" alt="Edit"></a>
			<a href="<?php echo "index.php?page=manage_comments&action=delete&id=" . $comment["id"];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_comment_confirmation()" title="Delete" alt="Delete"></a>
			</td>
        </tr>	
<?php } ?>

    </tbody>
</table>