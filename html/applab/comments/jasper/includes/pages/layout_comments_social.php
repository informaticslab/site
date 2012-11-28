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

<h3><?php echo CMTX_TITLE_COMMENTS_SOCIAL ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled_social'])) { $enabled_social = 1; } else { $enabled_social = 0; }
if (isset($_POST['social_new_window'])) { $social_new_window = 1; } else { $social_new_window = 0; }
if (isset($_POST['enabled_social_facebook'])) { $enabled_social_facebook = 1; } else { $enabled_social_facebook = 0; }
if (isset($_POST['enabled_social_delicious'])) { $enabled_social_delicious = 1; } else { $enabled_social_delicious = 0; }
if (isset($_POST['enabled_social_stumbleupon'])) { $enabled_social_stumbleupon = 1; } else { $enabled_social_stumbleupon = 0; }
if (isset($_POST['enabled_social_digg'])) { $enabled_social_digg = 1; } else { $enabled_social_digg = 0; }
if (isset($_POST['enabled_social_technorati'])) { $enabled_social_technorati = 1; } else { $enabled_social_technorati = 0; }
if (isset($_POST['enabled_social_google'])) { $enabled_social_google = 1; } else { $enabled_social_google = 0; }
if (isset($_POST['enabled_social_reddit'])) { $enabled_social_reddit = 1; } else { $enabled_social_reddit = 0; }
if (isset($_POST['enabled_social_myspace'])) { $enabled_social_myspace = 1; } else { $enabled_social_myspace = 0; }
if (isset($_POST['enabled_social_twitter'])) { $enabled_social_twitter = 1; } else { $enabled_social_twitter = 0; }
if (isset($_POST['enabled_social_linkedin'])) { $enabled_social_linkedin = 1; } else { $enabled_social_linkedin = 0; }

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social' WHERE title = 'enabled_social'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$social_new_window' WHERE title = 'social_new_window'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_facebook' WHERE title = 'enabled_social_facebook'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_delicious' WHERE title = 'enabled_social_delicious'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_stumbleupon' WHERE title = 'enabled_social_stumbleupon'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_digg' WHERE title = 'enabled_social_digg'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_technorati' WHERE title = 'enabled_social_technorati'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_google' WHERE title = 'enabled_social_google'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_reddit' WHERE title = 'enabled_social_reddit'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_myspace' WHERE title = 'enabled_social_myspace'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_twitter' WHERE title = 'enabled_social_twitter'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$enabled_social_linkedin' WHERE title = 'enabled_social_linkedin'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_comments_social" id="layout_comments_social" action="index.php?page=layout_comments_social" method="post">

<?php echo CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_1 ?>

<p />

<label class='layout_comments_social'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->enabled_social) { ?> <input type="checkbox" checked="checked" name="enabled_social"/> <?php } else { ?> <input type="checkbox" name="enabled_social"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_SOCIAL_ENABLED ?>', this, event, '')">[?]</a>
<p />
<label class='layout_comments_social'><?php echo CMTX_FIELD_LABEL_NEW_WINDOW ?></label> <?php if ($settings->social_new_window) { ?> <input type="checkbox" checked="checked" name="social_new_window"/> <?php } else { ?> <input type="checkbox" name="social_new_window"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NEW_WIN ?>', this, event, '')">[?]</a>

<p />

<?php echo CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_2 ?>

<p />

<label class='layout_comments_social'><img src="../images/social/facebook.png" title="Facebook" alt="Facebook"/></label> <?php if ($settings->enabled_social_facebook) { ?> <input type="checkbox" checked="checked" name="enabled_social_facebook"/> <?php } else { ?> <input type="checkbox" name="enabled_social_facebook"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/delicious.png" title="del.icio.us" alt="del.icio.us"/></label> <?php if ($settings->enabled_social_delicious) { ?> <input type="checkbox" checked="checked" name="enabled_social_delicious"/> <?php } else { ?> <input type="checkbox" name="enabled_social_delicious"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/stumbleupon.png" title="StumbleUpon" alt="StumbleUpon"/></label> <?php if ($settings->enabled_social_stumbleupon) { ?> <input type="checkbox" checked="checked" name="enabled_social_stumbleupon"/> <?php } else { ?> <input type="checkbox" name="enabled_social_stumbleupon"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/digg.png" title="Digg" alt="Digg"/></label> <?php if ($settings->enabled_social_digg) { ?> <input type="checkbox" checked="checked" name="enabled_social_digg"/> <?php } else { ?> <input type="checkbox" name="enabled_social_digg"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/technorati.png" title="Technorati" alt="Technorati"/></label> <?php if ($settings->enabled_social_technorati) { ?> <input type="checkbox" checked="checked" name="enabled_social_technorati"/> <?php } else { ?> <input type="checkbox" name="enabled_social_technorati"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/google.png" title="Google" alt="Google"/></label> <?php if ($settings->enabled_social_google) { ?> <input type="checkbox" checked="checked" name="enabled_social_google"/> <?php } else { ?> <input type="checkbox" name="enabled_social_google"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/reddit.png" title="Reddit" alt="Reddit"/></label> <?php if ($settings->enabled_social_reddit) { ?> <input type="checkbox" checked="checked" name="enabled_social_reddit"/> <?php } else { ?> <input type="checkbox" name="enabled_social_reddit"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/myspace.png" title="MySpace" alt="MySpace"/></label> <?php if ($settings->enabled_social_myspace) { ?> <input type="checkbox" checked="checked" name="enabled_social_myspace"/> <?php } else { ?> <input type="checkbox" name="enabled_social_myspace"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/twitter.png" title="Twitter" alt="Twitter"/></label> <?php if ($settings->enabled_social_twitter) { ?> <input type="checkbox" checked="checked" name="enabled_social_twitter"/> <?php } else { ?> <input type="checkbox" name="enabled_social_twitter"/> <?php } ?>
<p />
<label class='layout_comments_social'><img src="../images/social/linkedin.png" title="LinkedIn" alt="LinkedIn"/></label> <?php if ($settings->enabled_social_linkedin) { ?> <input type="checkbox" checked="checked" name="enabled_social_linkedin"/> <?php } else { ?> <input type="checkbox" name="enabled_social_linkedin"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>