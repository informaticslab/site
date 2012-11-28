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

define ('CMTX_TITLE_CHECKLIST', 'Checklist');
define ('CMTX_TITLE_DASHBOARD', 'Dashboard');
define ('CMTX_TITLE_COMMENTS', 'Comments');
define ('CMTX_TITLE_EDIT_COMMENT', 'Edit Comment');
define ('CMTX_TITLE_SPAM', 'Spam');
define ('CMTX_TITLE_PAGES', 'Pages');
define ('CMTX_TITLE_EDIT_PAGE', 'Edit Page');
define ('CMTX_TITLE_ADMINS', 'Administrators');
define ('CMTX_TITLE_EDIT_ADMIN', 'Edit Administrator');
define ('CMTX_TITLE_BANS', 'Bans');
define ('CMTX_TITLE_SUBSCRIBERS', 'Subscribers');
define ('CMTX_TITLE_EDIT_SUBSCRIBER', 'Edit Subscriber');
define ('CMTX_TITLE_LAYOUT_ORDER', 'Order');
define ('CMTX_TITLE_COMMENTS_ENABLED', 'Comments: Enabled');
define ('CMTX_TITLE_OUTER_AREA', 'Outer Area');
define ('CMTX_TITLE_COMMENTS_GENERAL', 'Comments: General');
define ('CMTX_TITLE_COMMENTS_PAGINATION', 'Comments: Pagination');
define ('CMTX_TITLE_COMMENTS_SORT_BY', 'Comments: Sort By');
define ('CMTX_TITLE_COMMENTS_REPLIES', 'Comments: Replies');
define ('CMTX_TITLE_COMMENTS_SOCIAL', 'Comments: Social');
define ('CMTX_TITLE_COMMENTS_GRAVATAR', 'Comments: Gravatar');
define ('CMTX_TITLE_FORM_ENABLED', 'Form: Enabled');
define ('CMTX_TITLE_FORM_REQUIRED', 'Form: Required');
define ('CMTX_TITLE_FORM_DEFAULTS', 'Form: Defaults');
define ('CMTX_TITLE_FORM_GENERAL', 'Form: General');
define ('CMTX_TITLE_FORM_SIZES_MAXIMUMS', 'Form: Sizes and Maximums');
define ('CMTX_TITLE_FORM_SORT_ORDER', 'Form: Sort Order');
define ('CMTX_TITLE_FORM_BB_CODE', 'Form: BB Code');
define ('CMTX_TITLE_FORM_SMILIES', 'Form: Smilies');
define ('CMTX_TITLE_FORM_QUESTIONS', 'Form: Questions');
define ('CMTX_TITLE_EDIT_QUESTION', 'Edit Question');
define ('CMTX_TITLE_POWERED', 'Powered');
define ('CMTX_TITLE_ADMIN', 'Administrator');
define ('CMTX_TITLE_EMAIL_PREFERENCES', 'Email Preferences');
define ('CMTX_TITLE_ADMIN_DETECTION', 'Admin Detection');
define ('CMTX_TITLE_AKISMET', 'Akismet');
define ('CMTX_TITLE_APPROVAL', 'Approval');
define ('CMTX_TITLE_EMAIL_METHOD', 'Email Method');
define ('CMTX_TITLE_EMAIL_SUB_CONFIRMATION', 'Email: Subscriber Confirmation');
define ('CMTX_TITLE_EMAIL_SUB_NOTIFICATION', 'Email: Subscriber Notification');
define ('CMTX_TITLE_EMAIL_NEW_BAN', 'Email: New Ban');
define ('CMTX_TITLE_EMAIL_NEW_FLAG', 'Email: New Flag');
define ('CMTX_TITLE_EMAIL_NEW_COMMENT_APPROVE', 'Email: New Comment Approve');
define ('CMTX_TITLE_EMAIL_NEW_COMMENT_OKAY', 'Email: New Comment Okay');
define ('CMTX_TITLE_EMAIL_RESET_PASSWORD', 'Email: Reset Password');
define ('CMTX_TITLE_ERROR_REPORTING', 'Error Reporting');
define ('CMTX_TITLE_ERROR_LOG_FRONTEND', 'Error Log: Frontend');
define ('CMTX_TITLE_ERROR_LOG_BACKEND', 'Error Log: Backend');
define ('CMTX_TITLE_FLAGGING', 'Flagging');
define ('CMTX_TITLE_FLOODING', 'Flooding');
define ('CMTX_TITLE_LANGUAGE', 'Language');
define ('CMTX_TITLE_MAINTENANCE', 'Maintenance');
define ('CMTX_TITLE_PROCESSOR_NAME', 'Processor: Name');
define ('CMTX_TITLE_PROCESSOR_EMAIL', 'Processor: Email');
define ('CMTX_TITLE_PROCESSOR_TOWN', 'Processor: Town');
define ('CMTX_TITLE_PROCESSOR_WEBSITE', 'Processor: Website');
define ('CMTX_TITLE_PROCESSOR_COMMENT', 'Processor: Comment');
define ('CMTX_TITLE_RICH_SNIPPETS', 'Rich Snippets');
define ('CMTX_TITLE_RSS', 'RSS');
define ('CMTX_TITLE_SECURITY', 'Security');
define ('CMTX_TITLE_SYSTEM', 'System');
define ('CMTX_TITLE_VIEWERS', 'Viewers');
define ('CMTX_TITLE_TASK_DELETE_BANS', 'Task: Delete Bans');
define ('CMTX_TITLE_TASK_DELETE_REPORTS', 'Task: Delete Reports');
define ('CMTX_TITLE_TASK_DELETE_VOTERS', 'Task: Delete Voters');
define ('CMTX_TITLE_TASK_DELETE_COM_IPS', 'Task: Delete Comment IPs');
define ('CMTX_TITLE_TASK_DELETE_UNCONFIRMED_SUBS', 'Task: Delete Unconfirmed Subscribers');
define ('CMTX_TITLE_TASK_DELETE_INACTIVE_SUBS', 'Task: Delete Inactive Subscribers');
define ('CMTX_TITLE_ACCESS', 'Access');
define ('CMTX_TITLE_PERMISSIONS', 'Permissions');
define ('CMTX_TITLE_VERSION', 'Version');
define ('CMTX_TITLE_PHPINFO', 'PHP Info');
define ('CMTX_TITLE_DATABASE_BACKUP', 'Database Backup');
define ('CMTX_TITLE_OPTIMIZE_TABLES', 'Optimize Tables');
define ('CMTX_TITLE_LIST_RESERVED_NAMES', 'List: Reserved Names');
define ('CMTX_TITLE_LIST_DUMMY_NAMES', 'List: Dummy Names');
define ('CMTX_TITLE_LIST_BANNED_NAMES', 'List: Banned Names');
define ('CMTX_TITLE_LIST_RESERVED_EMAILS', 'List: Reserved Emails');
define ('CMTX_TITLE_LIST_DUMMY_EMAILS', 'List: Dummy Emails');
define ('CMTX_TITLE_LIST_BANNED_EMAILS', 'List: Banned Emails');
define ('CMTX_TITLE_LIST_RESERVED_TOWNS', 'List: Reserved Towns');
define ('CMTX_TITLE_LIST_DUMMY_TOWNS', 'List: Dummy Towns');
define ('CMTX_TITLE_LIST_BANNED_TOWNS', 'List: Banned Towns');
define ('CMTX_TITLE_LIST_RESERVED_WEBSITES', 'List: Reserved Websites');
define ('CMTX_TITLE_LIST_DUMMY_WEBSITES', 'List: Dummy Websites');
define ('CMTX_TITLE_LIST_BANNED_WEBSITES', 'List: Banned Websites');
define ('CMTX_TITLE_LIST_SPAM_WORDS', 'List: Spam Words');
define ('CMTX_TITLE_LIST_MILD_SWEAR_WORDS', 'List: Mild Swear Words');
define ('CMTX_TITLE_LIST_STRONG_SWEAR_WORDS', 'List: Strong Swear Words');
define ('CMTX_TITLE_HELP_MANAGE_BANS', 'Help: Manage Bans');
define ('CMTX_TITLE_HELP_ADMIN_DETECTION', 'Help: Admin Detection');
define ('CMTX_TITLE_HELP_DATABASE_BACKUP', 'Help: Database Backup');
define ('CMTX_TITLE_HELP_LANGUAGE', 'Help: Language');

?>