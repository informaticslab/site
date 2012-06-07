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

defined('_JEXEC') or die( 'Restricted access' );

class JScriptegrator {
	
	/**
	 * Set properties for Scriptegrator plugin
	 * 
	 * @param $property 
	 * @return string
	 */
	function properties($property = 'name') {
	
		$name = 'cdscriptegrator';
		$version = '1.5.5';
		$folder = '/plugins/system/cdscriptegrator';
		
		switch ($property) {
			case 'name':
				$property = $name;
				break;
			case 'version':
				$property = $version;
				break;
			case 'folder':
				$property = $folder;
				break;
			default:
				$property = $name;
				break;
		}
		return $property;
	}
	
	/**
	 * Define Scriptegrator
	 * 
	 * @return void
	 */
	function defineScriptegrator() {
		if (!defined('_JSCRIPTEGRATOR')) define('_JSCRIPTEGRATOR', JScriptegrator::properties('name'));
	}
	
	/**
	 * Routine to check Scriptegrator plugin
	 * 
	 * @param $version_number
	 * @param $library
	 * @param $place
	 * @return string	Error message if some option is missing.
	 */
	function check($version_number = '1.5.5', $library = 'jquery', $place = 'site') {
		$message = '';
		// check if Scriptegrator is enabled
		if (class_exists('plgSystemCdScriptegrator'))
		{
			// check version
			$version = $version_number;
			if (!JScriptegrator::versionRequire($version))
			{
				$message = JText::sprintf('CDS_SCRIPTEGRATOR_REQUIREVERSION', $version);
			} else {
				// check place of library
				if (!JScriptegrator::checkLibrary($library, $place)) $message = JText::_('CDS_MISSING_' . strtoupper($library));
			}
		}
		return $message;
	}

	/**
	 * Return Scriptegrator folder path
	 * 
	 * @param $absolute
	 * @return string
	 */
	function folder($absolute = false) {
		$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		
		$path = JURI::root(true) . JScriptegrator::properties('folder');
		
		if ($absolute) $path = JPath::clean($root . JScriptegrator::properties('folder'));

		return $path;
	}

	/**
	 * Get actual Scriptegrator version
	 * 
	 * @return string
	 */
	function getVersion() {
		return JScriptegrator::properties('version');
	}

	/**
	 * Check version compatibility
	 * 
	 * @param $min_version
	 * @return boolean
	 */
	function versionRequire($min_version) {
		return (version_compare( JScriptegrator::getVersion(), $min_version, '>=' ) == 1);
	}
	
	/**
	 * Library JS loader
	 * 
	 * @param $library
	 * @param $files
	 * @return void
	 */
	function library($library = 'jquery', $files = array()) {
		$document = &JFactory::getDocument(); // set document for next usage
		$livepath = JURI::root(true);
		
		if ((int) plgSystemCdScriptegrator::pluginParam('compression', 1)) {
			
			$js_files = array();
			$css_files = array();
			
			foreach($files as $file) {
				$extension = JFile::getExt($file);
				switch ($extension) {
					case 'js':
						$js_files []= $file;
						break;
					case 'css':
						$css_files []= $file;
						break;
					default: break;
				}
			}
			
			if ($js_files) $js_files = implode('&amp;', array_map(array('plgSystemCdScriptegrator', 'arrayToUrl'), $js_files));
			if ($css_files) $css_files = implode('&amp;', array_map(array('plgSystemCdScriptegrator', 'arrayToUrl'), $css_files));
			
			if (!is_array($js_files)) {
				$loader_filepath = JScriptegrator::folder(true) . DS . 'libraries' . DS . $library . DS . 'js' . DS . 'jsloader.php';
				
				if (JFile::exists($loader_filepath)) {
					$document->addScript($livepath . JScriptegrator::properties('folder') . "/libraries/$library/js/jsloader.php?" . $js_files);
				}
			}
			
			if (!is_array($css_files)) {
				$loader_filepath = JScriptegrator::folder(true) . DS . 'libraries' . DS . $library . DS . 'css' . DS . 'cssloader.php';
				if (JFile::exists($loader_filepath)) {
					$document->addStyleSheet($livepath . JScriptegrator::properties('folder') . "/libraries/$library/css/cssloader.php?" . $css_files);
				}
			}
		} else {
			if (is_array($files) and $files) {
				foreach ($files as $file) {
					$extension = JFile::getExt($file);
					switch ($extension) {
						case 'js':
							$document->addScript($livepath . JScriptegrator::properties('folder') . "/libraries/$library/js/$file");
							break;
						case 'css':
							$document->addStyleSheet($livepath . JScriptegrator::properties('folder') . "/libraries/$library/css/$file", 'text/css');
							break;
						default: break;
					}
				}
			}
		}
	}
	
	/**
	 * jQuery UI loader - USE importUI() function
	 * 
	 * @param $compress
	 * @param $file
	 * @return void
	 */
	function UILoader($compress = 0, $file = 'ui.core') {
		JScriptegrator::importUI($file);
	}
	
	/**
	 * Import UI script
	 * 
	 * @param $uis
	 * @return void
	 */
	function importUI($uis = '') {
		
		$application = &JFactory::getApplication();
		$document = &JFactory::getDocument(); // set document for next usage
		
		$livepath = JURI::root(true);
   		if ($application->isSite()) $livepath = JURI::base(true);
   		
   		$ui_version = '1.8.7';
		
		if ((int) plgSystemCdScriptegrator::pluginParam('compression', 1)) {
			$loader_filepath = JScriptegrator::folder(true) . DS . 'libraries' . DS . 'jquery' . DS . 'js' . DS . 'ui' . DS . 'jsloader.php';
			if (JFile::exists($loader_filepath)) {
				$url = $livepath . JScriptegrator::properties('folder') . "/libraries/jquery/js/ui/jsloader.php?file=jquery-ui-$ui_version.custom.min.js";
				$document->addScript($url);
			}
		} else {
			$document->addScript($livepath . JScriptegrator::properties('folder') . "/libraries/jquery/js/ui/jquery-ui-$ui_version.custom.min.js");
		}
	}
	
	/**
	 * Import UI CSS theme
	 * 
	 * @param $theme
	 * @param $file
	 * @return void
	 */
	function importUITheme($theme = 'smoothness', $file = '') {
		
		$application = &JFactory::getApplication();
		$document = &JFactory::getDocument(); // set document for next usage
		
		$livepath = JURI::root(true);
		if ($application->isSite()) $livepath = JURI::base(true);
		
		$ui_version = '1.8.7';
		
		if ((int) plgSystemCdScriptegrator::pluginParam('compression', 1)) {
			$loader_filepath = JScriptegrator::folder(true) . DS . 'libraries' . DS . 'jquery' . DS . 'theme' . DS . 'cssloader.php';
			if (JFile::exists($loader_filepath)) {
				$url = $livepath . JScriptegrator::properties('folder') . "/libraries/jquery/theme/cssloader.php?theme=$theme&amp;file=jquery-ui-$ui_version.custom.css";
				$document->addStyleSheet($url, 'text/css');
				return true;
			}
		} else {
			$url = $livepath . JScriptegrator::properties('folder') . "/libraries/jquery/theme/$theme/jquery-ui-$ui_version.custom.css";
			$document->addStyleSheet($url, 'text/css');
		}
	}
		
	/**
	 * jQuery UI CSS loader - USE importUITheme() function
	 * 
	 * @param $compress
	 * @param $theme
	 * @param $file
	 * @return void
	 */
	function UICssLoader($compress = 0, $theme = 'smoothness', $file = 'ui.base') {
		JScriptegrator::importUITheme($theme, $file);
	}
	

	/**
	 * Check if library is enabled (jQuery, Highslide...)
	 * 
	 * @param $library
	 * @param $interface
	 * 
	 * @return boolean
	 */
	function checkLibrary($library = 'jquery', $interface = 'site') {

		$plugin = &JPluginHelper::getPlugin('system', JScriptegrator::properties('name'));
		$pluginParams = new JParameter($plugin->params);

		$pluginParams = (int)$pluginParams->get($library, 0);
		
		$library = false;
		
		switch ($interface) {
			case 'site':
				switch ($pluginParams) {
					case 1:
					case 3:
						$library = true;
						break;
					default:
						$library = false;
						break;
				}
				break;
			case 'admin':
				switch ($pluginParams) {
					case 2:
					case 3:
						$library = true;
						break;
					default:
						$library = false;
						break;
				}
				break;
		}
		
		return $library;
	}
	
	/**
	 * Return list of available themes
	 * 
	 * @return array
	 */
	function themeList() {
		jimport('joomla.filesystem.folder');
		$path = JScriptegrator::folder(true) . DS . 'libraries' . DS . 'jquery' . DS . 'theme';
		$files = array();
		$files = JFolder::folders($path, '.', false, false);
		return $files;
	}
}
?>