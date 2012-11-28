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

<h3><?php echo CMTX_TITLE_COMMENTS_REPLIES ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['show_reply'])) { $show_reply = 1; } else { $show_reply = 0; }
$reply_depth = $_POST['reply_depth'];
if (isset($_POST['reply_arrow'])) { $reply_arrow = 1; } else { $reply_arrow = 0; }
if (isset($_POST['scroll_reply'])) { $scroll_reply = 1; } else { $scroll_reply = 0; }

$reply_depth_san = sanitize($reply_depth);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_reply' WHERE title = 'show_reply'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reply_depth_san' WHERE title = 'reply_depth'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reply_arrow' WHERE title = 'reply_arrow'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$scroll_reply' WHERE title = 'scroll_reply'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_REPLIES ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_replies" id="layout_comments_replies" action="index.php?page=layout_comments_replies" method="post">
<label class='layout_comments_replies'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->show_reply) { ?> <input type="checkbox" checked="checked" name="show_reply"/> <?php } else { ?> <input type="checkbox" name="show_reply"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_SHOW_REPLY ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_replies'><?php echo CMTX_FIELD_LABEL_REPLY_DEPTH ?></label> <input type="text" name="reply_depth" size="1" maxlength="250" value="<?php echo $settings->reply_depth; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_REPLY_DEPTH ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_replies'><?php echo CMTX_FIELD_LABEL_REPLY_ARROW ?></label> <?php if ($settings->reply_arrow) { ?> <input type="checkbox" checked="checked" name="reply_arrow"/> <?php } else { ?> <input type="checkbox" name="reply_arrow"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_REPLY_ARROW ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_replies'><?php echo CMTX_FIELD_LABEL_SCROLL_REPLY ?></label> <?php if ($settings->scroll_reply) { ?> <input type="checkbox" checked="checked" name="scroll_reply"/> <?php } else { ?> <input type="checkbox" name="scroll_reply"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_SCROLL_REPLY ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>