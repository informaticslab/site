<?php
/**
 * JComments - Joomla Comment System
 * 
 * @version 2.1
 * @package JComments
 * @subpackage Helpers
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

/**
 * JComments plugin Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsObjectHelper
{
	/**
	 * Calls plugin for given object group and returns title for an object
	 *
	 * @static
	 * @access private
	 * @param int $object_id
	 * @param string $object_group
	 * @param string $language
	 * @param string $object_method
	 * @param mixed $default
	 * @return string
	 */
	function _getObjectVar( $object_id, $object_group, $language = null, $object_method, $default = '' )
	{
		static $cache = null;

		$object_id = (int) $object_id;
		$object_group = trim($object_group);
		
		if ($object_id != 0 && $object_group != '') {
			if (!is_array($cache)) {
				$cache = array();
			}
			
			$cache_key = md5($object_group . '_' . $object_id . '_' . ($language?$language:'') . '_' . $object_method);
			
			if (isset($cache[$cache_key])) {
				return $cache[$cache_key];
			}
			
			ob_start();
			include_once (JCOMMENTS_BASE.DS.'plugins'.DS.$object_group.'.plugin.php');
			ob_end_clean();

			
			$class = 'jc_' . $object_group;
			if (class_exists($class) && is_callable(array($class, $object_method))) {
				$object = call_user_func(array($class, $object_method), $object_id, $language);
				$cache[$cache_key] = $object;
				return $object;
			}
		}
		return $default;
	}

	/**
	 * Returns title for given object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @param string $language 
	 * @return string
	 */
	function getTitle( $object_id, $object_group = 'com_content', $language = null )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, $language, 'getObjectTitle');
	}
	
	/**
	 * Returns URI for given object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @return string
	 */
	function getLink( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, null, 'getObjectLink');
	}
	
	/**
	 * Returns identifier of user who is owner of an object
	 *
	 * @static 
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @return string
	 */
	function getOwner( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::_getObjectVar($object_id, $object_group, null, 'getObjectOwner', -1);
	}

	/**
	 * Returns array of titles for given objects
	 *
	 * @static 
	 * @access public
	 * @param array $object_id
	 * @param string $object_group
	 * @return array
	 */
	function getTitles( $object_ids, $object_group = 'com_content', $language = null )
	{
		static $cache = null;

		$count = count($object_ids);
		$titles = array();

		if ($count) {
			if (!is_array($cache)) {
				$cache = array();
			}

			$cache_key = md5($object_group . '_' . md5(serialize($object_ids)) . '_getTitles');

			if (isset($cache[$cache_key])) {
				return $cache[$cache_key];
			}

			ob_start();
			include_once (JCOMMENTS_BASE.DS.'plugins'.DS.$object_group.'.plugin.php');
			ob_end_clean();
			
			$class = 'jc_' . $object_group;
			if (class_exists($class)) {
				if (is_callable(array($class, 'getTitles'))) {
					$titles = call_user_func(array($class, 'getTitles'), $object_ids, $language);
				} else if (is_callable(array($class, 'getObjectTitle'))) {
					foreach($object_ids as $object_id) {
						$titles[$object_id] = JCommentsObjectHelper::_getObjectVar($object_id, $object_group, $language, 'getObjectTitle');
					}
				}
				$cache[$cache_key] = $titles;
			}
		}
		return $titles;
	}
}
?>