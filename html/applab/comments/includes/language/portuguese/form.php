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

/* Anchors */
define ('CMTX_ANCHOR_FORM', '#cmtx_form');
define ('CMTX_ANCHOR_RESET', '#cmtx_reset');

/* Heading */
define ('CMTX_FORM_HEADING', 'Adicionar Comentário');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'A função de adicionar comentários está desabilitado.');
define ('CMTX_THIS_FORM_DISABLED', 'A função de adicionar comentários está desabilitado para esta página.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'JavaScript deve ser habilitado para certas características funcionarem.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'você está respondendo para');
define ('CMTX_REPLY_CANCEL', '[cancelar]');
define ('CMTX_REPLY_NOBODY', 'Você não está respondendo para ninguém.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Informação requerida');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Nome:');
define ('CMTX_LABEL_EMAIL', 'Email:');
define ('CMTX_LABEL_WEBSITE', 'Website:');
define ('CMTX_LABEL_TOWN', 'Cidade:');
define ('CMTX_LABEL_COUNTRY', 'País:');
define ('CMTX_LABEL_RATING', 'Avaliação:');
define ('CMTX_LABEL_COMMENT', 'Comentário:');
define ('CMTX_LABEL_QUESTION', 'Pergunta:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Digite seu nome');
define ('CMTX_TITLE_EMAIL', 'Digite seu email');
define ('CMTX_TITLE_WEBSITE', 'Digite seu website');
define ('CMTX_TITLE_TOWN', 'Digite sua cidade');
define ('CMTX_TITLE_COUNTRY', 'Selecione seu País');
define ('CMTX_TITLE_RATING', 'Selecione a nota');
define ('CMTX_TITLE_COMMENT', 'Digite seu comentário');
define ('CMTX_TITLE_QUESTION', 'Digite a resposta para a pergunta');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Imagem Captcha');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Versão audível do captcha (inglês)');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Atualizar imagem captcha');
define ('CMTX_TITLE_CAPTCHA', 'Digite caracteres do captcha');
define ('CMTX_TITLE_NOTIFY', 'Receber emails de notificação');
define ('CMTX_TITLE_PRIVACY', 'Concordar com a política de privacidade');
define ('CMTX_TITLE_TERMS', 'Concordar com os Termos e Condições');
define ('CMTX_TITLE_SUBMIT', 'Adicionar Comentários');
define ('CMTX_TITLE_PREVIEW', 'Visualizar');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(não será publicado)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Por favor, escolha');

/* Ratings */
define ('CMTX_TOP_RATING', 'Selecione a Nota');
define ('CMTX_RATING_ONE', 'Horrível');
define ('CMTX_RATING_TWO', 'Ruim');
define ('CMTX_RATING_THREE', 'Ok');
define ('CMTX_RATING_FOUR', 'Bom');
define ('CMTX_RATING_FIVE', 'Excelente');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Digite um item da lista. Clique em Cancelar ou deixe em branco para terminar a lista.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Digite outro item da lista.Clique em Cancelar ou deixe em branco para terminar a lista.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Digite um item da lista. Clique em Cancelar ou deixe em branco para terminar a lista.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Digite outro item da lista.Clique em Cancelar ou deixe em branco para terminar a lista.');
define ('CMTX_PROMPT_ENTER_LINK', 'Por favor, digite o link para o website');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Opcionalmente, você também pode digitar um título para o link');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Por favor, digite o email');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Opcionalmente, você também pode digitar um título para o email');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Por favor, digite o link para a imagem');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Por favor, insira o link do vídeo. Sites suportados incluem:\nYouTube, Vimeo, MetaCafe e Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(link-inválido)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(email-inválido)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(imagem-inválido)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(vídeo-inválido)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Digite a resposta:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Digite os caracteres:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Notifique-me de novos comentários via email.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'Eu li e entendo a <a href="' . $settings->url_to_comments_folder . 'agreement/portuguese/privacy_policy.html" title="Ver política de privacidade" target="_blank" rel="nofollow">política de privacidade</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'eu li e concordo com os <a href="' . $settings->url_to_comments_folder . 'agreement/portuguese/terms_and_conditions.html" title="Ver termos e condições" target="_blank" rel="nofollow">temos e condições</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Adicionar comentário');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Visualizar');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Por favor aguarde..');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Powered by');
?>