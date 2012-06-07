<?php

// Translated by: Alexander Kahl (wolfpac4life@gmx.de)
// --------------------------------------------------------------------------------

defined( '_VALID_MOS' ) or die( 'Direkter Zugriff nicht erlaubt.' );

DEFINE('_MAMBO_WIKI_NAME', 'Mambo Wiki');
DEFINE('_JOOMLA_WIKI_NAME', 'JWiki');

DEFINE('_IMAGEMSG0', 'Das "Powered by MediaWiki" Bild wird angezeigt' );
DEFINE('_IMAGEMSG1', 'Das "Powered by MediaWiki" Bild wird nicht angezeigt' );

DEFINE('_HEIGHTMSG', 'Die IFRAME H�he wird eingestellt auf %height %pxstate' );
DEFINE('_HEIGHTERRORMSG', "Eine IFRAME H�heneinstellung von %height %pxstate ist nicht m�glich und wird nicht gespeichert" );

DEFINE('_NOT_CONFIGURED', 'Das Wiki wurde noch nicht konfiguriert. Bitte kontaktiere deinen Administrator.');
DEFINE('_NOT_LOGGED_IN', 'Du musst eingeloggt sein, um das Wiki nutzen zu k�nnen.');

DEFINE('_ADMINISTRATION', 'Administration');

DEFINE('_INIT_MEDIAWIKI', 'Installiere Datenbanktabellen und initialisiere MediaWiki');
DEFINE('_CONFIG_MEDIAWIKI', 'Konfiguriere JWiki �ber Spezialseiten');
DEFINE('_CONTRIBS', 'Verwalte mitwirkende Benutzer');
DEFINE('_SHOW_IMAGE', 'Zeige MediaWiki Bild im Wiki?');
DEFINE('_COMPONENT_HEIGHT', 'Gr�sse des Wikibereiches?');
DEFINE('_COMPONENT_HEIGHT_COMMENT', 'Note: Set the height to zero if the frame should stretch to accommodate its contents');

DEFINE('_IFRAME_SCROLLBARS', 'Zeige IFRAME Scrollleiste?');

DEFINE('_YES', 'Ja');
DEFINE('_NO', 'Nein');
DEFINE('_AUTO', 'Auto');

DEFINE('_PERCENT', 'Prozent');
DEFINE('_PIXELS', 'Pixel');
DEFINE('_CONFIRM', 'Bist du sicher?');
DEFINE('_CONFIG', 'Konfiguration');
DEFINE('_SETUP', 'Setup / Installation');

DEFINE('_INIT_MEDIAWIKI_TITLE', "Installiere Datenbanktabellen und initialisiere MediaWiki.");
DEFINE('_CONFIG_MEDIAWIKI_TITLE', "Konfiguriere JWiki �ber Spezialseiten");
DEFINE('_CONTRIBS_TITLE', "Verwalte mitwirkende Benutzer");
DEFINE('_SHOWUSERS', 'JWiki Benutzer');
DEFINE('_USER_ID', 'Joomla User ID');
DEFINE('_DISPLAY', 'Zeige');
DEFINE('_SEARCH', 'Suche');

DEFINE('_GOTOPAGE', 'Gehe zu Seite:');
DEFINE('_SHOWPAGE', 'Zeige Seite:');

DEFINE('_UNINSTALLWIKITABLES', 'Was soll mit den Daten beim Deinstallieren der Komponente passieren?');
DEFINE('_UNINSTALLWIKITABLES0MSG', 'Tabellen und Daten werden nicht beim Deinstallieren entfernt');
DEFINE('_UNINSTALLWIKITABLES1MSG', 'Die Wiki Tabellen und alle Men�eintr�ge werden beim Deinstallieren entfernt');
DEFINE('_UNINSTALLWIKITABLES2MSG', 'Die Wiki Tabellen bleiben erhalten und nur die Men�eintr�ge werden beim Deinstallieren entfernt');

DEFINE('_UNINSTALLOPTION0', 'Nein, ich upgrade die Komponente und m�chte alle Tabellen und Daten behalten');
DEFINE('_UNINSTALLOPTION1', 'Ja, ich m�chte die Komponente deinstallieren');
DEFINE('_UNINSTALLOPTION2', 'Ich m�chte die Wiki Tabellen behalten und nur die Men�eintr�ge entfernen');

DEFINE('_ACCESSOPTION0', 'Nobody');
DEFINE('_ACCESSOPTION1', 'Users');
DEFINE('_ACCESSOPTION2', 'Both');

DEFINE('_READACCESSRULES', 'Wer darf deine Seiten lesen?');
DEFINE('_READACCESSRULES0MSG', 'G�ste und User d�rfen die Seiten nicht lesen');
DEFINE('_READACCESSRULES1MSG', 'User d�rfen die Seiten lesen');
DEFINE('_READACCESSRULES2MSG', 'G�ste und User d�rfen die Seiten lesen');
DEFINE('_READACCESSRULES3MSG', 'Fehler: Kann Lesezugriff nicht updaten');

DEFINE('_EDITACCESSRULES', 'Wer darf deine Seiten bearbeiten?');
DEFINE('_EDITACCESSRULES0MSG', 'G�ste und User d�rfen die Seiten nicht bearbeiten');
DEFINE('_EDITACCESSRULES1MSG', 'Users d�rfen die Seiten bearbeiten');
DEFINE('_EDITACCESSRULES2MSG', 'G�ste und User d�rfen die Seiten bearbeiten');
DEFINE('_EDITACCESSRULES3MSG', 'Fehler: Kann Schreibzugriff nicht updaten');

DEFINE('_SCROLLBARMSG0', 'Die IFRAME Scrollleisten werden automatisch benutzt' );
DEFINE('_SCROLLBARMSG2', 'Die IFRAME Scrollleisten werden nicht benutzt' );
DEFINE('_SCROLLBARMSG1', 'Die IFRAME Scrollleisten werden benutzt' );

# DEFINE('_ALLOWDIRECTACCESS', 'Allow direct access' );
DEFINE('_ALLOWDIRECTACCESS', 'Allow direct access' );
# DEFINE('_LOGINCOMPONENT', 'Login component' );
DEFINE('_LOGINCOMPONENT', 'Login component' );

# DEFINE('_HELP_TITLE', "On-line help");
DEFINE('_HELP_TITLE', "On-line help");
# DEFINE('_HELP', 'Access the on-line help page');
DEFINE('_HELP', 'Access the on-line help page');

#Test();

function Test()
{
	echo _IMAGEMSG0."\n";
	echo _IMAGEMSG1."\n";
	echo _HEIGHTMSG."\n";
	echo _HEIGHTERRORMSG."\n";
	echo _NOT_CONFIGURED."\n";
	echo _NOT_LOGGED_IN."\n";
	echo _ADMINISTRATION."\n";
	echo _INIT_MEDIAWIKI."\n";
	echo _CONFIG_MEDIAWIKI."\n";
	echo _CONTRIBS."\n";
	echo _SHOW_IMAGE."\n";
	echo _COMPONENT_HEIGHT."\n";
	echo _IFRAME_SCROLLBARS."\n";
	echo _YES."\n";
	echo _NO."\n";
	echo _AUTO."\n";
	echo _PERCENT."\n";
	echo _PIXELS."\n";
	echo _CONFIRM."\n";
	echo _CONFIG."\n";
	echo _SETUP."\n";
	echo _INIT_MEDIAWIKI_TITLE."\n";
	echo _CONFIG_MEDIAWIKI_TITLE."\n";
	echo _CONTRIBS_TITLE."\n";
	echo _SHOWUSERS."\n";
	echo _USER_ID."\n";
	echo _DISPLAY."\n";
	echo _SEARCH."\n";
	echo _GOTOPAGE."\n";
	echo _SHOWPAGE."\n";
	echo _UNINSTALLWIKITABLES."\n";
	echo _UNINSTALLWIKITABLES0MSG."\n";
	echo _UNINSTALLWIKITABLES1MSG."\n";
	echo _UNINSTALLWIKITABLES2MSG."\n";
	echo _READACCESSRULES."\n";
	echo _READACCESSRULES0MSG."\n";
	echo _READACCESSRULES1MSG."\n";
	echo _READACCESSRULES2MSG."\n";
	echo _READACCESSRULES3MSG."\n";
	echo _EDITACCESSRULES."\n";
	echo _EDITACCESSRULES0MSG."\n";
	echo _EDITACCESSRULES1MSG."\n";
	echo _EDITACCESSRULES2MSG."\n";
	echo _EDITACCESSRULES3MSG."\n";
	echo _SCROLLBARMSG0."\n";
	echo _SCROLLBARMSG2."\n";
	echo _SCROLLBARMSG1."\n";
	echo _ALLOWDIRECTACCESS."\n";
	echo _LOGINCOMPONENT."\n";

}

?>
