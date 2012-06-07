<?php
/**
 * Filesystem handler class. Based on code from Joomla! CMS
 *
 * @version 1.0
 * @package JoomlaTune.Framework
 * @subpackage FileSystem
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 * @access public
 */

// Check for double include
if (!defined('JOOMLATUNE_FS')) {
	
	define('JOOMLATUNE_FS', 1);
	
	/**
	 * A File & Folders handling class
	 *
	 * @static
	 * @package JoomlaTune.Framework
	 * @subpackage	FileSystem
	 */
	class JoomlaTuneFS
	{
		/**
		 * Utility function to read the files and folders in a folder
		 *
		 * @static
		 * @param	string	$path		The path of the folder to read
		 * @param	string	$filter		A filter for folder names
		 * @param	mixed	$recurse	True to recursively search into sub-folders, or an integer to specify the maximum depth
		 * @param	boolean	$fullpath	True to return the full path to the folders
		 * @param	array	$exclude	Array with names of folders which should not be shown in the result
		 * @return	array	Folders in the given folder
		 */
		function readDirectory( $path, $filter = '.', $recurse = false, $fullpath = false, $exclude = array('.svn', 'CVS') )
		{
			$arr = array();
			
			$path = preg_replace('#[/\\\\]+#', DS, $path);
			
			if (!@is_dir($path)) {
				return $arr;
			}
			// read the source directory
			$handle = opendir($path);
			while (($file = readdir($handle)) !== false) {
				$dir = $path.DS.$file;
				$isDir = is_dir($dir);
				if (($file != '.') && ($file != '..') && (!in_array($file, $exclude))) {
					// removes SVN directores from list
					if (preg_match("/$filter/", $file)) {
						if ($fullpath) {
							$arr[] = $dir;
						} else {
							$arr[] = $file;
						}
					}
					if ($recurse && $isDir) {
						if (is_integer($recurse)) {
							$recurse--;
						}
						
						$arr2 = JoomlaTuneFS::readDirectory($dir, $filter, $recurse, $fullpath);
						$arr = array_merge($arr, $arr2);
					}
				}
			}
			closedir($handle);
			
			asort($arr);
			return $arr;
		}
	}
} // end of double include check
?>