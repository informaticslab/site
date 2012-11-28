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

define ('CMTX_HINT_SEND', 'Send a notification email of this comment to subscribers.');
define ('CMTX_HINT_STICKY', 'Stick this comment at the top.');
define ('CMTX_HINT_LOCKED', 'Lock replies for this comment.');

define ('CMTX_HINT_NEWEST_FIRST', 'List the comments by order of the newest or oldest ones first.');
define ('CMTX_HINT_DISPLAY_SAYS', 'Display the word <i>says</i> after the name of user.');
define ('CMTX_HINT_JS_VOTE_OK', 'Display a JavaScript message box if the Like/Dislike vote is okay.');

define ('CMTX_HINT_PAGINATION_ENABLED', 'Should the comments be spread over multiple pages?');
define ('CMTX_HINT_PAGINATION_TOP', 'Display the pagination links above the comments area.');
define ('CMTX_HINT_PAGINATION_BOTTOM', 'Display the pagination links below the comments area.');
define ('CMTX_HINT_PAGINATION_PER_PAGE', 'How many comments to display per page.');
define ('CMTX_HINT_PAGINATION_RANGE', 'The amount of links to display at either side of the current page.');

define ('CMTX_HINT_SORT_BY_ENABLED', 'Display the Sort By links.');
define ('CMTX_HINT_SORT_BY_1', 'For this to work the date must also be enabled.');
define ('CMTX_HINT_SORT_BY_2', 'For this to work the date must also be enabled.');
define ('CMTX_HINT_SORT_BY_3', 'For this to work the Like feature must also be enabled.');
define ('CMTX_HINT_SORT_BY_4', 'For this to work the Dislike feature must also be enabled.');
define ('CMTX_HINT_SORT_BY_5', 'For this to work the rating feature must also be enabled.');
define ('CMTX_HINT_SORT_BY_6', 'For this to work the rating feature must also be enabled.');

define ('CMTX_HINT_SHOW_REPLY', 'Display the reply link inside the comment box.');
define ('CMTX_HINT_REPLY_DEPTH', 'How many levels of replies before the reply link is disabled. Enter a number of 1 or higher. Make sure that the width of the replies can fit on your page.');
define ('CMTX_HINT_REPLY_ARROW', 'Whether to display an arrow next to the replies.');
define ('CMTX_HINT_SCROLL_REPLY', 'Gradually scroll down to the form after clicking the reply link.');

define ('CMTX_HINT_SOCIAL_ENABLED', 'Display the social sharing links.');

define ('CMTX_HINT_GRAVATAR_DEFAULT', 'Leave blank for the actual default.');
define ('CMTX_HINT_GRAVATAR_RATING', 'The audience type. G is suitable for all audiences.');

define ('CMTX_HINT_DISPLAY_JS_MSG', 'Display a warning message if JavaScript is disabled in the web browser of user.');
define ('CMTX_HINT_DISPLAY_AST_SYMBOL', 'Display the asterisk symbol (*) next to the required fields.');
define ('CMTX_HINT_DISPLAY_AST_MSG', 'Display the asterisk message:<br/>* Required information');
define ('CMTX_HINT_DISPLAY_EMAIL_NOTE', 'Display the email message:<br/> (will not be published)');
define ('CMTX_HINT_REPEAT_RATINGS', 'What to do with the rating field once a user has already rated.');
define ('CMTX_HINT_AGREE_TO_PREVIEW', 'Should the user have to agree to the privacy policy and the terms & conditions before being able to preview the comment?');

define ('CMTX_HINT_APPROVE_COMMENTS', 'Manually approve all comments.');
define ('CMTX_HINT_APPROVE_NOTIFICATIONS', 'Manually approve all subscriber notification emails.');

define ('CMTX_HINT_FLAG_MAX_PER_USER', 'The maximum number of pending reports a user can submit.');
define ('CMTX_HINT_FLAG_MIN_PER_COM', 'The minimum number of pending reports before a comment is flagged.');
define ('CMTX_HINT_FLAG_DISAPPROVE', 'Should a flagged comment be disapproved?');

define ('CMTX_HINT_ONE_NAME', 'Rejects comment if more than one name entered.');
define ('CMTX_HINT_FIX_NAME', 'Capitalizes first letter.<br />Remaining letters lowercase.');

define ('CMTX_HINT_FIX_TOWN', 'Capitalizes first letter.<br />Remaining letters lowercase.');

define ('CMTX_HINT_APPROVE_WEBSITE', 'Manually approve the comment if the user has entered a website address in the website field.');
define ('CMTX_HINT_PING', 'Checks whether the website exists. Your server must be capable to do this.');
define ('CMTX_HINT_NEW_WIN', 'Open link(s) in new window (tab).');
define ('CMTX_HINT_NO_FOLLOW', 'Add <i>rel=nofollow</i> tag to links to stop search engines from following them. This is good for SEO.');
define ('CMTX_HINT_CONVERT_LINKS', 'Make any web links that are entered clickable.');
define ('CMTX_HINT_CONVERT_EMAILS', 'Make any email links that are entered clickable.');
define ('CMTX_HINT_LINE_BREAKS', 'Respect when the user presses the Enter key to start a new line.');
define ('CMTX_HINT_MASK', 'Replace any swear words found with this piece of text.');
define ('CMTX_HINT_MAX_CAPITALS', 'Detect when a user enters a high percentage of capital letters.');
define ('CMTX_HINT_DETECT_REPEATS', 'Detect when a user enters 3 or more repeating characters.');

define ('CMTX_HINT_BAN_COOKIE', 'The amount of days before the ban cookie expires.');
define ('CMTX_HINT_CHECK_REFERRER', 'Whether to check that the form was submitted from your own website.');
define ('CMTX_HINT_CHECK_DB_FILE', 'Whether to check that the database details file, includes/db/details.php, is read-only.');
define ('CMTX_HINT_SECURITY_KEY', 'The security key is added to the form as a hidden field. The key is unique for every installation. Normally there is no need to change it.');

define ('CMTX_HINT_ADMIN_FOLDER', 'The name of your renamed admin folder.');
define ('CMTX_HINT_TIME_ZONE', 'The time zone of your location.');
define ('CMTX_HINT_COMMENTS_URL', 'The absolute URL of your comments folder.');
define ('CMTX_HINT_MYSQL_DUMP', 'If you are having a problem with the database backup tool you may need to specify the server path to your MySQLDump file.');
define ('CMTX_HINT_WYSIWYG', 'Should the WYSIWYG (What You See Is What You Get) HTML editor be enabled for the Edit Comment page?');
define ('CMTX_HINT_LIMIT_COMMENTS', 'To improve performance, show only this amount of results in Manage -> Comments.');

define ('CMTX_HINT_VISITOR_ENABLED', 'Whether visitor activity should be tracked and recorded.');
define ('CMTX_HINT_VISITOR_TIMEOUT', 'The amount of time before an online viewer is considered to be inactive and therefore no longer viewing the page.');
define ('CMTX_HINT_VISITOR_REFRESH', 'Whether to automatically refresh the Tools -> Viewers page.');
define ('CMTX_HINT_VISITOR_INTERVAL', 'How often to refresh the Tools -> Viewers page.');

?>