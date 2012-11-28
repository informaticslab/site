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
define ('CMTX_FORM_HEADING', 'Dodaj Komentar');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'Dodajanje komentarjev je onemogočeno.');
define ('CMTX_THIS_FORM_DISABLED', 'Na tej strani je dodajanje komentarjev onemogočeno.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'Pozor: nekatere storitve so na razpolago le ob vključenem JavaScript-u.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'Odgovarjate na');
define ('CMTX_REPLY_CANCEL', '[preklic]');
define ('CMTX_REPLY_NOBODY', 'Ne odgovarjate nikomur.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Zahtevan podatek');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Ime:');
define ('CMTX_LABEL_EMAIL', 'E-pošta:');
define ('CMTX_LABEL_WEBSITE', 'Web:');
define ('CMTX_LABEL_TOWN', 'Mesto:');
define ('CMTX_LABEL_COUNTRY', 'Država:');
define ('CMTX_LABEL_RATING', 'Ocena:');
define ('CMTX_LABEL_COMMENT', 'Komentar:');
define ('CMTX_LABEL_QUESTION', 'Vprašanje:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Vpišite ime');
define ('CMTX_TITLE_EMAIL', 'Vpišite e-naslov');
define ('CMTX_TITLE_WEBSITE', 'Vpišite spletno stran');
define ('CMTX_TITLE_TOWN', 'Vpišite mesto');
define ('CMTX_TITLE_COUNTRY', 'Izberite državo');
define ('CMTX_TITLE_RATING', 'Izberite oceno');
define ('CMTX_TITLE_COMMENT', 'Vpišite komentar');
define ('CMTX_TITLE_QUESTION', 'Odgovorite na vprašanje');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Captcha slika');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Branje znakov Captcha');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Zamenjaj Captcha sliko');
define ('CMTX_TITLE_CAPTCHA', 'Vpišite Captcha znake');
define ('CMTX_TITLE_NOTIFY', 'Želim prejemati e-poštna obvestila');
define ('CMTX_TITLE_PRIVACY', 'Strinjam se s politiko zasebnosti');
define ('CMTX_TITLE_TERMS', 'Strinjam se s pogoji uporabe');
define ('CMTX_TITLE_SUBMIT', 'Dodajte komentar');
define ('CMTX_TITLE_PREVIEW', 'Predogled');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(ne bo objavljeno)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Prosimo izberite');

/* Ratings */
define ('CMTX_TOP_RATING', 'Izberite oceno');
define ('CMTX_RATING_ONE', 'Obupno');
define ('CMTX_RATING_TWO', 'Slabo');
define ('CMTX_RATING_THREE', 'Povprečno');
define ('CMTX_RATING_FOUR', 'Dobro');
define ('CMTX_RATING_FIVE', 'Odlično');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Vpišite podatek. Kliknite \'Prekliči\' ali pustite prazno za zaključek.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Vnesite naslednji podatek. Kliknite \'Prekliči\' ali pustite prazno za zaključek.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Vnesite podatek. Kliknite \'Prekliči\' ali pustite prazno za zaključek.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Vnesite naslednji podatek. Kliknite \'Prekliči\' ali pustite prazno za zaključek.');
define ('CMTX_PROMPT_ENTER_LINK', 'Prosimo vnesite naslov spletne strani (url)');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'Če želite, lahko vnesete tudi naslov linka');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Prosimo vnesite e-poštni naslov');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'Če želite, lahko vnesete tudi naziv e-naslova');
define ('CMTX_PROMPT_ENTER_IMAGE', 'prosimo vpišite povezavo do slike');
define ('CMTX_PROMPT_ENTER_VIDEO', 'Vnesite povezavo na video. Podprte strani so:\nYouTube, Vimeo, MetaCafe in Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(napačen link)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(napačen e-naslov)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(neprava slika)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(nepravi video)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Vnesite odgovor:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Vnesite znake:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Obveščajte me o novih komentarjih po e-pošti.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'Strinjam se z vsebino <a href="' . $settings->url_to_comments_folder . 'agreement/slovenian/privacy_policy.html" title="Ogled politike zasebnosti." target="_blank" rel="nofollow">politike zasebnosti</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'Strinjam se s <a href="' . $settings->url_to_comments_folder . 'agreement/slovenian/terms_and_conditions.html" title="Pogoji uporabe." target="_blank" rel="nofollow">pogoji uporabe</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Nov komentar');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Predogled');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Prosimo počakajte ...');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Storitev omogoča');
?>