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

<h3><?php echo CMTX_TITLE_PROCESSOR_TOWN ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['fix_town_enabled'])) { $fix_town_enabled = 1; } else { $fix_town_enabled = 0; }
if (isset($_POST['detect_link_in_town_enabled'])) { $detect_link_in_town_enabled = 1; } else { $detect_link_in_town_enabled = 0; }
$link_in_town_action = $_POST['link_in_town_action'];
if (isset($_POST['reserved_towns_enabled'])) { $reserved_towns_enabled = 1; } else { $reserved_towns_enabled = 0; }
$reserved_towns_action = $_POST['reserved_towns_action'];
if (isset($_POST['dummy_towns_enabled'])) { $dummy_towns_enabled = 1; } else { $dummy_towns_enabled = 0; }
$dummy_towns_action = $_POST['dummy_towns_action'];
if (isset($_POST['banned_towns_enabled'])) { $banned_towns_enabled = 1; } else { $banned_towns_enabled = 0; }
$banned_towns_action = $_POST['banned_towns_action'];

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$fix_town_enabled' WHERE title = 'fix_town_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$detect_link_in_town_enabled' WHERE title = 'detect_link_in_town_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$link_in_town_action' WHERE title = 'link_in_town_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reserved_towns_enabled' WHERE title = 'reserved_towns_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reserved_towns_action' WHERE title = 'reserved_towns_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$dummy_towns_enabled' WHERE title = 'dummy_towns_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$dummy_towns_action' WHERE title = 'dummy_towns_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_towns_enabled' WHERE title = 'banned_towns_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_towns_action' WHERE title = 'banned_towns_action'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_PROCESSING_TOWN ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_processor_town" id="settings_processor_town" action="index.php?page=settings_processor_town" method="post">
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_FIX_TOWN ?></label> <?php if ($settings->fix_town_enabled) { ?> <input type="checkbox" checked="checked" name="fix_town_enabled"/> <?php } else { ?> <input type="checkbox" name="fix_town_enabled"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_FIX_TOWN ?>', this, event, '')">[?]</a>
<p /><hr class="separator"><br />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_DETECT_LINKS ?></label> <?php if ($settings->detect_link_in_town_enabled) { ?> <input type="checkbox" checked="checked" name="detect_link_in_town_enabled"/> <?php } else { ?> <input type="checkbox" name="detect_link_in_town_enabled"/> <?php } ?>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='link_in_town_action'>
<?php if ($settings->link_in_town_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->link_in_town_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<p /><hr class="separator"><br />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_RESERVED_TOWN ?></label> <?php if ($settings->reserved_towns_enabled) { ?> <input type="checkbox" checked="checked" name="reserved_towns_enabled"/> <?php } else { ?> <input type="checkbox" name="reserved_towns_enabled"/> <?php } ?>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_reserved_towns"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='reserved_towns_action'>
<?php if ($settings->reserved_towns_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->reserved_towns_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_DUMMY_TOWN ?></label> <?php if ($settings->dummy_towns_enabled) { ?> <input type="checkbox" checked="checked" name="dummy_towns_enabled"/> <?php } else { ?> <input type="checkbox" name="dummy_towns_enabled"/> <?php } ?>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_dummy_towns"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='dummy_towns_action'>
<?php if ($settings->dummy_towns_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->dummy_towns_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_BANNED_TOWN ?></label> <?php if ($settings->banned_towns_enabled) { ?> <input type="checkbox" checked="checked" name="banned_towns_enabled"/> <?php } else { ?> <input type="checkbox" name="banned_towns_enabled"/> <?php } ?>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_banned_towns"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_town'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='banned_towns_action'>
<?php if ($settings->banned_towns_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->banned_towns_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>