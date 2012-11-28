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

<h3><?php echo CMTX_TITLE_COMMENTS_ENABLED ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {
if (isset($_POST['show_website'])) { $show_website = 1; } else { $show_website = 0; }
if (isset($_POST['show_town'])) { $show_town = 1; } else { $show_town = 0; }
if (isset($_POST['show_country'])) { $show_country = 1; } else { $show_country = 0; }
if (isset($_POST['show_rating'])) { $show_rating = 1; } else { $show_rating = 0; }
if (isset($_POST['show_like'])) { $show_like = 1; } else { $show_like = 0; }
if (isset($_POST['show_dislike'])) { $show_dislike = 1; } else { $show_dislike = 0; }
if (isset($_POST['show_flag'])) { $show_flag = 1; } else { $show_flag = 0; }
if (isset($_POST['show_date'])) { $show_date = 1; } else { $show_date = 0; }
if (isset($_POST['show_reply'])) { $show_reply = 1; } else { $show_reply = 0; }
if (isset($_POST['enabled_gravatar'])) { $enabled_gravatar = 1; } else { $enabled_gravatar = 0; }
if (isset($_POST['enabled_sort_by'])) { $enabled_sort_by = 1; } else { $enabled_sort_by = 0; }
if (isset($_POST['show_average_rating'])) { $show_average_rating = 1; } else { $show_average_rating = 0; }
if (isset($_POST['enabled_social'])) { $enabled_social = 1; } else { $enabled_social = 0; }
if (isset($_POST['show_rss_this_page'])) { $show_rss_this_page = 1; } else { $show_rss_this_page = 0; }
if (isset($_POST['show_rss_all_pages'])) { $show_rss_all_pages = 1; } else { $show_rss_all_pages = 0; }
if (isset($_POST['show_comments_info'])) { $show_comments_info = 1; } else { $show_comments_info = 0; }

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_website' WHERE title = 'show_website'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_town' WHERE title = 'show_town'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_country' WHERE title = 'show_country'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_rating' WHERE title = 'show_rating'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_like' WHERE title = 'show_like'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_dislike' WHERE title = 'show_dislike'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_flag' WHERE title = 'show_flag'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_date' WHERE title = 'show_date'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_reply' WHERE title = 'show_reply'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_gravatar' WHERE title = 'enabled_gravatar'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_sort_by' WHERE title = 'enabled_sort_by'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_average_rating' WHERE title = 'show_average_rating'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social' WHERE title = 'enabled_social'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_rss_this_page' WHERE title = 'show_rss_this_page'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_rss_all_pages' WHERE title = 'show_rss_all_pages'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$show_comments_info' WHERE title = 'show_comments_info'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_ENABLED ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_enabled" id="layout_comments_enabled" action="index.php?page=layout_comments_enabled" method="post">
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_WEBSITE ?></label> <?php if ($settings->show_website) { ?> <input type="checkbox" checked="checked" name="show_website"/> <?php } else { ?> <input type="checkbox" name="show_website"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_TOWN ?></label> <?php if ($settings->show_town) { ?> <input type="checkbox" checked="checked" name="show_town"/> <?php } else { ?> <input type="checkbox" name="show_town"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_COUNTRY ?></label> <?php if ($settings->show_country) { ?> <input type="checkbox" checked="checked" name="show_country"/> <?php } else { ?> <input type="checkbox" name="show_country"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_RATING ?></label> <?php if ($settings->show_rating) { ?> <input type="checkbox" checked="checked" name="show_rating"/> <?php } else { ?> <input type="checkbox" name="show_rating"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <?php if ($settings->show_date) { ?> <input type="checkbox" checked="checked" name="show_date"/> <?php } else { ?> <input type="checkbox" name="show_date"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_LIKE ?></label> <?php if ($settings->show_like) { ?> <input type="checkbox" checked="checked" name="show_like"/> <?php } else { ?> <input type="checkbox" name="show_like"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_DISLIKE ?></label> <?php if ($settings->show_dislike) { ?> <input type="checkbox" checked="checked" name="show_dislike"/> <?php } else { ?> <input type="checkbox" name="show_dislike"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_FLAG ?></label> <?php if ($settings->show_flag) { ?> <input type="checkbox" checked="checked" name="show_flag"/> <?php } else { ?> <input type="checkbox" name="show_flag"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_REPLY ?></label> <?php if ($settings->show_reply) { ?> <input type="checkbox" checked="checked" name="show_reply"/> <?php } else { ?> <input type="checkbox" name="show_reply"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_GRAVATAR ?></label> <?php if ($settings->enabled_gravatar) { ?> <input type="checkbox" checked="checked" name="enabled_gravatar"/> <?php } else { ?> <input type="checkbox" name="enabled_gravatar"/> <?php } ?>
<div class='sub-heading'><?php echo CMTX_TITLE_OUTER_AREA ?></div>
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_SORT_BY ?></label> <?php if ($settings->enabled_sort_by) { ?> <input type="checkbox" checked="checked" name="enabled_sort_by"/> <?php } else { ?> <input type="checkbox" name="enabled_sort_by"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_AVG_RATING ?></label> <?php if ($settings->show_average_rating) { ?> <input type="checkbox" checked="checked" name="show_average_rating"/> <?php } else { ?> <input type="checkbox" name="show_average_rating"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_SOCIAL ?></label> <?php if ($settings->enabled_social) { ?> <input type="checkbox" checked="checked" name="enabled_social"/> <?php } else { ?> <input type="checkbox" name="enabled_social"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_RSS_THIS ?></label> <?php if ($settings->show_rss_this_page) { ?> <input type="checkbox" checked="checked" name="show_rss_this_page"/> <?php } else { ?> <input type="checkbox" name="show_rss_this_page"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_RSS_ALL ?></label> <?php if ($settings->show_rss_all_pages) { ?> <input type="checkbox" checked="checked" name="show_rss_all_pages"/> <?php } else { ?> <input type="checkbox" name="show_rss_all_pages"/> <?php } ?>
<p />
<label class='layout_comments_enabled'><?php echo CMTX_FIELD_LABEL_INFO ?></label> <?php if ($settings->show_comments_info) { ?> <input type="checkbox" checked="checked" name="show_comments_info"/> <?php } else { ?> <input type="checkbox" name="show_comments_info"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>