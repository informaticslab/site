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

<h3><?php echo CMTX_TITLE_SECURITY ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$banning_cookie_days = $_POST['banning_cookie_days'];
if (isset($_POST['check_referrer'])) { $check_referrer = 1; } else { $check_referrer = 0; }
if (isset($_POST['check_db_file'])) { $check_db_file = 1; } else { $check_db_file = 0; }
$security_key = $_POST['security_key'];

$banning_cookie_days_san = sanitize($banning_cookie_days);
$security_key_san = sanitize($security_key);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banning_cookie_days_san' WHERE title = 'banning_cookie_days'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_referrer' WHERE title = 'check_referrer'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_db_file' WHERE title = 'check_db_file'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$security_key_san' WHERE title = 'security_key'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_SECURITY ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_security" id="settings_security" action="index.php?page=settings_security" method="post">
<label class='settings_security'><?php echo CMTX_FIELD_LABEL_BAN_COOKIE ?></label> <input type="text" name="banning_cookie_days" size="1" maxlength="3" value="<?php echo $settings->banning_cookie_days; ?>"/> <span class='note'><?php echo CMTX_NOTE_DAYS ?></span>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_BAN_COOKIE ?>', this, event, '')">[?]</a>
<p />
<label class='settings_security'><?php echo CMTX_FIELD_LABEL_CHECK_REFERRER ?></label> <?php if ($settings->check_referrer) { ?> <input type="checkbox" checked="checked" name="check_referrer"/> <?php } else { ?> <input type="checkbox" name="check_referrer"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_CHECK_REFERRER ?>', this, event, '')">[?]</a>
<p />
<label class='settings_security'><?php echo CMTX_FIELD_LABEL_CHECK_DB_FILE ?></label> <?php if ($settings->check_db_file) { ?> <input type="checkbox" checked="checked" name="check_db_file"/> <?php } else { ?> <input type="checkbox" name="check_db_file"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_CHECK_DB_FILE ?>', this, event, '')">[?]</a>
<p />
<label class='settings_security'><?php echo CMTX_FIELD_LABEL_SECURITY_KEY ?></label> <input type="text" name="security_key" size="20" maxlength="250" value="<?php echo $settings->security_key; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_SECURITY_KEY ?>', this, event, '')">[?]</a>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>