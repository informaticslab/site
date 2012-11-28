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

<h3><?php echo CMTX_TITLE_VERSION ?></h3>
<hr class="title">

<?php echo CMTX_DESC_REPORT_VERSION_1 ?> <b>v<?php echo get_current_version(); ?></b>. <?php echo CMTX_DESC_REPORT_VERSION_2 ?>

<p />

<table id="data" class="display" summary="Versions">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_VERSION ?></th>
			<th><?php echo CMTX_TABLE_TYPE ?></th>
            <th><?php echo CMTX_TABLE_DATE_TIME ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$versions = mysql_query("SELECT * FROM `".$mysql_table_prefix."version` ORDER BY dated DESC");
while ($version = mysql_fetch_assoc($versions)) {
?>
    	<tr>
        	<td><?php echo $version["version"]; ?></td>
			<td><?php echo $version["type"]; ?></td>
            <td><span style="display:none;"><?php echo date("YmdHis", strtotime($version["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($version["dated"])); ?></td>
        </tr>	
<?php } ?>

    </tbody>
</table>