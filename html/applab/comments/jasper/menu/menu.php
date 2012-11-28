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
?>

<?php
if (!defined("IN_COMMENTICS")) { die("Access Denied."); }
?>

<div id="ddtopmenubar" class="mattblackmenu">
<ul>
<li><a href="index.php?page=dashboard"><?php echo CMTX_MENU_TITLE_DASHBOARD ?></a></li>
<li><a href="#" rel="manage"><?php echo CMTX_MENU_TITLE_MANAGE ?></a></li>
<li><a href="#" rel="layout"><?php echo CMTX_MENU_TITLE_LAYOUT ?></a></li>
<li><a href="#" rel="settings"><?php echo CMTX_MENU_TITLE_SETTINGS ?></a></li>
<li><a href="#" rel="tasks"><?php echo CMTX_MENU_TITLE_TASKS ?></a></li>
<li><a href="#" rel="reports"><?php echo CMTX_MENU_TITLE_REPORTS ?></a></li>
<li><a href="#" rel="tools"><?php echo CMTX_MENU_TITLE_TOOLS ?></a></li>
<li><a href="#" rel="help"><?php echo CMTX_MENU_TITLE_HELP ?></a></li>
<li><a href="index.php?page=log_out"><?php echo CMTX_MENU_TITLE_LOG_OUT ?></a></li>
</ul>
</div>

<script type="text/javascript">
ddlevelsmenu.setup("ddtopmenubar", "topbar");
</script>

<ul id="manage" class="ddsubmenustyle">
<li><a href="index.php?page=manage_comments"><?php echo CMTX_MENU_MANAGE_COMMENTS ?></a></li>
<li><a href="index.php?page=manage_pages"><?php echo CMTX_MENU_MANAGE_PAGES ?></a></li>
<li><a href="index.php?page=manage_administrators"><?php echo CMTX_MENU_MANAGE_ADMINS ?></a></li>
<li><a href="index.php?page=manage_bans"><?php echo CMTX_MENU_MANAGE_BANS ?></a></li>
<li><a href="index.php?page=manage_subscribers"><?php echo CMTX_MENU_MANAGE_SUBSCRIBERS ?></a></li>
</ul>

<ul id="layout" class="ddsubmenustyle">
<li><a href="index.php?page=layout_order"><?php echo CMTX_MENU_LAYOUT_ORDER ?></a></li>
<li>
<a href="#"><?php echo CMTX_MENU_LAYOUT_COMMENTS ?></a>
	<ul>
	<li><a href="index.php?page=layout_comments_enabled"><?php echo CMTX_MENU_LAYOUT_COMMENTS_ENABLED ?></a></li>
	<li><a href="index.php?page=layout_comments_general"><?php echo CMTX_MENU_LAYOUT_COMMENTS_GENERAL ?></a></li>
	<li><a href="index.php?page=layout_comments_pagination"><?php echo CMTX_MENU_LAYOUT_COMMENTS_PAGINATION ?></a></li>
	<li><a href="index.php?page=layout_comments_sort_by"><?php echo CMTX_MENU_LAYOUT_COMMENTS_SORT_BY ?></a></li>
	<li><a href="index.php?page=layout_comments_replies"><?php echo CMTX_MENU_LAYOUT_COMMENTS_REPLIES ?></a></li>
	<li><a href="index.php?page=layout_comments_social"><?php echo CMTX_MENU_LAYOUT_COMMENTS_SOCIAL ?></a></li>
	<li><a href="index.php?page=layout_comments_gravatar"><?php echo CMTX_MENU_LAYOUT_COMMENTS_GRAVATAR ?></a></li>
	</ul>
</li>
<li>
<a href="#"><?php echo CMTX_MENU_LAYOUT_FORM ?></a>
	<ul>
	<li><a href="index.php?page=layout_form_enabled"><?php echo CMTX_MENU_LAYOUT_FORM_ENABLED ?></a></li>
	<li><a href="index.php?page=layout_form_required"><?php echo CMTX_MENU_LAYOUT_FORM_REQUIRED ?></a></li>
	<li><a href="index.php?page=layout_form_defaults"><?php echo CMTX_MENU_LAYOUT_FORM_DEFAULTS ?></a></li>
	<li><a href="index.php?page=layout_form_general"><?php echo CMTX_MENU_LAYOUT_FORM_GENERAL ?></a></li>
	<li><a href="index.php?page=layout_form_sizes_maximums"><?php echo CMTX_MENU_LAYOUT_FORM_SIZES_MAXIMUMS ?></a></li>
	<li>
	<a href="#"><?php echo CMTX_MENU_LAYOUT_FORM_SORT_ORDER ?></a>
		<ul>
		<li><a href="index.php?page=layout_form_sort_order_fields"><?php echo CMTX_MENU_LAYOUT_FORM_SORT_ORDER_FIELDS ?></a></li>
		<li><a href="index.php?page=layout_form_sort_order_buttons"><?php echo CMTX_MENU_LAYOUT_FORM_SORT_ORDER_BUTTONS ?></a></li>
		</ul>
	</li>
	<li><a href="index.php?page=layout_form_bb_code"><?php echo CMTX_MENU_LAYOUT_FORM_BB_CODE ?></a></li>
	<li><a href="index.php?page=layout_form_smilies"><?php echo CMTX_MENU_LAYOUT_FORM_SMILIES ?></a></li>
	<li><a href="index.php?page=layout_form_questions"><?php echo CMTX_MENU_LAYOUT_FORM_QUESTIONS ?></a></li>
	</ul>
</li>
<li><a href="index.php?page=layout_powered"><?php echo CMTX_MENU_LAYOUT_POWERED ?></a></li>
</ul>

<ul id="settings" class="ddsubmenustyle">
<li><a href="index.php?page=settings_administrator"><?php echo CMTX_MENU_TITLE_SETTINGS_ADMINISTRATOR ?></a></li>
<li><a href="index.php?page=settings_admin_detection"><?php echo CMTX_MENU_TITLE_SETTINGS_ADMIN_DETECTION ?></a></li>
<li><a href="index.php?page=settings_akismet"><?php echo CMTX_MENU_TITLE_SETTINGS_AKISMET ?></a></li>
<li><a href="index.php?page=settings_approval"><?php echo CMTX_MENU_TITLE_SETTINGS_APPROVAL ?></a></li>
<li>
<a href="#"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL ?></a>
	<ul>
	<li><a href="index.php?page=settings_email_method"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_METHOD ?></a></li>
	<li>
	<a href="#"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR ?></a>
		<ul>
			<li>
			<a href="#"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER ?></a>
				<ul>
				<li><a href="index.php?page=settings_email_editor_user_subscriber_confirmation"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_CONFIRMATION ?></a></li>
				<li><a href="index.php?page=settings_email_editor_user_subscriber_notification"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_NOTIFICATION ?></a></li>
				</ul>
			</li>
			<li><a href="#"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN ?></a>
				<ul>
				<li><a href="index.php?page=settings_email_editor_admin_new_ban"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_BAN ?></a></li>
				<li><a href="index.php?page=settings_email_editor_admin_new_flag"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_FLAG ?></a></li>
				<li><a href="index.php?page=settings_email_editor_admin_new_comment_approve"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_APPROVE ?></a></li>
				<li><a href="index.php?page=settings_email_editor_admin_new_comment_okay"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_OKAY ?></a></li>
				<li><a href="index.php?page=settings_email_editor_admin_reset_password"><?php echo CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_RESET_PASSWORD ?></a></li>
				</ul>
			</li>
		</ul>
	</li>
	</ul>
</li>
<li><a href="index.php?page=settings_error_reporting"><?php echo CMTX_MENU_TITLE_SETTINGS_ERROR_REPORTING ?></a></li>
<li><a href="index.php?page=settings_flagging"><?php echo CMTX_MENU_TITLE_SETTINGS_FLAGGING ?></a></li>
<li><a href="index.php?page=settings_flooding"><?php echo CMTX_MENU_TITLE_SETTINGS_FLOODING ?></a></li>
<li><a href="index.php?page=settings_language"><?php echo CMTX_MENU_TITLE_SETTINGS_LANGUAGE ?></a></li>
<li><a href="index.php?page=settings_maintenance"><?php echo CMTX_MENU_TITLE_SETTINGS_MAINTENANCE ?></a></li>
<li>
<a href="#"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR ?></a>
	<ul>
	<li><a href="index.php?page=settings_processor_name"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR_NAME ?></a></li>
	<li><a href="index.php?page=settings_processor_email"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR_EMAIL ?></a></li>
	<li><a href="index.php?page=settings_processor_town"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR_TOWN ?></a></li>
	<li><a href="index.php?page=settings_processor_website"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR_WEBSITE ?></a></li>
	<li><a href="index.php?page=settings_processor_comment"><?php echo CMTX_MENU_TITLE_SETTINGS_PROCESSOR_COMMENT ?></a></li>
	</ul>	
</li>
<li><a href="index.php?page=settings_rich_snippets"><?php echo CMTX_MENU_TITLE_SETTINGS_RICH_SNIPPETS ?></a></li>
<li><a href="index.php?page=settings_rss"><?php echo CMTX_MENU_TITLE_SETTINGS_RSS ?></a></li>
<li><a href="index.php?page=settings_security"><?php echo CMTX_MENU_TITLE_SETTINGS_SECURITY ?></a></li>
<li><a href="index.php?page=settings_system"><?php echo CMTX_MENU_TITLE_SETTINGS_SYSTEM ?></a></li>
<li><a href="index.php?page=settings_viewers"><?php echo CMTX_MENU_TITLE_SETTINGS_VIEWERS ?></a></li>
</ul>

<ul id="tasks" class="ddsubmenustyle">
<li><a href="index.php?page=task_del_bans"><?php echo CMTX_MENU_TITLE_TASK_DEL_BANS ?></a></li>
<li><a href="index.php?page=task_del_reports"><?php echo CMTX_MENU_TITLE_TASK_DEL_REPORTS ?></a></li>
<li><a href="index.php?page=task_del_voters"><?php echo CMTX_MENU_TITLE_TASK_DEL_VOTERS ?></a></li>
<li><a href="index.php?page=task_del_comment_ips"><?php echo CMTX_MENU_TITLE_TASK_DEL_COMMENT_IPS ?></a></li>
<li><a href="index.php?page=task_del_unconfirmed_subs"><?php echo CMTX_MENU_TITLE_TASK_DEL_UNCONFIRMED_SUBS ?></a></li>
<li><a href="index.php?page=task_del_inactive_subs"><?php echo CMTX_MENU_TITLE_TASK_DEL_INACTIVE_SUBS ?></a></li>
</ul>

<ul id="reports" class="ddsubmenustyle">
<li><a href="index.php?page=report_access"><?php echo CMTX_MENU_TITLE_REPORT_ACCESS ?></a></li>
<li><a href="index.php?page=report_permissions"><?php echo CMTX_MENU_TITLE_REPORT_PERMISSIONS ?></a></li>
<li><a href="index.php?page=report_version"><?php echo CMTX_MENU_TITLE_REPORT_VERSION ?></a></li>
<li><a href="index.php?page=report_phpinfo"><?php echo CMTX_MENU_TITLE_REPORT_PHPINFO ?></a></li>
</ul>

<ul id="tools" class="ddsubmenustyle">
<li><a href="index.php?page=tool_db_backup"><?php echo CMTX_MENU_TITLE_TOOLS_DB_BACKUP ?></a></li>
<li><a href="index.php?page=tool_optimize_tables"><?php echo CMTX_MENU_TITLE_TOOLS_OPTIMIZE_TABLES ?></a></li>
<li><a href="index.php?page=tool_viewers"><?php echo CMTX_MENU_TITLE_TOOLS_VIEWERS ?></a></li>
</ul>

<ul id="help" class="ddsubmenustyle">
<li><a href="http://www.commentics.org/support/knowledgebase.php" target="_blank"><?php echo CMTX_MENU_TITLE_HELP_FAQ ?></a></li>
<li><a href="http://www.commentics.org/forum/" target="_blank"><?php echo CMTX_MENU_TITLE_HELP_FORUM ?></a></li>
<li><a href="http://www.commentics.org/support/knowledgebase.php?article=16" target="_blank"><?php echo CMTX_MENU_TITLE_HELP_DONATE ?></a></li>
<li><a href="http://www.commentics.org/license/" target="_blank"><?php echo CMTX_MENU_TITLE_HELP_LICENSE ?></a></li>
</ul>