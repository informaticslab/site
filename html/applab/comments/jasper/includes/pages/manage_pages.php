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

<h3><?php echo CMTX_TITLE_PAGES ?></h3>
<hr class="title">

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
mysql_query("DELETE FROM `".$mysql_table_prefix."pages` WHERE id = '$id'");
mysql_query("DELETE FROM `".$mysql_table_prefix."subscribers` WHERE page_id = '$id'");
$comments = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE page_id = '$id'");
while ($comment = mysql_fetch_assoc($comments)) {
$comment_id = $comment["id"];
mysql_query("DELETE FROM `".$mysql_table_prefix."voters` WHERE comment_id = '$comment_id'");
mysql_query("DELETE FROM `".$mysql_table_prefix."reports` WHERE comment_id = '$comment_id'");
}
mysql_query("DELETE FROM `".$mysql_table_prefix."comments` WHERE page_id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_PAGE_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<table id="data" class="display" summary="Pages">
    <thead>
    	<tr>
			<th><?php echo CMTX_TABLE_ID ?></th>
			<th><?php echo CMTX_TABLE_CUSTOM_ID ?></th>
        	<th><?php echo CMTX_TABLE_REFERENCE ?></th>
            <th><?php echo CMTX_TABLE_URL ?></th>
			<th><?php echo CMTX_TABLE_FORM_ENABLED ?></th>
            <th><?php echo CMTX_TABLE_DATE_TIME ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$pages = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` ORDER BY id ASC");
while ($page = mysql_fetch_assoc($pages)) {
?>
    	<tr>
			<td><?php echo $page["id"]; ?></td>
			<td><?php if (empty($page["custom_id"])) { echo CMTX_TABLE_NOT_SET; } else { echo $page["custom_id"]; } ?></td>
        	<td><?php echo $page["reference"]; ?></td>
            <td><?php echo "<a href='" . $page["url"] . "' target='_blank'>" . $page["url"] . "</a>"; ?></td>
			<td><?php if ($page["is_form_enabled"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($page["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($page["dated"])); ?></td>
			<td>
			<a href="<?php echo "index.php?page=edit_page&id=" . $page["id"];?>"><img src="images/buttons/edit.png" class="button_edit" title="Edit" alt="Edit"></a>
			<a href="<?php echo "index.php?page=manage_pages&action=delete&id=" . $page["id"];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_page_confirmation()" title="Delete" alt="Delete"></a>
			</td>
        </tr>	
<?php } ?>

    </tbody>
</table>