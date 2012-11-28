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
define ('CMTX_FIELD_LABEL_CUSTOM_ID', 'ID Customizado:');
define ('CMTX_FIELD_LABEL_USER', 'Usuário:');
define ('CMTX_FIELD_LABEL_USERNAME', 'Usuário:');
define ('CMTX_FIELD_LABEL_NAME', 'Nome:');
define ('CMTX_FIELD_LABEL_EMAIL', 'Email:');
define ('CMTX_FIELD_LABEL_EMAIL_ADDRESS', 'Endereço de Email:');
define ('CMTX_FIELD_LABEL_WEBSITE', 'Website:');
define ('CMTX_FIELD_LABEL_TOWN', 'Cidade:');
define ('CMTX_FIELD_LABEL_COUNTRY', 'País:');
define ('CMTX_FIELD_LABEL_RATING', 'Avaliação:');
define ('CMTX_FIELD_LABEL_COMMENT', 'Comentário:');
define ('CMTX_FIELD_LABEL_REPLY', 'Responder:');
define ('CMTX_FIELD_LABEL_REPLY_TO', 'Responder para:');
define ('CMTX_FIELD_LABEL_BB_CODE', 'BB Code:');
define ('CMTX_FIELD_LABEL_SMILIES', 'Emoticons:');
define ('CMTX_FIELD_LABEL_COUNTER', 'Contador:');
define ('CMTX_FIELD_LABEL_QUESTION', 'Pergunta:');
define ('CMTX_FIELD_LABEL_CAPTCHA', 'Captcha:');
define ('CMTX_FIELD_LABEL_NOTIFY', 'Notificar:');
define ('CMTX_FIELD_LABEL_PRIVACY', 'Privacidade:');
define ('CMTX_FIELD_LABEL_TERMS', 'Termos:');
define ('CMTX_FIELD_LABEL_PREVIEW', 'Visualizar:');
define ('CMTX_FIELD_LABEL_APPROVED', 'Aprovado:');
define ('CMTX_FIELD_LABEL_STICKY', 'Pegajoso:');
define ('CMTX_FIELD_LABEL_LOCKED', 'Trancado:');
define ('CMTX_FIELD_LABEL_NOTES', 'Notes:');
define ('CMTX_FIELD_LABEL_SEND', 'Enviar:');
define ('CMTX_FIELD_LABEL_LIKE', 'Curtir:');
define ('CMTX_FIELD_LABEL_LIKES', 'Curtir:');
define ('CMTX_FIELD_LABEL_DISLIKE', 'Não curtir:');
define ('CMTX_FIELD_LABEL_DISLIKES', 'Não curtir:');
define ('CMTX_FIELD_LABEL_REPORT', 'Relatar:');
define ('CMTX_FIELD_LABEL_REPORTS', 'Relatos:');
define ('CMTX_FIELD_LABEL_FLAG', 'Marcar:');
define ('CMTX_FIELD_LABEL_FLAGGED', 'Marcados:');
define ('CMTX_FIELD_LABEL_REASON', 'Razão:');
define ('CMTX_FIELD_LABEL_CONFIRMED', 'Confirmado:');
define ('CMTX_FIELD_LABEL_ACTIVE', 'Ativo:');
define ('CMTX_FIELD_LABEL_PAGE', 'Página:');
define ('CMTX_FIELD_LABEL_REFERENCE', 'Referência:');
define ('CMTX_FIELD_LABEL_URL', 'URL:');
define ('CMTX_FIELD_LABEL_ENABLED', 'Habilitado:');
define ('CMTX_FIELD_LABEL_FORM_ENABLED', 'Formulário Habilitado:');
define ('CMTX_FIELD_LABEL_PASSWORD', 'Senha:');
define ('CMTX_FIELD_LABEL_PASS', 'Senha:');
define ('CMTX_FIELD_LABEL_REPEAT', 'Repetir:');
define ('CMTX_FIELD_LABEL_NEW_PASSWORD', 'Nova Senha:');
define ('CMTX_FIELD_LABEL_REPEAT_PASSWORD', 'Repetir Senha:');
define ('CMTX_FIELD_LABEL_GRAVATAR', 'Gravatar:');
define ('CMTX_FIELD_LABEL_SORT_BY', 'Sort By:');
define ('CMTX_FIELD_LABEL_AVG_RATING', 'Aval. Média:');
define ('CMTX_FIELD_LABEL_SOCIAL', 'Social:');
define ('CMTX_FIELD_LABEL_RSS_THIS', 'RSS Este:');
define ('CMTX_FIELD_LABEL_RSS_ALL', 'RSS Todos:');
define ('CMTX_FIELD_LABEL_INFO', 'Informação:');
define ('CMTX_FIELD_LABEL_ORDER', 'Ordem:');
define ('CMTX_FIELD_LABEL_DISPLAY_SAYS', 'Exibir "Diz":');
define ('CMTX_FIELD_LABEL_JS_VOTE_OK', 'JS p/ Voto OK:');
define ('CMTX_FIELD_LABEL_TIME_FORMAT', 'Formato Hora:');
define ('CMTX_FIELD_LABEL_DATE_TIME', 'Data/Hora:');
define ('CMTX_FIELD_LABEL_TOP', 'Topo:');
define ('CMTX_FIELD_LABEL_BOTTOM', 'Embaixo:');
define ('CMTX_FIELD_LABEL_PER_PAGE', 'Por Página:');
define ('CMTX_FIELD_LABEL_RANGE', 'Intervalo:');
define ('CMTX_FIELD_LABEL_SORT_BY_1', 'O mais novo:');
define ('CMTX_FIELD_LABEL_SORT_BY_2', 'Mais antiga:');
define ('CMTX_FIELD_LABEL_SORT_BY_3', 'Útil:');
define ('CMTX_FIELD_LABEL_SORT_BY_4', 'Controverso:');
define ('CMTX_FIELD_LABEL_SORT_BY_5', 'Positivo:');
define ('CMTX_FIELD_LABEL_SORT_BY_6', 'Crítico:');
define ('CMTX_FIELD_LABEL_REPLY_DEPTH', 'Níveis Resp.:');
define ('CMTX_FIELD_LABEL_REPLY_ARROW', 'Seta Resp.:');
define ('CMTX_FIELD_LABEL_SCROLL_REPLY', 'Rolagem Resp.:');
define ('CMTX_FIELD_LABEL_NEW_WINDOW', 'Nova Jan.:');
define ('CMTX_FIELD_LABEL_GRAVATAR_DEFAULT', 'Padrão:');
define ('CMTX_FIELD_LABEL_GRAVATAR_RATING', 'Avaliação:');
define ('CMTX_FIELD_LABEL_DISPLAY', 'Exibir:');
define ('CMTX_FIELD_LABEL_ANSWER', 'Resposta:');
define ('CMTX_FIELD_LABEL_DISPLAY_JS_MSG', 'Exibir Mensagem JS:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_SYMBOL', 'Mostrar Símbolo *:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_MSG', 'Mostrar Mensagem *:');
define ('CMTX_FIELD_LABEL_DISPLAY_EMAIL_NOTE', 'Mostrar Nota Email:');
define ('CMTX_FIELD_LABEL_REPEAT_RATINGS', 'Repetir Avaliações:');
define ('CMTX_FIELD_LABEL_AGREE_TO_PREVIEW', 'Aceitar p/ Visualizar:');
define ('CMTX_FIELD_LABEL_DAYS', 'Dias:');
define ('CMTX_FIELD_LABEL_NEW_BAN', 'Novo Ban:');
define ('CMTX_FIELD_LABEL_NEW_COM_APPROVE', 'Novo Coment. (Aprovar):');
define ('CMTX_FIELD_LABEL_NEW_COM_OKAY', 'Novo Comentário (Ok):');
define ('CMTX_FIELD_LABEL_NEW_FLAG', 'Nova Marcação:');
define ('CMTX_FIELD_LABEL_METHOD', 'Método:');
define ('CMTX_FIELD_LABEL_ADD_COOKIE', 'Adicionar Cookie:');
define ('CMTX_FIELD_LABEL_DEL_COOKIE', 'Excluir Cookie:');
define ('CMTX_FIELD_LABEL_AKISMET_KEY', 'API Key:');
define ('CMTX_FIELD_LABEL_APPROVE_COMMENTS', 'Aprovar Comentários:');
define ('CMTX_FIELD_LABEL_APPROVE_NOTIFICATIONS', 'Aprovar Notificações:');
define ('CMTX_FIELD_LABEL_SMTP_HOST', 'Servidor:');
define ('CMTX_FIELD_LABEL_SMTP_PORT', 'Porta:');
define ('CMTX_FIELD_LABEL_SMTP_ENCRYPT', 'Encriptar:');
define ('CMTX_FIELD_LABEL_SMTP_AUTH', 'Autor:');
define ('CMTX_FIELD_LABEL_SENDMAIL_PATH', 'Caminho:');
define ('CMTX_FIELD_LABEL_SUBJECT', 'Assnto:');
define ('CMTX_FIELD_LABEL_FROM_NAME', 'De Nome:');
define ('CMTX_FIELD_LABEL_FROM_EMAIL', 'De Email:');
define ('CMTX_FIELD_LABEL_REPLY_EMAIL', 'Responder Email:');
define ('CMTX_FIELD_LABEL_FRONTEND', 'Área User:');
define ('CMTX_FIELD_LABEL_BACKEND', 'Área Admin:');
define ('CMTX_FIELD_LABEL_VIEW_LOG', 'Ver Log:');
define ('CMTX_FIELD_LABEL_MESSAGE', 'Mensagem:');
define ('CMTX_FIELD_LABEL_APPROVE', 'Aprovar:');
define ('CMTX_FIELD_LABEL_DISAPPROVE', 'Rejeitar:');
define ('CMTX_FIELD_LABEL_MAX_PER_USER', 'Max por Usuário:');
define ('CMTX_FIELD_LABEL_MIN_PER_COM', 'Min por Com:');
define ('CMTX_FIELD_LABEL_DELAY', 'Retardo:');
define ('CMTX_FIELD_LABEL_ALL_PAGES', 'Todas Páginas:');
define ('CMTX_FIELD_LABEL_MAXIMUM', 'Máximo:');
define ('CMTX_FIELD_LABEL_AMOUNT', 'Quantidade:');
define ('CMTX_FIELD_LABEL_PERIOD', 'Período:');
define ('CMTX_FIELD_LABEL_ONE_NAME', 'Um Nome:');
define ('CMTX_FIELD_LABEL_FIX_NAME', 'Corrigir Nome:');
define ('CMTX_FIELD_LABEL_DETECT_LINKS', 'Detectar Links:');
define ('CMTX_FIELD_LABEL_DETECT_REPEATS', 'Detectar Repetições:');
define ('CMTX_FIELD_LABEL_RESERVED_NAME', 'Reservados:');
define ('CMTX_FIELD_LABEL_DUMMY_NAME', 'Fictícios:');
define ('CMTX_FIELD_LABEL_BANNED_NAME', 'Banidos:');
define ('CMTX_FIELD_LABEL_RESERVED_EMAIL', 'Reservados:');
define ('CMTX_FIELD_LABEL_DUMMY_EMAIL', 'Fictícios:');
define ('CMTX_FIELD_LABEL_BANNED_EMAIL', 'Banidos:');
define ('CMTX_FIELD_LABEL_FIX_TOWN', 'Corrigir Cidade:');
define ('CMTX_FIELD_LABEL_RESERVED_TOWN', 'Reservadas:');
define ('CMTX_FIELD_LABEL_DUMMY_TOWN', 'Fictícias:');
define ('CMTX_FIELD_LABEL_BANNED_TOWN', 'Banidas:');
define ('CMTX_FIELD_LABEL_PING', 'Ping:');
define ('CMTX_FIELD_LABEL_NO_FOLLOW', 'Não Seguir:');
define ('CMTX_FIELD_LABEL_RESERVED_WEBSITE', 'Reservados:');
define ('CMTX_FIELD_LABEL_DUMMY_WEBSITE', 'Fictícios:');
define ('CMTX_FIELD_LABEL_BANNED_WEBSITE', 'Banidos:');
define ('CMTX_FIELD_LABEL_APPROVE_IMAGES', 'Aprovar Imagens:');
define ('CMTX_FIELD_LABEL_APPROVE_VIDEOS', 'Aprovar Vídeos:');
define ('CMTX_FIELD_LABEL_CONVERT_LINKS', 'Converter Links:');
define ('CMTX_FIELD_LABEL_CONVERT_EMAILS', 'Converter Emails:');
define ('CMTX_FIELD_LABEL_MIN_CHARS', 'Min Caracteres:');
define ('CMTX_FIELD_LABEL_MIN_WORDS', 'Min Palavras:');
define ('CMTX_FIELD_LABEL_MAX_CHARS', 'Max Caracteres:');
define ('CMTX_FIELD_LABEL_MAX_LINES', 'Max Linhas:');
define ('CMTX_FIELD_LABEL_MAX_SMILIES', 'Max Emoticos:');
define ('CMTX_FIELD_LABEL_LONG_WORD', 'Palavra Longa:');
define ('CMTX_FIELD_LABEL_LINE_BREAKS', 'Quebras de Linha:');
define ('CMTX_FIELD_LABEL_MASK', 'Máscara:');
define ('CMTX_FIELD_LABEL_MAX_CAPS', 'Max Maiúsculas:');
define ('CMTX_FIELD_LABEL_PERCENTAGE', 'Percentual:');
define ('CMTX_FIELD_LABEL_SPAM_WORDS', 'Palavras de Spam:');
define ('CMTX_FIELD_LABEL_MILD_SWEARS', 'Palavrões Leves:');
define ('CMTX_FIELD_LABEL_STRONG_SWEARS', 'Palavrões Pesados:');
define ('CMTX_FIELD_LABEL_TIMEOUT', 'Tempo máximo:');
define ('CMTX_FIELD_LABEL_REFRESH', 'Atualizar:');
define ('CMTX_FIELD_LABEL_INTERVAL', 'Intervalo:');
define ('CMTX_FIELD_LABEL_BAN_COOKIE', 'Cookie de Ban:');
define ('CMTX_FIELD_LABEL_CHECK_REFERRER', 'Checar Ref.:');
define ('CMTX_FIELD_LABEL_CHECK_DB_FILE', 'Checar Arq. DB:');
define ('CMTX_FIELD_LABEL_SECURITY_KEY', 'Chave de Segurança:');
define ('CMTX_FIELD_LABEL_ADMIN_FOLDER', 'Pasta Admin:');
define ('CMTX_FIELD_LABEL_TIME_ZONE', 'Fuso Horário:');
define ('CMTX_FIELD_LABEL_COMMENTS_URL', 'URL de Comentários:');
define ('CMTX_FIELD_LABEL_MYSQL_DUMP', 'Caminho do MySQLDump:');
define ('CMTX_FIELD_LABEL_WYSIWYG', 'Usar WYSIWYG:');
define ('CMTX_FIELD_LABEL_LIMIT_COMMENTS', 'Comentários Limite:');
define ('CMTX_FIELD_LABEL_TITLE', 'Título:');
define ('CMTX_FIELD_LABEL_LINK', 'Link:');
define ('CMTX_FIELD_LABEL_DESC', 'Descrição:');
define ('CMTX_FIELD_LABEL_LANG', 'Idioma:');
define ('CMTX_FIELD_LABEL_IMAGE', 'Imagem');
define ('CMTX_FIELD_LABEL_IMAGE_URL', 'URL de Imagem:');
define ('CMTX_FIELD_LABEL_IMAGE_WIDTH', 'Largura Imagem:');
define ('CMTX_FIELD_LABEL_IMAGE_HEIGHT', 'Altura Imagem:');
define ('CMTX_FIELD_LABEL_LIMIT_ITEMS', 'Limitar Items:');
define ('CMTX_FIELD_LABEL_LIMIT_AMOUNT', 'Limitar Quantidade:');
define ('CMTX_FIELD_LABEL_LIST', 'Lista:');
define ('CMTX_FIELD_LABEL_ACTION', 'Ação:');
define ('CMTX_FIELD_LABEL_IP_ADDRESS', 'Endereço IP:');
define ('CMTX_FIELD_LABEL_TIME', 'Hora:');
define ('CMTX_FIELD_LABEL_DATE', 'Data:');

/* Values */
define ('CMTX_FIELD_VALUE_COMMENTS', 'Comentários');
define ('CMTX_FIELD_VALUE_FORM', 'Forma');
define ('CMTX_FIELD_VALUE_YES', 'Sim');
define ('CMTX_FIELD_VALUE_NO', 'Não');
define ('CMTX_FIELD_VALUE_NOBODY', 'Ninguém');
define ('CMTX_FIELD_VALUE_NONE', 'Nenhum');
define ('CMTX_FIELD_VALUE_SENT_TO', 'Enviar para');
define ('CMTX_FIELD_VALUE_SUBSCRIBER', 'inscrito');
define ('CMTX_FIELD_VALUE_SUBSCRIBERS', 'inscritos');
define ('CMTX_FIELD_VALUE_ONE_LIKE', 'pessoa curtiu este comentário');
define ('CMTX_FIELD_VALUE_MANY_LIKES', 'pessoas curtiram este comentário');
define ('CMTX_FIELD_VALUE_ONE_DISLIKE', 'pessoa não curtiu este comentário');
define ('CMTX_FIELD_VALUE_MANY_DISLIKES', 'pessoas não curtiram este comentário');
define ('CMTX_FIELD_VALUE_NO_REPORTS', 'Não há relatos pendente');
define ('CMTX_FIELD_VALUE_ONE_REPORT', 'Há 1 relato pendente');
define ('CMTX_FIELD_VALUE_THERE_ARE', 'Há');
define ('CMTX_FIELD_VALUE_PENDING_REPORTS', 'relatos Pendentes');
define ('CMTX_FIELD_VALUE_GOOD', 'Bom');
define ('CMTX_FIELD_VALUE_FAIR', 'Razoável');
define ('CMTX_FIELD_VALUE_BAD', 'Ruim');
define ('CMTX_FIELD_VALUE_MSG', 'Mensagem');
define ('CMTX_FIELD_VALUE_NEWEST', 'o mais novo');
define ('CMTX_FIELD_VALUE_OLDEST', 'mais antiga');
define ('CMTX_FIELD_VALUE_IS_FLAGGED', 'Este comentário está marcado');
define ('CMTX_FIELD_VALUE_NOT_FLAGGED', 'Este comentário não está marcado');
define ('CMTX_FIELD_VALUE_ALLOW', 'Permitir');
define ('CMTX_FIELD_VALUE_DISABLE', 'Desabilitar');
define ('CMTX_FIELD_VALUE_HIDE', 'Ocultar');
define ('CMTX_FIELD_VALUE_SIZE_FIELD', 'tamanho do campo é');
define ('CMTX_FIELD_VALUE_SIZE_COLUMN', 'tamanho da coluna é');
define ('CMTX_FIELD_VALUE_SIZE_ROW', 'e o tamanho da linha é');
define ('CMTX_FIELD_VALUE_WITH_MAX', 'com um tamanho máximo de');
define ('CMTX_FIELD_VALUE_CHARACTERS', 'caracteres');
define ('CMTX_FIELD_VALUE_OFF', 'Desligado');
define ('CMTX_FIELD_VALUE_TEXT', 'Texto');
define ('CMTX_FIELD_VALUE_IMAGE', 'Imagem');
define ('CMTX_FIELD_VALUE_SUBMIT', 'Enviar');
define ('CMTX_FIELD_VALUE_COOKIE', 'Cookie');
define ('CMTX_FIELD_VALUE_EITHER', 'Ou');
define ('CMTX_FIELD_VALUE_BOTH', 'Ambos');
define ('CMTX_FIELD_VALUE_SSL', 'SSL');
define ('CMTX_FIELD_VALUE_TLS', 'TLS');
define ('CMTX_FIELD_VALUE_MASK', 'Máscara');
define ('CMTX_FIELD_VALUE_REJECT', 'Rejeitar');
define ('CMTX_FIELD_VALUE_APPROVE', 'Aprovar');
define ('CMTX_FIELD_VALUE_MASK_APPROVE', 'Máscar/Aprovar');
define ('CMTX_FIELD_VALUE_BAN', 'Ban');
define ('CMTX_FIELD_VALUE_VARIABLES', 'Variáveis disponíveis');
define ('CMTX_FIELD_VALUE_LOG_TO_FILE', 'Logar erros para o arquivo');
define ('CMTX_FIELD_VALUE_SHOW_ON_SCREEN', 'Mostrar na tela');
define ('CMTX_FIELD_VALUE_IS_WRITABLE', 'pode ser gravado');
define ('CMTX_FIELD_VALUE_IS_NOT_WRITABLE', 'não pode ser gravado');
define ('CMTX_FIELD_VALUE_PERMISSIONS_CORRECT', 'Todas as permissões estão corretas');
define ('CMTX_FIELD_VALUE_PERMISSIONS_INCORRECT', 'Todas as permissões não estão corretas');
define ('CMTX_FIELD_VALUE_DELETE_THIS', 'Apagar este.');
define ('CMTX_FIELD_VALUE_DELETE_ALL', 'Apagar tudo por esse usuário.');
define ('CMTX_FIELD_VALUE_DO_BAN', 'Proibir.');
define ('CMTX_FIELD_VALUE_NO_BAN', 'Não proibir.');
define ('CMTX_FIELD_VALUE_ADD_NAME', 'Adicione o nome, ');
define ('CMTX_FIELD_VALUE_ADD_EMAIL', 'Adicionar e-mail, ');
define ('CMTX_FIELD_VALUE_ADD_WEBSITE', 'Adicionar website, ');
define ('CMTX_FIELD_VALUE_TO_BANNED_NAMES', ', a lista de nomes proibidos.');
define ('CMTX_FIELD_VALUE_TO_BANNED_EMAILS', ', a lista proibida e-mails.');
define ('CMTX_FIELD_VALUE_TO_BANNED_WEBSITES', ', a lista de sites proibidos.');
define ('CMTX_FIELD_VALUE_BAD_REPORT', 'Relatório Ruim.');
define ('CMTX_FIELD_VALUE_SPAM', 'Spam.');

?>