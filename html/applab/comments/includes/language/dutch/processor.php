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
define ('CMTX_ERROR_NUMBER_PART_1', 'Sorry maar ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Sorry maar ');
define ('CMTX_ERROR_NUMBER_PART_2', ' fout gevonden bij het verwerken van uw bericht.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' fouten gevonden bij het verwerken van uw bericht.');
define ('CMTX_ERROR_CORRECTION', 'Corrigeer aub de fout en voeg uw bericht dan toe:');
define ('CMTX_ERRORS_CORRECTION', 'Corrigeer aub de fouten en voeg uw bericht dan toe:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Alleen Preview');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Bedankt.');
define ('CMTX_APPROVAL_TEXT', 'Uw bericht wacht op keuring.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Een bevestiging is per mail verzonden.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Bedankt.');
define ('CMTX_SUCCESS_TEXT', 'Uw bericht is toegevoegd.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Een bevestiging is per email aan u verstuurd.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'Uw naam is verplicht. Voer aub uw naam in.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'U kunt maar 1 naam invoeren.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'Uw naam mag uit letters en de volgende tekens bestaan - & . 0-9 \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Deze naam is al in gebruik. Kies een andere gebruikersnaam.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Deze gebruikersnaam is verboden. Kies een andere gebruikersnaam.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Dit is niet uw gebruikersnaam. Voer uw gebruikersnaam in.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Uw gebruikersnaam bevat een link. Voer uw gebruikersnaam in.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Uw mailadres is verplicht. Voer uw mailadres in deze wordt niet getoond.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'uw mailadres lijkt niet te kloppen. Controleer het aub.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'Het mailadres is gereserveerd. Voer uw mailadres in.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'Dit mailadres is verboden. Voer een ander mailadres in.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'Dit is niet uw mailadres. Voer uw mailadres in.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Het veld website mag niet leeg zijn. Voer uw website in.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'Het veld website mag niet de standaard waarde zijn. Voer een website in.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'De website lijkt niet te kloppen. Controleer uw invoer.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'Deze website is gereserveerd. Voer aub uw website in.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'Deze website is verboden. Aub verwijderen - veranderen.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'De website in uw bericht is verboden. Aub verwijderen.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'Deze website is niet van u. Voer aub uw website in.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'Het veld plaats mag niet leeg zijn. Voer aub uw plaats in.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'Uw plaatsnaam mag letters bevatten en de volgende tekens - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'Deze platsnaam is gereserveerd. Voer een andere plaats in.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'Deze plaatsnaam is verboden. Voer een andere plaats in.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'Deze plaatsnaam hoort niet bij u. Voer uw plaats in.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'Uw plaatsnaam bevat een link. Voer uw plaats in.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'U heeft geen land gekozen. Kies een land.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Het geselecteerde land is ongeldig. Probeer het opnieuw.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'U heeft geen waardering gegeven. Kies uw waardering.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'De geselecteerde rating is ongeldig. Probeer het opnieuw.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Het bericht waarop u reageerd is ongeldig. Probeer het nog eens.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Het veld berciht mag niet leeg zijn. Voer een bericht in.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Uw bericht is te kort. Voer aub een langer bericht in.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Het bericht is te lang. Kort uw bericht aub in.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Uw bericht bevat teveel regels. Probeer aub uw bericht over minder regels te maken.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Dit bericht bestaat al. Voer aub een nieuw bericht in.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Uw bericht bevat teveel smilies. Gebruik aub minder smilies.');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Uw bericht bevat beledigende woorden. Verwijder deze woorden.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Vloeken is niet toegestaan. Pas aub uw bericht aan.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'Spamming is niet toegestaan. Verwijder de spam uit uw bericht.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'uw bericht bevat een erg lang woord. Maak aub dit woord korter of verwijder het.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'Uw berciht bevat teveel hoofdletters. Gebruik minder hoofdletters.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'De ingevoerde opmerking bevat een link. Verwijder de link.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'Uw bericht bevat teveel vaak terugkerende letters. Verwijder ze aub.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Het veld Vraag mag niet leeg zijn. Voer het antwoord aub in.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'Het antwoord op de vraag was niet juist. Probeer het nog eens.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Het veld Captcha mag niet leeg zijn. Voer de juiste tekens in.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'De ingevoerde tekens waren niet juist. Probeer het nog eens.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'U heeft onlangs nog een bericht geplaats. Wacht aub een poosje voordat u weer plaatst.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'U heeft al meerdere berichten geplaatst. Wacht aub een poosje voordat uw weer plaatst.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Er is iets mis met uw inschrijving. U staat al ingeschreven.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Er is iets mis met uw inschrijving. Kijk in uw mailbox.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Zorg ervoor dat uw Browser cookies / referrer informatie toestaat.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'U bent geblokkeerd.<p/>Dit kan om verschillende redenen zijn.<p/>Als u denkt dat dit niet terecht is geef dan uw IP adres door aan de webmaster.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Sorry, u bent geblokkeerd.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Onjuiste security key.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Geen security key.');
define ('CMTX_BAN_REASON_INJECTION', 'Injection poging.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Ongeldige referrer.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Data komen niet overeen.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Maximum data overschreden.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Gereserveerde naam ingevoerd.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Geblokkeerde naam ingevoerd.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Valse naam ingevoerd.');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Link ingevoerd in naam.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Gereserveerd mailadres ingevoerd.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'Geblokkerd mailadres ingevoerd.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'Vals email adres ingevoerd.');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Gereserveerd website adres ingevoerd.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Geblokkeerd webadres ingevoerd.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Geblokkeerd webadres in bericht ingevoerd.');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Nep website ingevoerd.');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'Gereserveerde plaats ingevoerd.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Geblokkeerde plaats ingevoerd.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Nep plaats ingevoerd.');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link in plaatsnaam ingevoerd.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Mild gevloek.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Grof gevloek.');
define ('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
define ('CMTX_BAN_REASON_CAPITALS', 'Teveel hoofdletters.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link in bericht ingevoerd.');
define ('CMTX_BAN_REASON_REPEATS', 'veel herhalingen in bericht.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Alles goedkeuren.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Gereserveerde naam ingevoerd.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Geblokkeerde naam ingevoerd.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nep naam ingevoerd.');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link in naam ingevoerd.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Gereserveerd mailadres ingevoerd.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Geblokkeerd mail adres ingevoerd.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Nep mail adres ingevoerd.');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website ingevoerd.');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Gereserveerd website adres ingevoerd.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Beblokkeerde website ingevoerd onder website.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Beblokkeerde website ingevoerd in bericht.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Nep website ingevoerd.');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Gereserveerde plaats ingevoerd.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Geblokkeerde plaats ingevoerd.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Nep plaats ingevoerd.');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link in plaats ingevoerd.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link in bericht ingevoerd.');
define ('CMTX_APPROVE_REASON_REPEATS', 'Veel herhalingen in uw bericht.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Afbeelding ingevoerd.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video ingevoerd.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Mild vloeken.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Grof vloeken.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Spamming.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Teveel hoofdletters.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>