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

/* Labels */
define ('CMTX_FIELD_LABEL_ID', 'ID:');
define ('CMTX_FIELD_LABEL_CUSTOM_ID', 'Custom ID:');
define ('CMTX_FIELD_LABEL_USER', 'User:');
define ('CMTX_FIELD_LABEL_USERNAME', 'Username:');
define ('CMTX_FIELD_LABEL_NAME', 'Name:');
define ('CMTX_FIELD_LABEL_EMAIL', 'Email:');
define ('CMTX_FIELD_LABEL_EMAIL_ADDRESS', 'Email Address:');
define ('CMTX_FIELD_LABEL_WEBSITE', 'Website:');
define ('CMTX_FIELD_LABEL_TOWN', 'Town:');
define ('CMTX_FIELD_LABEL_COUNTRY', 'Country:');
define ('CMTX_FIELD_LABEL_RATING', 'Rating:');
define ('CMTX_FIELD_LABEL_COMMENT', 'Comment:');
define ('CMTX_FIELD_LABEL_REPLY', 'Reply:');
define ('CMTX_FIELD_LABEL_REPLY_TO', 'Reply to:');
define ('CMTX_FIELD_LABEL_BB_CODE', 'BB Code:');
define ('CMTX_FIELD_LABEL_SMILIES', 'Smilies:');
define ('CMTX_FIELD_LABEL_COUNTER', 'Counter:');
define ('CMTX_FIELD_LABEL_QUESTION', 'Question:');
define ('CMTX_FIELD_LABEL_CAPTCHA', 'Captcha:');
define ('CMTX_FIELD_LABEL_NOTIFY', 'Notify:');
define ('CMTX_FIELD_LABEL_PRIVACY', 'Privacy:');
define ('CMTX_FIELD_LABEL_TERMS', 'Terms:');
define ('CMTX_FIELD_LABEL_PREVIEW', 'Preview:');
define ('CMTX_FIELD_LABEL_APPROVED', 'Approved:');
define ('CMTX_FIELD_LABEL_STICKY', 'Sticky:');
define ('CMTX_FIELD_LABEL_LOCKED', 'Locked:');
define ('CMTX_FIELD_LABEL_NOTES', 'Notes:');
define ('CMTX_FIELD_LABEL_SEND', 'Send:');
define ('CMTX_FIELD_LABEL_LIKE', 'Like:');
define ('CMTX_FIELD_LABEL_LIKES', 'Likes:');
define ('CMTX_FIELD_LABEL_DISLIKE', 'Dislike:');
define ('CMTX_FIELD_LABEL_DISLIKES', 'Dislikes:');
define ('CMTX_FIELD_LABEL_REPORT', 'Report:');
define ('CMTX_FIELD_LABEL_REPORTS', 'Reports:');
define ('CMTX_FIELD_LABEL_FLAG', 'Flag:');
define ('CMTX_FIELD_LABEL_FLAGGED', 'Flagged:');
define ('CMTX_FIELD_LABEL_REASON', 'Reason:');
define ('CMTX_FIELD_LABEL_CONFIRMED', 'Confirmed:');
define ('CMTX_FIELD_LABEL_ACTIVE', 'Active:');
define ('CMTX_FIELD_LABEL_PAGE', 'Page:');
define ('CMTX_FIELD_LABEL_REFERENCE', 'Reference:');
define ('CMTX_FIELD_LABEL_URL', 'URL:');
define ('CMTX_FIELD_LABEL_ENABLED', 'Enabled:');
define ('CMTX_FIELD_LABEL_FORM_ENABLED', 'Form Enabled:');
define ('CMTX_FIELD_LABEL_PASSWORD', 'Password:');
define ('CMTX_FIELD_LABEL_PASS', 'Pass:');
define ('CMTX_FIELD_LABEL_REPEAT', 'Repeat:');
define ('CMTX_FIELD_LABEL_NEW_PASSWORD', 'New Password:');
define ('CMTX_FIELD_LABEL_REPEAT_PASSWORD', 'Repeat Password:');
define ('CMTX_FIELD_LABEL_GRAVATAR', 'Gravatar:');
define ('CMTX_FIELD_LABEL_SORT_BY', 'Sort By:');
define ('CMTX_FIELD_LABEL_AVG_RATING', 'Avg. Rating:');
define ('CMTX_FIELD_LABEL_SOCIAL', 'Social:');
define ('CMTX_FIELD_LABEL_RSS_THIS', 'RSS This:');
define ('CMTX_FIELD_LABEL_RSS_ALL', 'RSS All:');
define ('CMTX_FIELD_LABEL_INFO', 'Information:');
define ('CMTX_FIELD_LABEL_ORDER', 'Order:');
define ('CMTX_FIELD_LABEL_DISPLAY_SAYS', 'Display "Says":');
define ('CMTX_FIELD_LABEL_JS_VOTE_OK', 'JS Vote OK:');
define ('CMTX_FIELD_LABEL_TIME_FORMAT', 'Time Format:');
define ('CMTX_FIELD_LABEL_DATE_TIME', 'Date/Time:');
define ('CMTX_FIELD_LABEL_TOP', 'Top:');
define ('CMTX_FIELD_LABEL_BOTTOM', 'Bottom:');
define ('CMTX_FIELD_LABEL_PER_PAGE', 'Per Page:');
define ('CMTX_FIELD_LABEL_RANGE', 'Range:');
define ('CMTX_FIELD_LABEL_SORT_BY_1', 'Newest:');
define ('CMTX_FIELD_LABEL_SORT_BY_2', 'Oldest:');
define ('CMTX_FIELD_LABEL_SORT_BY_3', 'Helpful:');
define ('CMTX_FIELD_LABEL_SORT_BY_4', 'Useless:');
define ('CMTX_FIELD_LABEL_SORT_BY_5', 'Positive:');
define ('CMTX_FIELD_LABEL_SORT_BY_6', 'Critical:');
define ('CMTX_FIELD_LABEL_REPLY_DEPTH', 'Reply Depth:');
define ('CMTX_FIELD_LABEL_REPLY_ARROW', 'Reply Arrow:');
define ('CMTX_FIELD_LABEL_SCROLL_REPLY', 'Scroll Reply:');
define ('CMTX_FIELD_LABEL_NEW_WINDOW', 'New Win:');
define ('CMTX_FIELD_LABEL_GRAVATAR_DEFAULT', 'Default:');
define ('CMTX_FIELD_LABEL_GRAVATAR_RATING', 'Rating:');
define ('CMTX_FIELD_LABEL_DISPLAY', 'Display:');
define ('CMTX_FIELD_LABEL_ANSWER', 'Answer:');
define ('CMTX_FIELD_LABEL_DISPLAY_JS_MSG', 'Display JS Message:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_SYMBOL', 'Display * Symbol:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_MSG', 'Display * Message:');
define ('CMTX_FIELD_LABEL_DISPLAY_EMAIL_NOTE', 'Display Email Note:');
define ('CMTX_FIELD_LABEL_REPEAT_RATINGS', 'Repeat Ratings:');
define ('CMTX_FIELD_LABEL_AGREE_TO_PREVIEW', 'Agree to Preview:');
define ('CMTX_FIELD_LABEL_DAYS', 'Days:');
define ('CMTX_FIELD_LABEL_NEW_BAN', 'New Ban:');
define ('CMTX_FIELD_LABEL_NEW_COM_APPROVE', 'New Comment (Approve):');
define ('CMTX_FIELD_LABEL_NEW_COM_OKAY', 'New Comment (Okay):');
define ('CMTX_FIELD_LABEL_NEW_FLAG', 'New Flag:');
define ('CMTX_FIELD_LABEL_METHOD', 'Method:');
define ('CMTX_FIELD_LABEL_ADD_COOKIE', 'Add Cookie:');
define ('CMTX_FIELD_LABEL_DEL_COOKIE', 'Del Cookie:');
define ('CMTX_FIELD_LABEL_AKISMET_KEY', 'API Key:');
define ('CMTX_FIELD_LABEL_APPROVE_COMMENTS', 'Approve Comments:');
define ('CMTX_FIELD_LABEL_APPROVE_NOTIFICATIONS', 'Approve Notifications:');
define ('CMTX_FIELD_LABEL_SMTP_HOST', 'Host:');
define ('CMTX_FIELD_LABEL_SMTP_PORT', 'Port:');
define ('CMTX_FIELD_LABEL_SMTP_ENCRYPT', 'Encrypt:');
define ('CMTX_FIELD_LABEL_SMTP_AUTH', 'Auth:');
define ('CMTX_FIELD_LABEL_SENDMAIL_PATH', 'Path:');
define ('CMTX_FIELD_LABEL_SUBJECT', 'Subject:');
define ('CMTX_FIELD_LABEL_FROM_NAME', 'From Name:');
define ('CMTX_FIELD_LABEL_FROM_EMAIL', 'From Email:');
define ('CMTX_FIELD_LABEL_REPLY_EMAIL', 'Reply Email:');
define ('CMTX_FIELD_LABEL_FRONTEND', 'Frontend:');
define ('CMTX_FIELD_LABEL_BACKEND', 'Backend:');
define ('CMTX_FIELD_LABEL_VIEW_LOG', 'View Log:');
define ('CMTX_FIELD_LABEL_MESSAGE', 'Message:');
define ('CMTX_FIELD_LABEL_APPROVE', 'Approve:');
define ('CMTX_FIELD_LABEL_DISAPPROVE', 'Disapprove:');
define ('CMTX_FIELD_LABEL_MAX_PER_USER', 'Max per User:');
define ('CMTX_FIELD_LABEL_MIN_PER_COM', 'Min per Com:');
define ('CMTX_FIELD_LABEL_DELAY', 'Delay:');
define ('CMTX_FIELD_LABEL_ALL_PAGES', 'All Pages:');
define ('CMTX_FIELD_LABEL_MAXIMUM', 'Maximum:');
define ('CMTX_FIELD_LABEL_AMOUNT', 'Amount:');
define ('CMTX_FIELD_LABEL_PERIOD', 'Period:');
define ('CMTX_FIELD_LABEL_ONE_NAME', 'One Name:');
define ('CMTX_FIELD_LABEL_FIX_NAME', 'Fix Name:');
define ('CMTX_FIELD_LABEL_DETECT_LINKS', 'Detect Links:');
define ('CMTX_FIELD_LABEL_DETECT_REPEATS', 'Detect Repeats:');
define ('CMTX_FIELD_LABEL_RESERVED_NAME', 'Reserved Name:');
define ('CMTX_FIELD_LABEL_DUMMY_NAME', 'Dummy Name:');
define ('CMTX_FIELD_LABEL_BANNED_NAME', 'Banned Name:');
define ('CMTX_FIELD_LABEL_RESERVED_EMAIL', 'Reserved Email:');
define ('CMTX_FIELD_LABEL_DUMMY_EMAIL', 'Dummy Email:');
define ('CMTX_FIELD_LABEL_BANNED_EMAIL', 'Banned Email:');
define ('CMTX_FIELD_LABEL_FIX_TOWN', 'Fix Town:');
define ('CMTX_FIELD_LABEL_RESERVED_TOWN', 'Reserved Town:');
define ('CMTX_FIELD_LABEL_DUMMY_TOWN', 'Dummy Town:');
define ('CMTX_FIELD_LABEL_BANNED_TOWN', 'Banned Town:');
define ('CMTX_FIELD_LABEL_PING', 'Ping:');
define ('CMTX_FIELD_LABEL_NO_FOLLOW', 'No Follow:');
define ('CMTX_FIELD_LABEL_RESERVED_WEBSITE', 'Reserved Website:');
define ('CMTX_FIELD_LABEL_DUMMY_WEBSITE', 'Dummy Website:');
define ('CMTX_FIELD_LABEL_BANNED_WEBSITE', 'Banned Website:');
define ('CMTX_FIELD_LABEL_APPROVE_IMAGES', 'Approve Images:');
define ('CMTX_FIELD_LABEL_APPROVE_VIDEOS', 'Approve Videos:');
define ('CMTX_FIELD_LABEL_CONVERT_LINKS', 'Convert Links:');
define ('CMTX_FIELD_LABEL_CONVERT_EMAILS', 'Convert Emails:');
define ('CMTX_FIELD_LABEL_MIN_CHARS', 'Min Characters:');
define ('CMTX_FIELD_LABEL_MIN_WORDS', 'Min Words:');
define ('CMTX_FIELD_LABEL_MAX_CHARS', 'Max Characters:');
define ('CMTX_FIELD_LABEL_MAX_LINES', 'Max Lines:');
define ('CMTX_FIELD_LABEL_MAX_SMILIES', 'Max Smilies:');
define ('CMTX_FIELD_LABEL_LONG_WORD', 'Long Word:');
define ('CMTX_FIELD_LABEL_LINE_BREAKS', 'Line Breaks:');
define ('CMTX_FIELD_LABEL_MASK', 'Mask:');
define ('CMTX_FIELD_LABEL_MAX_CAPS', 'Max Capitals:');
define ('CMTX_FIELD_LABEL_PERCENTAGE', 'Percentage:');
define ('CMTX_FIELD_LABEL_SPAM_WORDS', 'Spam Words:');
define ('CMTX_FIELD_LABEL_MILD_SWEARS', 'Mild Swear Words:');
define ('CMTX_FIELD_LABEL_STRONG_SWEARS', 'Strong Swear Words:');
define ('CMTX_FIELD_LABEL_TIMEOUT', 'Timeout:');
define ('CMTX_FIELD_LABEL_REFRESH', 'Refresh:');
define ('CMTX_FIELD_LABEL_INTERVAL', 'Interval:');
define ('CMTX_FIELD_LABEL_BAN_COOKIE', 'Ban Cookie:');
define ('CMTX_FIELD_LABEL_CHECK_REFERRER', 'Check Referrer:');
define ('CMTX_FIELD_LABEL_CHECK_DB_FILE', 'Check DB File:');
define ('CMTX_FIELD_LABEL_SECURITY_KEY', 'Security Key:');
define ('CMTX_FIELD_LABEL_ADMIN_FOLDER', 'Admin Folder:');
define ('CMTX_FIELD_LABEL_TIME_ZONE', 'Time Zone:');
define ('CMTX_FIELD_LABEL_COMMENTS_URL', 'Comments URL:');
define ('CMTX_FIELD_LABEL_MYSQL_DUMP', 'MySQLDump Path:');
define ('CMTX_FIELD_LABEL_WYSIWYG', 'Use WYSIWYG:');
define ('CMTX_FIELD_LABEL_LIMIT_COMMENTS', 'Limit Comments:');
define ('CMTX_FIELD_LABEL_TITLE', 'Title:');
define ('CMTX_FIELD_LABEL_LINK', 'Link:');
define ('CMTX_FIELD_LABEL_DESC', 'Description:');
define ('CMTX_FIELD_LABEL_LANG', 'Language:');
define ('CMTX_FIELD_LABEL_IMAGE', 'Image');
define ('CMTX_FIELD_LABEL_IMAGE_URL', 'Image URL:');
define ('CMTX_FIELD_LABEL_IMAGE_WIDTH', 'Image Width:');
define ('CMTX_FIELD_LABEL_IMAGE_HEIGHT', 'Image Height:');
define ('CMTX_FIELD_LABEL_LIMIT_ITEMS', 'Limit Items:');
define ('CMTX_FIELD_LABEL_LIMIT_AMOUNT', 'Limit Amount:');
define ('CMTX_FIELD_LABEL_LIST', 'List:');
define ('CMTX_FIELD_LABEL_ACTION', 'Action:');
define ('CMTX_FIELD_LABEL_IP_ADDRESS', 'IP Address:');
define ('CMTX_FIELD_LABEL_TIME', 'Time:');
define ('CMTX_FIELD_LABEL_DATE', 'Date:');

/* Values */
define ('CMTX_FIELD_VALUE_YES', 'Yes');
define ('CMTX_FIELD_VALUE_NO', 'No');
define ('CMTX_FIELD_VALUE_COMMENTS', 'Comments');
define ('CMTX_FIELD_VALUE_FORM', 'Form');
define ('CMTX_FIELD_VALUE_NOBODY', 'Nobody');
define ('CMTX_FIELD_VALUE_NONE', 'None');
define ('CMTX_FIELD_VALUE_SENT_TO', 'Sent to');
define ('CMTX_FIELD_VALUE_SUBSCRIBER', 'subscriber');
define ('CMTX_FIELD_VALUE_SUBSCRIBERS', 'subscribers');
define ('CMTX_FIELD_VALUE_ONE_LIKE', 'person likes this comment');
define ('CMTX_FIELD_VALUE_MANY_LIKES', 'people like this comment');
define ('CMTX_FIELD_VALUE_ONE_DISLIKE', 'person dislikes this comment');
define ('CMTX_FIELD_VALUE_MANY_DISLIKES', 'people dislike this comment');
define ('CMTX_FIELD_VALUE_NO_REPORTS', 'There are no pending reports');
define ('CMTX_FIELD_VALUE_ONE_REPORT', 'There is 1 pending report');
define ('CMTX_FIELD_VALUE_THERE_ARE', 'There are');
define ('CMTX_FIELD_VALUE_PENDING_REPORTS', 'pending reports');
define ('CMTX_FIELD_VALUE_GOOD', 'Good');
define ('CMTX_FIELD_VALUE_FAIR', 'Fair');
define ('CMTX_FIELD_VALUE_BAD', 'Bad');
define ('CMTX_FIELD_VALUE_MSG', 'Message');
define ('CMTX_FIELD_VALUE_IS_FLAGGED', 'This comment is flagged');
define ('CMTX_FIELD_VALUE_NOT_FLAGGED', 'This comment is not flagged');
define ('CMTX_FIELD_VALUE_NEWEST', 'Newest');
define ('CMTX_FIELD_VALUE_OLDEST', 'Oldest');
define ('CMTX_FIELD_VALUE_ALLOW', 'Allow');
define ('CMTX_FIELD_VALUE_DISABLE', 'Disable');
define ('CMTX_FIELD_VALUE_HIDE', 'Hide');
define ('CMTX_FIELD_VALUE_SIZE_FIELD', 'field size is');
define ('CMTX_FIELD_VALUE_SIZE_COLUMN', 'column size is');
define ('CMTX_FIELD_VALUE_SIZE_ROW', 'and row size is');
define ('CMTX_FIELD_VALUE_WITH_MAX', 'with a maximum length of');
define ('CMTX_FIELD_VALUE_CHARACTERS', 'characters');
define ('CMTX_FIELD_VALUE_OFF', 'Off');
define ('CMTX_FIELD_VALUE_TEXT', 'Text');
define ('CMTX_FIELD_VALUE_IMAGE', 'Image');
define ('CMTX_FIELD_VALUE_SUBMIT', 'Submit');
define ('CMTX_FIELD_VALUE_COOKIE', 'Cookie');
define ('CMTX_FIELD_VALUE_EITHER', 'Either');
define ('CMTX_FIELD_VALUE_BOTH', 'Both');
define ('CMTX_FIELD_VALUE_SSL', 'SSL');
define ('CMTX_FIELD_VALUE_TLS', 'TLS');
define ('CMTX_FIELD_VALUE_MASK', 'Mask');
define ('CMTX_FIELD_VALUE_REJECT', 'Reject');
define ('CMTX_FIELD_VALUE_APPROVE', 'Approve');
define ('CMTX_FIELD_VALUE_MASK_APPROVE', 'Mask/Approve');
define ('CMTX_FIELD_VALUE_BAN', 'Ban');
define ('CMTX_FIELD_VALUE_VARIABLES', 'Available variables');
define ('CMTX_FIELD_VALUE_LOG_TO_FILE', 'Log errors to file');
define ('CMTX_FIELD_VALUE_SHOW_ON_SCREEN', 'Show on screen');
define ('CMTX_FIELD_VALUE_IS_WRITABLE', 'is writable');
define ('CMTX_FIELD_VALUE_IS_NOT_WRITABLE', 'is not writable');
define ('CMTX_FIELD_VALUE_PERMISSIONS_CORRECT', 'All permissions are correct');
define ('CMTX_FIELD_VALUE_PERMISSIONS_INCORRECT', 'All permissions are not correct');
define ('CMTX_FIELD_VALUE_DELETE_THIS', 'Delete this.');
define ('CMTX_FIELD_VALUE_DELETE_ALL', 'Delete all by this user.');
define ('CMTX_FIELD_VALUE_DO_BAN', 'Ban.');
define ('CMTX_FIELD_VALUE_NO_BAN', 'Don\'t ban.');
define ('CMTX_FIELD_VALUE_ADD_NAME', 'Add name, ');
define ('CMTX_FIELD_VALUE_ADD_EMAIL', 'Add email, ');
define ('CMTX_FIELD_VALUE_ADD_WEBSITE', 'Add website, ');
define ('CMTX_FIELD_VALUE_TO_BANNED_NAMES', ', to banned names list.');
define ('CMTX_FIELD_VALUE_TO_BANNED_EMAILS', ', to banned emails list.');
define ('CMTX_FIELD_VALUE_TO_BANNED_WEBSITES', ', to banned websites list.');
define ('CMTX_FIELD_VALUE_BAD_REPORT', 'Bad Report.');
define ('CMTX_FIELD_VALUE_SPAM', 'Spam.');

?>