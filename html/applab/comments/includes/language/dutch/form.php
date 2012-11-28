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
define ('CMTX_FORM_HEADING', 'Commentaar Toevoegen');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'Berichten toevoegen is uitgeschakeld.');
define ('CMTX_THIS_FORM_DISABLED', 'Berichten toevoegen is uitgeschakeld voor deze pagina.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'JavaScript moet zijn ingeschakeld voor sommige opties om te werken.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'U antwoord op');
define ('CMTX_REPLY_CANCEL', '[annuleer]');
define ('CMTX_REPLY_NOBODY', 'u reageerd op niemand.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Verplichte informatie');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Naam:');
define ('CMTX_LABEL_EMAIL', 'Email:');
define ('CMTX_LABEL_WEBSITE', 'Website:');
define ('CMTX_LABEL_TOWN', 'Stad:');
define ('CMTX_LABEL_COUNTRY', 'Land:');
define ('CMTX_LABEL_RATING', 'Stem:');
define ('CMTX_LABEL_COMMENT', 'Bericht:');
define ('CMTX_LABEL_QUESTION', 'Vraag:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Voer naam in');
define ('CMTX_TITLE_EMAIL', 'Voer emailadres in');
define ('CMTX_TITLE_WEBSITE', 'Voer uw website in');
define ('CMTX_TITLE_TOWN', 'Voer stad in');
define ('CMTX_TITLE_COUNTRY', 'Kies land');
define ('CMTX_TITLE_RATING', 'Kies waardering');
define ('CMTX_TITLE_COMMENT', 'Voer bericht in');
define ('CMTX_TITLE_QUESTION', 'Voer antwoord op vraag in');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Captcha image');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Hoorbare versie van captcha');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Ververs captcha image');
define ('CMTX_TITLE_CAPTCHA', 'Voer tekens van captcha in');
define ('CMTX_TITLE_NOTIFY', 'Ontvang email berichten');
define ('CMTX_TITLE_PRIVACY', 'Akkoord met privacy policy');
define ('CMTX_TITLE_TERMS', 'Akkoord met voorwaarden');
define ('CMTX_TITLE_SUBMIT', 'Voeg bericht toe');
define ('CMTX_TITLE_PREVIEW', 'Preview');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(wordt niet getoond)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Aub kiezen');

/* Ratings */
define ('CMTX_TOP_RATING', 'Kies waardering');
define ('CMTX_RATING_ONE', 'Verschrikkelijk');
define ('CMTX_RATING_TWO', 'Matig');
define ('CMTX_RATING_THREE', 'Redelijk');
define ('CMTX_RATING_FOUR', 'Goed');
define ('CMTX_RATING_FIVE', 'Uitstekend');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Voer een item in. Klik op annuleer of laat leeg om de lijst te eindigen.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Voer een ander item in. Klik op annuleer of laat leeg om de lijst te eindigen.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Voer een item in. Klik op annuleer of laat leeg om de lijst te eindigen.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Voer nog een item in. Klik op annuleer of laat leeg om de lijst te eindigen.');
define ('CMTX_PROMPT_ENTER_LINK', 'Voer aub uw website link in');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Als optie kunt u ook nog een titel voor uw link invoeren');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Voer het email adres in');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Als optie kunt u ook nog een titel voor het mail adres ingeven');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Voer de link naar de afbeelding in');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Geef de link van de video. Ondersteunde platforms zijn:\nYouTube, Vimeo, MetaCafe en Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(ongeldige-link)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(ongeldige-email)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(ongeldige-afbeelding)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(ongeldige-video)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Voer antwoord in:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Voer tekens in:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Meld me over nieuwe berichten via email.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'Ik begrijp en heb de privacy policy gelezen <a href="' . $settings->url_to_comments_folder . 'agreement/dutch/privacy_policy.html" title="Privacy policy" target="_blank" rel="nofollow">Privacy policy</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'Ik begrijp de voorwaarden en heb ze gelezen <a href="' . $settings->url_to_comments_folder . 'agreement/dutch/terms_and_conditions.html" title="Voorwaarden" target="_blank" rel="nofollow">Voorwaarden</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Voeg bericht toe');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Preview');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Aub wachten..');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Powered by');
?>