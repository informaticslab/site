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

<h3><?php echo CMTX_TITLE_RSS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['rss_enabled'])) { $rss_enabled = 1; } else { $rss_enabled = 0; }
$rss_title = $_POST['rss_title'];
$rss_link = $_POST['rss_link'];
$rss_description = $_POST['rss_description'];
$rss_language = $_POST['rss_language'];
if (isset($_POST['rss_image_enabled'])) { $rss_image_enabled = 1; } else { $rss_image_enabled = 0; }
$rss_image_url = $_POST['rss_image_url'];
$rss_image_width = $_POST['rss_image_width'];
$rss_image_height = $_POST['rss_image_height'];
if (isset($_POST['rss_most_recent_enabled'])) { $rss_most_recent_enabled = 1; } else { $rss_most_recent_enabled = 0; }
$rss_most_recent_amount = $_POST['rss_most_recent_amount'];

$rss_title_san = sanitize($rss_title);
$rss_link_san = sanitize($rss_link);
$rss_description_san = sanitize($rss_description);
$rss_language_san = sanitize($rss_language);
$rss_image_url_san = sanitize($rss_image_url);
$rss_most_recent_amount_san = sanitize($rss_most_recent_amount);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_enabled' WHERE title = 'rss_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_title_san' WHERE title = 'rss_title'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_link_san' WHERE title = 'rss_link'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_description_san' WHERE title = 'rss_description'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_language_san' WHERE title = 'rss_language'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_image_enabled' WHERE title = 'rss_image_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_image_url_san' WHERE title = 'rss_image_url'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_image_width' WHERE title = 'rss_image_width'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_image_height' WHERE title = 'rss_image_height'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_most_recent_enabled' WHERE title = 'rss_most_recent_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rss_most_recent_amount_san' WHERE title = 'rss_most_recent_amount'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_RSS ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_rss" id="settings_rss" action="index.php?page=settings_rss" method="post">
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->rss_enabled) { ?> <input type="checkbox" checked="checked" name="rss_enabled"/> <?php } else { ?> <input type="checkbox" name="rss_enabled"/> <?php } ?>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_TITLE ?></label> <input type="text" name="rss_title" size="20" maxlength="250" value="<?php echo $settings->rss_title; ?>"/>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_LINK ?></label> <input type="text" name="rss_link" size="35" maxlength="250" value="<?php echo $settings->rss_link; ?>"/>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_DESC ?></label> <input type="text" name="rss_description" size="50" maxlength="250" value="<?php echo $settings->rss_description; ?>"/>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_LANG ?></label> <input type="text" name="rss_language" size="1" maxlength="10" value="<?php echo $settings->rss_language; ?>"/>
<br /><hr class="separator"><br />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_IMAGE ?></label> <?php if ($settings->rss_image_enabled) { ?> <input type="checkbox" checked="checked" name="rss_image_enabled"/> <?php } else { ?> <input type="checkbox" name="rss_image_enabled"/> <?php } ?>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_IMAGE_URL ?></label> <input type="text" name="rss_image_url" size="35" maxlength="250" value="<?php echo $settings->rss_image_url; ?>"/>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_IMAGE_WIDTH ?></label> <input type="text" name="rss_image_width" size="1" maxlength="250" value="<?php echo $settings->rss_image_width; ?>"/> <span class='note'><?php echo CMTX_NOTE_PIXELS ?></span>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_IMAGE_HEIGHT ?></label> <input type="text" name="rss_image_height" size="1" maxlength="250" value="<?php echo $settings->rss_image_height; ?>"/> <span class='note'><?php echo CMTX_NOTE_PIXELS ?></span>
<br /><hr class="separator"><br />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_LIMIT_ITEMS ?></label> <?php if ($settings->rss_most_recent_enabled) { ?> <input type="checkbox" checked="checked" name="rss_most_recent_enabled"/> <?php } else { ?> <input type="checkbox" name="rss_most_recent_enabled"/> <?php } ?>
<p />
<label class='settings_rss'><?php echo CMTX_FIELD_LABEL_LIMIT_AMOUNT ?>:</label> <input type="text" name="rss_most_recent_amount" size="1" maxlength="250" value="<?php echo $settings->rss_most_recent_amount; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>