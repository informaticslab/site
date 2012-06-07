<?php
/*
 *  Akeeba Backup Lazy Scheduling
 *  Copyright (C) 2010  Nicholas K. Dionysopoulos / AkeebaBackup.com
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 *  Thank you notice:
 *  Many thanks to Jean-Sebastien Gervais of LazyBackup.net for proving that
 *  backup triggered by visitor activity is possible, essentially inspiring the
 *  functionality of this plugin.
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Basic check #1 - is PHP5 installed?
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	// No version info. I'll lie and hope for the best.
	$version = '5.0.0';
}

// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.0.0', '>=')) return;

// Basic check #2 - is Akeeba Backup installed?
jimport('joomla.filesystem.file');
if( !JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'version.php') ) return;

// Basic check #3 - is Akeeba Backup of July 28th 2010 or later installed?
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'version.php';
jimport('joomla.utilities.date');
$date = new JDate(AKEEBA_DATE);
if($date->toUnix() < 1280293200) return;

// Preload the Akeeba Engine factory
if(!defined('AKEEBAENGINE')) {
	define('AKEEBAENGINE', 1); // Required for accessing Akeeba Engine's factory class
	define('AKEEBAPLATFORM', 'joomla15'); // So that platform-specific stuff can get done!
}
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba'.DS.'akeeba'.DS.'factory.php';

// Since we are here, we can now include our main plugin file
require_once 'aklazy/main.php';