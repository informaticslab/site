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

<h3><?php echo CMTX_TITLE_SYSTEM ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$admin_folder = $_POST['admin_folder'];
$time_zone = $_POST['time_zone'];
$url_to_comments_folder = $_POST['url_to_comments_folder'];
$mysqldump_path = $_POST['mysqldump_path'];
if (isset($_POST['enabled_wysiwyg'])) { $enabled_wysiwyg = 1; } else { $enabled_wysiwyg = 0; }
$limit_comments = $_POST['limit_comments'];

$admin_folder_san = sanitize($admin_folder);
$url_to_comments_folder_san = sanitize($url_to_comments_folder);
$mysqldump_path_san = sanitize($mysqldump_path);
$limit_comments_san = sanitize($limit_comments);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$admin_folder_san' WHERE title = 'admin_folder'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$time_zone' WHERE title = 'time_zone'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$url_to_comments_folder_san' WHERE title = 'url_to_comments_folder'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$mysqldump_path_san' WHERE title = 'mysqldump_path'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_wysiwyg' WHERE title = 'enabled_wysiwyg'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$limit_comments_san' WHERE title = 'limit_comments'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_SYSTEM ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_system" id="settings_system" action="index.php?page=settings_system" method="post">
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_ADMIN_FOLDER ?></label> <input type="text" name="admin_folder" size="10" maxlength="250" value="<?php echo $settings->admin_folder; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_ADMIN_FOLDER ?>', this, event, '')">[?]</a>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_TIME_ZONE ?></label>
<?php
$selected_tz = $settings->time_zone;
$time_zones = DateTimeZone::listIdentifiers();
echo "<select name='time_zone'>";
foreach ($time_zones as $time_zone) {
	if ($time_zone == $selected_tz) {
		echo "<option selected value=$time_zone>$time_zone</option>";
	} else {
		echo "<option value=$time_zone>$time_zone</option>";
	}
}
echo "</select>";
?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_TIME_ZONE ?>', this, event, '')">[?]</a>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_COMMENTS_URL ?></label> <input type="text" name="url_to_comments_folder" size="45" maxlength="250" value="<?php echo $settings->url_to_comments_folder; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_COMMENTS_URL ?>', this, event, '')">[?]</a>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_MYSQL_DUMP ?></label> <input type="text" name="mysqldump_path" size="45" maxlength="250" value="<?php echo $settings->mysqldump_path; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_MYSQL_DUMP ?>', this, event, '')">[?]</a>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_WYSIWYG ?></label> <?php if ($settings->enabled_wysiwyg) { ?> <input type="checkbox" checked="checked" name="enabled_wysiwyg"/> <?php } else { ?> <input type="checkbox" name="enabled_wysiwyg"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_WYSIWYG ?>', this, event, '')">[?]</a>
<p />
<label class='settings_system'><?php echo CMTX_FIELD_LABEL_LIMIT_COMMENTS ?></label> <input type="text" name="limit_comments" size="3" maxlength="250" value="<?php echo $settings->limit_comments; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_LIMIT_COMMENTS ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>