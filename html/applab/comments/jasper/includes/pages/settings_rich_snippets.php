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

<h3><?php echo CMTX_TITLE_RICH_SNIPPETS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['rich_snippets'])) { $rich_snippets = 1; } else { $rich_snippets = 0; }
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$rich_snippets' WHERE title = 'rich_snippets'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_RICH_SNIPPETS_1 ?>

<p />

<img src="images/rich_snippets/example_review.png" title="Example Review" alt="Example Review"/>

<p />

<?php echo CMTX_DESC_SETTINGS_RICH_SNIPPETS_2 ?>

<p />

<pre>
<?php
echo "<span style='color:red;'>";
echo htmlentities("<div class=\"hreview-aggregate\">");
echo "<br />";
echo htmlentities("<span class=\"item\">");
echo "<br />";
echo htmlentities("<span class=\"fn\">Pizza Suprema</span>");
echo "<br />";
echo htmlentities("</span>");
echo "</span>";
echo "<br />";
echo htmlentities("<span class=\"rating\">");
echo "<br />";
echo htmlentities("<span class=\"average\">5</span>");
echo "<br />";
echo htmlentities("</span>");
echo "<br />";
echo htmlentities("<span class=\"votes\">39</span>");
echo "<br />";
echo htmlentities("</div>");
?>
</pre>

<p />

<?php echo CMTX_DESC_SETTINGS_RICH_SNIPPETS_3 ?>

<?php $settings = new Settings; ?>

<form name="settings_rich_snippets" id="settings_rich_snippets" action="index.php?page=settings_rich_snippets" method="post">
<label class='settings_rich_snippets'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->rich_snippets) { ?> <input type="checkbox" checked="checked" name="rich_snippets"/> <?php } else { ?> <input type="checkbox" name="rich_snippets"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>