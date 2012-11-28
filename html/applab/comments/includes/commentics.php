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

/*************************************************************** DIRECT ACCESS **********************************************************/
if (!defined("IN_COMMENTICS")) { die("Access Denied."); }
/****************************************************************************************************************************************/


/*************************************************************** FUNCTIONS **************************************************************/
require_once $path_to_comments_folder . "includes/functions/page.php"; //load functions file for page
require_once $path_to_comments_folder . "includes/functions/comments.php"; //load functions file for comments
require_once $path_to_comments_folder . "includes/functions/processor.php"; //load functions file for form processor
require_once $path_to_comments_folder . "includes/functions/form.php"; //load functions file for form design
/****************************************************************************************************************************************/


/*************************************************************** SWIFT MAILER ***********************************************************/
require_once $path_to_comments_folder . "includes/swift_mailer/lib/swift_required.php"; //load Swift Mailer
/****************************************************************************************************************************************/


/*************************************************************** DATABASE (1/2) *********************************************************/
require_once $path_to_comments_folder . "includes/db/connect.php"; //connect to database
if ($database_ok) { //if database connection okay
/****************************************************************************************************************************************/


/*************************************************************** SETTINGS ***************************************************************/
require_once $path_to_comments_folder . "includes/classes/settings.php"; //load class file for settings
$settings = new Settings; //get settings from database
/****************************************************************************************************************************************/


/*************************************************************** LANGUAGE ***************************************************************/
require_once $path_to_comments_folder . "includes/language/" . $settings->language_frontend . "/page.php"; //load language file for page
require_once $path_to_comments_folder . "includes/language/" . $settings->language_frontend . "/comments.php"; //load language file for comments
require_once $path_to_comments_folder . "includes/language/" . $settings->language_frontend . "/processor.php"; //load language file for form processor
require_once $path_to_comments_folder . "includes/language/" . $settings->language_frontend . "/form.php"; //load language file for form design
/****************************************************************************************************************************************/


/*************************************************************** ERROR REPORTING ********************************************************/
if ($settings->error_reporting_frontend) { //if error reporting is turned on for frontend
	@error_reporting(-1); //show every possible error
	if ($settings->error_reporting_method == "log") { //if errors should be logged to file
		@ini_set('display_errors', 0); //don't display errors
		@ini_set("log_errors" , 1); //log errors
		@ini_set("error_log" , $path_to_comments_folder . "includes/logs/errors.log"); //set log path
	} else { //if errors should be displayed on screen
		@ini_set('display_errors', 1); //display errors
		@ini_set("log_errors" , 0); //don't log errors
	}
} else { //if error reporting is turned off for frontend
	@error_reporting(0); //turn off all error reporting
	@ini_set('display_errors', 0); //don't display errors
	@ini_set("log_errors" , 0); //don't log errors
}
/****************************************************************************************************************************************/


/*************************************************************** ADMIN DETECTION ********************************************************/
$is_admin = cmtx_is_administrator(); //detect admin
/****************************************************************************************************************************************/


/*************************************************************** FORM VALUES ************************************************************/
cmtx_load_form_defaults(); //load default values
cmtx_load_form_cookie(); //load cookie values
/****************************************************************************************************************************************/


/*************************************************************** MAINTENANCE (1/2) ******************************************************/
if (!cmtx_in_maintenance()) { //if not in maintenance
/****************************************************************************************************************************************/


/*************************************************************** PAGE ID ****************************************************************/
$page_id = cmtx_validate_page_id(); //validate Page ID
/****************************************************************************************************************************************/


/*************************************************************** TIME ZONE **************************************************************/
@date_default_timezone_set($settings->time_zone); //set time zone PHP
@mysql_query("SET time_zone = " . $settings->time_zone); //set time zone DB
/****************************************************************************************************************************************/


/*************************************************************** UNBAN USER *************************************************************/
cmtx_unban_user(); //unban user if requested
/****************************************************************************************************************************************/


/*************************************************************** LOAD PROCESSOR *********************************************************/
require_once $path_to_comments_folder . "includes/app/processor.php"; //load file for form processor
/****************************************************************************************************************************************/


/*************************************************************** DISPLAY DATA ***********************************************************/
if ($settings->sort_order_parts == "1,2") {
	require_once $path_to_comments_folder . "includes/template/comments.php"; //display comments
	echo "<div class='height_for_divider'></div>"; //display divider
	require_once $path_to_comments_folder . "includes/template/form.php"; //display form
} else {
	require_once $path_to_comments_folder . "includes/template/form.php"; //display form
	echo "<div class='height_for_divider'></div>"; //display divider
	require_once $path_to_comments_folder . "includes/template/comments.php"; //display comments
}
/****************************************************************************************************************************************/


/*************************************************************** VIEWERS ****************************************************************/
if ($settings->viewers_enabled) { //if viewers feature is enabled
	if (!$is_admin) { cmtx_add_viewer(); } //add viewer if not administrator
}
/****************************************************************************************************************************************/


/*************************************************************** TASK SYSTEM ************************************************************/
require_once $path_to_comments_folder . "includes/tasks/tasks.php"; //load task system
/****************************************************************************************************************************************/


/*************************************************************** MAINTENANCE (2/2) ******************************************************/
} //end of if-not-in-maintenance
/****************************************************************************************************************************************/


/*************************************************************** DATABASE (2/2) *********************************************************/
mysql_close($connection); //close connection to database
} //end of is-database-connection-okay
/****************************************************************************************************************************************/

?>