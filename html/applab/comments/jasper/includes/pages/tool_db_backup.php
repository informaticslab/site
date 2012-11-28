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

<h3><?php echo CMTX_TITLE_DATABASE_BACKUP ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {
$backup_file = "backups/" . get_random_key(50)  . ".sql";
$command = $settings->mysqldump_path . "mysqldump --host=$mysql_host --user=$mysql_username --password=$mysql_password $mysql_database > $backup_file";
system($command);

?>
<div class="success"><?php echo CMTX_MSG_BACKUP_CREATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
if ( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) ) {
if ($settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else {
$id = $_GET['id'];
unlink("backups/" . $id);
?>
<div class="success"><?php echo CMTX_MSG_BACKUP_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<?php echo CMTX_DESC_TOOL_DATABASE_BACKUP ?>

<p />

<?php $settings = new Settings; ?>

<form name="db_backup" id="db_backup" action="index.php?page=tool_db_backup" method="post">
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_BACKUP ?>" value="<?php echo CMTX_BUTTON_BACKUP ?>"/>
</form>

<br />

<table id="data" class="display" summary="Backups">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_FILENAME ?></th>
            <th><?php echo CMTX_TABLE_SIZE ?></th>
            <th><?php echo CMTX_TABLE_DATE_TIME ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$directory = "backups/";
 
$backups = glob("" . $directory . "*.sql");

usort($backups, create_function('$b,$a', 'return filemtime($a) - filemtime($b);'));

$count = 0;
 
foreach ($backups as $backup) {
?>
    	<tr>
        	<td><?php echo "<a href='" . $backup . "'>" . basename($backup) . "</a>"; ?></td>
            <td><?php echo round(filesize($backup)/1024,2) . " KB"; ?></td>
            <td><?php echo date ("jS F Y g:ia", filemtime($backup)); ?></td>
			<td><a href="<?php echo "index.php?page=tool_db_backup&action=delete&id=" . basename($backup);?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_confirmation()" title="Delete" alt="Delete"></a></td>
        </tr>	
<?php
$count++;
}
?>

    </tbody>
</table>