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
define ('CMTX_ERROR_NUMBER_PART_1', 'Žao nam je, ali ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Žao nam je, ali ');
define ('CMTX_ERROR_NUMBER_PART_2', ' greška otkrivenih je za vrijeme obrade vašeg komentara.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' greška otkrivenih je za vrijeme obrade vašeg komentara.');
define ('CMTX_ERROR_CORRECTION', 'Molimo ispravite grešku i pošaljite ponovo:');
define ('CMTX_ERRORS_CORRECTION', 'Molimo ispravite greške i pošaljite ponovo:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Samo pregled');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Hvala.');
define ('CMTX_APPROVAL_TEXT', 'Vaš komentar čeka odobrenje.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Poslali smo vam potvrdu na e-mail.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Hvala.');
define ('CMTX_SUCCESS_TEXT', 'Vaš komentar je dodan.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Poslali smo vam potvrdu na e-mail.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'Polje \'Naziv\' ne može biti prazno. Molimo unesite svoje ime.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'Polje \'Naziv\' uzima samo jednu riječ. Molimo unesite svoje ime.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'Polje \'Naziv\' može sadržavati slova, brijeve 0 do 9 i znakove - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Upisano ime je rezervirana riječ. Molimo odaberite drugo ime.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Upisano ime je zabranjena riječ. Molimo odaberite drugo ime.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Upisano ime nije vaše. Molimo unesite svoje pravo ime.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'U upisanom imenu je link. Molimo unesite svoje pravo ime.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Polje \'E-mail\' ne može biti prazno. Molimo unesite adresu e-pošte.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Upisana e-mail adresa nije valjana. Molimo provjerite unos.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Upisana e-mail adresa je rezervirana. Molimo unesite drugu e-mail adresu.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Upisani e-mail je zabranjen. Molimo unesite drugu e-mail adresu.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Upisani e-mail nije vaš. Molimo unesite vašu e-mail adresu.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Polje web stranice ne može biti prazno. Molimo unesite vašu web stranicu.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'Polje web stranice ne može sadržavati zadane vrijednosti. Molimo unesite vašu web stranicu.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Web adresa nije valjana. Molimo provjerite unos.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Web adresa je rezervirana. Molimo unesite vašu web stranicu.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Web adresa je zabranjena. Molimo da ju uklonite.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Web adresa u vašem komentaru je zabranjena. Molimo da ju uklonite.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Web adresa nije vaša. Molimo unesite vašu web stranicu.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'Polje \'Grad\' ne može biti prazno. Molimo unesite svoje mjesto.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'Polje \'Grad\' može sadržavati slova i znakove - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Ime grada je rezervirano. Molimo unesite drugi grad.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Ime grada je zabranjeno. Molimo unesite drugi grad.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Upisani grad nije vaš. Molimo unesite vaš grad.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'U upisanom imenu grada je link. Molimo unesite vaš grad.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Država nije odabrana. Molimo odaberite svoju državu.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Odabrana zemlja nije valjan. Molimo pokušajte ponovno.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'Ocjena nije odabrana. Molimo odaberite ocjenu.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Odabrana Ocjena je nevažeći. Molimo pokušajte ponovno.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Komentar, na kojeg odgovarate, nije točan. Molimo pokušajte ponovo.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Polje za komentar ne može biti prazno. Molimo unesite komentar.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Prekratak komentar. Molimo unesite duži komentar.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Predugi komentar. Molimo skratite komentar.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Komentar ima previše redaka. Upotrebite manje redaka.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Taj komentar već je bio poslan. Molimo upišite svoj komentar.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Komentar sadrži previše smajlića. Molimo smanjite njihov broj.');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Komentar sadrži neprikladan jezik. Molim vas da uklonite uvredljive riječi.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Psovanje nije dopušteno. Molimo vas da uklonite psovke iz svog komentara.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'Spam nije dopušten. Molimo vas da uklonite spam iz vašeg komentara.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'Komentar sadrži dugu riječ. Skratite ili uklonite tu riječ.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'Komentar sadrži jako mnogo velikih slova. Molimo vas da koristite više malih slova.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'U upisanom komentaru je link. Molimo uklonite link.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'Komentar sadrži ponavljajuće znakove. Molimo uklonite ih.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Polje pitanja ne može biti prazno. Molimo unesite odgovor.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Odgovor na pitanje je netočan. Molimo pokušajte ponovno.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', '\'Captcha\' polje ne može biti prazno. Molimo unesite znakove.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Znakovi sa captcha slike su netočni. Molimo pokušajte ponovno.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Vaš zadnji komentar je bio podnesen nedavno. Molimo pričekajte neko vrijeme.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Nedavno ste poslali nekoliko komentara. Molimo pričekajte neko vrijeme.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Došlo je do problema s potvrdom o registraciji. Ne možete se registrirati više od jednom.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Došlo je do problema s potvrdom o registraciji. Potvrda je već u tijeku.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Molimo omogućite u vašem browseru kako bi slao identifikaciju.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'Upravo smo vas blokirali.<p/>Razlozi variraju, uključujući psovanje, spam i zlonamjerno ponašanje, kao što je hekanje.<p/>Ako smatrate da je to pogreška, molimo vas da se obratite administratoru, citirajući vašu IP adresu.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Žao nam je, bili ste blokirani.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Neispravan sigurnosni ključ.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Nedostaje sigurnosni ključ.');
define ('CMTX_BAN_REASON_INJECTION', 'Injection pokušaj.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Neispravan referrer.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Neusklađenost podataka.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Najveća količina podataka premašena.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Upisano pridržano ime.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Upisano blokirano ime.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Upisano ime bez sadržaja.');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Link u imenu.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Pridržana e-pošta.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'E-mail je blokiran.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'E-mail bez sadržaja.');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Pridržana web adresa.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Blokiran URL u polju \'Web stranica\'.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran URL upisan u komentaru.');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Web adresa bez sadržaja.');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'Ime grada je rezervirano.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Ime grada je blokirano.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Naziv grada bez sadržaja.');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Kao naziv grada se koristi link.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Blage psovke.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Jake psovke.');
define ('CMTX_BAN_REASON_SPAMMING', 'Spam.');
define ('CMTX_BAN_REASON_CAPITALS', 'Previše velikih slova.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link u komentaru.');
define ('CMTX_BAN_REASON_REPEATS', 'Ponavljanje u komentaru.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Potvrditi sve.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Pridržano ime.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Upisano blokirano ime.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Upisano ime bez sadržaja.');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link u imenu.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Pridržana e-mail adresa.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Blokirana e-mail adresa.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'E-mail adresa bez sadržaja.');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Web stranica unesena.');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Pridržana web adresa.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Blokiran URL u polju \'Web stranica\'.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran URL upisan u komentaru.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Ime grada bes sadržaja.');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Zabranjeno ime grada.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Uneseno blokirano ime grada.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Naziv grada bez sadržaja.');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link kao ime grada.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link u komentaru');
define ('CMTX_APPROVE_REASON_REPEATS', 'Ponavljanje u komentaru.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Unesena slika.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Unesen video.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Blage psovke.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Jake psovke.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Previše velikih slova.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>