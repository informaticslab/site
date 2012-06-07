<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend toolbar handler
 *
 * @version 2.1
 * @package JComments
 * @subpackage	Admin
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project, 
 * please make a reference to JComments someplace in your code 
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') or defined('_JEXEC')) or die('Restricted access');

global $mainframe, $task;

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// include legacy class
if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
} else {
	require_once ($mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
}

if (!defined('JCOMMENTS_ENCODING')) {
	DEFINE('JCOMMENTS_ENCODING', strtolower(preg_replace('/charset=/', '', _ISO)));
	if (JCOMMENTS_ENCODING == 'utf-8') {
		// pattern strings are treated as UTF-8
		DEFINE('JCOMMENTS_PCRE_UTF8', 'u');
	} else {
		DEFINE('JCOMMENTS_PCRE_UTF8', '');
	}
}

if (JCOMMENTS_JVERSION == '1.0') {
	require_once ($mainframe->getPath('toolbar_html'));
	require_once ($mainframe->getPath('toolbar_default'));
} else {
	$task = JRequest::getCmd('task');
	require_once (JApplicationHelper::getPath('toolbar_html'));
}

switch ($task) {
	case 'comments':
		menucomments::VIEW_MENU();
		break;
	case 'edit':
		menucomments::EDIT_MENU();
		break;
	case 'import':
		menucomments::IMPORT_MENU();
		break;
	case 'postinstall':
		menucomments::POSTINSTALL_MENU();
		break;
	case 'about':
		menucomments::ABOUT_MENU();
		break;
	case 'smiles':
		menucomments::SMILES_MENU();
		break;
	case 'subscriptions':
	case 'subscription.cancel':
		menucomments::SUBSCRIPTIONS_MENU();
		break;
	case 'subscription.new':
	case 'subscription.edit':
		menucomments::SUBSCRIPTIONS_EDIT_MENU();
		break;

	case 'custombbcode':
	case 'custombbcodes':
		menucomments::CUSTOMBBCODE_MENU();
		break;
	case 'custombbcode.new':
	case 'custombbcode.edit':
		menucomments::CUSTOMBBCODE_EDIT_MENU();
		break;

	case 'settings':
	case 'settings.save':
	case 'settings.cancel':
	case 'settings.restore':
		menucomments::CONFIG_MENU();
		break;
	default:
		menucomments::VIEW_MENU();
		break;
}
?>