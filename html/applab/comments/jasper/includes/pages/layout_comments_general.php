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

<h3><?php echo CMTX_TITLE_COMMENTS_GENERAL ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$newest_first = $_POST['newest_first'];
if (isset($_POST['show_says'])) { $show_says = 1; } else { $show_says = 0; }
if (isset($_POST['js_vote_ok'])) { $js_vote_ok = 1; } else { $js_vote_ok = 0; }
if (isset($_POST['scroll_reply'])) { $scroll_reply = 1; } else { $scroll_reply = 0; }
$time_format = $_POST['time_format'];
$date_time_format = $_POST['date_time_format'];

$time_format_san = sanitize($time_format);
$date_time_format_san = sanitize($date_time_format);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$newest_first' WHERE title = 'newest_first'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_says' WHERE title = 'show_says'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$js_vote_ok' WHERE title = 'js_vote_ok'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$time_format_san' WHERE title = 'time_format'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$date_time_format_san' WHERE title = 'date_time_format'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_GENERAL ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_general" id="layout_comments_general" action="index.php?page=layout_comments_general" method="post">
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_ORDER ?></label>
<select name='newest_first'>
<?php if ($settings->newest_first) { ?>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_NEWEST ?></option>
<option value='0'><?php echo CMTX_FIELD_VALUE_OLDEST ?></option>
<?php } else { ?>
<option value='1'><?php echo CMTX_FIELD_VALUE_NEWEST ?></option>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_OLDEST ?></option>
<?php } ?>
</select>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NEWEST_FIRST ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_SAYS ?></label> <?php if ($settings->show_says) { ?> <input type="checkbox" checked="checked" name="show_says"/> <?php } else { ?> <input type="checkbox" name="show_says"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_DISPLAY_SAYS ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_JS_VOTE_OK ?></label> <?php if ($settings->js_vote_ok) { ?> <input type="checkbox" checked="checked" name="js_vote_ok"/> <?php } else { ?> <input type="checkbox" name="js_vote_ok"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_JS_VOTE_OK ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_TIME_FORMAT ?></label> <input type="text" name="time_format" size="2" maxlength="250" value="<?php echo $settings->time_format; ?>"/> &nbsp; <a href="http://www.commentics.org/support/knowledgebase.php?article=20" target="_blank"><?php echo CMTX_LINK_FAQ ?></a>
<p />
<label class='layout_comments_general'><?php echo CMTX_FIELD_LABEL_DATE_TIME ?></label> <input type="text" name="date_time_format" size="8" maxlength="250" value="<?php echo $settings->date_time_format; ?>"/> &nbsp; <a href="http://www.commentics.org/support/knowledgebase.php?article=20" target="_blank"><?php echo CMTX_LINK_FAQ ?></a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>