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

<h3><?php echo CMTX_TITLE_PERMISSIONS ?></h3>
<hr class="title">

<?php echo CMTX_DESC_REPORT_PERMISSIONS ?>

<p />

<?php
$permissions_correct = true;

if ($settings->check_db_file) {

echo "<b><u>Database Connection</u></b>";

echo "<p />";

if (is_writable("../includes/db/details.php")) {
echo "comments/includes/db/details.php <span class='negative'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
$permissions_correct = false;
} else {
echo "comments/includes/db/details.php <span class='positive'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
}

echo "<p />";

}

echo "<b><u>Database Backup</u></b>";

echo "<p />";

if (is_writable("backups/")) {
echo "comments/" . $settings->admin_folder . "/backups/ <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/" . $settings->admin_folder . "/backups/ <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<p />";

echo "<b><u>Emails</u></b>";

echo "<p />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/user/subscriber_confirmation.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/user/subscriber_confirmation.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/user/subscriber_confirmation.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/user/subscriber_notification.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/user/subscriber_notification.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/user/subscriber_notification.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br /><br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/admin/new_ban.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_ban.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_ban.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/admin/new_flag.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_flag.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_flag.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/admin/new_comment_approve.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_comment_approve.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_comment_approve.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/admin/new_comment_okay.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_comment_okay.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/new_comment_okay.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/emails/" . $settings->language_frontend . "/admin/reset_password.txt")) {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/reset_password.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/emails/" . $settings->language_frontend . "/admin/reset_password.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<p />";

echo "<b><u>Words</u></b>";

echo "<p />";

if (is_writable("../includes/words/admin_notes.txt")) {
echo "comments/includes/words/admin_notes.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/admin_notes.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/reserved_names.txt")) {
echo "comments/includes/words/reserved_names.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/reserved_names.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/reserved_emails.txt")) {
echo "comments/includes/words/reserved_emails.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/reserved_emails.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/reserved_websites.txt")) {
echo "comments/includes/words/reserved_websites.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/reserved_websites.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/reserved_towns.txt")) {
echo "comments/includes/words/reserved_towns.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/reserved_towns.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/banned_names.txt")) {
echo "comments/includes/words/banned_names.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/banned_names.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/banned_emails.txt")) {
echo "comments/includes/words/banned_emails.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/banned_emails.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/banned_websites.txt")) {
echo "comments/includes/words/banned_websites.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/banned_websites.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/banned_towns.txt")) {
echo "comments/includes/words/banned_towns.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/banned_towns.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/dummy_names.txt")) {
echo "comments/includes/words/dummy_names.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/dummy_names.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/dummy_emails.txt")) {
echo "comments/includes/words/dummy_emails.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/dummy_emails.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/dummy_websites.txt")) {
echo "comments/includes/words/dummy_websites.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/dummy_websites.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/dummy_towns.txt")) {
echo "comments/includes/words/dummy_towns.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/dummy_towns.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/mild_swear_words.txt")) {
echo "comments/includes/words/mild_swear_words.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/mild_swear_words.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/strong_swear_words.txt")) {
echo "comments/includes/words/strong_swear_words.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/strong_swear_words.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("../includes/words/spam_words.txt")) {
echo "comments/includes/words/spam_words.txt <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/words/spam_words.txt <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<p />";

echo "<b><u>Error Logs</u></b>";

echo "<p />";

if (is_writable("../includes/logs/errors.log")) {
echo "comments/includes/logs/errors.log <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/includes/logs/errors.log <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<br />";

if (is_writable("includes/logs/errors.log")) {
echo "comments/" . $settings->admin_folder . "/includes/logs/errors.log <span class='positive'>" . CMTX_FIELD_VALUE_IS_WRITABLE . "</span>.";
} else {
echo "comments/" . $settings->admin_folder . "/includes/logs/errors.log <span class='negative'>" . CMTX_FIELD_VALUE_IS_NOT_WRITABLE . "</span>.";
$permissions_correct = false;
}

echo "<p />";

if ($permissions_correct) {
echo "<span class='positive'>" . CMTX_FIELD_VALUE_PERMISSIONS_CORRECT . "</span>.";
} else {
echo "<span class='negative'>" . CMTX_FIELD_VALUE_PERMISSIONS_INCORRECT . "</span>.";
}

?>

<p />

<input type="button" class="button" name="refresh" title="<?php echo CMTX_BUTTON_REFRESH ?>" value="<?php echo CMTX_BUTTON_REFRESH ?>" onclick="window.location.reload()"/>