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

<h3><?php echo CMTX_TITLE_FLOODING ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['flood_control_delay_enabled'])) { $flood_control_delay_enabled = 1; } else { $flood_control_delay_enabled = 0; }
$flood_control_delay_time = $_POST['flood_control_delay_time'];
if (isset($_POST['flood_control_delay_all_pages'])) { $flood_control_delay_all_pages = 1; } else { $flood_control_delay_all_pages = 0; }
if (isset($_POST['flood_control_maximum_enabled'])) { $flood_control_maximum_enabled = 1; } else { $flood_control_maximum_enabled = 0; }
$flood_control_maximum_amount = $_POST['flood_control_maximum_amount'];
$flood_control_maximum_period = $_POST['flood_control_maximum_period'];
if (isset($_POST['flood_control_maximum_all_pages'])) { $flood_control_maximum_all_pages = 1; } else { $flood_control_maximum_all_pages = 0; }

$flood_control_delay_time_san = sanitize($flood_control_delay_time);
$flood_control_maximum_amount_san = sanitize($flood_control_maximum_amount);
$flood_control_maximum_period_san = sanitize($flood_control_maximum_period);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_delay_enabled' WHERE title = 'flood_control_delay_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_delay_time_san' WHERE title = 'flood_control_delay_time'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_delay_all_pages' WHERE title = 'flood_control_delay_all_pages'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_maximum_enabled' WHERE title = 'flood_control_maximum_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_maximum_amount_san' WHERE title = 'flood_control_maximum_amount'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_maximum_period_san' WHERE title = 'flood_control_maximum_period'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$flood_control_maximum_all_pages' WHERE title = 'flood_control_maximum_all_pages'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_FLOODING ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_flooding" id="settings_flooding" action="index.php?page=settings_flooding" method="post">
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_DELAY ?></label> <?php if ($settings->flood_control_delay_enabled) { ?> <input type="checkbox" checked="checked" name="flood_control_delay_enabled"/> <?php } else { ?> <input type="checkbox" name="flood_control_delay_enabled"/> <?php } ?>
<p />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input type="text" name="flood_control_delay_time" size="1" maxlength="250" value="<?php echo $settings->flood_control_delay_time; ?>"/> <span class='note'><?php echo CMTX_NOTE_SECONDS ?></span>
<p />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_ALL_PAGES ?></label> <?php if ($settings->flood_control_delay_all_pages) { ?> <input type="checkbox" checked="checked" name="flood_control_delay_all_pages"/> <?php } else { ?> <input type="checkbox" name="flood_control_delay_all_pages"/> <?php } ?>
<br /><hr class="separator"><br />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_MAXIMUM ?></label> <?php if ($settings->flood_control_maximum_enabled) { ?> <input type="checkbox" checked="checked" name="flood_control_maximum_enabled"/> <?php } else { ?> <input type="checkbox" name="flood_control_maximum_enabled"/> <?php } ?>
<p />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_AMOUNT ?></label> <input type="text" name="flood_control_maximum_amount" size="1" maxlength="250" value="<?php echo $settings->flood_control_maximum_amount; ?>"/>
<p />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_PERIOD ?></label> <input type="text" name="flood_control_maximum_period" size="1" maxlength="250" value="<?php echo $settings->flood_control_maximum_period; ?>"/> <span class='note'><?php echo CMTX_NOTE_HOURS ?></span>
<p />
<label class='settings_flooding'><?php echo CMTX_FIELD_LABEL_ALL_PAGES ?></label> <?php if ($settings->flood_control_maximum_all_pages) { ?> <input type="checkbox" checked="checked" name="flood_control_maximum_all_pages"/> <?php } else { ?> <input type="checkbox" name="flood_control_maximum_all_pages"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>