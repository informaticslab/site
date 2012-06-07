<?php

if (!class_exists('JoomlaTuneLanguageTools')) {

	/**
	 * Languages tools
	 *
	 * @version 1.0
	 * @package JoomlaTune.Framework
	 * @subpackage Language
	 * @author Sergey M. Litvinov
	 * @copyright 2009-2010
	 * @access public
	 */
	class JoomlaTuneLanguageTools
	{

		/**
		 * Returns array list with language codes and additional information (name and encoding)
		 *
		 * @static
		 * @public
		 * @return	array
		 */
		function getLanguageCodes()
		{
			return array(
				  'be-BY' => array( 0 => 'belorussian', 1 => 'windows-1251')
				, 'bg-BG' => array( 0 => 'bulgarian', 1 => 'windows-1251')
				, 'ca-ES' => array( 0 => 'catalan', 1 => 'iso-8859-1')
				, 'cs-CZ' => array( 0 => 'czech', 1 => 'windows-1250')
				, 'da-DK' => array( 0 => 'danish', 1 => 'iso-8859-1')
				, 'de-DE' => array( 0 => 'german', 1 => 'iso-8859-1')
				, 'el-GR' => array( 0 => 'greek', 1 => 'windows-1253')
				, 'en-GB' => array( 0 => 'english', 1 => 'iso-8859-1')
				, 'es-ES' => array( 0 => 'spanish', 1 => 'iso-8859-1')
				, 'et-EE' => array( 0 => 'estonian', 1 => 'iso-8859-1')
				, 'eu-ES' => array( 0 => 'basque', 1 => 'iso-8859-1')
				, 'fi-FI' => array( 0 => 'finnish', 1 => 'iso-8859-1')
				, 'fr-FR' => array( 0 => 'french', 1 => 'iso-8859-1')
				, 'gl-ES' => array( 0 => 'galician', 1 => 'iso-8859-1')
				, 'hr-HR' => array( 0 => 'croatian', 1 => 'windows-1250')
				, 'hu-HU' => array( 0 => 'hungarian', 1 => 'iso-8859-2')
				, 'it-IT' => array( 0 => 'italian', 1 => 'iso-8859-1')
				, 'ja-JP' => array( 0 => 'japanese', 1 => 'iso-2022-jp')
				, 'lv-LV' => array( 0 => 'latvian', 1 => 'iso-8859-13')
				, 'nb-NO' => array( 0 => 'norwegian', 1 => 'iso-8859-1')
				, 'nl-NL' => array( 0 => 'dutch', 1 => 'iso-8859-1')
				, 'pl-PL' => array( 0 => 'polish', 1 => 'windows-1250')
				, 'pt-BR' => array( 0 => 'portuguese', 1 => 'iso-8859-1')
				, 'pt-PT' => array( 0 => 'portuguese', 1 => 'iso-8859-1')
				, 'ro-RO' => array( 0 => 'romanian', 1 => 'iso-8859-2')
				, 'ru-RU' => array( 0 => 'russian', 1 => 'windows-1251')
				, 'sk-SK' => array( 0 => 'slovak', 1 => 'windows-1250')
				, 'sl-SL' => array( 0 => 'slovenian ', 1 => 'iso-8859-2')
				, 'sr-YU' => array( 0 => 'serbian ', 1 => 'iso-8859-2')
				, 'sv-SE' => array( 0 => 'swedish ', 1 => 'iso-8859-1')
				, 'th-TH' => array( 0 => 'thai ', 1 => 'windows-874')
				, 'tr-TR' => array( 0 => 'turkish', 1 => 'iso-8859-9')
				, 'uk-UA' => array( 0 => 'ukrainian', 1 => 'windows-1251')
			);
		}

		/**
		 * Returns language code for given language name
		 *
		 * @static
		 * @public
		 * @param	string	$name	language name
		 * @return	string	language code
		 */
		function Name2Code($name)
		{
		        $codes = JoomlaTuneLanguageTools::getLanguageCodes();
			foreach($codes as $code=>$meta) {
				if ($meta[0] == strtolower($name)) {
					return $code;
				}
			}
			return '';
		}

		/**
		 * Returns correct plural form for specified language and number value
		 *
		 * @static
		 * @public
		 * @param	string	$code	language code
		 * @param	int	$number	number value
		 * @param	array	$pluralForms	array of plural forms for specified language
		 * @param	string	$defaultText	default value if no plural form found
		 * @return	string
		 */
		function getPlural($code, $number, $pluralForms, $defaultText = '')
		{
	        	// source: http://translate.sourceforge.net/wiki/l10n/pluralforms
			$rules = array(
				  'be-BY' => array(3, '(n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10< =4 && (n%100<10 || n%100>=20) ? 1 : 2))')
				, 'bg-BG' => array(2, '(n != 1)')
				, 'ca-ES' => array(2, '(n != 1)')
				, 'cs-CZ' => array(3, '(n==1) ? 0 : ((n>=2 && n<=4) ? 1 : 2)')
				, 'da-DK' => array(2, '(n != 1)')
				, 'de-DE' => array(2, '(n != 1)')
				, 'el-GR' => array(2, '(n != 1)')
				, 'en-GB' => array(2, '(n != 1)')
				, 'es-ES' => array(2, '(n != 1)')
				, 'et-EE' => array(2, '(n != 1)')
				, 'eu-ES' => array(2, '(n != 1)')
				, 'fi-FI' => array(2, '(n != 1)')
				, 'fr-FR' => array(2, '(n > 1)')
				, 'gl-ES' => array(2, '(n != 1)')
				, 'hr-HR' => array(3, '(n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 or n%100>=20) ? 1 : 2))')
				, 'hu-HU' => array(1, '0')
				, 'it-IT' => array(2, '(n != 1)')
				, 'ja-JP' => array(1, '0')
				, 'lv-LV' => array(3, '(n%10==1 && n%100!=11 ? 0 : n != 0 ? 1 : 2)')
				, 'nb-NO' => array(2, '(n != 1)')
				, 'nl-NL' => array(2, '(n != 1)')
				, 'pl-PL' => array(3, '(n==1 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2))')
				, 'pt-PT' => array(2, '(n != 1)')
				, 'pt-BR' => array(2, '(n > 1)')
				, 'ro-RO' => array(3, '(n==1 ? 0 : (n==0 || (n%100 > 0 && n%100 < 20)) ? 1 : 2)')
				, 'ru-RU' => array(3, '(n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2))')
				, 'sk-SK' => array(3, '(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2')
				, 'sl-SL' => array(4, '(n%100==1 ? 0 : (n%100==2 ? 1 : (n%100==3 || n%100==4 ? 2 : 3)))')
				, 'sr-YU' => array(4, '(n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 or n%100>=20) ? 1 : 2))')
				, 'sv-SE' => array(2, '(n != 1)')
				, 'th-TH' => array(1, '0')
				, 'tr-TR' => array(1, '0')
				, 'uk-UA' => array(3, '(n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2))')
			);

			if (!is_array($pluralForms)) {
				$pluralForms = explode(';', $pluralForms);			
			}

			if (!preg_match('#([a-z]{2}-[A-Z]{2})#', $code)) {
				$code = JoomlaTuneLanguageTools::name2code($code);
			}

			if (isset($rules[$code])) {
				$rule = $rules[$code];
				if (count($pluralForms) == $rule[0]) {
					$expression = str_replace('n', '$number', $rule[1]);
					$idx = 0;
					eval('$idx = ' . $expression . ';');
					if (isset($pluralForms[$idx])) {
						return $pluralForms[$idx];
					}
				}
			}
			return $defaultText;
		}
	}
}
?>