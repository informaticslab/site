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
define ('CMTX_ERROR_NUMBER_PART_1', 'Lo sentimos pero ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Lo sentimos pero ');
define ('CMTX_ERROR_NUMBER_PART_2', ' error ha sido encontrado al procesar su comentario.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' errores han sido encontrados al procesar su comentarios.');
define ('CMTX_ERROR_CORRECTION', 'Por favor corrija este error y envíe el formulario otra vez:');
define ('CMTX_ERRORS_CORRECTION', 'Por favor corrija estos errores y envíe el formulario otra vez:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Solo vista previa');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Gracias.');
define ('CMTX_APPROVAL_TEXT', 'El comentario está pendiente de aprobación.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Se le ha enviado un email de confirmación.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Gracias.');
define ('CMTX_SUCCESS_TEXT', 'Su comentario ha sido añadido.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Se le ha enviado un email de confirmación.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'El campo Nombre no puede estar vacío. por favor, escriba su nombre.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'Solo un nombre puede ser escrito en el campo Nombre. Por favor escriba su nombre.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'El nombre debe contener solo letras y opcionalmente - & . 0-9 \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Este nombre está reservado. Por favor, elija otro nombre.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'El nombre introducido está reservado. Por favor, elija otro nombre.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'El nombre introducido no es el suyo. Por favor, introduzca su nombre real.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'El nombre introducido contiene un enlace. Por favor, introduzca su nombre real.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'El campo email no puede estar vacío. Por favor, escriba su dirección de email.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'El email introducido parece ser incorrecto. Por favor, revíselo.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Este email está reservado. Por favor, escriba su dirección de email.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Esta dirección de email está prohibida. Por favor, escriba otra dirección de email.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Esta dirección de email no es la suya. Por favor, escriba su dirección de email.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'El campo Website no puede quedar vacío. Por favor, escriba su dirección web.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'El campo Website no puede tener este valor por defecto. Por favor, introduzca su dirección web.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'La dirección web parece ser incorrecta. Por favor, revísela.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Esta dirección web está reservada. Por favor, introduzca su dirección web.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'La dirección web introducida está prohibida. Por favor, elimínela.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Los enlaces en los comentarios están prohibidos. Por favor, elimínelos.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Esta dirección web no es la suya. Por favor, introduzca su dirección web.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'El campo Ciudad no puede estar vacío. Por favor, introduzca su ciudad.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'El campo ciudad de contener letras y opcionalmente - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'La ciudad introducidad está reservada. Por favor, escriba otra ciudad.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'La ciudad introducida está prhibida. Por favor, escriba otra ciudad.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'La ciudad introducida no es la suya. Por favor, escriba su ciudad.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'La ciudad introducida contiene un enlace. Por favor, escriba su ciudad.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'No ha elejido país. Por favor, elija su país.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'El país seleccionado no es válido. Por favor, inténtelo de nuevo.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'No ha seleccionado ninguna valoración. Por favor, elija una valoración.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'La calificación seleccionada no es válida. Por favor, inténtelo de nuevo.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'El comentario que está respondiendo es inválido. Por favor, inténtelo otra vez.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'El campo comentario no puede estar vacío. Por favor, escriba su  comentario.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'El comentario introducido es demasiado corto. Por favor, escriba un comentario más largo');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'El comentario introducido es demasiado extenso. Por favor, escriba un comentario más corto.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'El comentario introducido tiene demasiadas lineas. Por favor, introduzca menos líneas.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'El comentario introducido ya ha sido enviado. Por favor, introduzca un nuevo comentario.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'El comentario introducido tiene demasiados smilies. Por favor, introduzca menos smilies.');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'El comentario introducido contiene palabras ofensivas. Por favor, elimine estas palabras.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Las palabras malsonantes no está permitidas. Por favor, elimínelas.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'El Spam no está permitido. Por favor, elimin el Spam de su comentario.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'El comentario introducido tiene una palabra demasiado larga. Por favor, cámbiela.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'El comentario introducido contiene demasiadas letras en mayúsculas. Por favor, escriba menos letras en mayúsculas.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'El comentario introducido contiene un enlace. Por favor, quítelo.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'El comentario introducido contiene caracteres repetidos. Por favor, quítelos.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'El campo Pregunta no puede quedar vacío. Por favor, escriba una respuesta.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'La respuesta a la pregunta es incorrecta. Por favor, escriba la respuesta correcta.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'El campo Captcha no puede quedar vacío. Por favor, escriba los caracteres correctamente.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Los caracteres de imagen Catpcha son incorrectos. Por favor, escriba los caracteres correctamente.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Ha enviado un comentario hace poco tiempo. Por favor, espere un poco.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Ha enviado varios comentarios hace poco tiempo. Por favor, espere un poco.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Hay un problema con su subscripción. Ya está subscrito.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Hay un problema con su subscripción. Tiene un email pendiente de confirmación.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Por favor, active su navegador para que pueda enviar información por Referrers.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'Su acceso ha sido prohibido.<p/>Esto puede ser debido a varias razones, incluyendo insultos, spam y comportamientos relacionados con el hacking. <p/> Si usted cree que esto es un error, por favor póngase en contacto con el administrador, indicando su dirección IP.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Lo sentinos pero ha sido prohibido su acceso anteriormente.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Clave de seguridad incorrecta.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Sin Clave de seguridad.');
define ('CMTX_BAN_REASON_INJECTION', 'Intento de inyección.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Referrer incorrecto.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Los datos no coinciden.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Máximo tamaño de datos excedido.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Nombre introducido reservado.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Nombre introducido prohibido.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Nombre introducido ficticio.');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Enlace incluido en el nombre.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Email reservado introducido.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'Email bloqueado.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'Email ficticio.');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Web reservada introducida.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Introducida dirección Web bloqueada.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Introducida dirección Web bloqueada en el comentario.');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Introducida dirección Web ficticia.');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'Introducida ciudad reservada.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Introducida ciudad bloqueada.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Introducida ciudad ficticia.');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Introducida dirección Web en ciudad.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Palabras malsonantes leves.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Palabras malsonantes graves.');
define ('CMTX_BAN_REASON_SPAMMING', 'Spam.');
define ('CMTX_BAN_REASON_CAPITALS', 'Demasiadas letras mayúsculas.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Enlace incluido en el comentario.');
define ('CMTX_BAN_REASON_REPEATS', 'Repeticiones en el comentario.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Aprobar todo.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Nombre reservado introducido.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Nombre bloqueado introducido.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nombre ficticio introducido.');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Enlace incluido en el nombre.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Introducido email reservado.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Introducido email bloqueado.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Introducido email ficticio.');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Dirección wen introducida.');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Introducida dirección web reservada.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Introducida dirección web bloqueada en el campo Web.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Introducida dirección web bloaquead en el comentario.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Introducida dirección web ficticia.');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Introducida ciudad reservada.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Introducida ciudad bloqueada.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Introducida ciudad ficticia.');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Enlace introducido en el campo ciudad.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Enlace introducido en el comentario.');
define ('CMTX_APPROVE_REASON_REPEATS', 'Repeticiones introducidas en el comentario.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Introducida imagen.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Introducida vídeo.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Palabras malsonantes leves.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Palabras malsonantes graves.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Demasiadas letras mayúsculas.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>