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
?>
<html>
<head>
<title>Subscribers</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="noindex"/>
<style type="text/css"><!--
.info, .success, .warning, .error {
border: 1px solid;
margin: 10px 0px;
padding:15px 10px 15px 50px;
background-repeat: no-repeat;
background-position: 10px center;
position: relative;
float: left;
}

.info {
color: #00529B;
background-color: #BDE5F8;
background-image: url('images/messages/information.png');
}

.success {
color: #4F8A10;
background-color: #DFF2BF;
background-image:url('images/messages/success.png');
}

.warning {
color: #9F6000;
background-color: #FEEFB3;
background-image: url('images/messages/warning.png');
}

.error {
color: #D8000C;
background-color: #FFBABA;
background-image: url('images/messages/error.png');
}--></style>
</head>
<body>

<?php
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
require "includes/language/" . $settings->language_frontend . "/subscribers.php";

if (!$settings->enabled_notify) {
die(CMTX_SUB_FEATURE_DISABLED);
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

function validate_token ($entry) { //validate user-supplied GET token

	if (cmtx_strlen($entry) != 20 || !ctype_alnum($entry)) {
		?><div class="error"><?php echo CMTX_INVALID; ?></div><?php
		die();
	}
	
} //end of validate-token function

function sanitize_token ($entry) { //sanitize user-supplied GET token

	$entry = cmtx_sanitize($entry, true, true, true);
	
	return $entry;
	
} //end of sanitize-token function


function validate_action ($entry) { //validate user-supplied GET action

	if ($entry != 1) {
		?><div class="error"><?php echo CMTX_INVALID; ?></div><?php
		die();
	}
	
} //end of validate-action function


if (isset($_GET['uid']) && isset($_GET['confirm']) && !isset($_GET['activate']) && !isset($_GET['unsubscribe'])) { //confirm
	
	$token = $_GET['uid'];
	
	validate_token($token);
	sanitize_token($token);
	validate_action($_GET['confirm']);
	
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token' AND is_confirmed = '0'"))) {
		mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_confirmed='1' WHERE token = '$token'");
		mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_active='1' WHERE token = '$token'");
		mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET last_action = NOW() WHERE token = '$token'");
		?><div class="success"><?php echo CMTX_CONFIRMED; ?></div><?php
		die();
	} else if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token' AND is_confirmed = '1'"))) {
		?><div class="warning"><?php echo CMTX_ALREADY_CONFIRMED; ?></div><?php
		die();
	} else {
		?><div class="error"><?php echo CMTX_NO_SUBSCRIPTION; ?></div><?php
		die();
	}

} else if (isset($_GET['uid']) && !isset($_GET['confirm']) && isset($_GET['activate']) && !isset($_GET['unsubscribe'])) { //activate
	
	$token = $_GET['uid'];
	
	validate_token($token);
	sanitize_token($token);
	validate_action($_GET['activate']);
	
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token' AND is_confirmed = '0'"))) {
		?><div class="error"><?php echo CMTX_NOT_CONFIRMED; ?></div><?php
		die();
	} else if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token' AND is_active = '0'"))) {
		mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_active='1' WHERE token = '$token'");
		mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET last_action = NOW() WHERE token = '$token'");
		?><div class="success"><?php echo CMTX_ACTIVATED; ?></div><?php
		die();
	} else if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token' AND is_active = '1'"))) {
		?><div class="warning"><?php echo CMTX_ALREADY_ACTIVATED; ?></div><?php
		die();
	} else {
		?><div class="error"><?php echo CMTX_NO_SUBSCRIPTION; ?></div><?php
		die();
	}

} else if (isset($_GET['uid']) && !isset($_GET['confirm']) && !isset($_GET['activate']) && isset($_GET['unsubscribe'])) { //unsubscribe
	
	$token = $_GET['uid'];
	
	validate_token($token);
	sanitize_token($token);
	validate_action($_GET['unsubscribe']);	
	
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token'"))) {
		mysql_query("DELETE FROM `".$mysql_table_prefix."subscribers` WHERE token = '$token'");
		?><div class="success"><?php echo CMTX_UNSUBSCRIBED; ?></div><?php
		die();
	} else {
		?><div class="error"><?php echo CMTX_NO_SUBSCRIPTION; ?></div><?php
		die();
	}
	
} else { //invalid
	?><div class="error"><?php echo CMTX_INVALID; ?></div><?php
	die();
}
?>

</body>
</html>