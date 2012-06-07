<?php
/*======================================================================*\
|| #################################################################### ||
|| # Asirra HIP MediaWiki Addon by Bachsau                            # ||
|| # ---------------------------------------------------------------- # ||
|| # This addon is released into public domain, in the hope that it   # ||
|| # will be usefull, but without any warranty.                       # ||
|| # ------------ YOU CAN DO WITH IT WHATEVER YOU LIKE! ------------- # ||
|| #################################################################### ||
\*======================================================================*/

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/ConfirmEdit.php';
$wgCaptchaClass = 'Asirra';

// Default Asirra options.
// Use LocalSettings.php for any changes
$wgAsirraEnlargedPosition = 'bottom';
$wgAsirraCellsPerRow      = '6';
$wgAsirraScriptPath       = '';

// AsirraXmlParser initial values
$wgAsirra = array
(
	'inResult' => 0,
	'passed'   => 0
);

$wgExtensionMessagesFiles['Asirra'] = dirname( __FILE__ ) . '/Asirra.i18n.php';
$wgAutoloadClasses['Asirra'] = dirname( __FILE__ ) . '/Asirra.class.php';

$wgExtensionCredits['other'][] = array
(
	'path' => __FILE__,
	'name' => 'Asirra',
	'author' => array('Bachsau'),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Asirra',
	'version' => '0.6',
	'descriptionmsg' => 'asirra-desc',
);
