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
 * Joomla plugins helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 **/
class JCommentsPluginHelper
{
	/**
	 * Loads all the plugin files for a particular type if no specific plugin is specified
	 * otherwise only the specific pugin is loaded.
	 *
	 * @access public
	 * @param string $type The plugin type, relates to the sub-directory in the plugins directory
	 * @return boolean True if success
	 */
        function importPlugin( $type = 'jcomments' )
        {
		if (JCOMMENTS_JVERSION == '1.5') {
			JPluginHelper::importPlugin($type);
		} else if (JCOMMENTS_JVERSION == '1.0') {
			global $_MAMBOTS;
			$_MAMBOTS->loadBotGroup($type);
		}
        }

	/**
	 * Triggers an event by dispatching arguments to all observers that handle
	 * the event and returning their return values.
	 *
	 * @access public
	 * @param string $event The event name
	 * @param array	$args An array of arguments
	 * @return array An array of results from each function call
	 */
        function trigger( $event, $args = null)
        {
                $result = array ();

		if (JCOMMENTS_JVERSION == '1.5') {
			$dispatcher = & JDispatcher::getInstance();
			$result = $dispatcher->trigger($event, $args);
		} else if (JCOMMENTS_JVERSION == '1.0') {
			global $_MAMBOTS;
			$result = $_MAMBOTS->trigger($event, $args, false);
		}
		return $result;
	}


	/**
	 * Gets the parameter object for a plugin
	 *
	 * @access public
	 * @param string $pluginName The plugin name
	 * @param string $type The plugin type, relates to the sub-directory in the plugins directory
	 * @return JParameter A JParameter object (mosParameters for J1.0)
	 */
	function getParams($pluginName, $type = 'content')
	{
	
		if (JCOMMENTS_JVERSION == '1.5') {
 			$plugin	= & JPluginHelper::getPlugin($type, $pluginName);
 			if (is_object($plugin)) {
		 		$pluginParams = new JParameter($plugin->params);
		 	} else {
		 		$pluginParams = new JParameter('');
		 	}
		} else {
			static $mambotParams = array();
			$paramKey = $type . '_' . $pluginName;

			if (!isset($mambotParams[$paramKey])) {
				include_once (JCOMMENTS_BASE.DS.'jcomments.class.php');

				$dbo = & JCommentsFactory::getDBO();
				$dbo->setQuery("SELECT params FROM #__mambots WHERE element = '$pluginName' AND folder = '$type'");
				$mambotParams[$paramKey] = $dbo->loadResult();
			}

			$data = $mambotParams[$paramKey];
			$pluginParams = new mosParameters($data);
		}
		return $pluginParams;
	}
}
?>