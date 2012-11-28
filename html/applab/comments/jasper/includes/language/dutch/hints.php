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

define ('CMTX_HINT_SEND', 'Stuur een e-mailbericht van deze opmerking aan de abonnees.');
define ('CMTX_HINT_STICKY', 'Plak dit commentaar aan de top.');
define ('CMTX_HINT_LOCKED', 'Lock reacties voor deze reactie.');

define ('CMTX_HINT_NEWEST_FIRST', 'Toon de berichten op leeftijd en toon de nieuwste eerst.');
define ('CMTX_HINT_DISPLAY_SAYS', 'Toont het woord <i>zegt</i> achter de naam van de gebruiker.');
define ('CMTX_HINT_JS_VOTE_OK', 'Toon een JavaScript berichten box als de Like/Dislike stem okay is.');

define ('CMTX_HINT_PAGINATION_ENABLED', 'Moeten de berichten over meerdere paginas worden verdeeld?');
define ('CMTX_HINT_PAGINATION_TOP', 'Toon de paginatie links boven het berichten gebied.');
define ('CMTX_HINT_PAGINATION_BOTTOM', 'Toon de paginatie links onder het berichten gebied.');
define ('CMTX_HINT_PAGINATION_PER_PAGE', 'Hoeveel berichten wilt u per pagina tonen.');
define ('CMTX_HINT_PAGINATION_RANGE', 'Het aantal links om aan iedere zijde van de huidige pagina te tonen.');

define ('CMTX_HINT_SORT_BY_ENABLED', 'Geef het Sorteren op links.');
define ('CMTX_HINT_SORT_BY_1', 'Om dit te laten werken op de datum moet ook worden ingeschakeld.');
define ('CMTX_HINT_SORT_BY_2', 'Om dit te laten werken op de datum moet ook worden ingeschakeld.');
define ('CMTX_HINT_SORT_BY_3', 'Om dit te laten werken de Like-functie moet ook worden ingeschakeld.');
define ('CMTX_HINT_SORT_BY_4', 'Om dit te laten werken de Dislike functie moet worden ingeschakeld.');
define ('CMTX_HINT_SORT_BY_5', 'Om dit te laten werken de rating functie moet worden ingeschakeld.');
define ('CMTX_HINT_SORT_BY_6', 'Om dit te laten werken de rating functie moet worden ingeschakeld.');

define ('CMTX_HINT_SHOW_REPLY', 'Toon de reply/reageer link binnenin de berichten box.');
define ('CMTX_HINT_REPLY_DEPTH', 'Hoeveel levels van reacties wilt u toestaan voordat de reply/reageer link wordt uitgeschakeld. Voer een aantal in van 1 of hoger. Zorg ervoor dat de breedte van de reacties past binnenin uw eigen pagina/website.');
define ('CMTX_HINT_REPLY_ARROW', 'Wel of geen pijl naast de reacties.');
define ('CMTX_HINT_SCROLL_REPLY', 'Scroll langzaam naar beneden naar het formulier na het klikken op de reply/reageer link.');

define ('CMTX_HINT_SOCIAL_ENABLED', 'Toon de social sharing links.');

define ('CMTX_HINT_GRAVATAR_DEFAULT', 'Laat leeg voor de feitelijke standaard.');
define ('CMTX_HINT_GRAVATAR_RATING', 'Het publiek type. G is geschikt voor alle doelgroepen.');

define ('CMTX_HINT_DISPLAY_JS_MSG', 'Toon een waarschuwings bericht als JavaScript is uitgeschakeld in de web browser van de gebruiker.');
define ('CMTX_HINT_DISPLAY_AST_SYMBOL', 'Toon een asterisk symbol (*) naast de verplichte velden.');
define ('CMTX_HINT_DISPLAY_AST_MSG', 'Toon een asterisk bericht:<br/>* verplichte informatie');
define ('CMTX_HINT_DISPLAY_EMAIL_NOTE', 'Toon het email bericht:<br/> (wordt niet getoond)');
define ('CMTX_HINT_REPEAT_RATINGS', 'Wat te doen met het waarderingsveld als de gebruker al heeft gestemd.');
define ('CMTX_HINT_AGREE_TO_PREVIEW', 'Moet de gebruiker akkoord gaan met de privacy policy en de algemene voorwarden voordat hij een previeuw krijgt van het bericht?');

define ('CMTX_HINT_APPROVE_COMMENTS', 'Handmatig goedkeuren van alle berichten.');
define ('CMTX_HINT_APPROVE_NOTIFICATIONS', 'Handmatig goedkeuren van alle inschrijvers notificatie emails.');

define ('CMTX_HINT_FLAG_MAX_PER_USER', 'Het maximum aantal hangende rapportages die een bezoeker/gebruiker kan indienen.');
define ('CMTX_HINT_FLAG_MIN_PER_COM', 'Het minimim aantal hangende rapportages voordat een bericht wordt gerapporteerd.');
define ('CMTX_HINT_FLAG_DISAPPROVE', 'Moet een bericht worden gerapporteerd voordat het wordt afgekeurd?');

define ('CMTX_HINT_ONE_NAME', 'Wijs een bericht af wanneer meer dan 1 naam wordt ingevoerd.');
define ('CMTX_HINT_FIX_NAME', 'Hoofdletter voor de eerste letter.<br />Overige letters worden kleine letters.');

define ('CMTX_HINT_FIX_TOWN', 'Hoofdletter voor de eerste letter.<br />Overige letters worden kleine letters.');

define ('CMTX_HINT_APPROVE_WEBSITE', 'Handmatig bericht goedkeuren als een gebruiker een website adres invult in het website veld.');
define ('CMTX_HINT_PING', 'Controleerd of de website bestaat. je server moet in staat zijn dit te kunnen doen.');
define ('CMTX_HINT_NEW_WIN', 'Open link(s) in nieuw scherm (tab).');
define ('CMTX_HINT_NO_FOLLOW', 'Voeg <i>rel=nofollow</i> tag toe aan links zodat search engines ze niet kunnen volgen. Goed voor SEO.');
define ('CMTX_HINT_CONVERT_LINKS', 'Zorg ervoor dat ingevoerde links klikbaar zijn.');
define ('CMTX_HINT_CONVERT_EMAILS', 'Zorg ervoor dat ingevoerde email adressen klikbaar zijn.');
define ('CMTX_HINT_LINE_BREAKS', 'Respecteer dat de gebruiker de enter toets gebruikt on een nieuwe regel te starten.');
define ('CMTX_HINT_MASK', 'Vervang vloekende woorden met dit stuk tekst.');
define ('CMTX_HINT_MAX_CAPITALS', 'Detecteer het dat een gebruiker een grote hoeveelheid hoofdletters invoerd.');
define ('CMTX_HINT_DETECT_REPEATS', 'Detecteer het dat een gebruiker meer dan 3 dezelfde letters achter elkaar invoerd.');

define ('CMTX_HINT_BAN_COOKIE', 'Het aantal dagen voordat het verbod cookie verloopt.');
define ('CMTX_HINT_CHECK_REFERRER', 'Of het nu om te controleren of het formulier is verzonden vanaf uw eigen website.');
define ('CMTX_HINT_CHECK_DB_FILE', 'Of het nu om te controleren of de database gegevens bestand, includes/db/details.php, is alleen-lezen.');
define ('CMTX_HINT_SECURITY_KEY', 'De security key is toegevoegd aan het formulier als verborgen veld. De key is unique voor iedere installatie. Er is normaal geen reden om hem aan te passen.');

define ('CMTX_HINT_ADMIN_FOLDER', 'De naam van je hernoemde admin folder.');
define ('CMTX_HINT_TIME_ZONE', 'De tijdzone van jouw locatie/land.');
define ('CMTX_HINT_COMMENTS_URL', 'De absolute URL van jouw berichtenscript folder.');
define ('CMTX_HINT_MYSQL_DUMP', 'Als je problemen hebt met de database backup tool moet je het server path opgeven naar je MySQLDump file.');
define ('CMTX_HINT_WYSIWYG', 'Moet de WYSIWYG (What You See Is What You Get) HTML editor ingeschakeldc worden voor het bewerken van de berichten pagina?');
define ('CMTX_HINT_LIMIT_COMMENTS', 'Om de prestaties te verbeteren, blijkt alleen dit bedrag van de resultaten in Manage -> Comments.');

define ('CMTX_HINT_VISITOR_ENABLED', 'Of bezoeker activiteit moet worden gevolgd en geregistreerd.');
define ('CMTX_HINT_VISITOR_TIMEOUT', 'De tijd alvorens een online kijker wordt als actief en dus niet langer die de pagina.');
define ('CMTX_HINT_VISITOR_REFRESH', 'Of het nu om automatisch het Extra Tools -> Viewers pagina.');
define ('CMTX_HINT_VISITOR_INTERVAL', 'Hoe vaak naar het Tools Tools -> Viewers pagina.');

?>