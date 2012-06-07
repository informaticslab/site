<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments Installer
 *
 * @static
 * @version 2.1
 * @package JComments
 * @subpackage Installer
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2009-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

class JCommentsInstallerLanguageHelper
{
	function convertLanguages()
	{
		global $mainframe;

		$joomlaLanguagesPath = $mainframe->getCfg('absolute_path').DS.'language';
		$componentPath = $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments';

		require_once ($componentPath.DS.'libraries'.DS.'convert'.DS.'utf8.class.php');
		require_once ($componentPath.DS.'libraries'.DS.'joomlatune'.DS.'filesystem.php');
		require_once ($componentPath.DS.'libraries'.DS.'joomlatune'.DS.'language.tools.php');

		$path = $componentPath.DS.'languages';
		$filter = '[a-z]{2}-[A-Z]{2}\.com_jcomments\.ini';

		$files = JoomlaTuneFS::readDirectory($path, $filter, false, true);

		$codeMap = JoomlaTuneLanguageTools::getLanguageCodes();

		$joomlaLanguageFiles = JoomlaTuneFS::readDirectory($joomlaLanguagesPath, '[a-z]+\.xml', false, false);
		$joomlaLanguages = array();
		foreach($joomlaLanguageFiles as $file) {
			$joomlaLanguages[] = str_replace('.xml', '', $file);
		}

		foreach ($files as $file) {
			$m = array();
			preg_match('#([a-z]{2}-[A-Z]{2})#', (string) $file, $m);

			$code = $m[0];

			$language = isset($codeMap[$code]) ? $codeMap[$code][0] : '';
			$charset = isset($codeMap[$code]) ? $codeMap[$code][1] : 'iso-8859-1';

			if ($language != '' && in_array($language, $joomlaLanguages)) {
				if (defined('_ISO2')) {
					$charset = strtolower(_ISO2);
					if ($charset == 'utf-8' || $charset == 'utf8') {
						$newFile = str_replace( $code . '.com_jcomments.ini', $language . '.ini', $file);
						@copy((string) $file, $newFile);
					} else {
						JCommentsInstallerLanguageHelper::_convertFile($file, $code, $charset, $language);
					}
				} else {
					JCommentsInstallerLanguageHelper::_convertFile($file, $code, $charset, $language);
				}
			}
		}
		unset($codeMap);
	}

	function _convertFile($inFile, $code, $charset, $language)
	{
		$oldLines = file($inFile);
		$txt = implode('', $oldLines);
		$txt = str_replace('&lt;', '&amp;lt;', $txt);
		$txt = str_replace('&gt;', '&amp;gt;', $txt);
		$txt = str_replace("’", "'", $txt);

		if (($code == 'de-DE') || ($code == 'fr-FR') || ($code == 'it-IT')) {	
			$txt = htmlentities(utf8_decode($txt));
		} else {
			$converter = new JCommentsUtf8($charset);
			$txt = $converter->utf8ToStr($txt);
		}

		$txt = str_replace('&lt;', '<', $txt);
		$txt = str_replace('&gt;', '>', $txt);
		$txt = str_replace('&quot;', '"', $txt);
		$txt = str_replace('&amp;quot;', '&quot;', $txt);
		$txt = str_replace('&amp;gt;', '&gt;', $txt);
		$txt = str_replace('&amp;lt;', '&lt;', $txt);
		$txt = str_replace('Note : All ini files need to be saved as UTF-8 - No BOM', 'Note: this file need to be saved in ' . $charset . ' charset', $txt);

		$inFile = str_replace( $code . '.com_jcomments.ini', $language . '.ini', $inFile);

		$fp = fopen($inFile , "w");
		if ($fp) {
			fputs($fp, $txt);
			fclose($fp);
		}
	}
}
?>