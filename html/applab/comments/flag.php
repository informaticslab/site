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

//load Swift Mailer
require "includes/swift_mailer/lib/swift_required.php";

if (!$settings->show_flag) {
die();
}

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

echo "<img src='" . $settings->url_to_comments_folder . "images/buttons/flag.png' alt='Flag' title='" . CMTX_TITLE_FLAG . "'/>" . CMTX_FLAG;

if (isset($_POST['id']) && isset($_GET["reason"])) {

	$id = $_POST['id'];
	$id = str_ireplace("flag_", "", $id);
	$id = cmtx_sanitize($id, true, true, true);
	
	$reason = $_GET["reason"];
	$reason = cmtx_sanitize($reason, true, true, true);
	
	//check reason
	if (empty($reason)) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_NO_REASON . "');</script>";
		die();
	} else {
		$reason = substr($reason, 0, 100);
	}

	//check if comment exists
	$query = mysql_query("SELECT id FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	$count = mysql_num_rows($query);
	if ($count == 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_NO_COMMENT . "');</script>";
		die();
	}
	
	//check if user is reporting own comment
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."comments` WHERE id = '$id' and ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_OWN_COMMENT . "');</script>";
		die();
	}
	
	//check if user has submitted a bad report
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."reports` WHERE status = 'bad' AND ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_BAD_REPORT . "');</script>";
		die();
	}
	
	//check if user is banned
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."bans` WHERE ip_address = '$ip_address'");
	$count = mysql_num_rows($query);
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_BANNED . "');</script>";
		die();
	}
	
	//check how many reports user has submitted
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."reports` WHERE (status = 'pending' OR status = 'fair') AND ip_address = '$ip_address'");
	$count = mysql_num_rows($query);

	if ($count >= $settings->flag_max_per_user) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_REPORT_LIMIT . "');</script>";
		die();
	}
	
	//check if user has already reported this comment
	$query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND ip_address = '$ip_address' AND comment_id = '$id'");
	$count = mysql_num_rows($query);

	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_ALREADY_REPORTED . "');</script>";
		die();
	}
	
	//check if comment has already been flagged
	$query = mysql_query("SELECT comment_id FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
	$count = mysql_num_rows($query);
	
	if ($count >= $settings->flag_min_per_comment) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_ALREADY_FLAGGED . "');</script>";
		die();
	}
	
	//check if comment has already been verified
	$query = mysql_query("SELECT comment_id FROM `".$mysql_table_prefix."reports` WHERE status != 'pending' AND comment_id = '$id'");
	$count = mysql_num_rows($query);
	
	if ($count > 0) {
		echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_ALREADY_VERIFIED . "');</script>";
		die();
	}
	
	//report comment
	
	mysql_query("INSERT INTO `".$mysql_table_prefix."reports` (comment_id, ip_address, status, reason, dated) values ('$id', '$ip_address', 'pending', '$reason', NOW())");
	
	echo "<script language='javascript' type='text/javascript'>alert('" . CMTX_FLAG_REPORT_SENT . "');</script>";
	
	
	//check if comment should be flagged
	$query = mysql_query("SELECT comment_id FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
	$count = mysql_num_rows($query);
	
	if ($count == $settings->flag_min_per_comment) {
		
		if ($settings->flag_disapprove) {
			mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_approved = '0' WHERE id = '$id'");
			cmtx_unapprove_replies($id);
		}
		
		mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_flagged = '1' WHERE id = '$id'");
		
		//send email
		
		$admin_new_comment_flag_email_file = "includes/emails/" . $settings->language_frontend . "/admin/new_flag.txt"; //build path to admin new flag email file
		$body = file_get_contents($admin_new_comment_flag_email_file); //get the file's contents
		
		$comment_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
		$comment_result = mysql_fetch_assoc($comment_query);
		
		$page_id = $comment_result["page_id"];
		
		$page_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
		$page_result = mysql_fetch_assoc($page_query);
		
		$reasons = "";
		$reasons_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
		while ($reports = mysql_fetch_assoc($reasons_query)) {
			$reasons .= "- " . $reports["reason"] . "\r\n";
		}
		$reasons = substr_replace($reasons, "", -2); //remove ending line break
		
		$page_reference = $page_result["reference"];
		$page_url = $page_result["url"];
		$poster = $comment_result["name"];
		$comment = cmtx_prepare_comment_for_email($comment_result["comment"]);
		$admin_link = $settings->url_to_comments_folder . $settings->admin_folder . "/"; //build admin panel link
		
		//convert email variables with actual variables
		$body = str_ireplace("[page reference]", $page_reference, $body);
		$body = str_ireplace("[page url]", $page_url, $body);
		$body = str_ireplace("[poster]", $poster, $body);
		$body = str_ireplace("[comment]", $comment, $body);
		$body = str_ireplace("[flag reasoning]", $reasons, $body);
		$body = str_ireplace("[admin link]", $admin_link, $body);
		
		require "includes/swift_mailer/create.php"; //create email
		
		//Give the message a subject
		$message->setSubject($settings->admin_new_flag_subject);
		
		//Set the From address
		$message->setFrom(array($settings->admin_new_flag_from_email => $settings->admin_new_flag_from_name));
		
		//Set the Reply-To address
		$message->setReplyTo($settings->admin_new_flag_reply_to);
		
		//Give it a body
		$message->setBody($body);
		
		require "includes/swift_mailer/options.php"; //set options
		
		//select administrators from database
		$admins = mysql_query("SELECT email FROM `".$mysql_table_prefix."admins` WHERE receive_email_new_flag = '1' AND is_enabled = '1'");
		
		while ($admin = mysql_fetch_assoc($admins)) { //while there are administrators
	
			$email = $admin["email"]; //get administrator email address
	
			//Set the To address
			$message->setTo($email);
		
			//Send the message
			$result = $mailer->send($message);
		
		}
		
	}

}