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

define('DS', DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);

// theme
$theme = 'smoothness';
if (isset($_GET['theme']) && $_GET['theme']) $theme = (string) $_GET['theme'];

// Set file
$file = 'ui.base';
if (isset($_GET['file']) && $_GET['file']) $file = (string) $_GET['file'];

// zlib output
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) @ob_start('ob_gzhandler');

header('Content-type: text/css; charset=UTF-8');
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

$filepath = $dir . DS . $theme . DS . $file;

// get extension, based on Joomla! JFile::getExt() function
$ext = substr($file, strrpos($file, '.') + 1);

if (is_file($filepath) and $ext === 'css') {
	
	ob_start();
		include($filepath);
		$content = ob_get_contents();
	ob_end_clean();
	
	if (strpos($content, 'images/') !== false) {
		$content = str_replace('images/', $theme . '/images/', $content);
	}
	
	echo $content;
}
?>