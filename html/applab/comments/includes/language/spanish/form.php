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
define ('CMTX_FORM_HEADING', 'Agregar Comentario');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'No se pueden añadir comentarios.');
define ('CMTX_THIS_FORM_DISABLED', 'No se pueden añadir comentarios a esta página.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'JavaScript debe estar habilitado.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'está respondiendo a ');
define ('CMTX_REPLY_CANCEL', '[cancelar]');
define ('CMTX_REPLY_NOBODY', 'No está respondiendo a nadie.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Información requerida');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Nombre:');
define ('CMTX_LABEL_EMAIL', 'Email:');
define ('CMTX_LABEL_WEBSITE', 'Web:');
define ('CMTX_LABEL_TOWN', 'Ciudad:');
define ('CMTX_LABEL_COUNTRY', 'País:');
define ('CMTX_LABEL_RATING', 'Valoración:');
define ('CMTX_LABEL_COMMENT', 'Comentario:');
define ('CMTX_LABEL_QUESTION', 'Pregunta:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Introducir nombre');
define ('CMTX_TITLE_EMAIL', 'Introducir email');
define ('CMTX_TITLE_WEBSITE', 'Introducir Web');
define ('CMTX_TITLE_TOWN', 'Introducir ciudad');
define ('CMTX_TITLE_COUNTRY', 'Elegir país');
define ('CMTX_TITLE_RATING', 'Elegir valoración');
define ('CMTX_TITLE_COMMENT', 'Introducir comentario');
define ('CMTX_TITLE_QUESTION', 'Introducir respuesta a la pregunta');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Imagen Captcha');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Versión de audio del captcha');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Probar con otra imagen');
define ('CMTX_TITLE_CAPTCHA', 'Introducir los caracteres de la imagen');
define ('CMTX_TITLE_NOTIFY', 'recibir notificaciones por Email');
define ('CMTX_TITLE_PRIVACY', 'Estoy de acuerdo con la política de privacidad');
define ('CMTX_TITLE_TERMS', 'Estoy de acuerdo con los términos y condiciones');
define ('CMTX_TITLE_SUBMIT', 'añadir comentario');
define ('CMTX_TITLE_PREVIEW', 'Vista previa');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(no será publicado)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'por favor, elija');

/* Ratings */
define ('CMTX_TOP_RATING', 'Elija valoración');
define ('CMTX_RATING_ONE', 'Muy mal');
define ('CMTX_RATING_TWO', 'Mal');
define ('CMTX_RATING_THREE', 'Normal');
define ('CMTX_RATING_FOUR', 'Bien');
define ('CMTX_RATING_FIVE', 'Excelente');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Introduzca un elemento de la lista. Haga clic en cancelar o dejar en blanco para finalizar la lista.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Introducir otro elemento de la lista. Haga clic en cancelar o dejar en blanco para finalizar la lista.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Introduzca un elemento de la lista. Haga clic en cancelar o dejar en blanco para finalizar la lista.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Introducir otro elemento de la lista. Haga clic en cancelar o dejar en blanco para finalizar la lista.');
define ('CMTX_PROMPT_ENTER_LINK', 'Por favor, introduzca el enlace de la web');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Si lo desea puede introducir un título para el enlace');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Por favor, introduzca el Email');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Si lo desea puede introducir un título para el Email');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Por favor, introduzca el enlace de la imagen');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Por favor introduce el enlace del video. Sitios soportados incluyen:\nYouTube, Vimeo, MetaCafe y Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(enlace-inválido)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(email-inválido)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(imagen-inválida)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(vídeo-inválida)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Introduzca la respuesta:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Introduzca los caracteres:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Informarme de los nuevos comentarios por Email.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'He leido y entendido la <a href="' . $settings->url_to_comments_folder . 'agreement/spanish/privacy_policy.html" title="View privacy policy" target="_blank" rel="nofollow">Política de Privacidad</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'He leido y estoy de acuerdo con <a href="' . $settings->url_to_comments_folder . 'agreement/spanish/terms_and_conditions.html" title="View terms and conditions" target="_blank" rel="nofollow">términos y condiciones</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', ' Enviar ');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Vista previa');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Por favor, espere..');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Powered by');
?>