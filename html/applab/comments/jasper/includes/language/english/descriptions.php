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

define ('CMTX_DESC_LAYOUT_ORDER', 'Drag & drop the elements below to determine the sort order of the main parts.');
define ('CMTX_DESC_LAYOUT_COMMENTS_ENABLED', 'These settings determine which parts of the comments and their outer area are enabled.');
define ('CMTX_DESC_LAYOUT_COMMENTS_GENERAL', 'This section contains general comment settings.');
define ('CMTX_DESC_LAYOUT_COMMENTS_PAGINATION', 'These settings relate to the layout of the pagination.');
define ('CMTX_DESC_LAYOUT_COMMENTS_SORT_BY_1', 'This setting determines whether the Sort By feature is enabled.');
define ('CMTX_DESC_LAYOUT_COMMENTS_SORT_BY_2', 'These settings are to control which of the links are enabled.');
define ('CMTX_DESC_LAYOUT_COMMENTS_REPLIES', 'These settings are for the reply feature.');
define ('CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_1', 'These settings are for the social links.');
define ('CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_2', 'These settings are to control which of the links are enabled.');
define ('CMTX_DESC_LAYOUT_COMMENTS_GRAVATAR', 'A <b>Gravatar</b> is a user\'s personal image, hosted at gravatar.com, which is retrieved according to their email address.<p/>If the user does not have a Gravatar then the default one is displayed. See <a href="http://en.gravatar.com/site/implement/images/" target="_blank">here</a> for the possible options below.');
define ('CMTX_DESC_LAYOUT_FORM_ENABLED_1', 'This setting determines whether all of the forms are enabled.');
define ('CMTX_DESC_LAYOUT_FORM_ENABLED_2', 'These settings determine which parts of the form are enabled.');
define ('CMTX_DESC_LAYOUT_FORM_REQUIRED', 'These settings determine which parts of the form are required.');
define ('CMTX_DESC_LAYOUT_FORM_DEFAULTS', 'This section allows default values to be set.');
define ('CMTX_DESC_LAYOUT_FORM_GENERAL', 'This section contains general form settings.');
define ('CMTX_DESC_LAYOUT_FORM_SIZES_MAXIMUMS', 'These settings determine the form\'s field sizes and their maximum lengths.');
define ('CMTX_DESC_LAYOUT_FORM_SORT_ORDER_FIELDS', 'Drag & drop the elements below to determine the sort order of the form fields.');
define ('CMTX_DESC_LAYOUT_FORM_SORT_ORDER_BUTTONS', 'Drag & drop the elements below to determine the sort order of the form buttons.');
define ('CMTX_DESC_LAYOUT_FORM_BB_CODE', 'These settings are for the form\'s BB Code tags.');
define ('CMTX_DESC_LAYOUT_FORM_SMILIES', 'These settings are for the form\'s smiley images.');
define ('CMTX_DESC_LAYOUT_POWERED', 'These settings relate to the \'Powered by\' statement.');
define ('CMTX_DESC_SETTINGS_ADMIN', 'These settings are for the admin panel administrator.');
define ('CMTX_DESC_SETTINGS_ADMIN_DETECTION', 'This section allows for the detection of the administrator.');
define ('CMTX_DESC_SETTINGS_AKISMET', 'Akismet is an external, free, automated service used to identify comments as spam. Get your API key <a href="http://akismet.com/" target="_blank">here</a>.<p/>Identified comments require approval. The word \'Akismet\' will appear in the comment\'s Notes section.');
define ('CMTX_DESC_SETTINGS_APPROVAL', 'Select these if you want to <i>manually</i> approve the data below.<p /><b>Note</b>: Detailed options are in Settings -> Processor.');
define ('CMTX_DESC_SETTINGS_EMAIL_METHOD', 'Select the email transport method to use.');
define ('CMTX_DESC_SETTINGS_EMAIL_SUB_CONFIRMATION', 'This is the confirmation email the user receives when they subscribe to a page.');
define ('CMTX_DESC_SETTINGS_EMAIL_SUB_NOTIFICATION', 'This is the email the user receives when they are notified of a new comment.');
define ('CMTX_DESC_SETTINGS_EMAIL_NEW_BAN', 'This is the email the administrator receives when there is a new ban.');
define ('CMTX_DESC_SETTINGS_EMAIL_NEW_FLAG', 'This is the email the administrator receives when a new comment is flagged.');
define ('CMTX_DESC_SETTINGS_EMAIL_NEW_COMMENT_APPROVE', 'This is the email the administrator receives when there is a new comment that requires approval.');
define ('CMTX_DESC_SETTINGS_EMAIL_NEW_COMMENT_OKAY', 'This is the email the administrator receives when there is a new comment that is okay.');
define ('CMTX_DESC_SETTINGS_EMAIL_RESET_PASSWORD', 'This is the email the administrator receives when resetting the password.');
define ('CMTX_DESC_SETTINGS_ERROR_REPORTING', 'Enable these settings to produce any possible errors. Useful for debugging.');
define ('CMTX_DESC_SETTINGS_FLAGGING', 'These settings relate to the report / flag feature.');
define ('CMTX_DESC_SETTINGS_FLOODING', 'These settings relate to the submission of multiple comments over a short period of time.');
define ('CMTX_DESC_SETTINGS_LANGUAGE', 'Select the desired language for the pages.');
define ('CMTX_DESC_SETTINGS_MAINTENANCE', 'Enable this setting to put the script in maintenance mode. Useful during upgrades.<p /><b>Note</b>: The administrator is excluded from maintenance mode.');
define ('CMTX_DESC_SETTINGS_PROCESSING_NAME', 'These settings relate to the processing of the name field.');
define ('CMTX_DESC_SETTINGS_PROCESSING_EMAIL', 'These settings relate to the processing of the email field.');
define ('CMTX_DESC_SETTINGS_PROCESSING_TOWN', 'These settings relate to the processing of the town field.');
define ('CMTX_DESC_SETTINGS_PROCESSING_WEBSITE', 'These settings relate to the processing of the website field.');
define ('CMTX_DESC_SETTINGS_PROCESSING_COMMENT', 'These settings relate to the processing of the comment field.');
define ('CMTX_DESC_SETTINGS_RICH_SNIPPETS_1', '<b>Rich Snippets</b> is a way of marking-up certain types of data so that it appears in a specially displayed format in the search engine results pages, making it easier for users to decide whether to click to your site.<p />In Commentics the type of data which is marked-up is <b>reviews</b> (ratings). It is possible to mark-up an individual review or the aggregate of many. As Commentics is a multi-comment script, the aggregate is used.<p />The reviews can be marked-up with any of three formats: microdata, microformats or RDFa. Commentics uses <b>microformats</b> because it is the longest established of the three, it is easy to add to existing HTML, and it is understood by several search engines including Google and Yahoo.<p />This is an example of how this feature looks:');
define ('CMTX_DESC_SETTINGS_RICH_SNIPPETS_2', 'To achieve this, the following mark-up is needed:');
define ('CMTX_DESC_SETTINGS_RICH_SNIPPETS_3', 'The parts <b>Pizza Suprema</b>, <b>5</b> and <b>39</b> are dynamic, meaning they are different for each page.<p />The part in <span style="color:red;">red</span> is <b>NOT</b> generated by the script, so you will need to add this mark-up to your own part of your page yourself. This is because it includes the item being reviewed (<i>Pizza Suprema</i>) which Commentics does not display. The item being reviewed should already be displayed somewhere on your page above the script so you should be able to simply wrap the mark-up in red around it.<p />The part in black <b>IS</b> generated by the script. "5" is the average rating and "39" is the number of ratings.<p />Once you have added the mark-up, you can enable this feature below. First make sure that you actually have some ratings to mark-up. Afterwards, you can test it <a href="http://www.google.com/webmasters/tools/richsnippets" target="_blank">here</a>.');
define ('CMTX_DESC_SETTINGS_RSS', 'These settings are for the RSS comment feed.');
define ('CMTX_DESC_SETTINGS_SECURITY', 'These settings relate to the security of the script.');
define ('CMTX_DESC_SETTINGS_SYSTEM', 'These settings relate to the system. Be careful when changing these.');
define ('CMTX_DESC_SETTINGS_VIEWERS', 'These settings relate to the Tools -> Viewers feature.');
define ('CMTX_DESC_TASK_DELETE_BANS', 'This task automatically deletes bans that are older than the configured time period.');
define ('CMTX_DESC_TASK_DELETE_REPORTS', 'This task automatically deletes reports that are older than the configured time period.');
define ('CMTX_DESC_TASK_DELETE_VOTERS', 'This task automatically deletes voters that are older than the configured time period.');
define ('CMTX_DESC_TASK_DELETE_COM_IPS', 'This task automatically deletes comment IP Addresses that are older than the configured time period.');
define ('CMTX_DESC_TASK_DELETE_UNCONFIRMED_SUBS', 'This task automatically deletes subscribers who have been unconfirmed for longer than the configured time period.');
define ('CMTX_DESC_TASK_DELETE_INACTIVE_SUBS', 'This task automatically deletes subscribers who have been inactive for longer than the configured time period.');
define ('CMTX_DESC_REPORT_ACCESS', 'This report shows the last 100 pages that the administrator(s) has viewed.');
define ('CMTX_DESC_REPORT_PERMISSIONS', 'This report checks whether your file and folder permissions are set correctly:');
define ('CMTX_DESC_REPORT_VERSION_1', 'The installed version of Commentics is');
define ('CMTX_DESC_REPORT_VERSION_2', 'Below is a history of your upgrades.');
define ('CMTX_DESC_TOOL_DATABASE_BACKUP', 'Create a backup of the database.<p/><b>Note</b>: It is strongly advised that you download these backups to your computer.');
define ('CMTX_DESC_TOOL_OPTIMIZE_TABLES', 'This tool will optimize all of the database tables. This speeds up the database and helps avoid data corruption.<p/><b>Note</b>: For a normal site, running this tool every couple of weeks should suffice.');
define ('CMTX_DESC_TOOL_VIEWERS', 'The following people or spiders are currently viewing your page(s).');

?>