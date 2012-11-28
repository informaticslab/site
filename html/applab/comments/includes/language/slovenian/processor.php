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
define ('CMTX_ERROR_NUMBER_PART_1', 'Oprostite, toda ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Oprostite, toda ');
define ('CMTX_ERROR_NUMBER_PART_2', ' napaka je bilo zaznana med obdelavo.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' napak je bilo zaznanih med obdelavo.');
define ('CMTX_ERROR_CORRECTION', 'Prosimo odpravite napako in ponovno pošljite obrazec:');
define ('CMTX_ERRORS_CORRECTION', 'Prosimo odpravite napake in ponovno pošljite obrazec:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Samo predogled');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Hvala.');
define ('CMTX_APPROVAL_TEXT', 'Vaš komentar čaka na odobritev.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Poslana vam je bila potrditvena e-pošta.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Hvala.');
define ('CMTX_SUCCESS_TEXT', 'Vaš komentar je bil dodan.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Poslana vam je bila potrditvena e-pošta.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'Polje \'Ime\' ne more biti prazno. Prosimo vpišite vaše ime.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'Polje \'Ime\' sprejme samo eno besedo. Prosimo vpišite vaše ime.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'Ime lahko vsebuje črke, številke 0 do 9 in znake - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Vpisano ime je rezervirana beseda. Prosimo izberite drugo ime.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Vpisano ime je prepovedana beseda. Prosimo izberite drugo ime.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Vpisano ime ni vaše. Prosimo vpišite svoje pravo ime.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Vpisano ime vsebuje link. Prosimo vpišite svoje ime.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Polje \'E-naslov\' ne sme biti prazno. Prosimo vpišite e-naslov.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'Vpisani e-naslov ni pravilen. Prosimo preverite.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Vpisani e-naslov je rezerviran. Prosimo vpišite drug e-naslov.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Vpisani e-naslov je prepovedan. Prosimo vpišite drug e-naslov.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Vpisani e-naslov ni vaš. Prosimo vpišite vaš pravi e-naslov.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Polje \'Spletna stran\' ne sme biti prazno. Prosimo vpišite vašo spletno stran.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'Polje \'Spletna stran\' ne sme vsebovati privzete vrednosti. Prosimo vpišite vašo spletno stran.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'Naslov spletne strani ni veljaven. Prosimo preverite vpis.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Naslov spletne strani je rezerviran. Prosimo vpišite drug spletni naslov.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Naslov spletne strani je prepovedan. Prosimo odstranite ga.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'Naslov spletne strani v vašem komentarju je prepovedan. Prosimo odstranite ga.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Naslov spletne strani ni vaš. Prosimo vpišite resnični naslov vaše spletne strani.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'Polje Mesto ne sme biti prazno. Prosimo izpolnite ga.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'Mesto lahko vsebuje črke in znake - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Rezervirano ime mesta. Prosimo vpišite drugo mesto.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Prepovedano ime mesta. Prosimo vpišite drugo mesto.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Ni vpisano ime vašega mesta. Prosimo vpišite pravo ime vašega mesta.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Vpisano ime mesta je link. Prosimo pravilno imenujte vaše mesto.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Država ni izbrana. Prosimo izberite državo.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Izbrana država je neveljavna. Prosimo, poskusite znova.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'Ocena ni izbrana. Prosimo izberite jo.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'Izbrana ocena je neveljavna. Prosimo, poskusite znova.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Komentar, na katerega odgovarjate, ni pravilen. Prosimo poizkusite ponovno.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Polje \'Komentar\' ne more biti prazno. Prosimo vpišite komentar.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Prekratek komentar. Prosimo vnesite daljši komentar.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Predolg komentar. Prosimo skrajšajte ga.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Komentar vsebuje preveč vrstic. Prosimo uporabite manj vrstic.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Vnešeni komentar je bil že poslan. Prosimo vnesite nov komentar.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Komentar vsebuje preveč smeškov. Prosimo zmanjšajte njihovo število.');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Komentar vsebuje neprimerne besede. Prosimo odstranite jih.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Preklinjanje ni dovoljeno. Prosimo odstranite kletvice.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'Spam ni dovoljen. Prosimo odstranite spam iz komentarja.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'Komentar vsebuje predolgo besedo. Prosimo skrajšajte predolgo besedo ali jo odstranite.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'V komentarju je preveč velikih črk. Prosimo uporabljajte manj velikih črk.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Vpisani komentar vsebuje link. Prosimo odstranite link.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'Vpisani komentar vsebuje ponavljajoče se črke. Prosimo odstranite ponavljanje.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Polje odgovora na vprašanje ne sme biti prazno. Prosimo vpišite odgovor.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Na vprašanje ste odgovorili napačno. Poizkusite znova.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Polje \'Captcha\' ne sme biti prazno. Prosimo prepišite znake s slike.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Vnešeni znaki \'Captcha\' ne ustrezajo znakom na sliki. Poizkusite ponovno.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Od zadnjega komentarja je minilo premalo časa. Nekoliko počakajte.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Komentirali ste prepogosto. Nekoliko počakajte.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Pojavila se je težava, povezana s potrditvijo vašega vpisa. Ne morete se naročiti več kot enkrat.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Pojavila se je težava, povezana s potrditvijo vašega vpisa. Potrditev vaše naročnine je namreč že v teku.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Prosimo omogočite pošiljanje identifikacije vašega brskalnika.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'Pravkar smo vam onemogočili sodelovanje.<p/> Razlogi so lahko različni, vključno s preklinjanjem, smetenjem (Spam) in zlonamernim vedenjem, npr. hekanjem.<p/>Če menite, da po krivici, se obrnite na administratorja. Pri tem navedite vaš IP naslov.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Oprostite, bili ste izključeni.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Nepravilen varnostni ključ.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Manjka varnostni ključ.');
define ('CMTX_BAN_REASON_INJECTION', 'Injection poizkus.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Nepravilen referrer.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Pomešani podatki.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Prekoračitev količine podatkov.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Vnešeno rezervirano ime.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Vnešeno blokirano ime.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Vnešeno ime brez vsebine (Dummy).');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Link uporabljen v imenu.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Vnešen rezerviran e-mail.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'Vnešen blokiran e-mail.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'Vnešen e-mail brez vsebine (Dummy).');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Vnešen rezerviran spletni naslov.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Vnešen blokiran spletni naslov (polje \'Spletna stran\').');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Vnešen blokiran spletni naslov (polje \'Komentar\').');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Vnešen spletni naslov brez vsebine (Dummy).');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'Vnešeno rezervirano ime mesta.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Vnešeno blokirano ime mesta.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Vnešeno ime mesta brez vsebine (Dummy).');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Kot ime mesta uporabljen je link.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Blažje preklinjanje.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Hudo preklinjanje.');
define ('CMTX_BAN_REASON_SPAMMING', 'Spam.');
define ('CMTX_BAN_REASON_CAPITALS', 'Preveč velikih črk.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link v komentarju.');
define ('CMTX_BAN_REASON_REPEATS', 'Ponavljanja v komentarju.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Potrditi vse.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Vnešeno je bilo rezervirano ime.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Vnešeno je bilo blokirano ime.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Vnešeno je bilo ime brez vsebine (Dummy).');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link uporabljan v imenu.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Vnešen je bil rezerviran e-naslov.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Vnešen je bil blokiran e-naslov.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Vnešeni e-naslov je brez vsebine (Dummy).');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Vnešen je bil naslov spletne strani (url).');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Vnešen je bil rezerviran spletni naslov.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Vnešen je bil blokiran spletni naslov.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Blokiran spletni naslov uporabljan v komentarju.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Vnešen je bil spletni naslov brez vsebine (Dummy).');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Vnešeno je bilo rezervirano ime mesta.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Vnešeno je bilo blokirano ime mesta.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Vnešeno je bilo ime mesta brez vsebine (Dummy).');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link je bil vnešen kot ime mesta.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link je bil vsebovan v komentarju.');
define ('CMTX_APPROVE_REASON_REPEATS', 'Prisotna so ponavljanja v komentarju.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Vnešena je bila slika.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video je dodan.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Blažje preklinjanje.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Hudo preklinjanje.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Spam - smetenje.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Preveč velikih črk.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>