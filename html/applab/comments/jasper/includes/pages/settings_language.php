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

<h3><?php echo CMTX_TITLE_LANGUAGE ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$language_frontend = $_POST['language_frontend'];
$language_backend = $_POST['language_backend'];

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$language_frontend' WHERE title = 'language_frontend'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$language_backend' WHERE title = 'language_backend'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_LANGUAGE ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_language" id="settings_language" action="index.php?page=settings_language" method="post">
<label class='settings_language'><?php echo CMTX_FIELD_LABEL_FRONTEND ?></label>
<select name="language_frontend">
<?php
foreach (glob('../includes/language/*', GLOB_ONLYDIR) as $dir) {
	$dir = basename($dir);
	echo "<option value='" . $dir . "'";
	if ($dir == $settings->language_frontend) { echo " selected='selected'"; }
	echo ">" . $dir . "</option>";	
}
?>
</select>
<p />
<label class='settings_language'><?php echo CMTX_FIELD_LABEL_BACKEND ?></label>
<select name="language_backend">
<?php
foreach (glob('includes/language/*', GLOB_ONLYDIR) as $dir) {
	$dir = basename($dir);
	echo "<option value='" . $dir . "'";
	if ($dir == $settings->language_backend) { echo " selected='selected'"; }
	echo ">" . $dir . "</option>";	
}
?>
</select>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>