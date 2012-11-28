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

<h3><?php echo CMTX_TITLE_PROCESSOR_COMMENT ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['approve_images'])) { $approve_images = 1; } else { $approve_images = 0; }
if (isset($_POST['approve_videos'])) { $approve_videos = 1; } else { $approve_videos = 0; }
if (isset($_POST['comment_parser_convert_links'])) { $comment_parser_convert_links = 1; } else { $comment_parser_convert_links = 0; }
if (isset($_POST['comment_parser_convert_emails'])) { $comment_parser_convert_emails = 1; } else { $comment_parser_convert_emails = 0; }
if (isset($_POST['comment_links_new_window'])) { $comment_links_new_window = 1; } else { $comment_links_new_window = 0; }
if (isset($_POST['comment_links_nofollow'])) { $comment_links_nofollow = 1; } else { $comment_links_nofollow = 0; }
$comment_minimum_characters = $_POST['comment_minimum_characters'];
$comment_minimum_words = $_POST['comment_minimum_words'];
$comment_maximum_characters = $_POST['comment_maximum_characters'];
$comment_maximum_lines = $_POST['comment_maximum_lines'];
$comment_maximum_smilies = $_POST['comment_maximum_smilies'];
$long_word_length_to_deny = $_POST['long_word_length_to_deny'];
if (isset($_POST['comment_line_breaks'])) { $comment_line_breaks = 1; } else { $comment_line_breaks = 0; }
$swear_word_masking = $_POST['swear_word_masking'];
if (isset($_POST['detect_link_in_comment_enabled'])) { $detect_link_in_comment_enabled = 1; } else { $detect_link_in_comment_enabled = 0; }
$link_in_comment_action = $_POST['link_in_comment_action'];
if (isset($_POST['check_capitals_enabled'])) { $check_capitals_enabled = 1; } else { $check_capitals_enabled = 0; }
$check_capitals_percentage = $_POST['check_capitals_percentage'];
$check_capitals_action = $_POST['check_capitals_action'];
if (isset($_POST['check_repeats_enabled'])) { $check_repeats_enabled = 1; } else { $check_repeats_enabled = 0; }
$check_repeats_action = $_POST['check_repeats_action'];
if (isset($_POST['spam_words_enabled'])) { $spam_words_enabled = 1; } else { $spam_words_enabled = 0; }
$spam_words_action = $_POST['spam_words_action'];
if (isset($_POST['mild_swear_words_enabled'])) { $mild_swear_words_enabled = 1; } else { $mild_swear_words_enabled = 0; }
$mild_swear_words_action = $_POST['mild_swear_words_action'];
if (isset($_POST['strong_swear_words_enabled'])) { $strong_swear_words_enabled = 1; } else { $strong_swear_words_enabled = 0; }
$strong_swear_words_action = $_POST['strong_swear_words_action'];
if (isset($_POST['banned_websites_as_comment_enabled'])) { $banned_websites_as_comment_enabled = 1; } else { $banned_websites_as_comment_enabled = 0; }
$banned_websites_as_comment_action = $_POST['banned_websites_as_comment_action'];

$comment_minimum_characters_san = sanitize($comment_minimum_characters);
$comment_minimum_words_san = sanitize($comment_minimum_words);
$comment_maximum_characters_san = sanitize($comment_maximum_characters);
$comment_maximum_lines_san = sanitize($comment_maximum_lines);
$comment_maximum_smilies_san = sanitize($comment_maximum_smilies);
$long_word_length_to_deny_san = sanitize($long_word_length_to_deny);
$swear_word_masking_san = sanitize($swear_word_masking);
$check_capitals_percentage_san = sanitize($check_capitals_percentage);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$approve_images' WHERE title = 'approve_images'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$approve_videos' WHERE title = 'approve_videos'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_parser_convert_links' WHERE title = 'comment_parser_convert_links'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_parser_convert_emails' WHERE title = 'comment_parser_convert_emails'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_links_new_window' WHERE title = 'comment_links_new_window'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_links_nofollow' WHERE title = 'comment_links_nofollow'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_minimum_characters_san' WHERE title = 'comment_minimum_characters'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_minimum_words_san' WHERE title = 'comment_minimum_words'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_maximum_characters_san' WHERE title = 'comment_maximum_characters'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_maximum_lines_san' WHERE title = 'comment_maximum_lines'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_maximum_smilies_san' WHERE title = 'comment_maximum_smilies'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$long_word_length_to_deny_san' WHERE title = 'long_word_length_to_deny'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$comment_line_breaks' WHERE title = 'comment_line_breaks'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$swear_word_masking_san' WHERE title = 'swear_word_masking'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$detect_link_in_comment_enabled' WHERE title = 'detect_link_in_comment_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$link_in_comment_action' WHERE title = 'link_in_comment_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_capitals_enabled' WHERE title = 'check_capitals_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_capitals_percentage_san' WHERE title = 'check_capitals_percentage'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_capitals_action' WHERE title = 'check_capitals_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_repeats_enabled' WHERE title = 'check_repeats_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$check_repeats_action' WHERE title = 'check_repeats_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$spam_words_enabled' WHERE title = 'spam_words_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$spam_words_action' WHERE title = 'spam_words_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$mild_swear_words_enabled' WHERE title = 'mild_swear_words_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$mild_swear_words_action' WHERE title = 'mild_swear_words_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$strong_swear_words_enabled' WHERE title = 'strong_swear_words_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$strong_swear_words_action' WHERE title = 'strong_swear_words_action'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_websites_as_comment_enabled' WHERE title = 'banned_websites_as_comment_enabled'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$banned_websites_as_comment_action' WHERE title = 'banned_websites_as_comment_action'");

?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_PROCESSING_COMMENT ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_processor_comment" id="settings_processor_comment" action="index.php?page=settings_processor_comment" method="post">
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_APPROVE_IMAGES ?></label> <?php if ($settings->approve_images) { ?> <input type="checkbox" checked="checked" name="approve_images"/> <?php } else { ?> <input type="checkbox" name="approve_images"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_APPROVE_VIDEOS ?></label> <?php if ($settings->approve_videos) { ?> <input type="checkbox" checked="checked" name="approve_videos"/> <?php } else { ?> <input type="checkbox" name="approve_videos"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_CONVERT_LINKS ?></label> <?php if ($settings->comment_parser_convert_links) { ?> <input type="checkbox" checked="checked" name="comment_parser_convert_links"/> <?php } else { ?> <input type="checkbox" name="comment_parser_convert_links"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_CONVERT_LINKS ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_CONVERT_EMAILS ?></label> <?php if ($settings->comment_parser_convert_emails) { ?> <input type="checkbox" checked="checked" name="comment_parser_convert_emails"/> <?php } else { ?> <input type="checkbox" name="comment_parser_convert_emails"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_CONVERT_EMAILS ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_NEW_WINDOW ?></label> <?php if ($settings->comment_links_new_window) { ?> <input type="checkbox" checked="checked" name="comment_links_new_window"/> <?php } else { ?> <input type="checkbox" name="comment_links_new_window"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NEW_WIN ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_NO_FOLLOW ?></label> <?php if ($settings->comment_links_nofollow) { ?> <input type="checkbox" checked="checked" name="comment_links_nofollow"/> <?php } else { ?> <input type="checkbox" name="comment_links_nofollow"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_NO_FOLLOW ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MIN_CHARS ?></label> <input type="text" name="comment_minimum_characters" size="1" maxlength="250" value="<?php echo $settings->comment_minimum_characters; ?>"/>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MIN_WORDS ?></label> <input type="text" name="comment_minimum_words" size="1" maxlength="250" value="<?php echo $settings->comment_minimum_words; ?>"/>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MAX_CHARS ?></label> <input type="text" name="comment_maximum_characters" size="3" maxlength="250" value="<?php echo $settings->comment_maximum_characters; ?>"/>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MAX_LINES ?></label> <input type="text" name="comment_maximum_lines" size="1" maxlength="250" value="<?php echo $settings->comment_maximum_lines; ?>"/>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MAX_SMILIES ?></label> <input type="text" name="comment_maximum_smilies" size="1" maxlength="250" value="<?php echo $settings->comment_maximum_smilies; ?>"/>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LONG_WORD ?></label> <input type="text" name="long_word_length_to_deny" size="1" maxlength="250" value="<?php echo $settings->long_word_length_to_deny; ?>"/> <span class='note'><?php echo CMTX_NOTE_CHARS ?></span>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LINE_BREAKS ?></label> <?php if ($settings->comment_line_breaks) { ?> <input type="checkbox" checked="checked" name="comment_line_breaks"/> <?php } else { ?> <input type="checkbox" name="comment_line_breaks"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_LINE_BREAKS ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MASK ?></label> <input type="text" name="swear_word_masking" size="4" maxlength="250" value="<?php echo $settings->swear_word_masking; ?>"/>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_MASK ?>', this, event, '')">[?]</a>
<p /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_DETECT_LINKS ?></label> <?php if ($settings->detect_link_in_comment_enabled) { ?> <input type="checkbox" checked="checked" name="detect_link_in_comment_enabled"/> <?php } else { ?> <input type="checkbox" name="detect_link_in_comment_enabled"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='link_in_comment_action'>
<?php if ($settings->link_in_comment_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->link_in_comment_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MAX_CAPS ?></label> <?php if ($settings->check_capitals_enabled) { ?> <input type="checkbox" checked="checked" name="check_capitals_enabled"/> <?php } else { ?> <input type="checkbox" name="check_capitals_enabled"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_MAX_CAPITALS ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_PERCENTAGE ?></label> <input type="text" name="check_capitals_percentage" size="1" maxlength="250" value="<?php echo $settings->check_capitals_percentage; ?>"/> <span class='note'>%</span>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='check_capitals_action'>
<?php if ($settings->check_capitals_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->check_capitals_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<p /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_DETECT_REPEATS ?></label> <?php if ($settings->check_repeats_enabled) { ?> <input type="checkbox" checked="checked" name="check_repeats_enabled"/> <?php } else { ?> <input type="checkbox" name="check_repeats_enabled"/> <?php } ?>
<a href="#" class="hintanchor" onMouseover="showhint('<?php echo CMTX_HINT_DETECT_REPEATS ?>', this, event, '')">[?]</a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='check_repeats_action'>
<?php if ($settings->check_repeats_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->check_repeats_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_SPAM_WORDS ?></label> <?php if ($settings->spam_words_enabled) { ?> <input type="checkbox" checked="checked" name="spam_words_enabled"/> <?php } else { ?> <input type="checkbox" name="spam_words_enabled"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_spam_words"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='spam_words_action'>
<?php if ($settings->spam_words_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->spam_words_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_MILD_SWEARS ?></label> <?php if ($settings->mild_swear_words_enabled) { ?> <input type="checkbox" checked="checked" name="mild_swear_words_enabled"/> <?php } else { ?> <input type="checkbox" name="mild_swear_words_enabled"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_mild_swear_words"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='mild_swear_words_action'>
<?php if ($settings->mild_swear_words_action == "mask") { ?>
<option value='mask' selected><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->mild_swear_words_action == "reject") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->mild_swear_words_action == "approve") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->mild_swear_words_action == "mask_approve") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve' selected><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_STRONG_SWEARS ?></label> <?php if ($settings->strong_swear_words_enabled) { ?> <input type="checkbox" checked="checked" name="strong_swear_words_enabled"/> <?php } else { ?> <input type="checkbox" name="strong_swear_words_enabled"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_strong_swear_words"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='strong_swear_words_action'>
<?php if ($settings->strong_swear_words_action == "mask") { ?>
<option value='mask' selected><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->strong_swear_words_action == "reject") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->strong_swear_words_action == "approve") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->strong_swear_words_action == "mask_approve") { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve' selected><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='mask'><?php echo CMTX_FIELD_VALUE_MASK ?></option>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='mask_approve'><?php echo CMTX_FIELD_VALUE_MASK_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<br /><hr class="separator"><br />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_BANNED_WEBSITE ?></label> <?php if ($settings->banned_websites_as_comment_enabled) { ?> <input type="checkbox" checked="checked" name="banned_websites_as_comment_enabled"/> <?php } else { ?> <input type="checkbox" name="banned_websites_as_comment_enabled"/> <?php } ?>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_LIST ?></label> <a href="index.php?page=list_banned_websites"><?php echo CMTX_LINK_EDIT ?></a>
<p />
<label class='settings_processor_comment'><?php echo CMTX_FIELD_LABEL_ACTION ?></label>
<select name='banned_websites_as_comment_action'>
<?php if ($settings->banned_websites_as_comment_action == "reject") { ?>
<option value='reject' selected><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else if ($settings->banned_websites_as_comment_action == "approve") { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve' selected><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban'><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } else { ?>
<option value='reject'><?php echo CMTX_FIELD_VALUE_REJECT ?></option>
<option value='approve'><?php echo CMTX_FIELD_VALUE_APPROVE ?></option>
<option value='ban' selected><?php echo CMTX_FIELD_VALUE_BAN ?></option>
<?php } ?>
</select>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>