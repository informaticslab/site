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

/* Labels */
define ('CMTX_FIELD_LABEL_ID', 'ID:');
define ('CMTX_FIELD_LABEL_CUSTOM_ID', 'Custom ID:');
define ('CMTX_FIELD_LABEL_USER', 'Gebruiker:');
define ('CMTX_FIELD_LABEL_USERNAME', 'Gebruikersnaam:');
define ('CMTX_FIELD_LABEL_NAME', 'Naam:');
define ('CMTX_FIELD_LABEL_EMAIL', 'Email:');
define ('CMTX_FIELD_LABEL_EMAIL_ADDRESS', 'Email Adres:');
define ('CMTX_FIELD_LABEL_WEBSITE', 'Website:');
define ('CMTX_FIELD_LABEL_TOWN', 'Stad:');
define ('CMTX_FIELD_LABEL_COUNTRY', 'Land:');
define ('CMTX_FIELD_LABEL_RATING', 'Waardering:');
define ('CMTX_FIELD_LABEL_COMMENT', 'Bericht:');
define ('CMTX_FIELD_LABEL_REPLY', 'Reageer:');
define ('CMTX_FIELD_LABEL_REPLY_TO', 'Reageer op:');
define ('CMTX_FIELD_LABEL_BB_CODE', 'BB Code:');
define ('CMTX_FIELD_LABEL_SMILIES', 'Smilies:');
define ('CMTX_FIELD_LABEL_COUNTER', 'Teller:');
define ('CMTX_FIELD_LABEL_QUESTION', 'Vraag:');
define ('CMTX_FIELD_LABEL_CAPTCHA', 'Captcha:');
define ('CMTX_FIELD_LABEL_NOTIFY', 'Licht me in:');
define ('CMTX_FIELD_LABEL_PRIVACY', 'Privacy:');
define ('CMTX_FIELD_LABEL_TERMS', 'Voorwaarden:');
define ('CMTX_FIELD_LABEL_PREVIEW', 'Preview:');
define ('CMTX_FIELD_LABEL_APPROVED', 'Goedgekeurd:');
define ('CMTX_FIELD_LABEL_STICKY', 'Kleverig:');
define ('CMTX_FIELD_LABEL_LOCKED', 'Opgesloten:');
define ('CMTX_FIELD_LABEL_NOTES', 'Notes:');
define ('CMTX_FIELD_LABEL_SEND', 'Verstuur:');
define ('CMTX_FIELD_LABEL_LIKE', 'Like:');
define ('CMTX_FIELD_LABEL_LIKES', 'Likes:');
define ('CMTX_FIELD_LABEL_DISLIKE', 'Dislike:');
define ('CMTX_FIELD_LABEL_DISLIKES', 'Dislikes:');
define ('CMTX_FIELD_LABEL_REPORT', 'Rapporteer:');
define ('CMTX_FIELD_LABEL_REPORTS', 'Rapportages:');
define ('CMTX_FIELD_LABEL_FLAG', 'Meld:');
define ('CMTX_FIELD_LABEL_FLAGGED', 'Meldingen:');
define ('CMTX_FIELD_LABEL_REASON', 'Reden:');
define ('CMTX_FIELD_LABEL_CONFIRMED', 'Bevestigd:');
define ('CMTX_FIELD_LABEL_ACTIVE', 'Actief:');
define ('CMTX_FIELD_LABEL_PAGE', 'Pagina:');
define ('CMTX_FIELD_LABEL_REFERENCE', 'Referentie:');
define ('CMTX_FIELD_LABEL_URL', 'URL:');
define ('CMTX_FIELD_LABEL_ENABLED', 'Ingeschakeld:');
define ('CMTX_FIELD_LABEL_FORM_ENABLED', 'Formulier ingeschakeld:');
define ('CMTX_FIELD_LABEL_PASSWORD', 'Wachtwoord:');
define ('CMTX_FIELD_LABEL_PASS', 'Pass:');
define ('CMTX_FIELD_LABEL_REPEAT', 'Herhaal:');
define ('CMTX_FIELD_LABEL_NEW_PASSWORD', 'Nieuw Wachtwoord:');
define ('CMTX_FIELD_LABEL_REPEAT_PASSWORD', 'Herhaal wachtwoord:');
define ('CMTX_FIELD_LABEL_GRAVATAR', 'Gravatar:');
define ('CMTX_FIELD_LABEL_SORT_BY', 'Sorteren op:');
define ('CMTX_FIELD_LABEL_AVG_RATING', 'Gem. Waardering:');
define ('CMTX_FIELD_LABEL_SOCIAL', 'Social:');
define ('CMTX_FIELD_LABEL_RSS_THIS', 'RSS dit:');
define ('CMTX_FIELD_LABEL_RSS_ALL', 'RSS Alles:');
define ('CMTX_FIELD_LABEL_INFO', 'Informatie:');
define ('CMTX_FIELD_LABEL_NEWEST_FIRST', 'Nieuwste eerst:');
define ('CMTX_FIELD_LABEL_DISPLAY_SAYS', 'Display "zegt":');
define ('CMTX_FIELD_LABEL_JS_VOTE_OK', 'JS Stemmen OK:');
define ('CMTX_FIELD_LABEL_TIME_FORMAT', 'Time Format:');
define ('CMTX_FIELD_LABEL_DATE_TIME', 'Datum/Tijd:');
define ('CMTX_FIELD_LABEL_TOP', 'Top:');
define ('CMTX_FIELD_LABEL_BOTTOM', 'Onder:');
define ('CMTX_FIELD_LABEL_PER_PAGE', 'Per Pagina:');
define ('CMTX_FIELD_LABEL_RANGE', 'Range:');
define ('CMTX_FIELD_LABEL_SORT_BY_1', 'Nieuwste:');
define ('CMTX_FIELD_LABEL_SORT_BY_2', 'Oudste:');
define ('CMTX_FIELD_LABEL_SORT_BY_3', 'Nuttig:');
define ('CMTX_FIELD_LABEL_SORT_BY_4', 'Nutteloos:');
define ('CMTX_FIELD_LABEL_SORT_BY_5', 'Positief:');
define ('CMTX_FIELD_LABEL_SORT_BY_6', 'Kritisch:');
define ('CMTX_FIELD_LABEL_REPLY_DEPTH', 'Reply Diepte:');
define ('CMTX_FIELD_LABEL_REPLY_ARROW', 'Reply Pijl:');
define ('CMTX_FIELD_LABEL_SCROLL_REPLY', 'Scroll Reply:');
define ('CMTX_FIELD_LABEL_NEW_WINDOW', 'Nieuw scherm:');
define ('CMTX_FIELD_LABEL_GRAVATAR_DEFAULT', 'Verzuim:');
define ('CMTX_FIELD_LABEL_GRAVATAR_RATING', 'Waardering:');
define ('CMTX_FIELD_LABEL_DISPLAY', 'Toon:');
define ('CMTX_FIELD_LABEL_ANSWER', 'Antwoord:');
define ('CMTX_FIELD_LABEL_DISPLAY_JS_MSG', 'Toon JS bericht:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_SYMBOL', 'Toon * teken:');
define ('CMTX_FIELD_LABEL_DISPLAY_AST_MSG', 'Toon * bericht:');
define ('CMTX_FIELD_LABEL_DISPLAY_EMAIL_NOTE', 'Toon Email Note:');
define ('CMTX_FIELD_LABEL_REPEAT_RATINGS', 'Herhaal stemmen:');
define ('CMTX_FIELD_LABEL_AGREE_TO_PREVIEW', 'Akkoord voor Preview:');
define ('CMTX_FIELD_LABEL_DAYS', 'Dagen:');
define ('CMTX_FIELD_LABEL_NEW_BAN', 'Nieuwe Ban:');
define ('CMTX_FIELD_LABEL_NEW_COM_APPROVE', 'Nieuw bericht (keuren):');
define ('CMTX_FIELD_LABEL_NEW_COM_OKAY', 'Nieuw bericht (Okay):');
define ('CMTX_FIELD_LABEL_NEW_FLAG', 'Nieuwe melding:');
define ('CMTX_FIELD_LABEL_METHOD', 'Methode:');
define ('CMTX_FIELD_LABEL_ADD_COOKIE', 'Add Cookie:');
define ('CMTX_FIELD_LABEL_DEL_COOKIE', 'Del Cookie:');
define ('CMTX_FIELD_LABEL_AKISMET_KEY', 'API Key:');
define ('CMTX_FIELD_LABEL_APPROVE_COMMENTS', 'Berichten goedkeuren:');
define ('CMTX_FIELD_LABEL_APPROVE_NOTIFICATIONS', 'Notificaties goedkeuren:');
define ('CMTX_FIELD_LABEL_SMTP_HOST', 'Host:');
define ('CMTX_FIELD_LABEL_SMTP_PORT', 'Port:');
define ('CMTX_FIELD_LABEL_SMTP_ENCRYPT', 'Encrypt:');
define ('CMTX_FIELD_LABEL_SMTP_AUTH', 'Auth:');
define ('CMTX_FIELD_LABEL_SENDMAIL_PATH', 'Path:');
define ('CMTX_FIELD_LABEL_SUBJECT', 'Onderwerp:');
define ('CMTX_FIELD_LABEL_FROM_NAME', 'From Naam:');
define ('CMTX_FIELD_LABEL_FROM_EMAIL', 'From Email:');
define ('CMTX_FIELD_LABEL_REPLY_EMAIL', 'Reply Email:');
define ('CMTX_FIELD_LABEL_FRONTEND', 'Frontend:');
define ('CMTX_FIELD_LABEL_BACKEND', 'Backend:');
define ('CMTX_FIELD_LABEL_VIEW_LOG', 'Bekijk Log:');
define ('CMTX_FIELD_LABEL_MESSAGE', 'Bericht:');
define ('CMTX_FIELD_LABEL_APPROVE', 'Goedkeuren:');
define ('CMTX_FIELD_LABEL_DISAPPROVE', 'Afkeuren:');
define ('CMTX_FIELD_LABEL_MAX_PER_USER', 'Max per User:');
define ('CMTX_FIELD_LABEL_MIN_PER_COM', 'Min per bericht:');
define ('CMTX_FIELD_LABEL_DELAY', 'Vertraag:');
define ('CMTX_FIELD_LABEL_ALL_PAGES', 'Alle Paginas:');
define ('CMTX_FIELD_LABEL_MAXIMUM', 'Maximum:');
define ('CMTX_FIELD_LABEL_AMOUNT', 'Aantal:');
define ('CMTX_FIELD_LABEL_PERIOD', 'Periode:');
define ('CMTX_FIELD_LABEL_ONE_NAME', '1 Naam:');
define ('CMTX_FIELD_LABEL_FIX_NAME', 'Fix Naam:');
define ('CMTX_FIELD_LABEL_DETECT_LINKS', 'Detecteer Links:');
define ('CMTX_FIELD_LABEL_DETECT_REPEATS', 'Detecteer herhalingen:');
define ('CMTX_FIELD_LABEL_RESERVED_NAME', 'Gereserveerde naam:');
define ('CMTX_FIELD_LABEL_DUMMY_NAME', 'Dummy Naam:');
define ('CMTX_FIELD_LABEL_BANNED_NAME', 'Banned Naam:');
define ('CMTX_FIELD_LABEL_RESERVED_EMAIL', 'Gereserverde Email:');
define ('CMTX_FIELD_LABEL_DUMMY_EMAIL', 'Dummy Email:');
define ('CMTX_FIELD_LABEL_BANNED_EMAIL', 'Banned Email:');
define ('CMTX_FIELD_LABEL_FIX_TOWN', 'Fix stad:');
define ('CMTX_FIELD_LABEL_RESERVED_TOWN', 'Gereserveerde stad:');
define ('CMTX_FIELD_LABEL_DUMMY_TOWN', 'Dummy stad:');
define ('CMTX_FIELD_LABEL_BANNED_TOWN', 'Banned stad:');
define ('CMTX_FIELD_LABEL_PING', 'Ping:');
define ('CMTX_FIELD_LABEL_NO_FOLLOW', 'No Follow:');
define ('CMTX_FIELD_LABEL_RESERVED_WEBSITE', 'Gereserveerde Website:');
define ('CMTX_FIELD_LABEL_DUMMY_WEBSITE', 'Dummy Website:');
define ('CMTX_FIELD_LABEL_BANNED_WEBSITE', 'Banned Website:');
define ('CMTX_FIELD_LABEL_APPROVE_IMAGES', 'Goedkeuren Images:');
define ('CMTX_FIELD_LABEL_APPROVE_VIDEOS', 'Goedkeuren Videos:');
define ('CMTX_FIELD_LABEL_CONVERT_LINKS', 'Omzetten Links:');
define ('CMTX_FIELD_LABEL_CONVERT_EMAILS', 'Omzetten Emails:');
define ('CMTX_FIELD_LABEL_MIN_CHARS', 'Min tekens:');
define ('CMTX_FIELD_LABEL_MIN_WORDS', 'Min Woorden:');
define ('CMTX_FIELD_LABEL_MAX_CHARS', 'Max tekens:');
define ('CMTX_FIELD_LABEL_MAX_LINES', 'Max regels:');
define ('CMTX_FIELD_LABEL_MAX_SMILIES', 'Max Smilies:');
define ('CMTX_FIELD_LABEL_LONG_WORD', 'Lang Woord:');
define ('CMTX_FIELD_LABEL_LINE_BREAKS', 'Regel eindes:');
define ('CMTX_FIELD_LABEL_MASK', 'Masker:');
define ('CMTX_FIELD_LABEL_MAX_CAPS', 'Max Hoofdletters:');
define ('CMTX_FIELD_LABEL_PERCENTAGE', 'Percentage:');
define ('CMTX_FIELD_LABEL_SPAM_WORDS', 'Spam Woorden:');
define ('CMTX_FIELD_LABEL_MILD_SWEARS', 'Mild vloek Woorden:');
define ('CMTX_FIELD_LABEL_STRONG_SWEARS', 'Erge vloek woorden:');
define ('CMTX_FIELD_LABEL_TIMEOUT', 'Timeout:');
define ('CMTX_FIELD_LABEL_REFRESH', 'Refresh:');
define ('CMTX_FIELD_LABEL_INTERVAL', 'Interval:');
define ('CMTX_FIELD_LABEL_BAN_COOKIE', 'Ban Cookie:');
define ('CMTX_FIELD_LABEL_CHECK_REFERRER', 'Controleer Referrer:');
define ('CMTX_FIELD_LABEL_CHECK_DB_FILE', 'Controleer DB File:');
define ('CMTX_FIELD_LABEL_SECURITY_KEY', 'Security Key:');
define ('CMTX_FIELD_LABEL_ADMIN_FOLDER', 'Admin Folder:');
define ('CMTX_FIELD_LABEL_TIME_ZONE', 'Tijd Zone:');
define ('CMTX_FIELD_LABEL_COMMENTS_URL', 'Script URL:');
define ('CMTX_FIELD_LABEL_MYSQL_DUMP', 'MySQLDump Path:');
define ('CMTX_FIELD_LABEL_WYSIWYG', 'Use WYSIWYG:');
define ('CMTX_FIELD_LABEL_LIMIT_COMMENTS', 'Limiet Commentaar:');
define ('CMTX_FIELD_LABEL_TITLE', 'Titel:');
define ('CMTX_FIELD_LABEL_LINK', 'Link:');
define ('CMTX_FIELD_LABEL_DESC', 'Omschrijving:');
define ('CMTX_FIELD_LABEL_LANG', 'Taal:');
define ('CMTX_FIELD_LABEL_IMAGE', 'Image');
define ('CMTX_FIELD_LABEL_IMAGE_URL', 'Image URL:');
define ('CMTX_FIELD_LABEL_IMAGE_WIDTH', 'Image Breedte:');
define ('CMTX_FIELD_LABEL_IMAGE_HEIGHT', 'Image Hoogte:');
define ('CMTX_FIELD_LABEL_LIMIT_ITEMS', 'Beperk Items:');
define ('CMTX_FIELD_LABEL_LIMIT_AMOUNT', 'Beperk Aantal:');
define ('CMTX_FIELD_LABEL_LIST', 'Lijst:');
define ('CMTX_FIELD_LABEL_ACTION', 'Actie:');
define ('CMTX_FIELD_LABEL_IP_ADDRESS', 'IP Adres:');
define ('CMTX_FIELD_LABEL_TIME', 'Tijd:');
define ('CMTX_FIELD_LABEL_DATE', 'Datum:');

/* Values */
define ('CMTX_FIELD_VALUE_YES', 'ja');
define ('CMTX_FIELD_VALUE_NO', 'Nee');
define ('CMTX_FIELD_VALUE_COMMENTS', 'Reacties');
define ('CMTX_FIELD_VALUE_FORM', 'Vorm');
define ('CMTX_FIELD_VALUE_NOBODY', 'Niemand');
define ('CMTX_FIELD_VALUE_NONE', 'Geen');
define ('CMTX_FIELD_VALUE_SENT_TO', 'Stuur naar');
define ('CMTX_FIELD_VALUE_SUBSCRIBER', 'inschrijver');
define ('CMTX_FIELD_VALUE_SUBSCRIBERS', 'inschrijvers');
define ('CMTX_FIELD_VALUE_ONE_LIKE', 'persoon vindt dit bericht leuk');
define ('CMTX_FIELD_VALUE_MANY_LIKES', 'mensen vinden dit bericht leuk');
define ('CMTX_FIELD_VALUE_ONE_DISLIKE', 'persoon vindt dit bericht niet leuk');
define ('CMTX_FIELD_VALUE_MANY_DISLIKES', 'personen vinden dit bericht niet leuk');
define ('CMTX_FIELD_VALUE_NO_REPORTS', 'Er zijn geen wachtende rapportages');
define ('CMTX_FIELD_VALUE_ONE_REPORT', 'Er is 1 wachtende rapportage');
define ('CMTX_FIELD_VALUE_THERE_ARE', 'Er zijn');
define ('CMTX_FIELD_VALUE_PENDING_REPORTS', 'wachtende rapportages');
define ('CMTX_FIELD_VALUE_GOOD', 'Goed');
define ('CMTX_FIELD_VALUE_FAIR', 'Redelijk');
define ('CMTX_FIELD_VALUE_BAD', 'Slecht');
define ('CMTX_FIELD_VALUE_MSG', 'Bericht');
define ('CMTX_FIELD_VALUE_IS_FLAGGED', 'Dit bericht is gemeld');
define ('CMTX_FIELD_VALUE_NOT_FLAGGED', 'Dit bericht is niet gemeld');
define ('CMTX_FIELD_VALUE_NEWEST', 'Nieuwste');
define ('CMTX_FIELD_VALUE_OLDEST', 'Oudste');
define ('CMTX_FIELD_VALUE_ALLOW', 'Toestaan');
define ('CMTX_FIELD_VALUE_DISABLE', 'Uitschakelen');
define ('CMTX_FIELD_VALUE_HIDE', 'Verberg');
define ('CMTX_FIELD_VALUE_SIZE_FIELD', 'veld grootte is');
define ('CMTX_FIELD_VALUE_SIZE_COLUMN', 'kolom grootte is');
define ('CMTX_FIELD_VALUE_SIZE_ROW', 'en rij grootte is');
define ('CMTX_FIELD_VALUE_WITH_MAX', 'met een maximum lengte van');
define ('CMTX_FIELD_VALUE_CHARACTERS', 'tekens');
define ('CMTX_FIELD_VALUE_OFF', 'Uit');
define ('CMTX_FIELD_VALUE_TEXT', 'Text');
define ('CMTX_FIELD_VALUE_IMAGE', 'Image');
define ('CMTX_FIELD_VALUE_SUBMIT', 'Submit');
define ('CMTX_FIELD_VALUE_COOKIE', 'Cookie');
define ('CMTX_FIELD_VALUE_EITHER', 'Ofwel');
define ('CMTX_FIELD_VALUE_BOTH', 'Beide');
define ('CMTX_FIELD_VALUE_SSL', 'SSL');
define ('CMTX_FIELD_VALUE_TLS', 'TLS');
define ('CMTX_FIELD_VALUE_MASK', 'Maskeer');
define ('CMTX_FIELD_VALUE_REJECT', 'Afwijzen');
define ('CMTX_FIELD_VALUE_APPROVE', 'Goedkeuren');
define ('CMTX_FIELD_VALUE_MASK_APPROVE', 'Verberg/Goedkeuren');
define ('CMTX_FIELD_VALUE_BAN', 'Blokkeer');
define ('CMTX_FIELD_VALUE_VARIABLES', 'Beschikbare variables');
define ('CMTX_FIELD_VALUE_LOG_TO_FILE', 'Log errors naar bestand');
define ('CMTX_FIELD_VALUE_SHOW_ON_SCREEN', 'Toon on screen');
define ('CMTX_FIELD_VALUE_IS_WRITABLE', 'is writable');
define ('CMTX_FIELD_VALUE_IS_NOT_WRITABLE', 'is niet writable');
define ('CMTX_FIELD_VALUE_PERMISSIONS_CORRECT', 'Alle permissies zijn correct');
define ('CMTX_FIELD_VALUE_PERMISSIONS_INCORRECT', 'Alle permissies zijn niet correct');
define ('CMTX_FIELD_VALUE_DELETE_THIS', 'Verwijder deze.');
define ('CMTX_FIELD_VALUE_DELETE_ALL', 'Verwijder alle van deze gebruiker.');
define ('CMTX_FIELD_VALUE_DO_BAN', 'Verbieden.');
define ('CMTX_FIELD_VALUE_NO_BAN', 'Niet te verbieden.');
define ('CMTX_FIELD_VALUE_ADD_NAME', 'naam toevoegen, ');
define ('CMTX_FIELD_VALUE_ADD_EMAIL', 'Voeg e-mail, ');
define ('CMTX_FIELD_VALUE_ADD_WEBSITE', 'Voeg website, ');
define ('CMTX_FIELD_VALUE_TO_BANNED_NAMES', ', tot verboden namenlijst.');
define ('CMTX_FIELD_VALUE_TO_BANNED_EMAILS', ', tot verboden e-mails lijst.');
define ('CMTX_FIELD_VALUE_TO_BANNED_WEBSITES', ', tot verboden websites lijst.');
define ('CMTX_FIELD_VALUE_BAD_REPORT', 'Slecht rapport.');
define ('CMTX_FIELD_VALUE_SPAM', 'Spam.');

?>