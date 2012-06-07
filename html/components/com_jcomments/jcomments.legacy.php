<?php
/**
 * JComments - Joomla Comment System
 *
 * Compatibility Tools (for Joomla 1.5 support)
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

// define directory separator short constant
if (!defined( 'DS' )) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('JCOMMENTS_BASE')) {
	define('JCOMMENTS_BASE', dirname(__FILE__));
}

if (!defined('JCOMMENTS_LIBRARIES')) {
	define('JCOMMENTS_LIBRARIES', JCOMMENTS_BASE.DS.'libraries');
}

if (!defined('JCOMMENTS_HELPERS')) {
	define('JCOMMENTS_HELPERS', JCOMMENTS_BASE.DS.'helpers');
}

require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'joomla'.DS.'jversion.php');
require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'joomla'.DS.'jroute.php');

if (JOOMLATUNE_JVERSION == '1.5') {
	global $mainframe;
	define('JCOMMENTS_JVERSION', '1.5');
	define('JCOMMENTS_ADMIN', JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_jcomments');

	$option = JRequest::getCmd('option');
	$app = & JFactory::getApplication();
	if ($option != 'com_jcomments' || $app->isAdmin()) {
		$language = & JFactory::getLanguage();
		$language->load('com_jcomments', JPATH_SITE);
	}
} else {
	global $mosConfig_absolute_path, $mosConfig_lang, $mainframe;
	define('JCOMMENTS_JVERSION', '1.0');
	define('JCOMMENTS_ADMIN', $mosConfig_absolute_path.DS.'administrator'.DS.'components'.DS.'com_jcomments');

	require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'language.php');

	$lang = $mosConfig_lang;

	if (!is_file(JCOMMENTS_BASE.DS.'languages'.DS.$lang.'.ini')) {
		$lang = 'english';
	}

	$language = & JoomlaTuneLanguage::getInstance();
	$language->setRoot(JCOMMENTS_BASE.DS.'languages');
	$language->load($lang);

	$joomfish = $mosConfig_absolute_path.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';

	if (!class_exists('JText')) {
		$joomfish_class = $mosConfig_absolute_path.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'joomfish.class.php';
		$joomfish_language = $mosConfig_absolute_path.DS.'administrator'.DS.'components'.DS.'com_joomfish'.DS.'libraries'.DS.'joomla'.DS.'language.php';

		// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
		if (is_file($joomfish) && is_file($joomfish_language)) {
			include_once ($joomfish_class);
			include_once ($joomfish_language);
        		if(class_exists('JLanguageHelper')) {
				if (isset($mainframe) && $mainframe->isAdmin()) {
					$jfm = new JoomFishManager($mosConfig_absolute_path.DS.'administrator'.DS.'components'.DS.'com_joomfish');
					$adminLang = strtolower($jfm->getCfg('componentAdminLang'));
					$lng = & JLanguageHelper::getLanguage($adminLang);
				} else {
					$lng = & JLanguageHelper::getLanguage();
				}

				if (is_array($lng->_strings) && is_array($language->languages[$lang])) {
					$lng->_strings = array_merge($lng->_strings, $language->languages[$lang]);
				}
			}
		} else {
			require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'joomla'.DS.'jtext.php');
		}
	} else {
		if (class_exists('JLanguageHelper')) {
			// small hack for JoomFish 1.8.2+ on Joomla 1.0.x
			$lng = & JLanguageHelper::getLanguage();
			if (is_array($lng->_strings) && is_array($language->languages[$lang])) {
				$lng->_strings = array_merge($lng->_strings, $language->languages[$lang]);
			}
		}
	}
}
?>