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

<h3><?php echo CMTX_TITLE_COMMENTS_GRAVATAR ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled_gravatar'])) { $enabled_gravatar = 1; } else { $enabled_gravatar = 0; }
$gravatar_default = $_POST['gravatar_default'];
$gravatar_rating = $_POST['gravatar_rating'];

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_gravatar' WHERE title = 'enabled_gravatar'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$gravatar_default' WHERE title = 'gravatar_default'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$gravatar_rating' WHERE title = 'gravatar_rating'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_GRAVATAR ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_gravatar" id="layout_comments_gravatar" action="index.php?page=layout_comments_gravatar" method="post">
<label class='layout_comments_gravatar'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->enabled_gravatar) { ?> <input type="checkbox" checked="checked" name="enabled_gravatar"/> <?php } else { ?> <input type="checkbox" name="enabled_gravatar"/> <?php } ?>
<p />
<label class='layout_comments_gravatar'><?php echo CMTX_FIELD_LABEL_GRAVATAR_DEFAULT ?></label> <input type="text" name="gravatar_default" size="10" maxlength="250" value="<?php echo $settings->gravatar_default; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_GRAVATAR_DEFAULT ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_gravatar'><?php echo CMTX_FIELD_LABEL_GRAVATAR_RATING ?></label> <input type="text" name="gravatar_rating" size="1" maxlength="250" value="<?php echo $settings->gravatar_rating; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_GRAVATAR_RATING ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>