<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		1.5.5
 * @copyright	Copyright (C) 2007 - 2011 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Core Design Scriptegrator plugin
 *
 * @author		Daniel Rataj <info@greatjoomla.com>
 * @package		Core Design
 * @subpackage	System
 */
class plgSystemCdScriptegrator extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access	protected
     * @param	object		$subject The object to observe
     * @since	1.0
     */
    function plgSystemCdScriptegrator(&$subject)
    {
        parent::__construct($subject);
        
        JLoader::register('JScriptegrator' , dirname(__FILE__) . DS . 'cdscriptegrator' . DS . 'includes' . DS . 'jscriptegrator.php');
        
		JScriptegrator::defineScriptegrator(); // set define
        
        // load plugin parameters
        $this->plugin = &JPluginHelper::getPlugin('system', JScriptegrator::properties('name'));
        $this->params = new JParameter($this->plugin->params);
        
        JPlugin::loadLanguage('plg_system_' . JScriptegrator::properties('name'), JPATH_ADMINISTRATOR); // define language
    }
    
    /**
     * Function to integrate scripts to the site
     * 
     * @return void
     */
    function onAfterRoute()
    {		
        $document = &JFactory::getDocument(); // set document for next usage
        
        $doctype = $document->getType(); // get document type
        
        // disable plugin for non-HTML interface (like RSS feed or PDF)
        if ($doctype !== 'html') return false;
        
        // get folder names - from libraries folder
        $libraries = JFolder::folders(JScriptegrator::folder(true) . DS . 'libraries', false, false);
             
        // serach each library and call function
        foreach ($libraries as $library) {
        	
        	if ($this->enableLibrary($library)) {
	        	// define helper path
	        	$library_class_path = JScriptegrator::folder(true) . DS . 'libraries' . DS . $library . DS . $library . '.php';
	        	
	        	// load class file if exists
	        	if (JFile::exists($library_class_path)) {
	        		$class_name = $library;
	        		JLoader::register($class_name , $library_class_path);
	        		
	        		// import header files
	        		if (is_callable(array($class_name, 'importFiles'))) {
	        			$files_to_import = call_user_func(array($class_name, 'importFiles'));
	        			if (is_array($files_to_import)) {
	        				JScriptegrator::library($library, $files_to_import);
	        			}
	        		}
	        		
	        		// add script declaration
	        		if (is_callable(array($class_name, 'scriptDeclaration'))) {
	        			$script_declaration = call_user_func(array($class_name, 'scriptDeclaration'), $this->params);
	        			if ($script_declaration) {
	        				$document->addScriptDeclaration($script_declaration);
	        			}
	        		}
	        		
		        	if (is_callable(array($class_name, 'load'))) {
		        		call_user_func(array($class_name, 'load'));
		        	}
	        	}
        	}
        	
        }
    }
    
    /**
     * Check if the library will be loaded
     * 
     * @param $library
     * @return boolean
     */
    function enableLibrary($library = 'jquery') {
    	$application = & JFactory::getApplication();
    	
    	// prevent empty library
    	if (!$library) return false;

		$enable = (int) $this->params->get($library, 0);
		
		$load = false;

		switch ($enable)
		{
			case 0:
				$load = false;
				break;
			case 1:
				if ($application->isSite()) $load = true;
				break;
			case 2:
				if ($application->isAdmin()) $load = true;
				break;
			case 3:
				$load = true;
				break;
		}
		
		return $load;
    }
    
    /**
     * Get Scriptegrator plugin params
     * 
     * @param $param
     * @param $default
     * @return string or array
     */
    function pluginParam($param = '', $default = '') {
    	$plugin = &JPluginHelper::getPlugin('system', JScriptegrator::properties('name'));
        $params = new JParameter($plugin->params);
        
        if (!$param) return $params;
        
        return $params->get($param, $default);
    }
    
    /**
     * Modify URL array
     * 
     * @param $name
     * @return array
     */
	function arrayToUrl($value = '', $name = 'files') {
		return $name . '[]=' . $value;
	}
}
?>