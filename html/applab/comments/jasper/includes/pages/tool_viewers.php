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

<h3><?php echo CMTX_TITLE_VIEWERS ?></h3>
<hr class="title">

<?php echo CMTX_DESC_TOOL_VIEWERS ?>

<p />

<input type="button" class="button" name="refresh" title="<?php echo CMTX_BUTTON_REFRESH ?>" value="<?php echo CMTX_BUTTON_REFRESH ?>" onclick="window.location.reload()"/>

<p />

<?php
if (!$settings->viewers_enabled) {
mysql_query("TRUNCATE TABLE `".$mysql_table_prefix."viewers`");
}
?>

<?php
$timestamp = time();
$timeout = $timestamp - $settings->viewers_timeout;
mysql_query("DELETE FROM `".$mysql_table_prefix."viewers` WHERE timestamp < '$timeout'");
?>

<table id="data" class="display" summary="Viewers">
    <thead>
    	<tr>
			<th><?php echo CMTX_TABLE_TYPE ?></th>
        	<th><?php echo CMTX_TABLE_IP_ADDRESS ?></th>
			<th><?php echo CMTX_TABLE_PAGE_REFERENCE ?></th>
			<th><?php echo CMTX_TABLE_PAGE_URL ?></th>
            <th><?php echo CMTX_TABLE_LAST_ACTIVITY ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$viewers = mysql_query("SELECT * FROM `".$mysql_table_prefix."viewers` ORDER BY timestamp DESC");
while ($viewer = mysql_fetch_assoc($viewers)) {
?>
    	<tr>
        	<?php if (!empty($viewer["user_agent"]) && is_spider($viewer["user_agent"])) { ?> <td><img src="<?php echo "images/viewers/spider.png";?>" class="viewer" title="Spider" alt="Spider"></td> <?php } else { ?> <td><img src="<?php echo "images/viewers/person.png";?>" class="viewer" title="Person" alt="Person"></td> <?php } ?>
			<td><?php echo $viewer["ip_address"]; ?></td>
			<td><?php echo $viewer["page_reference"]; ?></td>
			<td><?php echo "<a href='" . $viewer["page_url"] . "' target='_blank'>" . $viewer["page_url"] . "</a>"; ?></td>
            <td><span style="display:none;"><?php echo $viewer["timestamp"]; ?></span><?php echo date("i\m s\s", $timestamp - $viewer["timestamp"]); ?></td>
        </tr>	
<?php } ?>

    </tbody>
</table>