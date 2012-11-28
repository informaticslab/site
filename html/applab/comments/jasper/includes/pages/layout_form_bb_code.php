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

<h3><?php echo CMTX_TITLE_FORM_BB_CODE ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {
if (isset($_POST['enabled_bb_code_bold'])) { $enabled_bb_code_bold = 1; } else { $enabled_bb_code_bold = 0; }
if (isset($_POST['enabled_bb_code_italic'])) { $enabled_bb_code_italic = 1; } else { $enabled_bb_code_italic = 0; }
if (isset($_POST['enabled_bb_code_underline'])) { $enabled_bb_code_underline = 1; } else { $enabled_bb_code_underline = 0; }
if (isset($_POST['enabled_bb_code_strike'])) { $enabled_bb_code_strike = 1; } else { $enabled_bb_code_strike = 0; }
if (isset($_POST['enabled_bb_code_superscript'])) { $enabled_bb_code_superscript = 1; } else { $enabled_bb_code_superscript = 0; }
if (isset($_POST['enabled_bb_code_subscript'])) { $enabled_bb_code_subscript = 1; } else { $enabled_bb_code_subscript = 0; }
if (isset($_POST['enabled_bb_code_code'])) { $enabled_bb_code_code = 1; } else { $enabled_bb_code_code = 0; }
if (isset($_POST['enabled_bb_code_php_code'])) { $enabled_bb_code_php_code = 1; } else { $enabled_bb_code_php_code = 0; }
if (isset($_POST['enabled_bb_code_quote'])) { $enabled_bb_code_quote = 1; } else { $enabled_bb_code_quote = 0; }
if (isset($_POST['enabled_bb_code_line'])) { $enabled_bb_code_line = 1; } else { $enabled_bb_code_line = 0; }
if (isset($_POST['enabled_bb_code_list_bullet'])) { $enabled_bb_code_list_bullet = 1; } else { $enabled_bb_code_list_bullet = 0; }
if (isset($_POST['enabled_bb_code_list_numeric'])) { $enabled_bb_code_list_numeric = 1; } else { $enabled_bb_code_list_numeric = 0; }
if (isset($_POST['enabled_bb_code_url'])) { $enabled_bb_code_url = 1; } else { $enabled_bb_code_url = 0; }
if (isset($_POST['enabled_bb_code_email'])) { $enabled_bb_code_email = 1; } else { $enabled_bb_code_email = 0; }
if (isset($_POST['enabled_bb_code_image'])) { $enabled_bb_code_image = 1; } else { $enabled_bb_code_image = 0; }
if (isset($_POST['enabled_bb_code_video'])) { $enabled_bb_code_video = 1; } else { $enabled_bb_code_video = 0; }

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_bold' WHERE title = 'enabled_bb_code_bold'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_italic' WHERE title = 'enabled_bb_code_italic'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_underline' WHERE title = 'enabled_bb_code_underline'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_strike' WHERE title = 'enabled_bb_code_strike'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_superscript' WHERE title = 'enabled_bb_code_superscript'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_subscript' WHERE title = 'enabled_bb_code_subscript'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_code' WHERE title = 'enabled_bb_code_code'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_php_code' WHERE title = 'enabled_bb_code_php_code'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_quote' WHERE title = 'enabled_bb_code_quote'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_line' WHERE title = 'enabled_bb_code_line'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_list_bullet' WHERE title = 'enabled_bb_code_list_bullet'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_list_numeric' WHERE title = 'enabled_bb_code_list_numeric'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_url' WHERE title = 'enabled_bb_code_url'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_email' WHERE title = 'enabled_bb_code_email'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_image' WHERE title = 'enabled_bb_code_image'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_bb_code_video' WHERE title = 'enabled_bb_code_video'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_BB_CODE ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_bb_code" id="layout_form_bb_code" action="index.php?page=layout_form_bb_code" method="post">
<label class='layout_form_bb_code'><img src="../images/bb_code/bold.png" title="Bold" alt="Bold"/></label> <?php if ($settings->enabled_bb_code_bold) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_bold"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_bold"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/italic.png" title="Italic" alt="Italic"/></label> <?php if ($settings->enabled_bb_code_italic) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_italic"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_italic"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/underline.png" title="Underline" alt="Underline"/></label> <?php if ($settings->enabled_bb_code_underline) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_underline"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_underline"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/strike.png" title="Strike" alt="Strike"/></label> <?php if ($settings->enabled_bb_code_strike) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_strike"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_strike"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/superscript.png" title="Superscript" alt="Superscript"/></label> <?php if ($settings->enabled_bb_code_superscript) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_superscript"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_superscript"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/subscript.png" title="Subscript" alt="Subscript"/></label> <?php if ($settings->enabled_bb_code_subscript) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_subscript"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_subscript"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/code.png" title="Code" alt="Code"/></label> <?php if ($settings->enabled_bb_code_code) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_code"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_code"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/php_code.png" title="PHP Code" alt="PHP Code"/></label> <?php if ($settings->enabled_bb_code_php_code) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_php_code"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_php_code"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/quote.png" title="Quote" alt="Quote"/></label> <?php if ($settings->enabled_bb_code_quote) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_quote"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_quote"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/line.png" title="Line" alt="Line"/></label> <?php if ($settings->enabled_bb_code_line) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_line"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_line"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/list_bullet.png" title="Bullet List" alt="Bullet List"/></label> <?php if ($settings->enabled_bb_code_list_bullet) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_list_bullet"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_list_bullet"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/list_numeric.png" title="Numeric List" alt="Numeric List"/></label> <?php if ($settings->enabled_bb_code_list_numeric) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_list_numeric"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_list_numeric"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/link.png" title="Link" alt="Link"/></label> <?php if ($settings->enabled_bb_code_url) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_url"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_url"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/email.png" title="Email" alt="Email"/></label> <?php if ($settings->enabled_bb_code_email) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_email"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_email"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/image.png" title="Image" alt="Image"/></label> <?php if ($settings->enabled_bb_code_image) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_image"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_image"/> <?php } ?>
<p />
<label class='layout_form_bb_code'><img src="../images/bb_code/video.png" title="Video" alt="Video"/></label> <?php if ($settings->enabled_bb_code_video) { ?> <input type="checkbox" checked="checked" name="enabled_bb_code_video"/> <?php } else { ?> <input type="checkbox" name="enabled_bb_code_video"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>