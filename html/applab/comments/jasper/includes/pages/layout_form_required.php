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

<h3><?php echo CMTX_TITLE_FORM_REQUIRED ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {
if (isset($_POST['required_email'])) { $required_email = 1; } else { $required_email = 0; }
if (isset($_POST['required_website'])) { $required_website = 1; } else { $required_website = 0; }
if (isset($_POST['required_town'])) { $required_town = 1; } else { $required_town = 0; }
if (isset($_POST['required_country'])) { $required_country = 1; } else { $required_country = 0; }
if (isset($_POST['required_rating'])) { $required_rating = 1; } else { $required_rating = 0; }
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$required_email' WHERE title = 'required_email'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$required_website' WHERE title = 'required_website'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$required_town' WHERE title = 'required_town'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$required_country' WHERE title = 'required_country'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$required_rating' WHERE title = 'required_rating'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_REQUIRED ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_required" id="layout_form_required" action="index.php?page=layout_form_required" method="post">
<label class='layout_form_required'><?php echo CMTX_FIELD_LABEL_EMAIL ?></label> <?php if ($settings->required_email) { ?> <input type="checkbox" checked="checked" name="required_email"/> <?php } else { ?> <input type="checkbox" name="required_email"/> <?php } ?>
<p />
<label class='layout_form_required'><?php echo CMTX_FIELD_LABEL_WEBSITE ?></label> <?php if ($settings->required_website) { ?> <input type="checkbox" checked="checked" name="required_website"/> <?php } else { ?> <input type="checkbox" name="required_website"/> <?php } ?>
<p />
<label class='layout_form_required'><?php echo CMTX_FIELD_LABEL_TOWN ?></label> <?php if ($settings->required_town) { ?> <input type="checkbox" checked="checked" name="required_town"/> <?php } else { ?> <input type="checkbox" name="required_town"/> <?php } ?>
<p />
<label class='layout_form_required'><?php echo CMTX_FIELD_LABEL_COUNTRY ?></label> <?php if ($settings->required_country) { ?> <input type="checkbox" checked="checked" name="required_country"/> <?php } else { ?> <input type="checkbox" name="required_country"/> <?php } ?>
<p />
<label class='layout_form_required'><?php echo CMTX_FIELD_LABEL_RATING ?></label> <?php if ($settings->required_rating) { ?> <input type="checkbox" checked="checked" name="required_rating"/> <?php } else { ?> <input type="checkbox" name="required_rating"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>