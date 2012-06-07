<?php

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

DEFINE('_MAMBO_WIKI_NAME', 'Mambo Wiki');
DEFINE('_JOOMLA_WIKI_NAME', 'JWiki');

DEFINE('_IMAGEMSG0', 'The "Powered by MediaWiki" image will be displayed' );
DEFINE('_IMAGEMSG1', 'The "Powered by MediaWiki" image will not be displayed' );

DEFINE('_HEIGHTMSG', 'The IFRAME height will be set to %height %pxstate' );
DEFINE('_HEIGHTERRORMSG', "An IFRAME height setting of %height %pxstate is not valid and will not be saved" );

DEFINE('_NOT_CONFIGURED', 'This Wiki has not been configured.  Please contact your administrator.');
DEFINE('_NOT_LOGGED_IN', 'You must be logged in to use this Wiki menu option.');

DEFINE('_ADMINISTRATION', 'Administration');

DEFINE('_INIT_MEDIAWIKI', 'Install database tables and initialise MediaWiki');
DEFINE('_CONFIG_MEDIAWIKI', 'Configure JWiki Component using special pages');
DEFINE('_CONTRIBS', 'Manage Contributions');
DEFINE('_SHOW_IMAGE', 'Show MediaWiki image in the component area?');
DEFINE('_COMPONENT_HEIGHT', 'Height of the component area?');
DEFINE('_COMPONENT_HEIGHT_COMMENT', 'Note: Set the height to zero if the frame should stretch to accommodate its contents');

DEFINE('_IFRAME_SCROLLBARS', 'Show IFRAME scroll bars?');

DEFINE('_YES', 'Yes');
DEFINE('_NO', 'No');
DEFINE('_AUTO', 'Auto');

DEFINE('_PERCENT', 'Percent');
DEFINE('_PIXELS', 'Pixels');
DEFINE('_CONFIRM', 'Are you sure?');
DEFINE('_CONFIG', 'Configuration');
DEFINE('_SETUP', 'Setup/Install');

DEFINE('_INIT_MEDIAWIKI_TITLE', "Install database tables and initialise MediaWiki.");
DEFINE('_CONFIG_MEDIAWIKI_TITLE', "Configure JWiki component using special pages");
DEFINE('_CONTRIBS_TITLE', "Manage user contributions");
DEFINE('_SHOWUSERS', 'JWiki Users');
DEFINE('_USER_ID', 'Joomla User ID');
DEFINE('_DISPLAY', 'Display');
DEFINE('_SEARCH', 'Search');

DEFINE('_GOTOPAGE', 'Go to page:');
DEFINE('_SHOWPAGE', 'Show Page:');

DEFINE('_UNINSTALLWIKITABLES', 'What to do with data when the component is uninstalled?');
DEFINE('_UNINSTALLWIKITABLES0MSG', 'No tables or data will be removed when the component is uninstalled');
DEFINE('_UNINSTALLWIKITABLES1MSG', 'The Wiki tables and all menu data will be removed when the component is uninstalled');
DEFINE('_UNINSTALLWIKITABLES2MSG', 'The Wiki tables will be kept and only menu data will be removed when the component is uninstalled');

DEFINE('_UNINSTALLOPTION0', 'I am upgrading and want to keep all tables and data');
DEFINE('_UNINSTALLOPTION1', 'I am uninstalling this component and all tables should be removed');
DEFINE('_UNINSTALLOPTION2', 'Keep the Wiki tables and only remove menu data');

DEFINE('_ACCESSOPTION0', 'Nobody');
DEFINE('_ACCESSOPTION1', 'Users');
DEFINE('_ACCESSOPTION2', 'Both');

DEFINE('_READACCESSRULES', 'Who is allowed to read your pages?');
DEFINE('_READACCESSRULES0MSG', 'Anonymous and Users will not be allowed to read pages');
DEFINE('_READACCESSRULES1MSG', 'Users will be allowed to read pages');
DEFINE('_READACCESSRULES2MSG', 'Anonymous and Users can read pages');
DEFINE('_READACCESSRULES3MSG', 'Unable to update the read access rules');

DEFINE('_EDITACCESSRULES', 'Who is allowed to edit your pages?');
DEFINE('_EDITACCESSRULES0MSG', 'Anonymous and Users will not be allowed to edit pages');
DEFINE('_EDITACCESSRULES1MSG', 'Users will be allowed to edit pages');
DEFINE('_EDITACCESSRULES2MSG', 'Anonymous and Users can edit pages');
DEFINE('_EDITACCESSRULES3MSG', 'Unable to update the edit access rules');

DEFINE('_SCROLLBARMSG0', 'The IFRAME scrollbars will be set to Auto' );
DEFINE('_SCROLLBARMSG2', 'The IFRAME scrollbars will be disabled' );
DEFINE('_SCROLLBARMSG1', 'The IFRAME scrollbars will be enabled' );

DEFINE('_ALLOWDIRECTACCESS', 'Allow direct access' );
DEFINE('_LOGINCOMPONENT', 'Login component' );

DEFINE('_HELP_TITLE', "On-line help");
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