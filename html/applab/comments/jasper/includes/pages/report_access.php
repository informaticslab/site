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

<h3><?php echo CMTX_TITLE_ACCESS ?></h3>
<hr class="title">

<?php echo CMTX_DESC_REPORT_ACCESS ?>

<p />

<table id="data" class="display" summary="Access">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_ADMIN_ID ?></th>
			<th><?php echo CMTX_TABLE_USERNAME ?></th>
            <th><?php echo CMTX_TABLE_IP_ADDRESS ?></th>
			<th><?php echo CMTX_TABLE_PAGE ?></th>
			<th><?php echo CMTX_TABLE_DATE_TIME ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$access_log = mysql_query("SELECT * FROM `".$mysql_table_prefix."access` ORDER BY dated DESC");
while ($access = mysql_fetch_assoc($access_log)) {
?>
    	<tr>
        	<td><?php echo $access["admin_id"]; ?></td>
			<td><?php echo $access["username"]; ?></td>
			<td><?php if ($settings->is_demo) { echo "(<i>" . CMTX_TABLE_IP_HIDDEN . "</i>)"; } else { echo $access["ip_address"]; } ?></td>
			<td><?php echo $access["page"]; ?></td>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($access["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($access["dated"])); ?></td>
        </tr>	
<?php } ?>

    </tbody>
</table>