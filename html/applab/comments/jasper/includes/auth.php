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

session_start();
ob_start();

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }

/* Database connection */
require "../includes/db/connect.php"; //connect to database
if (!$database_ok) { die(); }

/* Get Settings */
require "../includes/classes/settings.php";
$settings = new Settings;

require "includes/language/" . $settings->language_backend . "/login.php"; //load language file for login
require "includes/language/" . $settings->language_backend . "/dashboard.php"; //load language file for dashboard
require "includes/language/" . $settings->language_backend . "/menu.php"; //load language file for menu
require "includes/language/" . $settings->language_backend . "/titles.php"; //load language file for titles
require "includes/language/" . $settings->language_backend . "/descriptions.php"; //load language file for descriptions
require "includes/language/" . $settings->language_backend . "/links.php"; //load language file for links
require "includes/language/" . $settings->language_backend . "/messages.php"; //load language file for messages
require "includes/language/" . $settings->language_backend . "/fields.php"; //load language file for fields
require "includes/language/" . $settings->language_backend . "/notes.php"; //load language file for notes
require "includes/language/" . $settings->language_backend . "/hints.php"; //load language file for hints
require "includes/language/" . $settings->language_backend . "/tables.php"; //load language file for tables
require "includes/language/" . $settings->language_backend . "/buttons.php"; //load language file for buttons
require "includes/language/" . $settings->language_backend . "/prompts.php"; //load language file for prompts

require "includes/functions/general.php"; //load functions

require "../includes/swift_mailer/lib/swift_required.php"; //load Swift Mailer

/* Error Reporting */
if ($settings->error_reporting_admin) { //if error reporting is turned on for admin panel
	@error_reporting(-1); //show every possible error
	if ($settings->error_reporting_method == "log") { //if errors should be logged to file
		@ini_set('display_errors', 0); //don't display errors
		@ini_set("log_errors" , 1); //log errors
		@ini_set("error_log" , "includes/logs/errors.log"); //set log path
	} else { //if errors should be displayed on screen
		@ini_set('display_errors', 1); //display errors
		@ini_set("log_errors" , 0); //don't log errors
	}
} else { //if error reporting is turned off for admin panel
	@error_reporting(0); //turn off all error reporting
	@ini_set('display_errors', 0); //don't display errors
	@ini_set("log_errors" , 0); //don't log errors
}

@date_default_timezone_set($settings->time_zone); //set time zone PHP
@mysql_query("SET time_zone = " . $settings->time_zone); //set time zone DB

if (isset($_POST['username']) && isset($_POST['password'])) {

	if (valid_account($_POST['username'], md5($_POST['password']))) {
	
		$_SESSION['username'] = sanitize($_POST['username']);
		$_SESSION['password'] = sanitize(md5($_POST['password']));
		mysql_query("UPDATE `".$mysql_table_prefix."admins` SET last_login = NOW() WHERE id = '" . get_admin_id() . "'");
		mysql_query("UPDATE `".$mysql_table_prefix."logins` SET dated = NOW() ORDER BY dated ASC LIMIT 1");
		header("Location: index.php?page=dashboard");
		
	} else {
	
		header("Location: index.php?action=attempt");
		
	}
	
} else if (isset($_GET['action']) && $_GET['action'] == "reset") {

	?>
	<html>
	<head>
	<title>Commentics: Reset</title>
	<meta name="robots" content="noindex"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
	<link rel="stylesheet" type="text/css" href="css/general.css"/>
	</head>
	<body onload="document.reset.email.focus();">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<tr>
	<td align="center">
	<form name="reset" id="reset" action="index.php?action=reset" method="post">
	<fieldset style="width:17%;">
	<legend><?php echo CMTX_RESET_FIELDSET ?></legend>
	<span style='float:left;'>
	<?php echo CMTX_RESET_EMAIL ?> <input type="text" name="email"/>
	<br />
	<div style="margin-bottom:5px;"></div>
	<span style='float:left;'>
	<input class='button' type='submit' title='<?php echo CMTX_RESET_BUTTON ?>' value='<?php echo CMTX_RESET_BUTTON ?>'/>
	</span>
	</span>
	</fieldset>
	</form>
	<?php
	if (isset($_POST['email'])) {
	
		if ($settings->is_demo) {
		
			echo "<span class='demo'>" . CMTX_RESET_DEMO . "</span><p />";
		
		} else {

			$email = sanitize($_POST['email']);

			if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE email = '$email'"))) {
			
				$username_query = mysql_query("SELECT username FROM `".$mysql_table_prefix."admins` WHERE email = '$email'");
				$username_result = mysql_fetch_assoc($username_query);
				$username = $username_result["username"];
			
				$password = get_random_key(10);
				
				$reset_password_email_file = "../includes/emails/" . $settings->language_frontend . "/admin/reset_password.txt"; //build path to reset password email file
				$body = file_get_contents($reset_password_email_file); //get the file's contents
				
				$admin_link = $settings->url_to_comments_folder . $settings->admin_folder . "/"; //build admin panel link
				
				//convert email variables with actual variables
				$body = str_ireplace("[username]", $username, $body);
				$body = str_ireplace("[password]", $password, $body);
				$body = str_ireplace("[admin link]", $admin_link, $body);
				
				require "../includes/swift_mailer/create.php"; //create email
				
				//Give the message a subject
				$message->setSubject($settings->admin_reset_password_subject);
	
				//Set the From address
				$message->setFrom(array($settings->admin_reset_password_from_email => $settings->admin_reset_password_from_name));
	
				//Set the Reply-To address
				$message->setReplyTo($settings->admin_reset_password_reply_to);
				
				//Set the To address
				$message->setTo($email);
	
				//Give it a body
				$message->setBody($body);
	
				require "../includes/swift_mailer/options.php"; //set options
	
				//Send the message
				$result = $mailer->send($message);
				
				$password = md5($password);
				
				mysql_query("UPDATE `".$mysql_table_prefix."admins` SET password = '$password' WHERE email = '$email'");
			
				echo "<span class='email_sent'>" . CMTX_RESET_SENT . "</span><p />";
				
			} else {
			
				echo "<span class='email_not_found'>" . CMTX_RESET_ADDR . "</span><p />";
				
			}
		
		}
	
	}
	?>
	<span class="return_login"><a href="index.php?page=dashboard" title="<?php echo CMTX_RESET_LOGIN ?>"><?php echo CMTX_RESET_LOGIN ?></a></span>
	</td>
	</tr>
	</table>
	</body>
	</html>
	<?php
	die();

} else if (isset($_SESSION['username']) && isset($_SESSION['password']) && valid_account($_SESSION['username'], $_SESSION['password'])) {

	//currently logged in, no action required.

} else {

	?>
	<html>
	<head>
	<title>Commentics: Login</title>
	<meta name="robots" content="noindex"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
	<link rel="stylesheet" type="text/css" href="css/general.css"/>
	</head>
	<body onload="document.login.username.focus();">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
	<tr>
	<td align="center">
	<form name="login" id="login" action="index.php" method="post">
	<fieldset style="width:20%;">
	<legend><?php echo CMTX_LOGIN_FIELDSET ?></legend>
	<span style='float:left;'>
	<?php echo CMTX_LOGIN_USERNAME ?> <input type="text" name="username"/>
	<br />
	<?php echo CMTX_LOGIN_PASSWORD ?> <input type="password" name="password"/>
	<br />
	<div style="margin-bottom:5px;"></div>
	<span style='float:left;'>
	<input class='button' type='submit' title='<?php echo CMTX_LOGIN_BUTTON ?>' value='<?php echo CMTX_LOGIN_BUTTON ?>'/>
	</span>
	</span>
	</fieldset>
	</form>
	<?php
	if (isset($_GET['action'])) {
		if ($_GET['action'] == "attempt") {
			echo "<span class='attempt'>" . CMTX_LOGIN_ATTEMPT . "</span><p />";
		} else if ($_GET['action'] == "logout") {
			echo "<span class='logout'>" . CMTX_LOGIN_LOGOUT . "</span><p />";
		}
	}
	?>
	<span class="lost_details"><a href="index.php?action=reset" title="<?php echo CMTX_LOGIN_RESET ?>"><?php echo CMTX_LOGIN_RESET ?></a></span>
	</td>
	</tr>
	</table>
	</body>
	</html>
	<?php
	die();

}
?>