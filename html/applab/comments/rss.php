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
require "includes/language/" . $settings->language_frontend . "/rss.php";

if (!$settings->rss_enabled) {
die(CMTX_RSS_FEATURE_DISABLED);
}

if (cmtx_is_administrator()) {} else {
	if (cmtx_in_maintenance()) { //check if under maintenance
		die();
	}
}

header("Content-Type:text/xml; charset=utf-8");

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

if (isset($_GET['id']) && ctype_digit($_GET['id']) && cmtx_strlen($_GET['id']) < 10) { //if page ID is in URL and it validates

	$id = $_GET['id'];
	$id = cmtx_sanitize($id, true, true, true);
	$query = "SELECT * FROM `".$mysql_table_prefix."comments` WHERE is_approved = '1' AND page_id = '$id' ORDER BY dated DESC"; //get page's items

} else {
	$query = "SELECT * FROM `".$mysql_table_prefix."comments` WHERE is_approved = '1' ORDER BY dated DESC"; //get all items
}

/* Last Build Date */
$lbd_query = $query . " LIMIT 1";
$lbd_query = mysql_query($lbd_query);
$lbd_result = mysql_fetch_assoc($lbd_query);
$last_build_date = date("r", strtotime($lbd_result["dated"]));

/* Most Recent */
if ($settings->rss_most_recent_enabled) {
	$query .= " LIMIT " . $settings->rss_most_recent_amount;
}

$result = mysql_query($query);

echo 
'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
	<channel>
		<title>'.$settings->rss_title.'</title>
		<link>'.$settings->rss_link.'</link>
		<description>'.$settings->rss_description.'</description>
		<language>'.$settings->rss_language.'</language>
		<lastBuildDate>'.$last_build_date.'</lastBuildDate>
		<generator>Commentics</generator>
		<ttl>60</ttl>'; //time to live
		if ($settings->rss_image_enabled) {
		echo '
		<image>
			<url>'.$settings->rss_image_url.'</url>
			<title>'.$settings->rss_title.'</title>
			<link>'.$settings->rss_link.'</link>
			<width>'.$settings->rss_image_width.'</width>
			<height>'.$settings->rss_image_height.'</height>
		</image>';
		}

		while ($comments = mysql_fetch_assoc($result)) {
		$pages_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE id = '".$comments["page_id"]."'");
		$pages = mysql_fetch_assoc($pages_query);
		$title = $comments["name"] . CMTX_RSS_COMMENT_POSTER;
		$link = $pages["url"];
		$comment = $comments["comment"];
		$dated = date("r", strtotime($comments["dated"]));
		$guid = $comments["id"];
		echo '
		<item>
			<title><![CDATA['.$title.']]></title>
			<link>'.$link.'</link>
			<description><![CDATA['.$comment.']]></description>
			<pubDate>'.$dated.'</pubDate>
			<guid isPermaLink="false">'.$guid.'</guid>
		</item>';
		}

	echo '
	</channel>
</rss>';
?>