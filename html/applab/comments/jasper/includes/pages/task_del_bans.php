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

<h3><?php echo CMTX_TITLE_TASK_DELETE_BANS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled'])) { $task_enabled_delete_bans = 1; } else { $task_enabled_delete_bans = 0; }
$days_to_delete_bans = $_POST['days'];

$days_to_delete_bans_san = sanitize($days_to_delete_bans);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$task_enabled_delete_bans' WHERE title = 'task_enabled_delete_bans'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$days_to_delete_bans_san' WHERE title = 'days_to_delete_bans'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_TASK_DELETE_BANS ?>

<p />

<?php $settings = new Settings; ?>

<form name="task_del_bans" id="task_del_bans" action="index.php?page=task_del_bans" method="post">
<label class='task_del_bans'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->task_enabled_delete_bans) { ?> <input type="checkbox" checked="checked" name="enabled"/> <?php } else { ?> <input type="checkbox" name="enabled"/> <?php } ?>
<p />
<label class='task_del_bans'><?php echo CMTX_FIELD_LABEL_DAYS ?></label> <input type="text" name="days" size="1" maxlength="4" value="<?php echo $settings->days_to_delete_bans; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>