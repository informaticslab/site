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

require $_SERVER['DOCUMENT_ROOT'].'/configuration.php';
$joomla_config = new JConfig();

	
//ENTER DATABASE INFORMATION HERE*****************************************************
$mysql_database = "AppComments";		// The name of the database you created
$mysql_username = $joomla_config->app_comments_user; 				// Your MySQL username
$mysql_password = $joomla_config->app_comments_pass;			 	// Your MySQL password
$mysql_host = "localhost";			// Usually 'localhost'. Can also be an IP address.
$mysql_table_prefix = "apps_";			// In most cases leave blank.
//************************************************************************************

?>