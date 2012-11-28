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

<h3><?php echo CMTX_TITLE_OPTIMIZE_TABLES ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$all_tables = mysql_query("SHOW TABLES");

while ($table = mysql_fetch_assoc($all_tables)) {
	foreach ($table as $db => $table_name) {
		mysql_query("OPTIMIZE TABLE ‘".$table_name."‘");
	}
}
?>
<div class="success"><?php echo CMTX_MSG_OPTIMIZED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_TOOL_OPTIMIZE_TABLES ?>

<p />

<?php $settings = new Settings; ?>

<form name="optimize_tables" id="optimize_tables" action="index.php?page=tool_optimize_tables" method="post">
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_OPTIMIZE ?>" value="<?php echo CMTX_BUTTON_OPTIMIZE ?>"/>
</form>