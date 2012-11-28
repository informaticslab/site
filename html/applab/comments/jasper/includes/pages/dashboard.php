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
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<?php
if (isset($_POST['submit_checklist'])) {
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '1' WHERE title = 'checklist_complete'");
}
?>

<?php if (!$settings->checklist_complete && !isset($_POST['submit_checklist'])) { ?>
<h3><?php echo CMTX_TITLE_CHECKLIST ?></h3>
<hr class="title">

<p />

Welcome to Commentics - here is a checklist to help get you started:

<ul>
<li>Check File Permissions (<b>Reports</b> -> <b>Permissions</b>)</li>
<li>Add the Admin Cookie (<b>Settings</b> -> <b>Admin Detection</b>)</li>
<li>Select Email Method (<b>Setttings</b> -> <b>Email</b> -> <b>Method</b>)</li>
<li>View Email Signature (<b>Setttings</b> -> <b>Email</b> -> <b>Editor</b>)</li>
</ul>

Tip: To manually approve all comments go to <b>Settings</b> -> <b>Approval</b>.

<p />

You can return to this checklist at any time by going to the dashboard.

<p />

<form name="checklist" id="checklist" action="index.php?page=dashboard" method="post">
<input type="submit" class="button" name="submit_checklist" title="<?php echo CMTX_BUTTON_COMPLETED ?>" value="<?php echo CMTX_BUTTON_COMPLETED ?>"/>
</form>

<?php } else { ?>
<h3><?php echo CMTX_TITLE_DASHBOARD ?></h3>
<hr class="title">

<p />

<div class="dashboard_left">

<div class="dashboard_block">
<div class="dashboard_title"><?php echo CMTX_DASH_VERSION_CHECK ?></div>
<div class="dashboard_content">
<?php
$version_url = "http://www.commentics.org/version.txt";
$latest_version = "";
$issue = false;

if (function_exists('curl_version') && is_callable('curl_version')) { //if cURL is available
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_URL, $version_url);
	$latest_version = curl_exec($ch);
	curl_close($ch);
} else if ((bool)ini_get('allow_url_fopen')) {
	$latest_version = file_get_contents($version_url);
} else {
	?><span class='negative'><?php echo CMTX_DASH_VERSION_CHECK_UNABLE ?></span><?php
	$issue = true;
}

if (!$issue) {
	if (floatval($latest_version)) {
		if (version_compare(get_current_version(), $latest_version, '<')) {
			?><span class='negative'><?php echo CMTX_DASH_VERSION_CHECK_NEWER ?></span><?php
		} else {
			?><span class='positive'><?php echo CMTX_DASH_VERSION_CHECK_LATEST ?></span><?php
		}
	} else {
		?><span class='negative'><?php echo CMTX_DASH_VERSION_CHECK_ISSUE ?></span><?php
		$issue = true;
	}
}
?>
</div>
</div>

<div class="dashboard_block">
<div class="dashboard_title"><?php echo CMTX_DASH_LAST_LOGIN ?></div>
<div class="dashboard_content">
<?php
$last_login_query = mysql_query("SELECT dated FROM `".$mysql_table_prefix."logins` ORDER BY dated ASC LIMIT 1");
$last_login_result = mysql_fetch_assoc($last_login_query);
$last_login = $last_login_result["dated"];
?>
<?php echo CMTX_DASH_LAST_LOGIN_AT ?> <?php echo date("g:ia", strtotime($last_login))?> <?php echo CMTX_DASH_LAST_LOGIN_ON ?> <?php echo date("l jS F Y", strtotime($last_login))?>.
</div>
</div>

<div class="dashboard_block">
<div class="dashboard_title"><?php echo CMTX_DASH_STATISTICS ?></div>
<div class="dashboard_content">
<?php
$approve_comments_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."comments` WHERE is_approved = '0'";
$approve_comments_result = mysql_query($approve_comments_query);
$r = mysql_fetch_row($approve_comments_result);
$approve_comments = $r[0];

$flagged_comments_query = mysql_query("SELECT id FROM `".$mysql_table_prefix."comments` WHERE is_flagged = '1'");
$flagged_comments = mysql_num_rows($flagged_comments_query);

$today = date("Y-m-d");

$new_comments_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."comments` WHERE dated LIKE '".$today."%'";
$new_comments_result = mysql_query($new_comments_query);
$r = mysql_fetch_row($new_comments_result);
$new_comments = $r[0];

$new_subscribers_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."subscribers` WHERE dated LIKE '".$today."%'";
$new_subscribers_result = mysql_query($new_subscribers_query);
$r = mysql_fetch_row($new_subscribers_result);
$new_subscribers = $r[0];

$new_bans_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."bans` WHERE dated LIKE '".$today."%'";
$new_bans_result = mysql_query($new_bans_query);
$r = mysql_fetch_row($new_bans_result);
$new_bans = $r[0];

$all_comments_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."comments`";
$all_comments_result = mysql_query($all_comments_query);
$r = mysql_fetch_row($all_comments_result);
$all_comments = $r[0];

$all_subscribers_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."subscribers`";
$all_subscribers_result = mysql_query($all_subscribers_query);
$r = mysql_fetch_row($all_subscribers_result);
$all_subscribers = $r[0];

$all_bans_query = "SELECT COUNT(*) FROM `".$mysql_table_prefix."bans`";
$all_bans_result = mysql_query($all_bans_query);
$r = mysql_fetch_row($all_bans_result);
$all_bans = $r[0];

if ($approve_comments > 0) { echo "<span class='approve_comments'>"; }
echo CMTX_DASH_STATISTICS_YOU_HAVE . " " . $approve_comments . " ";
if ($approve_comments == 1) {
echo CMTX_DASH_STATISTICS_APPROVAL . " ";
} else {
echo CMTX_DASH_STATISTICS_APPROVALS . " ";
}
if ($approve_comments > 0) { echo "</span>"; }

if ($settings->show_flag) {
if ($flagged_comments > 0) { echo "<span class='flagged_comments'>"; }
if ($flagged_comments == 1) {
echo $flagged_comments . " " . CMTX_DASH_STATISTICS_FLAG;
} else {
echo $flagged_comments . " " . CMTX_DASH_STATISTICS_FLAGS;
}
if ($flagged_comments > 0) { echo "</span>"; }
}

echo "<br />";

echo CMTX_DASH_STATISTICS_TODAY_YOU_HAVE . " " . $new_comments . " ";
if ($new_comments == 1) {
echo CMTX_DASH_STATISTICS_NEW_COMMENT . " ";
} else {
echo CMTX_DASH_STATISTICS_NEW_COMMENTS . " ";
}

echo $new_subscribers . " ";
if ($new_subscribers == 1) {
echo CMTX_DASH_STATISTICS_NEW_SUB . " ";
} else {
echo CMTX_DASH_STATISTICS_NEW_SUBS . " ";
}

echo $new_bans . " ";
if ($new_bans == 1) {
echo CMTX_DASH_STATISTICS_NEW_BAN;
} else {
echo CMTX_DASH_STATISTICS_NEW_BANS;
}

echo "<br />";

echo CMTX_DASH_STATISTICS_TOTAL_HAVE . " " . $all_comments . " ";
if ($all_comments == 1) {
echo CMTX_DASH_STATISTICS_COMMENT . " ";
} else {
echo CMTX_DASH_STATISTICS_COMMENTS . " ";
}

echo $all_subscribers . " ";
if ($all_subscribers == 1) {
echo CMTX_DASH_STATISTICS_SUB . " ";
} else {
echo CMTX_DASH_STATISTICS_SUBS . " ";
}

echo $all_bans . " ";
if ($all_bans == 1) {
echo CMTX_DASH_STATISTICS_BAN;
} else {
echo CMTX_DASH_STATISTICS_BANS;
}
?>
</div>
</div>

<div class="dashboard_block">
<div class="dashboard_title"><?php echo CMTX_DASH_TIP_OF_DAY ?></div>
<div class="dashboard_content">
<?php echo tip_of_the_day(); ?>
</div>
</div>

</div>

<div class="dashboard_right">

<div class="dashboard_block news">
<div class="dashboard_title"><?php echo CMTX_DASH_NEWS ?></div>
<div class="dashboard_content">
<?php
if ($issue) {
	echo CMTX_DASH_NEWS_ISSUE;
} else {
	$news_url = "http://www.commentics.org/news.txt";
	if (function_exists('curl_version') && is_callable('curl_version')) { //if cURL is available
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, $news_url);
		$news = curl_exec($ch);
		curl_close($ch);
	} else if ((bool)ini_get('allow_url_fopen')) {
		$news = file_get_contents($news_url);
	}
	$news = htmlentities($news);
	echo nl2br($news);
} ?>
</div>
</div>

<div class="dashboard_block">
<div class="dashboard_title"><?php echo CMTX_DASH_QUICK_LINKS ?></div>
<div class="dashboard_content">
<?php
$pages = mysql_query("SELECT page, COUNT(*) AS frequency FROM `".$mysql_table_prefix."access` WHERE page != 'dashboard' AND page NOT LIKE 'edit%' GROUP BY page ORDER BY frequency DESC LIMIT 5"); 
if (mysql_num_rows($pages) != 5) {
	echo CMTX_DASH_QUICK_LINKS_NO_DATA;
} else {
	$i = 1;
	while ($row = mysql_fetch_array($pages, MYSQL_NUM)) {
		echo $i . ". <a href='index.php?page=". $row[0] . "'>" . $row[0] . "</a>";
		if ($i != 5) { echo "<br />"; }
		$i++;
	}
}
?>
</div>
</div>

</div>

<p />

<?php
if (isset($_POST['submit_notes']) && !$settings->is_demo) {
$data = $_POST['admin_notes'];
$file = "../includes/words/admin_notes.txt";
$handle = fopen($file,"w");
fputs($handle, $data);
fclose($handle);
}
?>

<?php
$data = file_get_contents('../includes/words/admin_notes.txt');
?>

<div style="clear: left;"></div>
<form name="admin_notes" id="admin_notes" action="index.php?page=dashboard" method="post">
<div class="dashboard_title notes"><?php echo CMTX_DASH_ADMIN_NOTES ?></div>
<textarea name="admin_notes" cols="" rows="8" style="width:100%;"><?php echo $data; ?></textarea>
<p />
<input type="submit" class="button" name="submit_notes" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>

<?php } ?>