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

<h3><?php echo CMTX_TITLE_EDIT_COMMENT ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$id = $_GET['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$website = $_POST['website'];
$town = $_POST['town'];
$country = $_POST['cmtx_country'];
if ($country == "blank") { $country = ""; }
$rating = $_POST['cmtx_rating'];
if ($rating == "blank") { $rating = ""; }
$comment = $_POST['comment'];
$reply = $_POST['reply'];
$page_id = $_POST['page_id'];
$reply_to = $_POST['reply_to'];
$is_approved = $_POST['is_approved'];
$is_sticky = $_POST['is_sticky'];
$is_locked = $_POST['is_locked'];

if (!$is_approved) {
unapprove_replies($id);
}

if (isset($_POST['send']) && $_POST['send'] == "1") {
notify_subscribers($name, $comment, $id, $page_id);
}

if ($settings->show_flag) {
	$unflagged = false;
	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
	while ($reports = mysql_fetch_assoc($query)) {
		if (isset($_POST['report_' . $reports["id"]])) {
			$report_id = $reports["id"];
			if ($_POST['report_' . $reports["id"]] == "good") {
				mysql_query("UPDATE `".$mysql_table_prefix."reports` SET status = 'good' WHERE id = '$report_id'");
			} else if ($_POST['report_' . $reports["id"]] == "fair") {
				mysql_query("UPDATE `".$mysql_table_prefix."reports` SET status = 'fair' WHERE id = '$report_id'");
			} else {
				mysql_query("UPDATE `".$mysql_table_prefix."reports` SET status = 'bad' WHERE id = '$report_id'");
				$ip_address_query = mysql_query("SELECT ip_address FROM `".$mysql_table_prefix."reports` WHERE id = '$report_id'");
				$ip_address_result = mysql_fetch_assoc($ip_address_query);
				$ip_address = $ip_address_result["ip_address"];
				mysql_query("INSERT INTO `".$mysql_table_prefix."bans` (ip_address, reason, unban, dated) VALUES ('$ip_address', '" . CMTX_FIELD_VALUE_BAD_REPORT . "', '0', NOW());");
			}
		$unflagged = true;
		}
	}
	if ($unflagged) {
		mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_flagged = '0' WHERE id = '$id'");
	}
}

$id = sanitize($id);
$name = sanitize($name);
$email = sanitize($email);
$website = sanitize($website);
$town = sanitize($town);
$comment = sanitize($comment);
$reply = sanitize($reply);

mysql_query("UPDATE `".$mysql_table_prefix."comments` SET name = '$name' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET email = '$email' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET website = '$website' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET town = '$town' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET country = '$country' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET rating = '$rating' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET comment = '$comment' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET reply = '$reply' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET page_id = '$page_id' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET page_id = '$page_id' WHERE reply_to = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET reply_to = '$reply_to' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_approved = '$is_approved' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_sticky = '$is_sticky' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."comments` SET is_locked = '$is_locked' WHERE id = '$id'");

?>
<div class="success"><?php echo CMTX_MSG_COMMENT_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
$id = $_GET['id'];
$id = sanitize($id);
$comment_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
$comment_result = mysql_fetch_assoc($comment_query);
$name = $comment_result["name"];
$email = $comment_result["email"];
$website = $comment_result["website"];
$town = $comment_result["town"];
$country = $comment_result["country"];
$rating = $comment_result["rating"];
$comment = $comment_result["comment"];
$reply = $comment_result["reply"];
$reply_to = $comment_result["reply_to"];
$ip_address = $comment_result["ip_address"];
$is_approved = $comment_result["is_approved"];
$approval_reasoning = $comment_result["approval_reasoning"];
$is_sent = $comment_result["is_sent"];
$sent_to = $comment_result["sent_to"];
$likes = $comment_result["vote_up"];
$dislikes = $comment_result["vote_down"];
$is_flagged = $comment_result["is_flagged"];
$is_sticky = $comment_result["is_sticky"];
$is_locked = $comment_result["is_locked"];

$time = date("g:ia", strtotime($comment_result["dated"]));
$date = date("jS M Y", strtotime($comment_result["dated"]));

$page_id = $comment_result["page_id"];
$page_reference_query = mysql_query("SELECT reference FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id'");
$page_reference_result = mysql_fetch_assoc($page_reference_query);
$page_reference = $page_reference_result["reference"];
?>

<p />

<?php $path_to_comments_folder = ""; require "../includes/language/" . $settings->language_frontend . "/form.php"; ?>

<?php $settings = new Settings; ?>

<form name="edit_comment" id="edit_comment" action="index.php?page=edit_comment&id=<?php echo $id ?>" method="post">
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_NAME ?></label> <input type="text" name="name" size="33" maxlength="250" value="<?php echo htmlentities($name, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_EMAIL ?></label> <input type="text" name="email" size="33" maxlength="250" value="<?php echo htmlentities($email, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_WEBSITE ?></label> <input type="text" name="website" size="33" maxlength="250" value="<?php echo htmlentities($website, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_TOWN ?></label> <input type="text" name="town" size="33" maxlength="250" value="<?php echo htmlentities($town, ENT_NOQUOTES, 'UTF-8'); ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_COUNTRY ?></label>
<?php
require "../includes/template/countries.php";
if ($country != "blank") {
	$countries = str_ireplace("'".$country."'","'".$country."' selected",$countries);
}
echo $countries;
?>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_RATING ?></label>
<?php
require "../includes/template/ratings.php";
if ($rating != "blank") {
	$ratings = str_ireplace("'".$rating."'","'".$rating."' selected",$ratings);
}
echo $ratings;
?>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_COMMENT ?></label> <textarea name="comment" cols="39" rows="6"><?php echo htmlentities($comment, ENT_NOQUOTES, 'UTF-8'); ?></textarea>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_REPLY ?></label> <textarea name="reply" cols="39" rows="6"><?php echo htmlentities($reply, ENT_NOQUOTES, 'UTF-8'); ?></textarea>
<br /><hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_PAGE ?></label> <select name="page_id"><?php $pages = mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` ORDER BY id ASC");
while ($page = mysql_fetch_assoc($pages)) { ?>
<option value='<?php echo $page['id'];?>' <?php if ($page_id == $page['id']) { echo "selected='selected'"; } ?>><?php echo $page['reference']; ?></option>
<?php } ?>
</select>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_REPLY_TO ?></label>
<select name="reply_to">
<option value="0"<?php if (!$reply_to) { echo " selected='selected'"; } ?>><?php echo CMTX_FIELD_VALUE_NOBODY ?></option>
<?php
$comments = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE page_id = '$page_id' AND id != '$id' ORDER BY dated DESC");
while ($comment = mysql_fetch_assoc($comments)) {
echo "<option value='" . $comment['id'] . "'";
if ($reply_to == $comment['id']) { echo " selected='selected'"; }
echo ">" . $comment['name'] . " - " . date("jS M Y", strtotime($comment["dated"])) . " - " . date("g:ia", strtotime($comment["dated"])) . "</option>";
}
?>
</select>
<p />
<hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_APPROVED ?></label>
<?php if ($is_approved) { ?>
<select name='is_approved'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='is_approved'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_NOTES ?></label> <?php if (empty($approval_reasoning)) { echo CMTX_FIELD_VALUE_NONE; } else { echo $approval_reasoning; } ?>
<?php if ($settings->enabled_notify) { ?>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_SEND ?></label>
<?php if ($is_sent) {
echo CMTX_FIELD_VALUE_SENT_TO . " " . $sent_to;
if ($sent_to == 1) { echo " " . CMTX_FIELD_VALUE_SUBSCRIBER; } else { echo " " . CMTX_FIELD_VALUE_SUBSCRIBERS; }
} else {  ?>
<select name='send'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_SEND ?>', this, event, '')">[?]</a>
<?php } ?>
<?php } ?>
<?php if ($settings->show_like || $settings->show_dislike) { ?>
<br /><hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_LIKES ?></label>
<?php echo $likes; ?>
<?php if ($likes == 1) { echo " " . CMTX_FIELD_VALUE_ONE_LIKE; } else { echo " " . CMTX_FIELD_VALUE_MANY_LIKES; } ?>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_DISLIKES ?></label>
<?php echo $dislikes; ?>
<?php if ($dislikes == 1) { echo " " . CMTX_FIELD_VALUE_ONE_DISLIKE; } else { echo " " . CMTX_FIELD_VALUE_MANY_DISLIKES; } ?>
<?php } ?>
<?php if ($settings->show_flag) {
?><br /><hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_REPORTS ?></label><?php
$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."reports` WHERE status = 'pending' AND comment_id = '$id'");
$count = mysql_num_rows($query);
if ($count == 0) { echo CMTX_FIELD_VALUE_NO_REPORTS; }
if ($count == 1) { echo CMTX_FIELD_VALUE_ONE_REPORT; }
if ($count > 1) { echo CMTX_FIELD_VALUE_THERE_ARE . " " . $count . " " . CMTX_FIELD_VALUE_PENDING_REPORTS; }
?><?php
if ($count > 0) {
	$i = 1;
	while ($reports = mysql_fetch_assoc($query)) {
		echo "<p /><label class='edit_comment'>" . CMTX_FIELD_LABEL_REPORT . " $i:</label>";
		echo "<input type='radio' name='report_" . $reports["id"] . "' value='good' /><span class='report_good'>" . CMTX_FIELD_VALUE_GOOD . "</span> ";
		echo "<input type='radio' name='report_" . $reports["id"] . "' value='fair' /><span class='report_fair'>" . CMTX_FIELD_VALUE_FAIR . "</span> ";
		echo "<input type='radio' name='report_" . $reports["id"] . "' value='bad' /><span class='report_bad'>" . CMTX_FIELD_VALUE_BAD . "</span> ";
		echo "&nbsp;&nbsp;<b>" . CMTX_FIELD_VALUE_MSG . "</b>: " . $reports["reason"];
		$i++;
	}
}
?><p /><label class='edit_comment'><?php echo CMTX_FIELD_LABEL_FLAGGED ?></label><?php
if ($is_flagged) { echo CMTX_FIELD_VALUE_IS_FLAGGED; } else { echo CMTX_FIELD_VALUE_NOT_FLAGGED; }
}
?>
<hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_STICKY ?></label>
<?php if ($is_sticky) { ?>
<select name='is_sticky'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='is_sticky'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_STICKY ?>', this, event, '')">[?]</a>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_LOCKED ?></label>
<?php if ($is_locked) { ?>
<select name='is_locked'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='is_locked'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_LOCKED ?>', this, event, '')">[?]</a>
<br /><hr class="separator"><br />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_IP_ADDRESS ?></label> <input readonly="readonly" type="text" class="readonly" name="ip_address" size="12" maxlength="39" value="<?php echo $ip_address; ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input readonly="readonly" type="text" class="readonly" name="time" size="5" maxlength="250" value="<?php echo $time; ?>"/>
<p />
<label class='edit_comment'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <input readonly="readonly" type="text" class="readonly" name="date" size="12" maxlength="250" value="<?php echo $date; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_comment_confirmation()){window.location='index.php?page=manage_comments&action=delete&id=<?php echo $id ?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>
<input type="button" class="button" name="spam" onclick="window.location='index.php?page=spam&id=<?php echo $id ?>';" title="<?php echo CMTX_BUTTON_SPAM ?>" value="<?php echo CMTX_BUTTON_SPAM ?>"/>

<p />

<a href="index.php?page=manage_comments"><?php echo CMTX_LINK_BACK ?></a>