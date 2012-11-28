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

<h3><?php echo CMTX_TITLE_FORM_ENABLED ?></h3>
<hr class="title">

<?php

if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled_form'])) { $enabled_form = 1; } else { $enabled_form = 0; }
if (isset($_POST['enabled_email'])) { $enabled_email = 1; } else { $enabled_email = 0; }
if (isset($_POST['enabled_website'])) { $enabled_website = 1; } else { $enabled_website = 0; }
if (isset($_POST['enabled_town'])) { $enabled_town = 1; } else { $enabled_town = 0; }
if (isset($_POST['enabled_country'])) { $enabled_country = 1; } else { $enabled_country = 0; }
if (isset($_POST['enabled_rating'])) { $enabled_rating = 1; } else { $enabled_rating = 0; }
if (isset($_POST['enabled_bb_code'])) { $enabled_bb_code = 1; } else { $enabled_bb_code = 0; }
if (isset($_POST['enabled_smilies'])) { $enabled_smilies = 1; } else { $enabled_smilies = 0; }
if (isset($_POST['enabled_counter'])) { $enabled_counter = 1; } else { $enabled_counter = 0; }
if (isset($_POST['enabled_question'])) { $enabled_question = 1; } else { $enabled_question = 0; }
if (isset($_POST['enabled_captcha'])) { $enabled_captcha = 1; } else { $enabled_captcha = 0; }
if (isset($_POST['enabled_notify'])) { $enabled_notify = 1; } else { $enabled_notify = 0; }
if (isset($_POST['enabled_privacy'])) { $enabled_privacy = 1; } else { $enabled_privacy = 0; }
if (isset($_POST['enabled_terms'])) { $enabled_terms = 1; } else { $enabled_terms = 0; }
if (isset($_POST['enabled_preview'])) { $enabled_preview = 1; } else { $enabled_preview = 0; }

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_form' WHERE title = 'enabled_form'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_email' WHERE title = 'enabled_email'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_website' WHERE title = 'enabled_website'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_town' WHERE title = 'enabled_town'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_country' WHERE title = 'enabled_country'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_rating' WHERE title = 'enabled_rating'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code' WHERE title = 'enabled_bb_code'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies' WHERE title = 'enabled_smilies'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_counter' WHERE title = 'enabled_counter'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_question' WHERE title = 'enabled_question'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_captcha' WHERE title = 'enabled_captcha'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_notify' WHERE title = 'enabled_notify'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_privacy' WHERE title = 'enabled_privacy'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_terms' WHERE title = 'enabled_terms'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_preview' WHERE title = 'enabled_preview'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_enabled" id="layout_form_enabled" action="index.php?page=layout_form_enabled" method="post">

<?php echo CMTX_DESC_LAYOUT_FORM_ENABLED_1 ?>

<p />

<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->enabled_form) { ?> <input type="checkbox" checked="checked" name="enabled_form"/> <?php } else { ?> <input type="checkbox" name="enabled_form"/> <?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_ENABLED_2 ?>

<p />

<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_EMAIL ?></label> <?php if ($settings->enabled_email) { ?> <input type="checkbox" checked="checked" name="enabled_email"/> <?php } else { ?> <input type="checkbox" name="enabled_email"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_WEBSITE ?></label> <?php if ($settings->enabled_website) { ?> <input type="checkbox" checked="checked" name="enabled_website"/> <?php } else { ?> <input type="checkbox" name="enabled_website"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_TOWN ?></label> <?php if ($settings->enabled_town) { ?> <input type="checkbox" checked="checked" name="enabled_town"/> <?php } else { ?> <input type="checkbox" name="enabled_town"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_COUNTRY ?></label> <?php if ($settings->enabled_country) { ?> <input type="checkbox" checked="checked" name="enabled_country"/> <?php } else { ?> <input type="checkbox" name="enabled_country"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_RATING ?></label> <?php if ($settings->enabled_rating) { ?> <input type="checkbox" checked="checked" name="enabled_rating"/> <?php } else { ?> <input type="checkbox" name="enabled_rating"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_BB_CODE ?></label> <?php if ($settings->enabled_bb_code) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_SMILIES ?></label> <?php if ($settings->enabled_smilies) { ?> <input type="checkbox" checked="checked" name="enabled_smilies"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_COUNTER ?></label> <?php if ($settings->enabled_counter) { ?> <input type="checkbox" checked="checked" name="enabled_counter"/> <?php } else { ?> <input type="checkbox" name="enabled_counter"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_QUESTION ?></label> <?php if ($settings->enabled_question) { ?> <input type="checkbox" checked="checked" name="enabled_question"/> <?php } else { ?> <input type="checkbox" name="enabled_question"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_CAPTCHA ?></label> <?php if ($settings->enabled_captcha) { ?> <input type="checkbox" checked="checked" name="enabled_captcha"/> <?php } else { ?> <input type="checkbox" name="enabled_captcha"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_NOTIFY ?></label> <?php if ($settings->enabled_notify) { ?> <input type="checkbox" checked="checked" name="enabled_notify"/> <?php } else { ?> <input type="checkbox" name="enabled_notify"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_PRIVACY ?></label> <?php if ($settings->enabled_privacy) { ?> <input type="checkbox" checked="checked" name="enabled_privacy"/> <?php } else { ?> <input type="checkbox" name="enabled_privacy"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_TERMS ?></label> <?php if ($settings->enabled_terms) { ?> <input type="checkbox" checked="checked" name="enabled_terms"/> <?php } else { ?> <input type="checkbox" name="enabled_terms"/> <?php } ?>
<p />
<label class='layout_form_enabled'><?php echo CMTX_FIELD_LABEL_PREVIEW ?></label> <?php if ($settings->enabled_preview) { ?> <input type="checkbox" checked="checked" name="enabled_preview"/> <?php } else { ?> <input type="checkbox" name="enabled_preview"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>