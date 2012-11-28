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

/* Dashboard */
define ('CMTX_MENU_TITLE_DASHBOARD', 'Dashboard');

/* Manage */
define ('CMTX_MENU_TITLE_MANAGE', 'Manage');
define ('CMTX_MENU_MANAGE_COMMENTS', 'Comments');
define ('CMTX_MENU_MANAGE_PAGES', 'Pages');
define ('CMTX_MENU_MANAGE_ADMINS', 'Admins');
define ('CMTX_MENU_MANAGE_BANS', 'Bans');
define ('CMTX_MENU_MANAGE_SUBSCRIBERS', 'Subscribers');

/* Layout */
define ('CMTX_MENU_TITLE_LAYOUT', 'Layout');
define ('CMTX_MENU_LAYOUT_ORDER', 'Order');
define ('CMTX_MENU_LAYOUT_COMMENTS', 'Comments');
define ('CMTX_MENU_LAYOUT_COMMENTS_ENABLED', 'Enabled');
define ('CMTX_MENU_LAYOUT_COMMENTS_GENERAL', 'General');
define ('CMTX_MENU_LAYOUT_COMMENTS_PAGINATION', 'Pagination');
define ('CMTX_MENU_LAYOUT_COMMENTS_SORT_BY', 'Sort By');
define ('CMTX_MENU_LAYOUT_COMMENTS_REPLIES', 'Replies');
define ('CMTX_MENU_LAYOUT_COMMENTS_SOCIAL', 'Social');
define ('CMTX_MENU_LAYOUT_COMMENTS_GRAVATAR', 'Gravatar');
define ('CMTX_MENU_LAYOUT_FORM', 'Form');
define ('CMTX_MENU_LAYOUT_FORM_ENABLED', 'Enabled');
define ('CMTX_MENU_LAYOUT_FORM_REQUIRED', 'Required');
define ('CMTX_MENU_LAYOUT_FORM_DEFAULTS', 'Defaults');
define ('CMTX_MENU_LAYOUT_FORM_GENERAL', 'General');
define ('CMTX_MENU_LAYOUT_FORM_SIZES_MAXIMUMS', 'Sizes/Maximums');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER', 'Sort Order');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_FIELDS', 'Fields');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_BUTTONS', 'Buttons');
define ('CMTX_MENU_LAYOUT_FORM_BB_CODE', 'BB Code');
define ('CMTX_MENU_LAYOUT_FORM_SMILIES', 'Smilies');
define ('CMTX_MENU_LAYOUT_FORM_QUESTIONS', 'Questions');
define ('CMTX_MENU_LAYOUT_POWERED', 'Powered');

/* Settings */
define ('CMTX_MENU_TITLE_SETTINGS', 'Settings');
define ('CMTX_MENU_TITLE_SETTINGS_ADMINISTRATOR', 'Administrator');
define ('CMTX_MENU_TITLE_SETTINGS_ADMIN_DETECTION', 'Admin Detection');
define ('CMTX_MENU_TITLE_SETTINGS_AKISMET', 'Akismet');
define ('CMTX_MENU_TITLE_SETTINGS_APPROVAL', 'Approval');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_METHOD', 'Method');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR', 'Editor');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER', 'User');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_CONFIRMATION', 'Subscriber Confirmation');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_NOTIFICATION', 'Subscriber Notification');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN', 'Admin');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_BAN', 'New Ban');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_FLAG', 'New Flag');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_APPROVE', 'New Comment: Approve');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_OKAY', 'New Comment: Okay');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_RESET_PASSWORD', 'Reset Password');
define ('CMTX_MENU_TITLE_SETTINGS_ERROR_REPORTING', 'Error Reporting');
define ('CMTX_MENU_TITLE_SETTINGS_FLAGGING', 'Flagging');
define ('CMTX_MENU_TITLE_SETTINGS_FLOODING', 'Flooding');
define ('CMTX_MENU_TITLE_SETTINGS_LANGUAGE', 'Language');
define ('CMTX_MENU_TITLE_SETTINGS_MAINTENANCE', 'Maintenance');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR', 'Processor');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_NAME', 'Name');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_TOWN', 'Town');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_WEBSITE', 'Website');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_COMMENT', 'Comment');
define ('CMTX_MENU_TITLE_SETTINGS_RICH_SNIPPETS', 'Rich Snippets');
define ('CMTX_MENU_TITLE_SETTINGS_RSS', 'RSS');
define ('CMTX_MENU_TITLE_SETTINGS_SECURITY', 'Security');
define ('CMTX_MENU_TITLE_SETTINGS_SYSTEM', 'System');
define ('CMTX_MENU_TITLE_SETTINGS_VIEWERS', 'Viewers');

/* Tasks */
define ('CMTX_MENU_TITLE_TASKS', 'Tasks');
define ('CMTX_MENU_TITLE_TASK_DEL_BANS', 'Del Bans');
define ('CMTX_MENU_TITLE_TASK_DEL_REPORTS', 'Del Reports');
define ('CMTX_MENU_TITLE_TASK_DEL_VOTERS', 'Del Voters');
define ('CMTX_MENU_TITLE_TASK_DEL_COMMENT_IPS', 'Del Comment IPs');
define ('CMTX_MENU_TITLE_TASK_DEL_UNCONFIRMED_SUBS', 'Del Unconfirmed Subs');
define ('CMTX_MENU_TITLE_TASK_DEL_INACTIVE_SUBS', 'Del Inactive Subs');

/* Reports */
define ('CMTX_MENU_TITLE_REPORTS', 'Reports');
define ('CMTX_MENU_TITLE_REPORT_ACCESS', 'Access');
define ('CMTX_MENU_TITLE_REPORT_PERMISSIONS', 'Permissions');
define ('CMTX_MENU_TITLE_REPORT_VERSION', 'Version');
define ('CMTX_MENU_TITLE_REPORT_PHPINFO', 'PHP Info');

/* Tools */
define ('CMTX_MENU_TITLE_TOOLS', 'Tools');
define ('CMTX_MENU_TITLE_TOOLS_DB_BACKUP', 'Database Backup');
define ('CMTX_MENU_TITLE_TOOLS_OPTIMIZE_TABLES', 'Optimize Tables');
define ('CMTX_MENU_TITLE_TOOLS_VIEWERS', 'Viewers');

/* Help */
define ('CMTX_MENU_TITLE_HELP', 'Help');
define ('CMTX_MENU_TITLE_HELP_FAQ', 'FAQ');
define ('CMTX_MENU_TITLE_HELP_FORUM', 'Forum');
define ('CMTX_MENU_TITLE_HELP_DONATE', 'Donate');
define ('CMTX_MENU_TITLE_HELP_LICENSE', 'License');

/* Log Out */
define ('CMTX_MENU_TITLE_LOG_OUT', 'Log Out');

?>