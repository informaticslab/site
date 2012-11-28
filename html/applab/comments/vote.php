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

define ('IN_COMMENTICS', '1');

/* Database Connection */
require "includes/db/connect.php"; //connect to database
if (!$database_ok) { die(); }

//get settings
require "includes/classes/settings.php";
$settings = new Settings;

//load functions file
require "includes/functions/page.php";

//load language file
require "includes/language/" . $settings->language_frontend . "/comments.php";

if (cmtx_is_administrator()) {} else {
	if (cmtx_in_maintenance()) { //check if under maintenance
		die();
	}
}

/* Error Reporting */
if ($settings->error_reporting_frontend) { //if error reporting is turned on for frontend
	@error_reporting(-1); //show every possible error
	if ($settings->error_reporting_method == "log") { //if errors should be logged to file
		@ini_set('display_errors', 0); //don't display errors
		@ini_set("log_errors" , 1); //log errors
		@ini_set("error_log" , "includes/logs/errors.log"); //set log path
	} else { //if errors should be displayed on screen
		@ini_set('display_errors', 1); //display errors
		@ini_set("log_errors" , 0); //don't log errors
	}
} else { //if error reporting is turned off for frontend
	@error_reporting(0); //turn off all error reporting
	@ini_set('display_errors', 0); //don't display errors
	@ini_set("log_errors" , 0); //don't log errors
}

/* Time Zone */
@date_default_timezone_set($settings->time_zone); //set time zone PHP
@mysql_query("SET time_zone = " . $settings->time_zone); //set time zone DB

$ip_address = cmtx_get_ip_address(); //get user's ip address

if (isset($_POST['id']) && isset($_GET["type"])) {

	$id = $_POST['id'];
	$id = str_ireplace("vote_up_", "", $id);
	$id = str_ireplace("vote_down_", "", $id);
	$id = cmtx_sanitize($id, true, true, true);
	
	$issue = false;
	
	//check if comment exists
	$query = mysql_query("SELECT id FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	$count = mysql_num_rows($query);
	if ($count == 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_NO_COMMENT . "');</script>";
		$issue = true;
	}
	
	//check if user is voting own comment
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."comments` WHERE id = '$id' and ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_OWN_COMMENT . "');</script>";
		$issue = true;
	}

	//check if user has already voted
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."voters` WHERE comment_id = '$id' and ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_ALREADY_VOTED . "');</script>";
		$issue = true;
	}
	
	//check if user is banned
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."bans` WHERE ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_BANNED . "');</script>";
		$issue = true;
	}

	if (!$issue) {
	
		if ($_GET["type"] == "up" && $settings->show_like) {
		
			mysql_query("UPDATE `".$mysql_table_prefix."comments` SET vote_up = vote_up + 1 WHERE id = '$id'");
			mysql_query("INSERT INTO `".$mysql_table_prefix."voters` (comment_id, ip_address, dated) values ('$id', '$ip_address', NOW())");
			
			if ($settings->js_vote_ok) {
				echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_UP . "');</script>";
			}

		} else if ($_GET["type"] == "down" && $settings->show_dislike) {
		
			mysql_query("UPDATE `".$mysql_table_prefix."comments` SET vote_down = vote_down + 1 WHERE id = '$id'");
			mysql_query("INSERT INTO `".$mysql_table_prefix."voters` (comment_id, ip_address, dated) values ('$id', '$ip_address', NOW())");

			if ($settings->js_vote_ok) {
				echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_VOTE_DOWN . "');</script>";
			}
			
		}
		
	}
	
	if ($_GET["type"] == "up") {
	
		$result = mysql_query("SELECT vote_up FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
		$row = mysql_fetch_array($result);
		$vote_up = $row['vote_up'];
		echo "<img src='" . $settings->url_to_comments_folder . "images/buttons/up.png' alt='Up' title='" . CMTX_TITLE_VOTE_UP . "'/>" . $vote_up;
	
	} else if ($_GET["type"] == "down") {
	
		$result = mysql_query("SELECT vote_down FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
		$row = mysql_fetch_array($result);
		$vote_down = $row['vote_down'];
		echo "<img src='" . $settings->url_to_comments_folder . "images/buttons/down.png' alt='Down' title='" . CMTX_TITLE_VOTE_DOWN . "'/>" . $vote_down;
		
	}

}