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
define ('CMTX_FORM_HEADING', 'Dodaj komentar');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'Dodavanje komentara je onemogućeno.');
define ('CMTX_THIS_FORM_DISABLED', 'Dodavanje komentara je onemogućeno za ovu stranicu.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'Upozorenje: neke usluge dostupne su samo uz uključen JavaScript.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'Odgovor na');
define ('CMTX_REPLY_CANCEL', '[Odustani]');
define ('CMTX_REPLY_NOBODY', 'Ne odgovarate nikomu.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Potrebne informacije');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Naziv:');
define ('CMTX_LABEL_EMAIL', 'E-mail:');
define ('CMTX_LABEL_WEBSITE', 'Web:');
define ('CMTX_LABEL_TOWN', 'Grad:');
define ('CMTX_LABEL_COUNTRY', 'Država:');
define ('CMTX_LABEL_RATING', 'Ocjena:');
define ('CMTX_LABEL_COMMENT', 'Komentar:');
define ('CMTX_LABEL_QUESTION', 'Pitanje:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Unesite ime');
define ('CMTX_TITLE_EMAIL', 'Unesite adresu e-pošte');
define ('CMTX_TITLE_WEBSITE', 'Unesite web stranicu');
define ('CMTX_TITLE_TOWN', 'Unesite grad');
define ('CMTX_TITLE_COUNTRY', 'Izaberite državu');
define ('CMTX_TITLE_RATING', 'Izaberite ocjenu');
define ('CMTX_TITLE_COMMENT', 'Unesite komentar');
define ('CMTX_TITLE_QUESTION', 'Unesite odgovor na pitanje');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Captcha slika');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Čitanje captcha znakova');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Osvježi captcha sliku');
define ('CMTX_TITLE_CAPTCHA', 'Unesite captcha znakove');
define ('CMTX_TITLE_NOTIFY', 'Želim primati e-mail obavjesti');
define ('CMTX_TITLE_PRIVACY', 'Prihvaćam pravila o privatnosti');
define ('CMTX_TITLE_TERMS', 'Slažem se s uvjetima korištenja');
define ('CMTX_TITLE_SUBMIT', 'Dodajte komentar');
define ('CMTX_TITLE_PREVIEW', 'Pregled');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(neće biti objavljeno)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Molimo izaberite');

/* Ratings */
define ('CMTX_TOP_RATING', 'Odaberite ocjenu');
define ('CMTX_RATING_ONE', 'Vrlo loše');
define ('CMTX_RATING_TWO', 'Loše');
define ('CMTX_RATING_THREE', 'Prosječno');
define ('CMTX_RATING_FOUR', 'Dobro');
define ('CMTX_RATING_FIVE', 'Izvrsno');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Unesite podatak. Kliknite \'Odustani\' ili ostaviti prazno do kraja.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Unesite sljedeći podatak. Kliknite \'Odustani\' ili ostavite prazno do kraja.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Unesite podatak. Kliknite \'Odustani\' ili ostavite prazno do kraja.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Unesite sljedeći podatak. Kliknite \'Odustani\' ili ostavite prazno do kraja.');
define ('CMTX_PROMPT_ENTER_LINK', 'Molimo unesite link web stranice.');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Ako želite možete naslov linka dodati kasnije.');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Molimo, unesite svoju e-mail adresu.');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Možete unijeti i naziv e-mail adrese.');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Molimo upišite link do slike.');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Molimo upišite link videa. Podržani su:\nYouTube, Vimeo, MetaCafe i Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(neispravan link)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(neispravan e-mail)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(neispravna slika)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(neispravan video)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Unesite odgovor:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Unesite znakove:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Obavijestite me o novim komentarima putem e-maila.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'Slažem se sa sadržajem <a href="' . $settings->url_to_comments_folder . 'agreement/croatian/privacy_policy.html" title="Politika privatnosti." target="_blank" rel="nofollow">ugovora politike privatnosti</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'Pročitao sam i slažem se sa <a href="' . $settings->url_to_comments_folder . 'agreement/croatian/terms_and_conditions.html" title="Uvjeti korišćenja." target="_blank" rel="nofollow">uvjetima korišćenja</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Novi komentar');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Predgled');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Molimo pričekajte ...');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Usluge nudi');
?>