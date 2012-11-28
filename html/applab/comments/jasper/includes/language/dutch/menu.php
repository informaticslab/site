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
define ('CMTX_MENU_TITLE_MANAGE', 'Beheer');
define ('CMTX_MENU_MANAGE_COMMENTS', 'Berichten');
define ('CMTX_MENU_MANAGE_PAGES', 'Paginas');
define ('CMTX_MENU_MANAGE_ADMINS', 'Admins');
define ('CMTX_MENU_MANAGE_BANS', 'Blokkeringen');
define ('CMTX_MENU_MANAGE_SUBSCRIBERS', 'Inschrijvingen');

/* Layout */
define ('CMTX_MENU_TITLE_LAYOUT', 'Layout');
define ('CMTX_MENU_LAYOUT_ORDER', 'Volgorde');
define ('CMTX_MENU_LAYOUT_COMMENTS', 'Berichten');
define ('CMTX_MENU_LAYOUT_COMMENTS_ENABLED', 'Ingeschakeld');
define ('CMTX_MENU_LAYOUT_COMMENTS_GENERAL', 'Algemeen');
define ('CMTX_MENU_LAYOUT_COMMENTS_PAGINATION', 'Paginatie');
define ('CMTX_MENU_LAYOUT_COMMENTS_SORT_BY', 'Sorteren op');
define ('CMTX_MENU_LAYOUT_COMMENTS_REPLIES', 'Reacties');
define ('CMTX_MENU_LAYOUT_COMMENTS_SOCIAL', 'Social');
define ('CMTX_MENU_LAYOUT_COMMENTS_GRAVATAR', 'Gravatar');
define ('CMTX_MENU_LAYOUT_FORM', 'Formulier');
define ('CMTX_MENU_LAYOUT_FORM_ENABLED', 'Ingeschakeld');
define ('CMTX_MENU_LAYOUT_FORM_REQUIRED', 'Verplicht');
define ('CMTX_MENU_LAYOUT_FORM_DEFAULTS', 'Standaard');
define ('CMTX_MENU_LAYOUT_FORM_GENERAL', 'Algemeen');
define ('CMTX_MENU_LAYOUT_FORM_SIZES_MAXIMUMS', 'Afmeting/Maximums');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER', 'Sortering volgorde');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_FIELDS', 'Velden');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_BUTTONS', 'Knoppen');
define ('CMTX_MENU_LAYOUT_FORM_BB_CODE', 'BB Code');
define ('CMTX_MENU_LAYOUT_FORM_SMILIES', 'Smilies');
define ('CMTX_MENU_LAYOUT_FORM_QUESTIONS', 'Vragen');
define ('CMTX_MENU_LAYOUT_POWERED', 'Powered');

/* Settings */
define ('CMTX_MENU_TITLE_SETTINGS', 'Instellingen');
define ('CMTX_MENU_TITLE_SETTINGS_ADMINISTRATOR', 'Administrator');
define ('CMTX_MENU_TITLE_SETTINGS_ADMIN_DETECTION', 'Admin Detectie');
define ('CMTX_MENU_TITLE_SETTINGS_AKISMET', 'Akismet');
define ('CMTX_MENU_TITLE_SETTINGS_APPROVAL', 'Goedkeuring');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_METHOD', 'Methode');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR', 'Editor');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER', 'Gebruiker');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_CONFIRMATION', 'Inschrijver Bevestiging');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_NOTIFICATION', 'Inschrijver Notificatie');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN', 'Admin');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_BAN', 'Nieuwe Ban');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_FLAG', 'Nieuwe Rapportage');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_APPROVE', 'Nieuw bericht: Goedkeuren');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_OKAY', 'Nieuw bericht: Okay');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_RESET_PASSWORD', 'Reset wachtwoord');
define ('CMTX_MENU_TITLE_SETTINGS_ERROR_REPORTING', 'Fouten rapportage');
define ('CMTX_MENU_TITLE_SETTINGS_FLAGGING', 'Rapportages');
define ('CMTX_MENU_TITLE_SETTINGS_FLOODING', 'Flooding');
define ('CMTX_MENU_TITLE_SETTINGS_LANGUAGE', 'Taal');
define ('CMTX_MENU_TITLE_SETTINGS_MAINTENANCE', 'Onderhoud');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR', 'Processor');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_NAME', 'Naam');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_TOWN', 'Stad');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_WEBSITE', 'Website');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_COMMENT', 'Bericht');
define ('CMTX_MENU_TITLE_SETTINGS_RICH_SNIPPETS', 'Rich Snippets');
define ('CMTX_MENU_TITLE_SETTINGS_RSS', 'RSS');
define ('CMTX_MENU_TITLE_SETTINGS_SECURITY', 'Security');
define ('CMTX_MENU_TITLE_SETTINGS_SYSTEM', 'Systeem');
define ('CMTX_MENU_TITLE_SETTINGS_VIEWERS', 'Viewers');

/* Tasks */
define ('CMTX_MENU_TITLE_TASKS', 'Taken');
define ('CMTX_MENU_TITLE_TASK_DEL_BANS', 'Del blokkeringen');
define ('CMTX_MENU_TITLE_TASK_DEL_REPORTS', 'Del rapportages');
define ('CMTX_MENU_TITLE_TASK_DEL_VOTERS', 'Del Stemmen');
define ('CMTX_MENU_TITLE_TASK_DEL_COMMENT_IPS', 'Del bericht IPs');
define ('CMTX_MENU_TITLE_TASK_DEL_UNCONFIRMED_SUBS', 'Del onbevestigde inschrijvers');
define ('CMTX_MENU_TITLE_TASK_DEL_INACTIVE_SUBS', 'Del Inactive inschrijvers');

/* Reports */
define ('CMTX_MENU_TITLE_REPORTS', 'Rapporten');
define ('CMTX_MENU_TITLE_REPORT_ACCESS', 'Toegang');
define ('CMTX_MENU_TITLE_REPORT_PERMISSIONS', 'Rechten');
define ('CMTX_MENU_TITLE_REPORT_VERSION', 'Versie');
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