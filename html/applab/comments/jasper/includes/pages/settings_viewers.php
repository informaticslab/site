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

<h3><?php echo CMTX_TITLE_VIEWERS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['viewers_enabled'])) { $viewers_enabled = 1; } else { $viewers_enabled = 0; }
$viewers_timeout = $_POST['viewers_timeout'];
if (isset($_POST['viewers_refresh_enabled'])) { $viewers_refresh_enabled = 1; } else { $viewers_refresh_enabled = 0; }
$viewers_refresh_time = $_POST['viewers_refresh_time'];

$viewers_timeout_san = sanitize($viewers_timeout);
$viewers_refresh_time_san = sanitize($viewers_refresh_time);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$viewers_enabled' WHERE title = 'viewers_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$viewers_timeout_san' WHERE title = 'viewers_timeout'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$viewers_refresh_enabled' WHERE title = 'viewers_refresh_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$viewers_refresh_time_san' WHERE title = 'viewers_refresh_time'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_VIEWERS ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_viewers" id="settings_viewers" action="index.php?page=settings_viewers" method="post">
<label class='settings_viewers'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->viewers_enabled) { ?> <input type="checkbox" checked="checked" name="viewers_enabled"/> <?php } else { ?> <input type="checkbox" name="viewers_enabled"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_VISITOR_ENABLED ?>', this, event, '')">[?]</a>
<p />
<label class='settings_viewers'><?php echo CMTX_FIELD_LABEL_TIMEOUT ?></label> <input type="text" name="viewers_timeout" size="1" maxlength="250" value="<?php echo $settings->viewers_timeout; ?>"/> <span class='note'><?php echo CMTX_NOTE_SECONDS ?></span>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_VISITOR_TIMEOUT ?>', this, event, '')">[?]</a>
<p />
<label class='settings_viewers'><?php echo CMTX_FIELD_LABEL_REFRESH ?></label> <?php if ($settings->viewers_refresh_enabled) { ?> <input type="checkbox" checked="checked" name="viewers_refresh_enabled"/> <?php } else { ?> <input type="checkbox" name="viewers_refresh_enabled"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_VISITOR_REFRESH ?>', this, event, '')">[?]</a>
<p />
<label class='settings_viewers'><?php echo CMTX_FIELD_LABEL_INTERVAL ?></label> <input type="text" name="viewers_refresh_time" size="1" maxlength="250" value="<?php echo $settings->viewers_refresh_time; ?>"/> <span class='note'><?php echo CMTX_NOTE_SECONDS ?></span>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_VISITOR_INTERVAL ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>