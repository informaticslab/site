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


function sanitize ($entry) { //prepares data for database
    
	$entry = trim($entry); //strip any whitespace from beginning and end of string

	$entry = mysql_real_escape_string($entry); //escape any special characters
		
	return $entry; //return sanitized string
	
} //end of sanitize function


function is_spider ($user_agent) { //is the viewer a search engine spider

	$spider_found = false; //initialise flag as false

	$spiders_file = "../includes/words/spiders.txt"; //build path to spiders file
	
	if (filesize($spiders_file) != 0) { //if file is not empty
		
		$spiders = file($spiders_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($spiders as $spider) { //for each spider
			
			if (stristr($user_agent, $spider)) { //if user agent matches as a spider
				$spider_found = true; //set flag as true
			}
			
		} //end of for-each-spider
	
	} //end of if-file-not-empty

    return $spider_found;
	
} //end of is-spider function


function get_random_key ($length) { //generates a random key

    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $key = "";
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $key;
	
} //end of get-random-key function


function get_current_version() { //gets current version

	global $mysql_table_prefix; //globalise variables

	$current_version_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."version` ORDER BY dated DESC LIMIT 1");
	$current_version_result = mysql_fetch_assoc($current_version_query);
	$current_version = $current_version_result["version"];
	
	return $current_version;

} //end of get-current-version function


function notify_subscribers ($poster, $comment, $comment_id, $page_id) { //notify subscribers of new comment

	global $mysql_table_prefix, $settings; //globalise variables

	//select active subscribers from database
	$subscribers = mysql_query("SELECT * FROM `".$mysql_table_prefix."subscribers` WHERE page_id = '$page_id' AND is_confirmed = '1' AND is_active = '1'");
	
	$page_query = mysql_query("SELECT reference, url FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
	$page_result = mysql_fetch_assoc($page_query);
	$page_reference = $page_result["reference"];
	$page_url = $page_result["url"];
	
	$subscriber_notification_email_file = "../includes/emails/" . $settings->language_frontend . "/user/subscriber_notification.txt"; //build path to subscriber notification email file
	
	$comment = prepare_comment_for_email($comment); //prepare comment for email

	require "../includes/swift_mailer/create.php"; //create email
	
	//Give the message a subject
	$message->setSubject($settings->subscriber_notification_subject);
	
	//Set the From address
	$message->setFrom(array($settings->subscriber_notification_from_email => $settings->subscriber_notification_from_name));
	
	//Set the Reply-To address
	$message->setReplyTo($settings->subscriber_notification_reply_to);
	
	require "../includes/swift_mailer/options.php"; //set options
	
	$count = 0; //count how many emails are sent
	
	while ($subscriber = mysql_fetch_assoc($subscribers)) { //while there are subscribers
	
		$body = file_get_contents($subscriber_notification_email_file); //get the file's contents
		
		$email = $subscriber["email"];
		$name = $subscriber["name"];
		$token = $subscriber["token"];
		
		$activation_link = $settings->url_to_comments_folder . "subscribers.php" . "?uid=" . $token . "&activate=1"; //build activation link
		$unsubscribe_link = $settings->url_to_comments_folder . "subscribers.php" . "?uid=" . $token . "&unsubscribe=1"; //build unsubscribe link

		//convert email variables with actual variables
		$body = str_ireplace("[name]", $name, $body);
		$body = str_ireplace("[page reference]", $page_reference, $body);
		$body = str_ireplace("[page url]", $page_url, $body);
		$body = str_ireplace("[poster]", $poster, $body);
		$body = str_ireplace("[comment]", $comment, $body);
		$body = str_ireplace("[activation link]", $activation_link, $body);
		$body = str_ireplace("[unsubscribe link]", $unsubscribe_link, $body);

		//Set the To address
		$message->setTo(array($email => $name));
		
		//Give it a body
		$message->setBody($body);

		//Send the message
		$result = $mailer->send($message);
		
		$count++; //increment email counter
	
	}
	
	mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_sent='1' WHERE id = '$comment_id'"); //mark comment as sent
	mysql_query("UPDATE `".$mysql_table_prefix."comments` SET sent_to = $count WHERE id = '$comment_id'"); //set how many were sent (if any)
	mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET last_action = NOW() WHERE page_id = '$page_id' AND is_confirmed = '1' AND is_active = '1'"); //update time/date of last action for relevant subscribers
	mysql_query("UPDATE `".$mysql_table_prefix."subscribers` SET is_active='0' WHERE page_id = '$page_id' AND is_confirmed = '1' AND is_active = '1'"); //mark relevant subscribers as inactive
	
} //end of notify-subscribers function


function prepare_comment_for_email ($comment) { //prepares comment for email
	
	$comment = str_ireplace("<br />", "\r\n", $comment);
	$comment = str_ireplace("<p />", "\r\n\r\n", $comment);
	
	$comment = str_ireplace("<li>", "- ", $comment);
	$comment = str_ireplace("</li>", "\r\n", $comment);
	$comment = str_ireplace("\r\n</ul>", "", $comment);
	$comment = str_ireplace("\r\n</ol>", "", $comment);
	
	$comment = strip_tags($comment);
	
	$comment = html_entity_decode($comment, ENT_NOQUOTES, 'UTF-8');
	
	return $comment;
	
} //end of prepare-comment-for-email function


function get_ip_address() { //get IP address
	
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
	
	$ip_address = sanitize($ip_address);
	
	return $ip_address; //return IP address
	
} //end of get-ip-address function


function valid_account ($username, $password) { //check whether account is valid
	
	global $mysql_table_prefix; //globalise variables

	$username = sanitize($username);
	$password = sanitize($password);
	
	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE username = '$username' AND password = '$password' AND is_enabled = '1'"))) {
		return true;
	} else {
		return false;
	}
	
} //end of valid-account function


function get_admin_id() { //get id of administrator
	
	global $mysql_table_prefix; //globalise variables

	$username = $_SESSION['username'];
	
	$admin_id_query = mysql_query("SELECT id FROM `".$mysql_table_prefix."admins` WHERE username = '$username'");
	$admin_id_result = mysql_fetch_assoc($admin_id_query);
	$admin_id = $admin_id_result["id"];	
	
	return $admin_id;
	
} //end of get-admin-id function


function tip_of_the_day() { //get an admin tip
	
	$admin_tips = file('../includes/words/admin_tips.txt');
	
	$amount = count($admin_tips);
	
	$day = date('z');
 
    $position = (int) $day % $amount;
	
    $tip = $admin_tips[$position];

	return $tip;

} //end of tip-of-the-day function


function delete_replies($id) { //delete replies of given comment
	
	global $mysql_table_prefix;
	
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '$id'");
	
	while ($comments = mysql_fetch_assoc($query)) {
	
		$id = $comments["id"];
	
		mysql_query("DELETE FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	
		delete_replies($id);
	
	}

} //end of delete-replies function


function unapprove_replies($id) { //unapprove replies of given comment
	
	global $mysql_table_prefix;
	
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '$id'");
	
	while ($comments = mysql_fetch_assoc($query)) {
	
		$id = $comments["id"];

		mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_approved = '0' WHERE id = '$id'");
	
		unapprove_replies($id);
	
	}

} //end of unapprove-replies function
?>