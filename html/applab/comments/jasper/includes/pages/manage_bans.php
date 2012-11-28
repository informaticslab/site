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

<h3><?php echo CMTX_TITLE_BANS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$ip_address = $_POST['ip_address'];
$reason = $_POST['reason'];

$ip_address = sanitize($ip_address);
$reason = sanitize($reason);

mysql_query("INSERT INTO `".$mysql_table_prefix."bans` (ip_address, reason, unban, dated) VALUES ('$ip_address', '$reason', '0', NOW());");
?>
<div class="success"><?php echo CMTX_MSG_BAN_ADDED ?></div>
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
mysql_query("UPDATE `".$mysql_table_prefix."bans` SET unban = '1' WHERE id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_BAN_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<?php $settings = new Settings; ?>

<form name="add_ban" id="add_ban" action="index.php?page=manage_bans" method="post">
<?php echo CMTX_FIELD_LABEL_IP_ADDRESS ?> <input type="text" name="ip_address" size="12" maxlength="39"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_REASON ?> <input type="text" name="reason" size="45" maxlength="100"/>&nbsp;
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_ADD_BAN ?>" value="<?php echo CMTX_BUTTON_ADD_BAN ?>"/>
</form>

<br />

<table id="data" class="display" summary="Bans">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_IP_ADDRESS ?></th>
            <th><?php echo CMTX_TABLE_REASON ?></th>
            <th><?php echo CMTX_TABLE_DATE_TIME ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$bans = mysql_query("SELECT * FROM `".$mysql_table_prefix."bans` WHERE unban = '0' ORDER BY dated DESC");

while ($ban = mysql_fetch_assoc($bans)) {
?>
    	<tr>
        	<td><?php echo $ban["ip_address"]; ?></td>
            <td><?php echo $ban["reason"]; ?></td>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($ban["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($ban["dated"])); ?></td>
			<td><a href="<?php echo "index.php?page=manage_bans&action=delete&id=" . $ban["id"];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_confirmation()" title="Delete" alt="Delete"></a></td>
        </tr>	
<?php } ?>

    </tbody>
</table>