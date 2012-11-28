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
	
require_once "details.php"; //load database details

$database_ok = true;

@$connection = mysql_connect ($mysql_host, $mysql_username, $mysql_password);
if (!$connection) {
	echo "<h3>Commentics</h3>";
	echo "<div style='margin-bottom: 10px;'></div>";
	echo "Sorry, there is a database connection problem.<p />Please check back again shortly .. Thank you!";
	$database_ok = false;
	return;
}

@$database = mysql_select_db ($mysql_database);
if (!$database) {
	echo "<h3>Commentics</h3>";
	echo "<div style='margin-bottom: 10px;'></div>";
	echo "Sorry, there is a database selection problem.<p />Please check back again shortly. Thank you!";
	$database_ok = false;
	return;
}

if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$mysql_table_prefix."comments'")) == 0) {
	if (!defined("IN_INSTALLER")) {
		echo "<h3>Commentics</h3>";
		echo "<div style='margin-bottom: 10px;'></div>";
		echo "Sorry, there is a database tables problem.<p />Please check back again shortly. Thanks!";
		$database_ok = false;
		return;
	}
}

if (function_exists('mysql_set_charset')) {
	mysql_set_charset('utf8');
} else {
	mysql_query("SET NAMES 'UTF8'");
}

?>