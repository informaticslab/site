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

<h3><?php echo CMTX_TITLE_PHPINFO ?></h3>
<hr class="title">

<?php
if ($settings->is_demo) {
echo CMTX_MSG_DEMO;
die();
}
?>

<?php
ob_start();
phpinfo();

preg_match ('%<style type="text/css">(.*?)</style>.*?(<body>.*</body>)%s', ob_get_clean(), $matches);

echo "<div class='phpinfodisplay'><style type='text/css'>\n",
    join( "\n",
        array_map(
            create_function(
                '$i',
                'return ".phpinfodisplay " . preg_replace( "/,/", ",.phpinfodisplay ", $i );'
                ),
            preg_split( '/\n/', $matches[1] )
            )
        ),
    "</style>\n",
    $matches[2],
    "\n</div>\n";
?>