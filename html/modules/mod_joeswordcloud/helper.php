<?php
/**
 * Helper class for Joes Word Cloud module
 *
 * @package    Joes Joomla
 * @subpackage Modules
 * @link www.joellipman.com
 * @license        GNU GPL v3
 * Displays a cluster of the words from your Joomla! articles (core content not meta data).  What makes this one different to other module tag clouds is that this doesn\'t use tags or meta data and instead gets its words from your Joomla! articles.  Does not use any javascript or fancy effects so as to minimize any overheads in bandwidth and server interactions.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modJoesWordCloudHelper
{




	/**
     * Retrieves the hello message
     *
     * @param array $params An object containing the module parameters
     * @access public
     */
    function getModuleContent( $params )
    {

		# some sub functions to be used in this function
		function joes_strip_punctuation( $text ) {
		    $urlbrackets    = '\[\]\(\)';
		    $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
		    $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
		    $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;
		    $specialquotes  = '\'"\*<>';
		    $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
		    $comma          = '\x{002C}\x{FE50}\x{FF0C}';
		    $arabsep        = '\x{066B}\x{066C}';
		    $numseparators  = $fullstop . $comma . $arabsep;
		    $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
		    $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
		    $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
		    $nummodifiers   = $numbersign . $percent . $prime;
		    return preg_replace(
		        array(
		            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
		            '/\p{Po}(?<![' . $specialquotes .
		                $numseparators . $urlall . $nummodifiers . '])/u',
		            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
		            '/[' . $specialquotes . $numseparators . $urlspaceafter .
		                '\p{Pd}\p{Pc}]+((?= )|$)/u',
		            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
		            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
		            '/ +/',
		        ),
		        ' ',
				$text );
		}

		function joes_strip_symbols( $text ) {
		    $plus   = '\+\x{FE62}\x{FF0B}\x{208A}\x{207A}';
		    $minus  = '\x{2012}\x{208B}\x{207B}';
		    $units  = '\\x{00B0}\x{2103}\x{2109}\\x{23CD}';
		    $units .= '\\x{32CC}-\\x{32CE}';
		    $units .= '\\x{3300}-\\x{3357}';
		    $units .= '\\x{3371}-\\x{33DF}';
		    $units .= '\\x{33FF}';
		    $ideo   = '\\x{2E80}-\\x{2EF3}';
		    $ideo  .= '\\x{2F00}-\\x{2FD5}';
		    $ideo  .= '\\x{2FF0}-\\x{2FFB}';
		    $ideo  .= '\\x{3037}-\\x{303F}';
		    $ideo  .= '\\x{3190}-\\x{319F}';
		    $ideo  .= '\\x{31C0}-\\x{31CF}';
		    $ideo  .= '\\x{32C0}-\\x{32CB}';
		    $ideo  .= '\\x{3358}-\\x{3370}';
		    $ideo  .= '\\x{33E0}-\\x{33FE}';
		    $ideo  .= '\\x{A490}-\\x{A4C6}';
		    return preg_replace(
		        array(
		            '/[\p{Sk}\p{Co}]/u',
					'/\p{Sm}(?<![' . $plus . $minus . '=~\x{2044}])/u',
					'/((?<= )|^)[' . $plus . $minus . ']+((?![\p{N}\p{Sc}])|$)/u',
					'/((?<= )|^)=+/u',
					'/[' . $plus . $minus . '=~]+((?= )|$)/u',
					'/\p{So}(?<![' . $units . $ideo . '])/u',
					'/ +/',
				),
				' ',
				$text );
		}

		function joes_utf8_strlen($str) {
		    $count = 0;
		    for($i = 0; $i < strlen($str); $i++) {
		        $value = ord($str[$i]);
		        if($value > 127) {
		            if($value >= 192 && $value <= 223)
		                $i++;
		            elseif($value >= 224 && $value <= 239)
		                $i = $i + 2;
		            elseif($value >= 240 && $value <= 247)
		                $i = $i + 3;
				}
			    $count++;
			}
			return $count;
		}

		function joes_return_keywords($str) {
			$search = array (
				'@<script[^>]*?>.*?</script>@si',	// Strip out javascript
				'@<style[^>]*?>.*?</style>@si',		// Strip out Inline Stylesheets
				'@[{].*?[}]@si',					// Strip out Internal Joomla Curly Brackets commands?
		        '@<[\/\!]*?[^<>]*?>@si',			// Strip out HTML tags
		        '@([\r\n])[\s]+@',					// Strip out white space
		        '@&#(\d+);@e'
			);
			$str = preg_replace($search, ' ', $str);
			$str = strip_tags(str_replace(array('[',']'), array('<','>'), $str));	// remove BB Code and HTML tags
			$str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );					// converts html entities into characters (symbols)
			$str = preg_replace("/&.{0,}?;/",'', $str);								// removes numeric entities?
			$str = preg_replace('/<!--\[if[^\]]*]>.*?<!\[endif\]-->/i', '', $str);	// removes MS Office style html comments (and everything in between)
			$str = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $str);			// remove carriage returns, line feeds, tabs and double-spaces

			$str = joes_strip_punctuation( $str );									// remove punctuation in unicode
			$str = joes_strip_symbols( $str );										// remove symbols in unicode

			$str = str_replace('  ', ' ', $str);									// replace any double-spaces with a single-space
			$str = str_replace('  ', ' ', $str);									// replace any double-spaces with a single-space

			return $str;
		}

		# version 1.1
		$modulescancontent = $params->get('paramSCANCONTENT')*1;
		$temp_array = array( 'title', 'intro', 'title, intro' );
		$modulescansql = $temp_array[$modulescancontent];
		$modulescancontent = $params->get('paramSCANCONTENT')*1;
		$temp_array = array( 'a.title title', 'a.introtext intro', 'a.title title, a.introtext intro' );
		$modulescancontentsql = $temp_array[$modulescancontent];
		$modulesearchurl = strip_tags(trim($params->get('paramSEARCHURL')));
		$moduleminwordlength = $params->get('paramMINWORDLENGTH')*1;
		$modulewordcount = $params->get('paramWORDCOUNT')*1;
		$modulewordcount=($modulewordcount<=0)?1:$modulewordcount;
		$moduleminfontsize = $params->get('paramMINFONTSIZE')*1;
		$modulemaxfontsize = $params->get('paramMAXFONTSIZE')*1;
		$modulepoweredby = $params->get('paramPOWEREDBY')*1;
		$modulepoweredby=($modulepoweredby==1)?true:false;

		# version 1.2
		$moduletextalignment = $params->get('paramTEXTALIGNMENT')*1;
		$temp_array = array( 'left', 'center', 'right', 'justify' );
		$moduletextalignment = $temp_array[$moduletextalignment];

		# version 1.3
		$modulewordunderlines = $params->get('paramWORDUNDERLINES')*1;
		$modulewordunderlines=($modulewordunderlines==1)?true:false;
		$modulescank2 = $params->get('paramSCANK2')*1;
		$modulescank2=($modulescank2==1)?true:false;
		$temp_array = array( 'b.title title', 'b.introtext intro', 'b.title title, b.introtext intro' );
		$modulescancontentk2 = $temp_array[$modulescancontent];
		$modulescanhp = $params->get('paramSCANHOTPROPERTY')*1;
		$modulescanhp=($modulescanhp==1)?true:false;
		$temp_array = array( 'c.name title', 'c.intro_text intro', 'c.name title, c.intro_text intro' );
		$modulescancontenthp = $temp_array[$modulescancontent];
		$moduleexclusionlist_array=array();
		$moduleexclusionlist = strip_tags(trim($params->get('paramEXCLUDEKEYWORDS')));
		$moduleexclusionlist_array = explode(",", $moduleexclusionlist);
		for ($i=0; $i<count($moduleexclusionlist_array); $i++) { $moduleexclusionlist_array[$i]=trim($moduleexclusionlist_array[$i]); }

		# version 1.4
		$moduleinclusionlist_array=array();
		$moduleinclusionlist = strip_tags(trim($params->get('paramINCLUDEKEYWORDS')));
		$moduleinclusionlist_array = explode(",", $moduleinclusionlist);
		for ($i=0; $i<count($moduleinclusionlist_array); $i++) { $moduleinclusionlist_array[$i]=trim($moduleinclusionlist_array[$i]); }

		# version 1.5
		$modulescanphocadl = $params->get('paramSCANPHOCADOWNLOAD')*1;
		$modulescanphocadl=($modulescanphocadl==1)?true:false;
		$temp_array = array( 'd.title title', 'd.description intro', 'd.title title, d.description intro' );
		$modulescancontentphocadlsql = $temp_array[$modulescancontent];
		$moduleshowsql = $params->get('paramSHOWSQL')*1;
		$moduleshowsql =($moduleshowsql==1)?true:false;
		$modulecasesensitive = $params->get('paramCASESENSITIVE')*1;
		$modulecasesensitive=($modulecasesensitive==1)?true:false;

		#if no values set then specify default values
		$moduleminwordlength=((trim($moduleminwordlength)=="")||($moduleminwordlength<=0))?5:$moduleminwordlength;
		$modulewordcount=((trim($modulewordcount)=="")||($modulewordcount<=0))?5:$modulewordcount;
		$modulecontent="";
		$freqData=$all_words=$word_array=array();
		$count=0;
		$text_decoration=($modulewordunderlines)?";text-decoration:none":"";

		# add alignment parameter
		$output='<p style="text-align:'.$moduletextalignment.'">';

		if (trim($moduleinclusionlist)=="") {

			# convert to unicode
			$db =& JFactory::getDBO();
			$sql_utf8 = "set names 'utf8'";
			$db->setQuery( $sql_utf8 );
			$temp_result = $db->query();

			# combine further tables
			$k2_sql=($modulescank2)?'UNION ALL SELECT '.$modulescancontentk2.' FROM `#__k2_items` b WHERE b.published=1':'';
			$hp_sql=($modulescanhp)?'UNION ALL SELECT '.$modulescancontenthp.' FROM `#__hp_properties` c WHERE c.published=1':'';
			$pcdl_sql=($modulescanphocadl)?'UNION ALL SELECT '.$modulescancontentphocadlsql.' FROM `#__phocadownload` d WHERE d.published=1':'';

			# generate sql query
			$sql_query = '
SELECT
	'.$modulescansql.'
FROM
	(
		SELECT
			'.$modulescancontentsql.'
		FROM
			`#__content` a
		WHERE
			a.state=1
		'.$k2_sql.'
		'.$hp_sql.'
		'.$pcdl_sql.'
	) t1
';
			$db->setQuery( $sql_query );
			$countvalidrows=0;
			$rows = $db->loadAssocList();
			for($i=0;$i<count($rows);$i++) {
				$countvalidrows++;
				$title = $rows[$i]['title'];
				$introtext = ($modulescancontent>0) ? $rows[$i]['intro'] : '';
				$full_string = $title.' '.$introtext;
				$full_string = joes_return_keywords( $full_string );  // try to return only words bearing in mind International characters
				$word_array = explode(" ", $full_string);
				$all_words = array_merge($all_words, $word_array);
			}
			$modulecontent = implode($all_words , " ");						// convert the all_words array into a string
			$all_words_count_array = array_count_values ( $all_words );		// create associative array with words as keys and frequency as values
			$all_words=array();												// clear some memory and we're going to reuse it
			unset($all_words_count_array['']);								// remove any words which are NULL
			arsort( $all_words_count_array );								// sort by values in reverse alphabetical order
			$all_words_count_array = array_keys( $all_words_count_array );	// return an array with just the words (keys. values are frequency)
		} else {
			unset($moduleinclusionlist_array['']);								// remove any words which are NULL
			$all_words_count_array=$moduleinclusionlist_array;
			$modulewordcount=count($all_words_count_array);
			$countvalidrows=0;
			$sql_query='Invalid request as "Inclusion List" is not empty.';
		}
		$fontsize_variant=(($modulemaxfontsize-$moduleminfontsize)/$modulewordcount);

		# process the words array
		for ($i=0; $i<count($all_words_count_array); $i++) {
			$cloud_word=trim($all_words_count_array[$i]);
			if (joes_utf8_strlen($cloud_word)>=$moduleminwordlength) {	// now check that each word meets the minimum length specified

				if ($modulecasesensitive) {
					if ((!in_array( $cloud_word, $moduleexclusionlist_array ))) {
						$count++;																// increment count of words that were valid

						# assign font size
						$fontsize=intval($modulemaxfontsize-($fontsize_variant*$count));
						$all_words[]='<a href="/'.$modulesearchurl.$cloud_word.'"><span style="font-size:'.$fontsize.'px'.$text_decoration.'">'.$cloud_word.'</span></a>';
						if ($count>=$modulewordcount) break;
					}
				} else {
					if (!in_array( mb_strtolower($cloud_word, 'UTF-8'), $moduleexclusionlist_array)) {
						$count++;																// increment count of words that were valid

						# assign font size
						$fontsize=intval($modulemaxfontsize-($fontsize_variant*$count));
						$all_words[]='<a href="/'.$modulesearchurl.$cloud_word.'"><span style="font-size:'.$fontsize.'px'.$text_decoration.'">'.$cloud_word.'</span></a>';
						if ($count>=$modulewordcount) break;
					}
				}
			}
		}
		shuffle( $all_words );
		$modulecontent="\n\n\n".implode( " ", $all_words )."\n\n\n";
		$output.=$modulecontent;
		if ($modulepoweredby) {$output.=' <a href="http://www.joellipman.com/" target="_blank" style="font-size:8px">JoelLipman.Com</a>'; }
		$output.=($moduleshowsql)?'<br /><br />['.$countvalidrows.' valid data row(s).  '.$sql_query.']<br /><br /></p>':'</p>';
		return $output;
    }
}
?>
