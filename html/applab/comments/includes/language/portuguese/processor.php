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

/* Error box */
define ('CMTX_ERROR_NUMBER_PART_1', 'Desculpe, mas ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Desculpe, mas ');
define ('CMTX_ERROR_NUMBER_PART_2', ' um erro foi encontrado durante o processamento do seu comentário.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' erros foram encontrados durante o processamento do seu comentário.');
define ('CMTX_ERROR_CORRECTION', 'Por favor corrija este erro e envie o formulário de novo:');
define ('CMTX_ERRORS_CORRECTION', 'Por favor corrija estes erros e envie o formulário de novo:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Apenas Visualização');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Obrigado.');
define ('CMTX_APPROVAL_TEXT', 'Seu comentário está aguardando aprovação.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Um email de confirmação foi enviado para você.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Obrigado.');
define ('CMTX_SUCCESS_TEXT', 'Seu comentário foi adicionado.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Um email de confirmação foi enviado para você.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'O campo Nome não pode ser deixado vazio. Por favor, digite seu nome.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'Apenas um nome pode ser colocado no campo Nome. Por favor, digite apenas um nome.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'O nome deve conter apenas letras e opcionalmente - & . 0-9 \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'O nome digitado é reservado. Por favor, escolha outro nome.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'O nome digitado é proibido. Por favor, escolha outro nome.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'O nome digitado não é o seu. Por favor, digite seu nome real.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'O nome digitado contém um link. Por favor, digite seu nome real.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'O campo Email não pode ser deixado vazio. Por favor, digite seu endereço de email.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'O endereço de email que vocë digitou aparenta ser incorreto. Por favor, cheque o que foi digitado.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'O endereço de email digitado é reservado. Por favor, digite seu endereço de email.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'O endereço de email digitado é proibido. Por favor, digite outro endereço de email.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'O endereço de email digitado não é seu. Por favor, digite seu endereço de email.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'O campo Website não pode ser deixado vazio. Por favor, digite seu website.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'O campo Website não pode conter somente seu valor padrão. Por favor, digite seu website.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'O endereço do website que vocë digitou aparenta ser incorreto. Por favor, cheque o que foi digitado.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'O endereço de website digitado é reservado. Por favor, digite seu website.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'O website digitado é proibido. Por favor, remova-o.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'O website digitado em seu comentário é proibido. Por favor, remova-o.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'O website digitado não é seu. Por favor, digite seu website.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'O campo Cidade não pode ser deixado vazio. Por favor, digete sua cidade.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'A cidade pode conter letras e opcionalmente - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'A cidade digitada é reservada. Por favor, digite outra cidade.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'A cidade digitada é proibida. Por favor, digite outra cidade.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'A cidade digitada não é sua, Por favor, digite sua cidade.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'A cidade digitada contém um link. Por favor, digite sua cidade.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Um País não foi selecionado. Por favor, selecione seu país.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'O país selecionado é inválido. Por favor, tente novamente.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'Uma nota não foi atribuída. Por favor, atribua uma nota.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'A avaliação selecionado é inválido. Por favor, tente novamente.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'O comentário para o qual você está respondendo é inválido. Por favor, tente novamente.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'O campo Comentário não pode ser deixado vazio. Por favor, digite seu comentário.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'O comentário digitado é muito curto. Por favor, digite um comentário maior.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'O comentário digitado é muito longo. Por favor, diminua seu comentário.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'O comentário digitado tem muitas linhas. Por favor, use menos linhas.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'O comentário digitado já foi enviado. Por favor, envie um novo comentário.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'O comentário digitado possui muitos emoticons. Por favor, use menos emoticons');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'O comentário digitado contém palavras ofensivas. Por favor, remova elas.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Xingamento não é permitido. Por favor, remova os palavrões do seu comentário.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'Praticar spam não é permitido. Por favor, remova o spam do seu comentário.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'O comentário digitado contém uma palavra longa demais. Por favor, diminua ou remova esta palavra.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'O comentário digital tem muitas palavras em maiúsculo. Por favor, use menos palavras em maiúsculas.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'O comentário digitado contém um link. Por favor, remova o link.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'O comentário digitado contém caracteres de repetição. Por favor, remova-os.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'O campo Pergunta não pode ser deixado vazio. Por favor, digite uma resposta.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'A resposta à pergunta não está correta. Por favor, tente novamente.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'O campo Captcha não pode ser deixado vazio. Por favor, digite os caracteres.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Os caracteres para a imagem do captcha estão incorretos. Por favor, tente novamente.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Seu último comentário foi enviado recentemente. Por favor, aguarde um pouco.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Você enviou vários comentários recentemente. Por favor, aguarde um pouco.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Houve um problema com sua tentativa de inscrição. Você já está inscrito.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Houve um problema com sua tentativa de inscrição. Você tem emails pendentes.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Por favor, habilite seu navegador para envio de informação de referência de origem.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'Você foi banido.<p/>isto pode ter ocorrido devido a uma varidade de motivos, incluind xingamento, prática de spam e comportamento relacionado a tentativas de invasão (hacker).<p/>Se você acredita que isto foi um erro, por favor contacte o administrador, citando seu endereço de IP.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Desculpe, você foi banido anteriormente.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Chave de segurança incorreta.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Sem chave de segurança.');
define ('CMTX_BAN_REASON_INJECTION', 'Tentativa de injeção.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Indetificação do navegador incorreta.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Dados descasados.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Máximo de dados excedidos.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Nome reservado informado.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Nome banido informado.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Nome fictício informado.');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Link informado no nome.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Endereço de email reservado informado.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'Endereço de email banido informado.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'Endereço de email fictício informado.');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Endereço de website reservado informado.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Website banido informado no campo.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Website banido informado no comentário.');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Website fictício informado.');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'Cidade reservada informada.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Cidade banida informada.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Cidade fictícia informada.');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link informado na cidade.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Xingamento leve.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Xingamento pesado.');
define ('CMTX_BAN_REASON_SPAMMING', 'Prática de spam.');
define ('CMTX_BAN_REASON_CAPITALS', 'Muitas maiúsculas.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link informado no comentário.');
define ('CMTX_BAN_REASON_REPEATS', 'Repetições informadas no comentário.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Todos aprovador.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Nome reservado informado.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Nome banido informado.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nome fictício informado.');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link informado no nome.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Endereço de email reservado informado.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Endereço de email banido informado.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Endereço de email fictício informado.');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website informado.');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Website banido informado.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Website banido informado no campo.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Website banido informado no comentário.');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Cidade reservada informada.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Cidade banida informada.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Cidade fictícia informada.');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link informado na cidade.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link informado no comentário.');
define ('CMTX_APPROVE_REASON_REPEATS', 'Repetições informadas no comentário.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Imagem informada.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Vídeo informada.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Xingamento leve.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Xingamento pesado.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Prática de spam.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Muitas maiúsculas.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>