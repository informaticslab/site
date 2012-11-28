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

<h3><?php echo CMTX_TITLE_COMMENTS_PAGINATION ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled_pagination'])) { $enabled_pagination = 1; } else { $enabled_pagination = 0; }
if (isset($_POST['show_pagination_top'])) { $show_pagination_top = 1; } else { $show_pagination_top = 0; }
if (isset($_POST['show_pagination_bottom'])) { $show_pagination_bottom = 1; } else { $show_pagination_bottom = 0; }
$comments_per_page = $_POST['comments_per_page'];
$range_of_pages = $_POST['range_of_pages'];

$comments_per_page_san = sanitize($comments_per_page);
$range_of_pages_san = sanitize($range_of_pages);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_pagination' WHERE title = 'enabled_pagination'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_pagination_top' WHERE title = 'show_pagination_top'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_pagination_bottom' WHERE title = 'show_pagination_bottom'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comments_per_page_san' WHERE title = 'comments_per_page'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$range_of_pages_san' WHERE title = 'range_of_pages'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_PAGINATION ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_pagination" id="layout_comments_pagination" action="index.php?page=layout_comments_pagination" method="post">
<label class='layout_comments_pagination'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->enabled_pagination) { ?> <input type="checkbox" checked="checked" name="enabled_pagination"/> <?php } else { ?> <input type="checkbox" name="enabled_pagination"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PAGINATION_ENABLED ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_pagination'><?php echo CMTX_FIELD_LABEL_TOP ?></label> <?php if ($settings->show_pagination_top) { ?> <input type="checkbox" checked="checked" name="show_pagination_top"/> <?php } else { ?> <input type="checkbox" name="show_pagination_top"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PAGINATION_TOP ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_pagination'><?php echo CMTX_FIELD_LABEL_BOTTOM ?></label> <?php if ($settings->show_pagination_bottom) { ?> <input type="checkbox" checked="checked" name="show_pagination_bottom"/> <?php } else { ?> <input type="checkbox" name="show_pagination_bottom"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PAGINATION_BOTTOM ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_pagination'><?php echo CMTX_FIELD_LABEL_PER_PAGE ?></label> <input type="text" name="comments_per_page" size="1" maxlength="250" value="<?php echo $settings->comments_per_page; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PAGINATION_PER_PAGE ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_pagination'><?php echo CMTX_FIELD_LABEL_RANGE ?></label> <input type="text" name="range_of_pages" size="1" maxlength="250" value="<?php echo $settings->range_of_pages; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PAGINATION_RANGE ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>