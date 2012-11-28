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

<h3><?php echo CMTX_TITLE_PROCESSOR_WEBSITE ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['approve_websites'])) { $approve_websites = 1; } else { $approve_websites = 0; }
if (isset($_POST['validate_website_ping'])) { $validate_website_ping = 1; } else { $validate_website_ping = 0; }
if (isset($_POST['website_new_window'])) { $website_new_window = 1; } else { $website_new_window = 0; }
if (isset($_POST['website_nofollow'])) { $website_nofollow = 1; } else { $website_nofollow = 0; }
if (isset($_POST['dummy_websites_enabled'])) { $dummy_websites_enabled = 1; } else { $dummy_websites_enabled = 0; }
$reserved_websites_action = $_POST['reserved_websites_action'];
if (isset($_POST['reserved_websites_enabled'])) { $reserved_websites_enabled = 1; } else { $reserved_websites_enabled = 0; }
$dummy_websites_action = $_POST['dummy_websites_action'];
if (isset($_POST['banned_websites_as_website_enabled'])) { $banned_websites_as_website_enabled = 1; } else { $banned_websites_as_website_enabled = 0; }
$banned_websites_as_website_action = $_POST['banned_websites_as_website_action'];

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$approve_websites' WHERE title = 'approve_websites'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$validate_website_ping' WHERE title = 'validate_website_ping'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$website_new_window' WHERE title = 'website_new_window'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$website_nofollow' WHERE title = 'website_nofollow'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reserved_websites_enabled' WHERE title = 'reserved_websites_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$reserved_websites_action' WHERE title = 'reserved_websites_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$dummy_websites_enabled' WHERE title = 'dummy_websites_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$dummy_websites_action' WHERE title = 'dummy_websites_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_websites_as_website_enabled' WHERE title = 'banned_websites_as_website_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_websites_as_website_action' WHERE title = 'banned_websites_as_website_action'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_PROCESSING_WEBSITE ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_processor_website" id="settings_processor_website" action="index.php?page=settings_processor_website" method="post">
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_APPROVE ?></label> <?php if ($settings->approve_websites) { ?> <input type="checkbox" checked="checked" name="approve_websites"/> <?php } else { ?> <input type="checkbox" name="approve_websites"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_APPROVE_WEBSITE ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_PING ?></label> <?php if ($settings->validate_website_ping) { ?> <input type="checkbox" checked="checked" name="validate_website_ping"/> <?php } else { ?> <input type="checkbox" name="validate_website_ping"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_PING ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_NEW_WINDOW ?></label> <?php if ($settings->website_new_window) { ?> <input type="checkbox" checked="checked" name="website_new_window"/> <?php } else { ?> <input type="checkbox" name="website_new_window"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NEW_WIN ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_NO_FOLLOW ?></label> <?php if ($settings->website_nofollow) { ?> <input type="checkbox" checked="checked" name="website_nofollow"/> <?php } else { ?> <input type="checkbox" name="website_nofollow"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NO_FOLLOW ?>', this, event, '')">[?]</a>
<br /><hr class="separator"><br />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_RESERVED_WEBSITE ?></label> <?php if ($settings->reserved_websites_enabled) { ?> <input type="checkbox" checked="checked" name="reserved_websites_enabled"/> <?php } else { ?> <input type="checkbox" name="reserved_websites_enabled"/> <?php } ?>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_reserved_websites"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='reserved_websites_action'>
<?php if ($settings->reserved_websites_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->reserved_websites_action == "approve") { ?>
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
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_DUMMY_WEBSITE ?></label> <?php if ($settings->dummy_websites_enabled) { ?> <input type="checkbox" checked="checked" name="dummy_websites_enabled"/> <?php } else { ?> <input type="checkbox" name="dummy_websites_enabled"/> <?php } ?>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_dummy_websites"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='dummy_websites_action'>
<?php if ($settings->dummy_websites_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->dummy_websites_action == "approve") { ?>
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
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_BANNED_WEBSITE ?></label> <?php if ($settings->banned_websites_as_website_enabled) { ?> <input type="checkbox" checked="checked" name="banned_websites_as_website_enabled"/> <?php } else { ?> <input type="checkbox" name="banned_websites_as_website_enabled"/> <?php } ?>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_banned_websites"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_website'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='banned_websites_as_website_action'>
<?php if ($settings->banned_websites_as_website_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->banned_websites_as_website_action == "approve") { ?>
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