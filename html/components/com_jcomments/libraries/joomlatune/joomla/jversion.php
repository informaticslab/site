<?php
/**
 * Joomla version defines
 *
 * @version 1.0
 * @package JoomlaTune.Framework
 * @subpackage Joomla
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2008 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 * @access public
 */

if (!defined('JOOMLATUNE_JVERSION')) {
	if (defined('_JEXEC') && class_exists('JApplication')) {
		define('JOOMLATUNE_JVERSION', '1.5');
		define('JOOMLATUNE_JPATH_SITE', JPATH_SITE);

		$live_site = substr_replace(JURI::base(), '', -1, 1);

		if(strtolower(JPATH_BASE) == strtolower(JPATH_ADMINISTRATOR)) {
			$live_site = str_replace('/administrator', '', $live_site);
		}

		define('JOOMLATUNE_LIVE_SITE', $live_site);

		if (!defined('_ISO')) {
			define('_ISO', 'charset=utf-8');
		}

		$config = & JFactory::getConfig();

		if (!$config->getValue('config.legacy')) {
			$config->setValue('config.live_site', JOOMLATUNE_LIVE_SITE);
			$config->setValue('config.absolute_path', JOOMLATUNE_JPATH_SITE);
			$config->setValue('config.cachepath', JPATH_BASE.DS.'cache');

			$lang = & JFactory::getLanguage();
			$lng = is_callable(array('JLanguage', 'getBackwardLang')) ? $lang->getBackwardLang() : $lang->getTag();
			$config->setValue('config.lang', $lng);
		} else {
			$config->setValue('config.cachepath', JPATH_BASE.DS.'cache');
		}

		if (empty($GLOBALS['my'])) {
			$user	=& JFactory::getUser();
			$GLOBALS['my'] = (object)$user->getProperties();
			$GLOBALS['my']->gid = $user->get('aid', 0);
		}

		if (!class_exists('JoomlaTuneDBTable')) {
			class JoomlaTuneDBTable extends JTable
			{
				function JoomlaTuneDBTable( $table, $key, &$db )
				{
					parent::__construct($table, $key, $db);
				}
			}
		}
	} else {
		global $mosConfig_absolute_path, $mosConfig_live_site;

		define('JOOMLATUNE_JVERSION', '1.0');
		define('JOOMLATUNE_JPATH_SITE', $mosConfig_absolute_path);
		define('JOOMLATUNE_LIVE_SITE', $mosConfig_live_site);

		if (!class_exists('JoomlaTuneDBTable')) {
			class JoomlaTuneDBTable extends mosDBTable
			{
				function JoomlaTuneDBTable( $table, $key, &$db )
				{
					$this->mosDBTable($table, $key, $db);
				}
			}
		}
	}
}
?>