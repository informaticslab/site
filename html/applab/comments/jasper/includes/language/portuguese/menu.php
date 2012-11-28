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
define ('CMTX_MENU_TITLE_DASHBOARD', 'Painel');

/* Manage */
define ('CMTX_MENU_TITLE_MANAGE', 'Gerenciar');
define ('CMTX_MENU_MANAGE_COMMENTS', 'Comentários');
define ('CMTX_MENU_MANAGE_PAGES', 'Páginas');
define ('CMTX_MENU_MANAGE_ADMINS', 'Admins');
define ('CMTX_MENU_MANAGE_BANS', 'Bans');
define ('CMTX_MENU_MANAGE_SUBSCRIBERS', 'Inscritos');

/* Layout */
define ('CMTX_MENU_TITLE_LAYOUT', 'Layout');
define ('CMTX_MENU_LAYOUT_ORDER', 'Ordem');
define ('CMTX_MENU_LAYOUT_COMMENTS', 'Comentários');
define ('CMTX_MENU_LAYOUT_COMMENTS_ENABLED', 'Habilitar');
define ('CMTX_MENU_LAYOUT_COMMENTS_GENERAL', 'Geral');
define ('CMTX_MENU_LAYOUT_COMMENTS_PAGINATION', 'Paginação');
define ('CMTX_MENU_LAYOUT_COMMENTS_SORT_BY', 'Sort By');
define ('CMTX_MENU_LAYOUT_COMMENTS_REPLIES', 'Respostas');
define ('CMTX_MENU_LAYOUT_COMMENTS_SOCIAL', 'Social');
define ('CMTX_MENU_LAYOUT_COMMENTS_GRAVATAR', 'Gravatar');
define ('CMTX_MENU_LAYOUT_FORM', 'Formulário');
define ('CMTX_MENU_LAYOUT_FORM_ENABLED', 'Habilitado');
define ('CMTX_MENU_LAYOUT_FORM_REQUIRED', 'Requerido');
define ('CMTX_MENU_LAYOUT_FORM_DEFAULTS', 'Padrões');
define ('CMTX_MENU_LAYOUT_FORM_GENERAL', 'Geral');
define ('CMTX_MENU_LAYOUT_FORM_SIZES_MAXIMUMS', 'Tamanhos/Máximos');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER', 'Ordenação');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_FIELDS', 'Campos');
define ('CMTX_MENU_LAYOUT_FORM_SORT_ORDER_BUTTONS', 'Botões');
define ('CMTX_MENU_LAYOUT_FORM_BB_CODE', 'BB Code');
define ('CMTX_MENU_LAYOUT_FORM_SMILIES', 'Emoticons');
define ('CMTX_MENU_LAYOUT_FORM_QUESTIONS', 'Perguntas');
define ('CMTX_MENU_LAYOUT_POWERED', 'Powered');

/* Settings */
define ('CMTX_MENU_TITLE_SETTINGS', 'Configurações');
define ('CMTX_MENU_TITLE_SETTINGS_ADMINISTRATOR', 'Administrador');
define ('CMTX_MENU_TITLE_SETTINGS_ADMIN_DETECTION', 'Detecção de Admin');
define ('CMTX_MENU_TITLE_SETTINGS_AKISMET', 'Akismet');
define ('CMTX_MENU_TITLE_SETTINGS_APPROVAL', 'Aprovar');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_METHOD', 'Método');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR', 'Editor');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER', 'Usuário');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_CONFIRMATION', 'Confirmação de Inscrição');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_USER_SUBSCRIBER_NOTIFICATION', 'Notificação de Inscrição');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN', 'Admin');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_BAN', 'Novo Ban');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_FLAG', 'Nova Marca');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_APPROVE', 'Novo Comentário: Aprovar');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_NEW_COMMENT_OKAY', 'Novo Comentário: Ok');
define ('CMTX_MENU_TITLE_SETTINGS_EMAIL_EDITOR_ADMIN_RESET_PASSWORD', 'Resetar Senha');
define ('CMTX_MENU_TITLE_SETTINGS_ERROR_REPORTING', 'Relatório de Erros');
define ('CMTX_MENU_TITLE_SETTINGS_FLAGGING', 'Marcação');
define ('CMTX_MENU_TITLE_SETTINGS_FLOODING', 'Flooding');
define ('CMTX_MENU_TITLE_SETTINGS_LANGUAGE', 'Idioma');
define ('CMTX_MENU_TITLE_SETTINGS_MAINTENANCE', 'Manutenção');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR', 'Processador');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_NAME', 'Nome');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_EMAIL', 'Email');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_TOWN', 'Cidade');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_WEBSITE', 'Website');
define ('CMTX_MENU_TITLE_SETTINGS_PROCESSOR_COMMENT', 'Comentários');
define ('CMTX_MENU_TITLE_SETTINGS_RICH_SNIPPETS', 'Rich Snippets');
define ('CMTX_MENU_TITLE_SETTINGS_RSS', 'RSS');
define ('CMTX_MENU_TITLE_SETTINGS_SECURITY', 'Segurança');
define ('CMTX_MENU_TITLE_SETTINGS_SYSTEM', 'Sistema');
define ('CMTX_MENU_TITLE_SETTINGS_VIEWERS', 'Visualizadores');

/* Tasks */
define ('CMTX_MENU_TITLE_TASKS', 'Tarefas');
define ('CMTX_MENU_TITLE_TASK_DEL_BANS', 'Excluir Bans');
define ('CMTX_MENU_TITLE_TASK_DEL_REPORTS', 'Excluir Relatos');
define ('CMTX_MENU_TITLE_TASK_DEL_VOTERS', 'Excluir Eleitores');
define ('CMTX_MENU_TITLE_TASK_DEL_COMMENT_IPS', 'Excluir IPs de Comentários');
define ('CMTX_MENU_TITLE_TASK_DEL_UNCONFIRMED_SUBS', 'Excluir Inscritos Não Confirmados');
define ('CMTX_MENU_TITLE_TASK_DEL_INACTIVE_SUBS', 'Excluir Inscritos Inativos');

/* Reports */
define ('CMTX_MENU_TITLE_REPORTS', 'Relatórios');
define ('CMTX_MENU_TITLE_REPORT_ACCESS', 'Acessos');
define ('CMTX_MENU_TITLE_REPORT_PERMISSIONS', 'Permissões');
define ('CMTX_MENU_TITLE_REPORT_VERSION', 'Versão');
define ('CMTX_MENU_TITLE_REPORT_PHPINFO', 'Info do PHP');

/* Tools */
define ('CMTX_MENU_TITLE_TOOLS', 'Ferramentas');
define ('CMTX_MENU_TITLE_TOOLS_DB_BACKUP', 'Backup da Base');
define ('CMTX_MENU_TITLE_TOOLS_OPTIMIZE_TABLES', 'Otimizar Tabelas');
define ('CMTX_MENU_TITLE_TOOLS_VIEWERS', 'Visualizadores');

/* Help */
define ('CMTX_MENU_TITLE_HELP', 'Ajuda');
define ('CMTX_MENU_TITLE_HELP_FAQ', 'FAQ');
define ('CMTX_MENU_TITLE_HELP_FORUM', 'Forum');
define ('CMTX_MENU_TITLE_HELP_DONATE', 'Doar');
define ('CMTX_MENU_TITLE_HELP_LICENSE', 'Licença');

/* Log Out */
define ('CMTX_MENU_TITLE_LOG_OUT', 'Deslogar');

?>