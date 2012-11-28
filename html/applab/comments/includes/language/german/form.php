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
define ('CMTX_FORM_HEADING', 'Kommentar Hinzufügen');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'Das Hinzufügen von Kommentaren wurde deaktiviert.');
define ('CMTX_THIS_FORM_DISABLED', 'Das Hinzufügen von Kommentaren für diese Seite wurde deaktiviert.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'JavaScript muß aktiviert sein, um alle Funktionen dieser Seite nutzen zu k&ouml;nnen.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'Sie sind zu beantworten');
define ('CMTX_REPLY_CANCEL', '[stornieren]');
define ('CMTX_REPLY_NOBODY', 'Sie sind nicht Antworten auf niemanden.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Pflichtfeld');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Name:');
define ('CMTX_LABEL_EMAIL', 'E-Mail:');
define ('CMTX_LABEL_WEBSITE', 'Webseite:');
define ('CMTX_LABEL_TOWN', 'Stadt:');
define ('CMTX_LABEL_COUNTRY', 'Land:');
define ('CMTX_LABEL_RATING', 'Bewertung:');
define ('CMTX_LABEL_COMMENT', 'Kommentar:');
define ('CMTX_LABEL_QUESTION', 'Frage:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Geben Sie Ihren Namen ein');
define ('CMTX_TITLE_EMAIL', 'Geben Sie Ihre E-Mail-Adresse ein');
define ('CMTX_TITLE_WEBSITE', 'Geben Sie Ihre Webseiten-Adresse ein');
define ('CMTX_TITLE_TOWN', 'Geben Sie Ihre Stadt ein');
define ('CMTX_TITLE_COUNTRY', 'Land wählen');
define ('CMTX_TITLE_RATING', 'Bewertung');
define ('CMTX_TITLE_COMMENT', 'Geben Sie Ihren Kommentar ein');
define ('CMTX_TITLE_QUESTION', 'Beantworten Sie die Frage');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Captcha-Bild');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Audible-Version von Captcha');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Captcha-Bild erneuern');
define ('CMTX_TITLE_CAPTCHA', 'Geben Sie die Zeichen des Captcha-Bildes ein');
define ('CMTX_TITLE_NOTIFY', 'Via E-Mail benachrichtigen');
define ('CMTX_TITLE_PRIVACY', 'Ich stimme der Datenschutzerklärung zu');
define ('CMTX_TITLE_TERMS', 'Ich stimme den Bedingungen und Konditionen zu');
define ('CMTX_TITLE_SUBMIT', 'Kommentar hinzufügen');
define ('CMTX_TITLE_PREVIEW', 'Vorschau');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(wird nicht veröffentlicht)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Bitte wählen');

/* Ratings */
define ('CMTX_TOP_RATING', 'Keine Bewertung');
define ('CMTX_RATING_ONE', 'Mangelhaft');
define ('CMTX_RATING_TWO', 'Ausreichend');
define ('CMTX_RATING_THREE', 'Befriedigend');
define ('CMTX_RATING_FOUR', 'Gut');
define ('CMTX_RATING_FIVE', 'Sehr gut');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Listeneintrag eingeben.\nAuf Abbrechen klicken oder das Feld leer lassen, um die Liste zu beenden.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Einen weiteren Listeneintrag eingeben.\nAuf Abbrechen klicken oder das Feld leer lassen, um die Liste zu beenden.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Listeneintrag eingeben.\nAuf Abbrechen klicken oder das Feld leer lassen, um die Liste zu beenden.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Einen weiteren Listeneintrag eingeben.\nAuf Abbrechen klicken oder das Feld leer lassen, um die Liste zu beenden.');
define ('CMTX_PROMPT_ENTER_LINK', 'Bitte den Link zur Webseite eingeben.');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Optional kann ein Titel für den Link angegeben werden.');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Bitte die E-Mail-Adresse eingeben.');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Optional kann ein Titel für die E-Mail-Adresse angegeben werden.');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Bitte den Link zum Bild eingeben.');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Bitte geben Sie den Link des Videos. Unterstützte Plattformen sind:\nYouTube, Vimeo, MetaCafe und Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(ungültiger Link)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(ungültige E-Mail)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(ungültiges Bild)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(ungültiges Video)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Die Antwort lautet:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Die Zeichen sind:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Informiere mich via E-Mail über neue Kommentare.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'Ich habe die <a href="' . $settings->url_to_comments_folder . 'agreement/german/privacy_policy.html" title="Datenschutzrichtlinien" target="_blank" rel="nofollow">Datenschutzrichtlinien</a> gelesen und verstanden.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'Ich habe die <a href="' . $settings->url_to_comments_folder . 'agreement/german/terms_and_conditions.html" title="Nutzungsbedingungen" target="_blank" rel="nofollow">Nutzungsbedingungen</a> gelesen und stimme ihnen zu.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Kommentar hinzufügen');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Vorschau');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Bitte warten...');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Powered by');
?>