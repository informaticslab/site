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


function cmtx_strip ($value) { //strip slashes

	if (is_array($value)) {
		$value = array_map('cmtx_strip', $value);
	} else if (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value->{$key} = cmtx_strip($data);
		}
	} else {
		$value = stripslashes($value);
	}
	
	return $value;
	
} //end of strip function


function cmtx_decode ($value) { //decode

	$value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
	
	return $value;
	
} //end of decode function


function cmtx_validate_page_id() { //validate page ID

	global $mysql_table_prefix, $page_id, $reference, $parameters; //globalise variables

	if (!isset($page_id) || empty($page_id)) { //if no page ID
	
		?><span class="page_id_alert"><?php	echo CMTX_ALERT_MESSAGE_NO_PAGE_ID;?></span><?php
		die();
		
	} else if (cmtx_strlen($page_id) < 250) { //if page ID validates
	
		//get URL
		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$url = urldecode($url);
		$url = strtolower($url);
		
		//remove URL parameters if configured
		if (isset($parameters)) {
			if (empty($parameters) || $parameters == "none") {
				$url = strtok($url, "?");
			} else {
				$queries = explode(",", $parameters);
				$query_string = "";
				foreach ($queries as $query) {
					if (isset($_GET[$query])) { $query_string .= $query . "=" . $_GET[$query] . "&"; } else { die(); }
				}
				if (preg_match('/[&$]/', $query_string)) {
					$query_string = substr($query_string, 0, -1);
				}
				$url = strtok($url, "?");
				$url .= "?" . $query_string;
			}
		}
		
		//ensure reference is set
		if (!isset($reference)) {
			$reference = "";
		}
	
		//get page title
		if ($page_id == "cmtx_title" || $reference == "cmtx_title") {
			if (cmtx_get_ip_address() == "127.0.0.1") { //if on localhost
				$path = $_SERVER['SCRIPT_FILENAME'];
			} else {
				$path = $url;
			}
			if ((bool)ini_get('allow_url_fopen')) {
				$file = file_get_contents($path);
			} else if (function_exists('curl_version') && is_callable('curl_version') && cmtx_get_ip_address() != "127.0.0.1") { //if cURL is available and not on localhost
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_URL, $path);
				$file = curl_exec($ch);
				curl_close($ch);
			}
			if (isset($file)) {
				if (preg_match("/<title>(.+)<\/title>/i", $file, $match)) {
					if ($page_id == "cmtx_title") { $page_id = $match[1]; }
					if ($reference == "cmtx_title") { $reference = $match[1]; }
				} else {
					if ($page_id == "cmtx_title") { $page_id = "Title not found"; }
					if ($reference == "cmtx_title") { $reference = "Title not found"; }
				}
			} else {
				if ($page_id == "cmtx_title") { $page_id = "Server incapable"; }
				if ($reference == "cmtx_title") { $reference = "Server incapable"; }
			}
		}
		
		//get page filename
		if ($page_id == "cmtx_filename" || $reference == "cmtx_filename") {
			if (isset($_SERVER['SCRIPT_NAME'])) {
				if ($page_id == "cmtx_filename") { $page_id = $_SERVER['SCRIPT_NAME']; }
				if ($reference == "cmtx_filename") { $reference = basename($_SERVER['SCRIPT_NAME']); }
			} else {
				if ($page_id == "cmtx_filename") { $page_id = "Server incapable"; }
				if ($reference == "cmtx_filename") { $reference = "Server incapable"; }
			}
		}
		
		//set page ID as reference
		if ($page_id == "cmtx_reference") {
			$page_id = $reference;
		}
		
		//set reference as page ID
		if ($reference == "cmtx_id") {
			$reference = $page_id;
		}
		
		//set reference as URL
		if ($reference == "cmtx_url") {
			$reference = $url;
		}
		
		//set page ID as URL
		if ($page_id == "cmtx_url") {
			$page_id = $url;
			$page_id = str_ireplace("www.", "", $page_id); //remove 'www.' if there
			$page_id = str_ireplace("index.php", "", $page_id); //remove 'index.php' if there
			$page_id = str_ireplace("index.htm", "", $page_id); //remove 'index.htm' if there
			$page_id = str_ireplace("index.html", "", $page_id); //remove 'index.html' if there
			$page_id = str_ireplace("index.shtml", "", $page_id); //remove 'index.shtml' if there
			$page_id = str_ireplace("https://", "http://", $page_id); //remove ssl if there
		}
	
		//sanitize data
		$page_id = cmtx_sanitize($page_id, true, true, true);
		$reference = cmtx_sanitize($reference, true, true, true);
		$url = cmtx_sanitize($url, true, true, true);
	
		if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE custom_id = '$page_id'"))) { //if ID is found and is custom
		
			$real_id_query = mysql_query("SELECT id FROM `".$mysql_table_prefix."pages` WHERE custom_id = '$page_id'"); //get real non-custom ID
			$real_id_result = mysql_fetch_assoc($real_id_query);
			$page_id = $real_id_result["id"];
			return $page_id;
			
		} else if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'"))) { //if ID is found and is not custom
		
			return $page_id;
			
		} else { //create page
			
			mysql_query("INSERT INTO `".$mysql_table_prefix."pages` (custom_id, reference, url, is_form_enabled, dated) VALUES ('$page_id', '$reference', '$url', 1, NOW())");
			
			return mysql_insert_id();
			
		}
		
	} else { //page ID did not validate
	
		?><span class="page_id_alert"><?php	echo CMTX_ALERT_MESSAGE_INVALID_PAGE_ID;?></span><?php
		die();
		
	}
	
} //end of validate-page-id function


function cmtx_get_page_reference() { //get page reference

	global $mysql_table_prefix, $page_id; //globalise variables

	$page_reference_query = mysql_query("SELECT reference FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
	$page_reference_result = mysql_fetch_assoc($page_reference_query);
	$page_reference = $page_reference_result["reference"];
	
	return $page_reference;
	
} //end of get-page-reference function


function cmtx_get_page_url() { //get page url

	global $mysql_table_prefix, $page_id; //globalise variables

	$page_url_query = mysql_query("SELECT url FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
	$page_url_result = mysql_fetch_assoc($page_url_query);
	$page_url = strtolower($page_url_result["url"]);
	
	return $page_url;
	
} //end of get-page-url function


function cmtx_sanitize ($entry, $stage_one, $stage_two, $stage_three) { //prepares data for database
    
	$entry = trim($entry); //strip any whitespace from beginning and end of string
	
	if ($stage_one) {
		$entry = strip_tags($entry); //strip any tags from string
	}

	if ($stage_two) {
		$entry = htmlentities($entry, ENT_NOQUOTES, 'UTF-8'); //convert any applicable characters, except quotes, to HTML entities
	}

	if ($stage_three) {
		$entry = mysql_real_escape_string($entry); //escape any special characters
	}
		
	return $entry; //return sanitized string
	
} //end of sanitize function


function cmtx_get_ip_address() { //get IP address
	
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
    } else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		} else {
			$ip_address = getenv('REMOTE_ADDR');
		}
    }
	
	$ip_address = cmtx_sanitize($ip_address, true, true, true);
	
	return $ip_address; //return IP address
	
} //end of get-ip-address function


function cmtx_get_user_agent() { //get user agent
	
	if (isset($_SERVER['HTTP_USER_AGENT']) && cmtx_strlen($_SERVER['HTTP_USER_AGENT']) < 250) {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = cmtx_sanitize($user_agent, true, true, true);
	} else {
		$user_agent = "";
	}
	
	return $user_agent; //return user agent
	
} //end of get-user-agent function


function cmtx_in_maintenance() { //check if in maintenance mode

	global $settings, $is_admin; //globalise variables

	if ($settings->maintenance_mode && !$is_admin) {
		?><h3>Commentics</h3>
		<div style="margin-bottom: 10px;"></div>
		<span class="maintenance_message"><?php
		echo $settings->maintenance_message;
		?></span><?php
		return true;
	} else {
		return false;
	}
	
} //end of in-maintenance function


function cmtx_is_administrator() { //is the user the administrator
	
	global $mysql_table_prefix; //globalise variables
	
	//initialise values
	$administrator_found = false;
	$admin_ip_address_found = false;
	$admin_cookie_found = false;
	$detect_admin = false;
	$detect_method = "both";
	
	//check ip address
	$ip_address = cmtx_get_ip_address();
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE ip_address = '$ip_address' AND is_enabled = '1'"))) {
		$admin_ip_address_found = true; //set ip address flag as true
	}
	
	//check cookie
	if (isset($_COOKIE['Commentics-Admin']) && $_COOKIE['Commentics-Admin'] < 250) {
		$cookie_value = cmtx_sanitize($_COOKIE['Commentics-Admin'], true, true, true);
		if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE cookie_key = '$cookie_value' AND is_enabled = '1'"))) {
			$admin_cookie_found = true; //set cookie flag as true
		}
	}
	
	//get detection settings
	if ($admin_ip_address_found || $admin_cookie_found) {
	
		if ($admin_ip_address_found) {
		
			$detection_settings = mysql_query("SELECT detect_admin, detect_method FROM `".$mysql_table_prefix."admins` WHERE ip_address = '$ip_address' AND is_enabled = '1' LIMIT 1");
			$detection_settings = mysql_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings["detect_admin"];
			$detect_method = $detection_settings["detect_method"];
		
		} else {
		
			$detection_settings = mysql_query("SELECT detect_admin, detect_method FROM `".$mysql_table_prefix."admins` WHERE cookie_key = '$cookie_value' AND is_enabled = '1' LIMIT 1");
			$detection_settings = mysql_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings["detect_admin"];
			$detect_method = $detection_settings["detect_method"];		
		
		}
	
	}
	
	if ($detect_admin) { //if administrator should be detected
	
		if ($detect_method == "ip_address") {
			if ($admin_ip_address_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "cookie") {
			if ($admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "either") {
			if ($admin_ip_address_found || $admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "both") {
			if ($admin_ip_address_found && $admin_cookie_found) {
				$administrator_found = true;
			}
		}
	
	}
	
	return $administrator_found;
	
} //end of is-administrator function


function cmtx_prepare_name_for_email ($name) { //prepares name for email
	
	$name = cmtx_strip($name);
	
	$name = strip_tags($name);
	
	$name = cmtx_decode($name);
	
	return $name;
	
} //end of prepare-name-for-email function


function cmtx_prepare_email_for_email ($email) { //prepares email address for email
	
	$email = cmtx_strip($email);
	
	$email = strip_tags($email);
	
	$email = cmtx_decode($email);
	
	return $email;
	
} //end of prepare-email-for-email function


function cmtx_prepare_comment_for_email ($comment) { //prepares comment for email
	
	$comment = cmtx_strip($comment);
	
	$comment = str_ireplace("<br />", "\r\n", $comment);
	$comment = str_ireplace("<p />", "\r\n\r\n", $comment);
	
	$comment = str_ireplace("<li>", "- ", $comment);
	$comment = str_ireplace("</li>", "\r\n", $comment);
	$comment = str_ireplace("\r\n</ul>", "", $comment);
	$comment = str_ireplace("\r\n</ol>", "", $comment);
	
	$comment = strip_tags($comment);
	
	$comment = cmtx_decode($comment);
	
	return $comment;
	
} //end of prepare-comment-for-email function





function cmtx_get_random_key ($length) { //generates a random key

    $characters = "0123456789abcdefghijklmnopqrstuvwxyz"; //allowed characters
    $key = "";
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[mt_rand(0, cmtx_strlen($characters)-1)];
    }

    return $key;
	
} //end of get-random-key function


function cmtx_add_viewer() { //add viewer to database

	global $mysql_table_prefix, $settings; //globalise variables

	$ip_address = cmtx_get_ip_address();
	$user_agent = cmtx_get_user_agent();
	$page_reference = cmtx_get_page_reference();
	$page_url = cmtx_get_page_url();
	
	$timestamp = time();
	$timeout = $timestamp - $settings->viewers_timeout;
	
	mysql_query("DELETE FROM `".$mysql_table_prefix."viewers` WHERE timestamp < '$timeout'");
	mysql_query("DELETE FROM `".$mysql_table_prefix."viewers` WHERE ip_address = '$ip_address'");
	mysql_query("INSERT INTO `".$mysql_table_prefix."viewers` (user_agent, ip_address, page_reference, page_url, timestamp) VALUES ('$user_agent', '$ip_address', '$page_reference', '$page_url', '$timestamp')");

} //end of add-viewer function


function cmtx_get_query ($type) { //gets query string from url

	if ($type == "pagination" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "&" . $_SERVER['QUERY_STRING'];
	} else if ($type == "form" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "?" . $_SERVER['QUERY_STRING'];
	} else if ($type == "sort" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "&" . $_SERVER['QUERY_STRING'];
	} else {
		$query = "";
	}
	
	$query = preg_replace("/&cmtx_page=[0-9]*/", "", $query);
	$query = preg_replace("/cmtx_page=[0-9]*&/", "", $query);
	$query = preg_replace("/cmtx_page=[0-9]*/", "", $query);
	
	if ($type != "pagination") {
		$query = preg_replace("/&cmtx_sort=[0-9]*/", "", $query);
		$query = preg_replace("/cmtx_sort=[0-9]*&/", "", $query);
		$query = preg_replace("/cmtx_sort=[0-9]*/", "", $query);
	}
	
	if (!strstr($query, '=')) {
		$query = str_replace("?", "", $query);
	}
	
	$query = htmlentities($query);

	return $query;

} //end of get-query function


function cmtx_unban_user() { //unban user if requested

	global $mysql_table_prefix; //globalise variables

	$bans = mysql_query("SELECT * FROM `".$mysql_table_prefix."bans` WHERE unban = '1'");
	
	while ($ban = mysql_fetch_assoc($bans)) {
	
		if (cmtx_get_ip_address() == $ban['ip_address']) {
			@setcookie("Commentics-Ban", "", time() - 3600, '/');
			mysql_query("DELETE FROM `".$mysql_table_prefix."bans` WHERE id = '".$ban['id']."'");
		}
		
	}

} //end of unban-user function


function cmtx_strlen($entry) { //get length of string

	if (function_exists('mb_strlen') && is_callable('mb_strlen')) {
		$length = mb_strlen($entry, 'UTF-8');
	} else {
		$length = strlen(utf8_decode($entry));
	}
	
	return $length;

} //end of strlen function


function cmtx_unapprove_replies($id) { //unapprove replies of given comment
	
	global $mysql_table_prefix;
	
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '$id'");
	
	while ($comments = mysql_fetch_assoc($query)) {
	
		$id = $comments["id"];

		mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_approved = '0' WHERE id = '$id'");
	
		cmtx_unapprove_replies($id);
	
	}

} //end of unapprove-replies function
?>