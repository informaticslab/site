<?php
/**
 * Text  handling class
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	Language
 * @since		1.5
 */

if (!class_exists('JText')) {
	class JText
	{
		function _( $text, $jsSafe = false )
		{
			$lang = & JoomlaTuneLanguage::getInstance();
			return $lang->_($text, $jsSafe);
		}

		function sprintf( $string )
		{
			$lang = & JoomlaTuneLanguage::getInstance();
			$args = func_get_args();
			if (count($args) > 0) {
				$args[0] = $lang->_($args[0]);
				return call_user_func_array('sprintf', $args);
			}
			return '';
		}
	}
}
?>