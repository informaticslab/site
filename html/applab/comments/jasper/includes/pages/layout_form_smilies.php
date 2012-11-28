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

<h3><?php echo CMTX_TITLE_FORM_SMILIES ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled_smilies_smile'])) { $enabled_smilies_smile = 1; } else { $enabled_smilies_smile = 0; }
if (isset($_POST['enabled_smilies_sad'])) { $enabled_smilies_sad = 1; } else { $enabled_smilies_sad = 0; }
if (isset($_POST['enabled_smilies_huh'])) { $enabled_smilies_huh = 1; } else { $enabled_smilies_huh = 0; }
if (isset($_POST['enabled_smilies_laugh'])) { $enabled_smilies_laugh = 1; } else { $enabled_smilies_laugh = 0; }
if (isset($_POST['enabled_smilies_mad'])) { $enabled_smilies_mad = 1; } else { $enabled_smilies_mad = 0; }
if (isset($_POST['enabled_smilies_tongue'])) { $enabled_smilies_tongue = 1; } else { $enabled_smilies_tongue = 0; }
if (isset($_POST['enabled_smilies_crying'])) { $enabled_smilies_crying = 1; } else { $enabled_smilies_crying = 0; }
if (isset($_POST['enabled_smilies_grin'])) { $enabled_smilies_grin = 1; } else { $enabled_smilies_grin = 0; }
if (isset($_POST['enabled_smilies_wink'])) { $enabled_smilies_wink = 1; } else { $enabled_smilies_wink = 0; }
if (isset($_POST['enabled_smilies_scared'])) { $enabled_smilies_scared = 1; } else { $enabled_smilies_scared = 0; }
if (isset($_POST['enabled_smilies_cool'])) { $enabled_smilies_cool = 1; } else { $enabled_smilies_cool = 0; }
if (isset($_POST['enabled_smilies_sleep'])) { $enabled_smilies_sleep = 1; } else { $enabled_smilies_sleep = 0; }
if (isset($_POST['enabled_smilies_blush'])) { $enabled_smilies_blush = 1; } else { $enabled_smilies_blush = 0; }
if (isset($_POST['enabled_smilies_unsure'])) { $enabled_smilies_unsure = 1; } else { $enabled_smilies_unsure = 0; }
if (isset($_POST['enabled_smilies_shocked'])) { $enabled_smilies_shocked = 1; } else { $enabled_smilies_shocked = 0; }

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_smile' WHERE title = 'enabled_smilies_smile'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_sad' WHERE title = 'enabled_smilies_sad'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_huh' WHERE title = 'enabled_smilies_huh'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_laugh' WHERE title = 'enabled_smilies_laugh'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_mad' WHERE title = 'enabled_smilies_mad'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_tongue' WHERE title = 'enabled_smilies_tongue'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_crying' WHERE title = 'enabled_smilies_crying'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_grin' WHERE title = 'enabled_smilies_grin'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_wink' WHERE title = 'enabled_smilies_wink'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_scared' WHERE title = 'enabled_smilies_scared'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_cool' WHERE title = 'enabled_smilies_cool'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_sleep' WHERE title = 'enabled_smilies_sleep'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_blush' WHERE title = 'enabled_smilies_blush'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_unsure' WHERE title = 'enabled_smilies_unsure'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_smilies_shocked' WHERE title = 'enabled_smilies_shocked'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_SMILIES ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_smilies" id="layout_form_smilies" action="index.php?page=layout_form_smilies" method="post">
<label class='layout_form_smilies'><img src="../images/smilies/smile.gif" title="Smile" alt="Smile"/></label> <?php if ($settings->enabled_smilies_smile) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_smile"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_smile"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/sad.gif" title="Sad" alt="Sad"/></label> <?php if ($settings->enabled_smilies_sad) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_sad"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_sad"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/huh.gif" title="Huh" alt="Huh"/></label> <?php if ($settings->enabled_smilies_huh) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_huh"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_huh"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/laugh.gif" title="Laugh" alt="Laugh"/></label> <?php if ($settings->enabled_smilies_laugh) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_laugh"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_laugh"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/mad.gif" title="Mad" alt="Mad"/></label> <?php if ($settings->enabled_smilies_mad) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_mad"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_mad"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/tongue.gif" title="Tongue" alt="Tongue"/></label> <?php if ($settings->enabled_smilies_tongue) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_tongue"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_tongue"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/crying.gif" title="Crying" alt="Crying"/></label> <?php if ($settings->enabled_smilies_crying) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_crying"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_crying"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/grin.gif" title="Grin" alt="Grin"/></label> <?php if ($settings->enabled_smilies_grin) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_grin"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_grin"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/wink.gif" title="Wink" alt="Wink"/></label> <?php if ($settings->enabled_smilies_wink) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_wink"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_wink"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/scared.gif" title="Scared" alt="Scared"/></label> <?php if ($settings->enabled_smilies_scared) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_scared"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_scared"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/cool.gif" title="Cool" alt="Cool"/></label> <?php if ($settings->enabled_smilies_cool) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_cool"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_cool"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/sleep.gif" title="Sleep" alt="Sleep"/></label> <?php if ($settings->enabled_smilies_sleep) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_sleep"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_sleep"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/blush.gif" title="Blush" alt="Blush"/></label> <?php if ($settings->enabled_smilies_blush) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_blush"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_blush"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/unsure.gif" title="Unsure" alt="Unsure"/></label> <?php if ($settings->enabled_smilies_unsure) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_unsure"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_unsure"/> <?php } ?>
<p />
<label class='layout_form_smilies'><img src="../images/smilies/shocked.gif" title="Shocked" alt="Shocked"/></label> <?php if ($settings->enabled_smilies_shocked) { ?> <input type="checkbox" checked="checked" name="enabled_smilies_shocked"/> <?php } else { ?> <input type="checkbox" name="enabled_smilies_shocked"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>