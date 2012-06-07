<?php
/**
 * JComments - Joomla Comment System
 *
 * Core classes
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

ob_start();
// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once (JCOMMENTS_BASE.DS.'jcomments.legacy.php');
require_once (JCOMMENTS_HELPERS.DS.'object.php');
ob_end_clean();

/**
 * Comments table
 *
 */
class JCommentsDB extends JoomlaTuneDBTable
{
	/** @var int Primary key */
	var $id = null;
	/** @var int */
	var $parent = null;
	/** @var string */
	var $path = null;
	/** @var int */
	var $level = null;
	/** @var int */
	var $object_id = null;
	/** @var string */
	var $object_group = null;
	/** @var string */
	var $object_params = null;
	/** @var string */
	var $lang = null;
	/** @var int */
	var $userid = null;
	/** @var string */
	var $name = null;
	/** @var string */
	var $username = null;
	/** @var string */
	var $title = null;
	/** @var string */
	var $comment = null;
	/** @var string */
	var $email = null;
	/** @var string */
	var $homepage = null;
	/** @var datetime */
	var $date = null;
	/** @var string */
	var $ip = null;
	/** @var int */
	var $isgood = null;
	/** @var int */
	var $ispoor = null;
	/** @var boolean */
	var $published = null;
	/** @var boolean */
	var $subscribe = null;
	/** @var string */
	var $source = null;
	/** @var boolean */
	var $checked_out = 0;
	/** @var datetime */
	var $checked_out_time = 0;
	/** @var string */
	var $editor = '';

	/**
	* @param database A database connector object
	* @access public
	* @return JCommentsDB
	*/
	function JCommentsDB( &$db ) {
		$this->JoomlaTuneDBTable('#__jcomments', 'id', $db);
	}

	function delete( $oid=null )
	{
		
		$k = $this->_tbl_key;
		$id = $oid ? $oid : $this->$k;

		$result = parent::delete($oid);
		
		if ($result) {
			// process nested comments (threaded mode)
			$query = "SELECT id, parent"
				. "\n FROM #__jcomments"
				. "\n WHERE `object_group` = '" . $this->object_group . "'"
				. "\n AND `object_id`='" . $this->object_id . "'"
				;
			$this->_db->setQuery($query);
			$rows = $this->_db->loadObjectList();

			require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'tree.php');

			$tree = new JoomlaTuneTree($rows);
			$descendants = $tree->descendants($id);

			unset($rows);

			if (count($descendants)) {
				$query = "DELETE FROM #__jcomments WHERE id IN (" . implode(',', $descendants) . ')';
				$this->_db->setQuery($query);
				$this->_db->query();

				$descendants[] = $id;
				$query = "DELETE FROM #__jcomments_votes WHERE commentid IN (" . implode(',', $descendants) . ')';
				$this->_db->setQuery($query);
				$this->_db->query();

				$query = "DELETE FROM #__jcomments_reports WHERE commentid IN (" . implode(',', $descendants) . ')';
				$this->_db->setQuery($query);
				$this->_db->query();
			} else {
				// delete comment's vote info
				$query = "DELETE FROM #__jcomments_votes WHERE commentid = " . $id;
				$this->_db->setQuery($query);
				$this->_db->query();

				// delete comment's reports info
				$query = "DELETE FROM #__jcomments_reports WHERE commentid = " . $id;
				$this->_db->setQuery($query);
				$this->_db->query();
			}
			unset($descendants);
		}

		return $result;
	}

}

class JCommentsBaseACL
{
	function check( $str )
	{
		global $my;

		if (isset($str)) {

			if (!isset($my)) {
				$my = & JCommentsFactory::getUser();
			}

			$list = explode(',', $str);

			if (isset($my->groups)) {
				if (array_intersect($my->groups, $list)) {
					return 1;		
				}
			}

			for ($i = 0, $n = count($list); $i < $n; $i++) {
				if (($my->id != 0) && ($my->usertype == $list[$i])) {
					return 1;
				} else if (($my->id == 0) && ($list[$i] == 'Unregistered')) {
					return 1;
				}
			}
		}
		return 0;
	}
}

class JCommentsACL extends JCommentsBaseACL
{
	var $canDelete		= 0;
	var $canDeleteOwn	= 0;
	var $canEdit		= 0;
	var $canEditOwn		= 0;
	var $canPublish		= 0;
	var $canViewIP		= 0;
	var $canViewEmail	= 0;
	var $canViewHomepage	= 0;
	var $canComment		= 0;
	var $canQuote		= 0;
	var $canReply		= 0;
	var $canVote		= 0;
	var $canReport		= 0;
	var $userID		= 0;
	var $userIP		= 0;

	function JCommentsACL() {
		global $my, $mainframe;

		if (!isset($my)) {
			$my = $mainframe->getUser();
		}
		
		$config = & JCommentsFactory::getConfig();

		$this->canDelete	= $this->check('can_delete');
		$this->canDeleteOwn	= $this->check('can_delete_own');
		$this->canEdit		= $this->check('can_edit');
		$this->canEditOwn	= $this->check('can_edit_own');
		$this->canPublish	= $this->check('can_publish');
		$this->canViewIP	= $this->check('can_view_ip');
		$this->canViewEmail	= $this->check('can_view_email');
		$this->canViewHomepage	= $this->check('can_view_homepage');
		$this->canComment	= $this->check('can_comment');
		$this->canVote		= $this->check('can_vote');
		$this->canReport	= $this->check('can_report');
		$this->canQuote		= intval($this->canComment && $this->check('enable_bbcode_quote'));
		$this->canReply		= intval($this->canComment && $this->check('can_reply') && $config->get('template_view') == 'tree');

		$this->userID		= (int) $my->id;
		$this->userIP		= $_SERVER['REMOTE_ADDR'];// getenv('REMOTE_ADDR');
	}

	function check( $str )
	{
		$config = & JCommentsFactory::getConfig();
	        return JCommentsBaseACL::check($config->get($str));
	}

	function getUserIP()
	{
		return $this->userIP;
	}

	function getUserId()
	{
		return $this->userID;
	}

	function isLocked($obj)
	{
		if (isset($obj) && ($obj!=null)) {
			return ($obj->checked_out && $obj->checked_out != $this->userID) ? 1 : 0;
		}
		return 0;
	}

	function canDelete($obj)
	{
		return (($this->canDelete || ($this->canDeleteOwn && ($obj->userid == $this->userID)))
			&& (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canEdit($obj)
	{
		return (($this->canEdit || ($this->canEditOwn && ($obj->userid == $this->userID)))
			&& (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canPublish($obj=null)
	{
		return ($this->canPublish && (!$this->isLocked($obj))) ? 1 : 0;
	}

	function canViewIP($obj=null)
	{
		if (is_null($obj)) {
			return ($this->canViewIP) ? 1 : 0;
		} else {
			return ($this->canViewIP&&($obj->ip!='')) ? 1 : 0;
		}
	}

	function canViewEmail($obj=null)
	{
		if (is_null($obj)) {
			return ($this->canViewEmail) ? 1 : 0;
		} else {
			return ($this->canViewEmail&&($obj->email!='')) ? 1 : 0;
		}
	}

	function canViewHomepage($obj=null)
	{
		if (is_null($obj)) {
			return ($this->canViewHomepage) ? 1 : 0;
		} else {
			return ($this->canViewHomepage&&($obj->homepage!='')) ? 1 : 0;
		}
	}

	function canComment()
	{
		return $this->canComment;
	}

	function canQuote($obj=null)
	{
		if (is_null($obj)) {
			return $this->canQuote;
		} else {
			return ($this->canQuote&&(!isset($obj->_disable_quote))) ? 1 : 0;
		}
	}

	function canReply($obj=null)
	{
		if (is_null($obj)) {
			return $this->canReply;
		} else {
			return ($this->canReply&&(!isset($obj->_disable_reply))) ? 1 : 0;
		}
	}

	function canVote($obj)
	{
		if ($this->userID) {
			return ($this->canVote && $obj->userid != $this->userID && !isset($obj->voted));
		} else {
			return ($this->canVote && $obj->ip != $this->userIP && !isset($obj->voted));
		}

	}

	function canReport($obj)
	{
		if (is_null($obj)) {
			return $this->canReport;
		} else {
			return ($this->canReport && (!isset($obj->_disable_report))) ? 1 : 0;
		}
	}

	function canModerate($obj) {
		return $this->canEdit($obj) || $this->canDelete($obj)
			|| $this->canPublish($obj) || $this->canViewIP($obj);
	}
}

function jc_compare($a, $b) {
	if (strlen($a) == strlen($b)) {
		return 0;
	}
	return (strlen($a) > strlen($b)) ? -1 : 1;
}

class JCommentsSmiles
{
	var $_smiles = array();

	function JCommentsSmiles()
	{
		global $mainframe;

		if (count($this->_smiles) == 0) {
			$config = & JCommentsFactory::getConfig();
			$list = (array) $config->get('smiles');
			uksort($list, 'jc_compare');
			
			foreach ($list as $sc=>$si) {
				$this->_smiles['code'][] = '#(^|\s|\n|\r|\>)('.preg_quote( $sc, '#' ) . ')(\s|\n|\r|\<|$)#ism' . JCOMMENTS_PCRE_UTF8;
				$this->_smiles['icon'][] = '\\1 \\2 \\3';
				$this->_smiles['code'][] = '#(^|\s|\n|\r|\>)('.preg_quote( $sc, '#' ) . ')(\s|\n|\r|\<|$)#ism' . JCOMMENTS_PCRE_UTF8;
				$this->_smiles['icon'][] = '\\1<img src="' . $mainframe->getCfg( 'live_site' ) . '/components/com_jcomments/images/smiles/' . $si . '" border="0" alt="'.htmlspecialchars($sc).'" />\\3';
			}
		}
	}

	function get()
	{
		return $this->_smiles;
	}

	function replace($str)
	{
		if (count($this->_smiles) == 0) {
			return $str;
		}

		$str = JCommentsText::br2nl($str);
		$str = preg_replace($this->_smiles['code'], $this->_smiles['icon'], $str);
		$str = JCommentsText::nl2br($str);

		return $str;
	}

	function strip($str)
	{
		if (count($this->_smiles) == 0) {
			return $str;
		}

		$str = JCommentsText::br2nl($str);
		$str = preg_replace($this->_smiles['code'], '\\1\\3', $str);
		$str = JCommentsText::nl2br($str);

		return $str;
	}
}

/**
 * Base class
 * 
 */
class JCommentsPlugin
{
	/**
	 * Return the title of an object by given identifier.
	 *
	 * @abstract
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return string Object title 
	 */
	function getObjectTitle( $id )
	{
		global $mainframe;
		return $mainframe->getCfg('sitename');
	}

	/**
	 * Return the URI to object by given identifier.
	 *
	 * @abstract 
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return string URI of an object 
	 */
	function getObjectLink( $id )
	{
		global $mainframe;
		return $mainframe->getCfg('live_site');
	}

	/**
	 * Return identifier of the object owner.
	 *
	 * @abstract 
	 * @access public 
	 * @param int $id A object identifier. 
	 * @return int Identifier of the object owner, otherwise -1 
	 */
	function getObjectOwner( $id )
	{
		return -1;
	}

	/**
	 * Return titles for objects by given identifiers.
	 *
	 * @abstract
	 * @access public 
	 * @param array $ids A object identifier. 
	 * @return array titles
	 */
	function getTitles( $ids )
	{
		return array();
	}

	function getCategories( $filter = '' )
	{
		return array();
	}

	function getItemid( $object_group )
	{
		static $cache = null;
		
		if (!isset($cache)) {
			$cache = array();
		}
		
		$v = 'jc_' . $object_group . '_itemid';

		if (!isset($cache[$v])) {
			if (JCOMMENTS_JVERSION == '1.5') {
				require_once(JPATH_SITE.DS.'includes'.DS.'application.php');
				$component = & JComponentHelper::getComponent($object_group);
				$menus = & JSite::getMenu();
				$items = $menus->getItems('componentid', $component->id);
				$cache[$v] = (count($items)) ? $items[0]->id : 0;
				unset($items);
			} else {
				$db = & JCommentsFactory::getDBO();
				$db->setQuery("SELECT id FROM `#__menu` WHERE link LIKE '%" . $db->getEscaped($object_group) . "%' AND published=1");
				$cache[$v] = (int) $db->loadResult();
			}
		}
		return $cache[$v];
	}
}

class JCommentsPluginLoader
{
	/**
	 * @deprecated As of version 2.0
	 * @see  JCommentsObjectHelper::getTitle()
	 */
	function getObjectTitle( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::getTitle($object_id, $object_group);
	}
	
	/**
	 * @deprecated As of version 2.0
	 * @see  JCommentsObjectHelper::getLink()
	 */
	function getObjectLink( $object_id, $object_group = 'com_content')
	{
		return JCommentsObjectHelper::getLink($object_id, $object_group);
	}

	/**
	 * @deprecated As of version 2.0
	 * @see  JCommentsObjectHelper::getOwner()
	 */
	function getObjectOwner( $object_id, $object_group = 'com_content' )
	{
		return JCommentsObjectHelper::getOwner($object_id, $object_group);
	}
}

class JCommentsText
{
	function formatDate( $date = 'now', $format = null, $offset = null )
	{
		if ($format == 'DATETIME_FORMAT') {
			$format = null;
		}

		if (JCOMMENTS_JVERSION == '1.5') {
			if (empty($format)) {
				$format = JText::_('DATE_FORMAT_LC1');
			}
			return JHTML::_('date', $date, $format, $offset);
		}

		if (!is_string($date)) {
			$date = strftime($format, (int) $date);
		}

		return mosFormatDate($date, $format, $offset);
	}

	/**
	 * Replaces newlines with HTML line breaks
	 * @static
	 * @param  $text string The input string.
	 * @return string Returns the altered string.
	 */
	function nl2br( $text )
	{
		$text = preg_replace(array('/\r/', '/^\n+/', '/\n+$/'), '', $text);
		$text = str_replace("\n", '<br />', $text);
		return $text;
	}

	/**
	 * Replaces HTML line breaks with newlines
	 * @static
	 * @param  $text string The input string.
	 * @return string Returns the altered string. 
	 */
	function br2nl( $text )
	{
		return str_replace('<br />', "\n", $text);
	}

	/**
	 * Escapes input string with slashes to use it in JavaScript
	 * @static
	 * @param  $text string The input string.
	 * @return string Returns the altered string.
	 */
	function jsEscape( $text )
	{
		return addcslashes($text, "\\\\&\"\n\r<>'");
	}

	/**
	 * Inserts a separator in a very long continuous sequences of characters
	 * @static
	 * @param  $text string The input string.
	 * @param  $maxLength int The maximum length of sequence.
	 * @param  $customBreaker string The custom string to be used as breaker.
	 * @return string Returns the altered string.
	 */
	function fixLongWords( $text, $maxLength, $customBreaker = '')
	{
		$maxLength = (int) min(65535, $maxLength);

		if ($maxLength > 5) {
			ob_start();
			if ($customBreaker == '') {
				if (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
					$breaker = '<span style="margin: 0 -0.65ex 0 -1px;padding:0;"> </span>';
				} else {
					$breaker = '<span style="font-size:0;padding:0;margin:0;"> </span>';
				}
			} else {
				$breaker = $customBreaker;
			}

			$plainText = $text;
			$plainText = preg_replace('#<img[^\>]+/>#isU', '', $plainText);
			$plainText = preg_replace('#<a.*?>(.*?)</a>#isU', '', $plainText);
			$plainText = preg_replace('#<object.*?>(.*?)</object>#isU', '', $plainText);
			$plainText = preg_replace('#<code.*?>(.*?)</code>#isU', '', $plainText);
			$plainText = preg_replace('#<embed.*?>(.*?)</embed>#isU', '', $plainText);
			$plainText = preg_replace('#(^|\s|\>|\()((http://|https://|news://|ftp://|www.)\w+[^\s\[\]\<\>\"\'\)]+)#i', '', $plainText);

			$matches = array();
			$matchCount = preg_match_all('#([^\s<>\'\"/\.\x133\x151\\-\?&%=\n\r\%]{'.$maxLength.'})#i' . JCOMMENTS_PCRE_UTF8, $plainText, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$text = preg_replace("#(".preg_quote($matches[1][$i], '#').")#i" . JCOMMENTS_PCRE_UTF8, "\\1".$breaker, $text);
			}
			$text = preg_replace('#('.preg_quote($breaker, '#').'\s)#i' . JCOMMENTS_PCRE_UTF8, " ", $text);
			unset($matches);
			ob_end_clean();
		}
		return $text;
	}

	function countLinks( $text )
	{
		$matches = array();
		return preg_match_all(_JC_REGEXP_LINK, $text, $matches);
	}

	function clearLinks( $text )
	{
		return preg_replace(_JC_REGEXP_LINK, '', $text);
	}

	function url($s)
	{
		if (isset($s) && preg_match('/^((http|https|ftp):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}((:[0-9]{1,5})?\/.*)?$/i' , $s)) {
			$url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:]|i', '', $s);
			$url = str_replace(';//', '://', $url);
			if ($url != '') {
				$url = (!strstr($url, '://')) ? 'http://'.$url : $url;
				$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);
				return $url;
			}
		}
		return '';
	}

	function censor( $text )
	{
		ob_start();
		
		$config = & JCommentsFactory::getConfig();
		$badWords = $config->get('badwords');
		$replaceWord = $config->get('censor_replace_word', '***');
		
		if (!empty($badWords)) {
			for ($i = 0, $n = count($badWords); $i < $n; $i++) {
				$word = trim($badWords[$i]);
				if ($word != '') {
					$word = str_replace('#', '\#', str_replace('\#', '#', $word));
					$txt = trim(preg_replace('#'. $word.'#ism'. JCOMMENTS_PCRE_UTF8, $replaceWord, $text));
					// make safe from dummy bad words list
					if ($txt != '') {
						$text = $txt;
					}
				}
			}
		}
		ob_end_clean();
		return $text;
	}

	/**
	 * Cleans text of all formatting and scripting code
	 * @static
	 * @param  $text string The input string.
	 * @return string Returns the altered string.
	 */
	function cleanText( $text )
	{
		$bbcode = & JCommentsFactory::getBBCode();
		$config = & JCommentsFactory::getConfig();
		
		$text = $bbcode->filter($text, true);

		if ($config->getInt('enable_custom_bbcode')) {
			$customBBCode = & JCommentsFactory::getCustomBBCode();
			$text = $customBBCode->filter($text, true);
		}

		$text = str_replace('<br />', ' ', $text);
		$text = preg_replace('#(\s){2,}#ism' . JCOMMENTS_PCRE_UTF8, '\\1', $text);
		$text = preg_replace('#<script[^>]*>.*?</script>#ism' . JCOMMENTS_PCRE_UTF8, '', $text);
		$text = preg_replace('#<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>#ism' . JCOMMENTS_PCRE_UTF8, '\2 (\1)', $text);
		$text = preg_replace('#<!--.+?-->#ism' . JCOMMENTS_PCRE_UTF8, '', $text);
		$text = preg_replace('#&nbsp;#ism' . JCOMMENTS_PCRE_UTF8, ' ', $text);
		$text = preg_replace('#&amp;#ism' . JCOMMENTS_PCRE_UTF8, ' ', $text);
		$text = preg_replace('#&quot;#ism' . JCOMMENTS_PCRE_UTF8, ' ', $text);
		$text = strip_tags($text);
		$text = htmlspecialchars($text);
		$text = html_entity_decode($text);
		//$text = html_entity_decode($text, ENT_COMPAT, JCOMMENTS_ENCODING);
		
		return $text;
	}

	function strlen( $str )
	{
		if (JCOMMENTS_ENCODING != 'utf-8') {
			return strlen($str);
		} else {
			return strlen(utf8_decode($str));
		}
	}

	function substr( $text, $length = 0 )
	{
		if (class_exists('JString')) {
			if ($length && JString::strlen($text) > $length) {
				$text = JString::substr($text, 0, $length) . '...';
			}
		} else {
			if ($length && strlen($text) > $length) {
				$text = substr($text, 0, $length) . '...';
			}
		}
		
		return $text;		
	}

	function isUTF8( $v )
	{
		for ($i = 0; $i < strlen($v); $i++) {
			if (ord($v[$i]) < 0x80) {
				$n = 0;
			} elseif ((ord($v[$i]) & 0xE0) == 0xC0) {
				$n = 1;
			} elseif ((ord($v[$i]) & 0xF0) == 0xE0) {
				$n = 2;
			} elseif ((ord($v[$i]) & 0xF0) == 0xF0) {
				$n = 3;
			} else {
				return false;
			}				
			
			for ($j = 0; $j < $n; $j++) {
				if ((++$i == strlen($v)) || ((ord($v[$i]) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
}

class JCommentsBBCode
{
	var $_codes	= array();

	function JCommentsBBCode()
	{
		ob_start();
		$this->registerCode('b');
		$this->registerCode('i');
		$this->registerCode('u');
		$this->registerCode('s');
		$this->registerCode('url');
		$this->registerCode('img');
		$this->registerCode('list');
		$this->registerCode('hide');
		$this->registerCode('quote');
		$this->registerCode('code');
		ob_end_clean();
	}

	function registerCode($str)
	{
		$acl = & JCommentsFactory::getACL();
		$this->_codes[$str] = $acl->check('enable_bbcode_'.$str);
	}

	function getCodes()
	{
		return array_keys( $this->_codes );
	}

	function enabled()
	{
		static $enabled = null;

		if ($enabled == null) {
			foreach($this->_codes as $code=>$_enabled) {
				if ($_enabled == 1 && $code != 'quote') {
					$enabled = $_enabled;
					break;
				}
			}
		}
		return $enabled;
	}

	function canUse($str)
	{
		return $this->_codes[$str] ? 1 : 0;
	}

	function filter($str, $forceStrip = false)
	{
		global $my;

		ob_start();
		$patterns = array();
		$replacements = array();

		// disabled BBCodes
		$patterns[] = '/\[email\](.*?)\[\/email\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = ' \\1';
		$patterns[] = '/\[sup\](.*?)\[\/sup\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = ' \\1';
		$patterns[] = '/\[sub\](.*?)\[\/sub\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = ' \\1';

		//empty tags
		foreach($this->_codes as $code=>$enabled) {
			$patterns[] = '/\['.$code.'\]\[\/'.$code.'\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '';
		}
		// B
		if (($this->canUse('b') == 0) || ($forceStrip)) {
			$patterns[] = '/\[b\](.*?)\[\/b\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
		}

		// I
		if (($this->canUse('i') == 0) || ($forceStrip)) {
			$patterns[] = '/\[i\](.*?)\[\/i\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
		}

		// U
		if (($this->canUse('u') == 0) || ($forceStrip)) {
			$patterns[] = '/\[u\](.*?)\[\/u\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
		}

		// S
		if (($this->canUse('s') == 0) || ($forceStrip)) {
			$patterns[] = '/\[s\](.*?)\[\/s\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
		}

		// URL
		if (($this->canUse('url') == 0) || ($forceStrip)) {
			$patterns[] = '/\[url\](.*?)\[\/url\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
//			$patterns[] = '/\[url=([^\s<\"\'\]]*?)\]([^\[]*?)\[\/url\]/iU' . JCOMMENTS_PCRE_UTF8;
			$patterns[] = '/\[url=([^\s<\"\'\]]*?)\](.*?)\[\/url\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\2: \\1';
		}

		// IMG
		if (($this->canUse('img') == 0) || ($forceStrip)) {
			$patterns[] = '/\[img\](.*?)\[\/img\]/i' . JCOMMENTS_PCRE_UTF8;
			$replacements[] = '\\1';
		}

		// HIDE
		if (($this->canUse('hide') == 0) || ($forceStrip)) {
			$patterns[] = '/\[hide\](.*?)\[\/hide\]/i' . JCOMMENTS_PCRE_UTF8;
			if ($my->id) {
				$replacements[] = '\\1';
			} else {
				$replacements[] = '';
			}
		}

		// CODE
		if ($forceStrip) {
			$codePattern = '#\[code\=?([a-z0-9]*?)\](.*?)\[\/code\]#ism' . JCOMMENTS_PCRE_UTF8;
			$patterns[] = $codePattern;
			$replacements[] = '\\2';
		}

		$str = preg_replace($patterns, $replacements, $str);

		// LIST
		if (($this->canUse('list') == 0) || ($forceStrip)) {
			$matches = array();
			$matchCount = preg_match_all('/\[list\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]/is' . JCOMMENTS_PCRE_UTF8, $str, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$textBefore = preg_quote($matches[2][$i]);
				$textAfter = preg_replace('#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is' . JCOMMENTS_PCRE_UTF8, "<br />", $matches[2][$i]);
				$textAfter = preg_replace('#^<br />#is' . JCOMMENTS_PCRE_UTF8, '', $textAfter);
				$textAfter = preg_replace('#(<br\s?\/?\>)+#is' . JCOMMENTS_PCRE_UTF8, '<br />', $textAfter);
				$str = preg_replace('#\[list\](<br\s?\/?\>)*' . $textBefore . '(<br\s?\/?\>)*\[/list\]#is' . JCOMMENTS_PCRE_UTF8, "\n$textAfter\n", $str);
			}
			$matches = array();
			$matchCount = preg_match_all('#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]#is' . JCOMMENTS_PCRE_UTF8, $str, $matches);
			for ($i = 0; $i < $matchCount; $i++) {
				$textBefore = preg_quote($matches[3][$i]);
				$textAfter = preg_replace('#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is' . JCOMMENTS_PCRE_UTF8, '<br />', $matches[3][$i]);
				$textAfter = preg_replace('#^<br />#' . JCOMMENTS_PCRE_UTF8, "", $textAfter);
				$textAfter = preg_replace('#(<br\s?\/?\>)+#' . JCOMMENTS_PCRE_UTF8, '<br />', $textAfter);
				$str = preg_replace('#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*' . $textBefore . '(<br\s?\/?\>)*\[/list\]#is' . JCOMMENTS_PCRE_UTF8, "\n$textAfter\n", $str);
			}
		}

		if ($forceStrip) {
			// QUOTE
			$quotePattern = '#\[quote\s?name=\"([^\"\'\<\>\(\)]+)+\"\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/quote\]#iU' . JCOMMENTS_PCRE_UTF8;
			$quoteReplace = ' ';
			while(preg_match($quotePattern, $str)) {
				$str = preg_replace($quotePattern, $quoteReplace, $str);
			}
			$quotePattern = '#\[quote[^\]]*?\](<br\s?\/?\>)*([^\[]+)(<br\s?\/?\>)*\[\/quote\]#iU' . JCOMMENTS_PCRE_UTF8;
			$quoteReplace = ' ';
			while(preg_match($quotePattern, $str)) {
				$str = preg_replace($quotePattern, $quoteReplace, $str);
			}

			$str = preg_replace('#\[\/?(b|i|u|s|sup|sub|url|img|list|quote|code|hide)\]#is' . JCOMMENTS_PCRE_UTF8, '', $str);
		}

		$str = trim(preg_replace('#( ){2,}#i' . JCOMMENTS_PCRE_UTF8, '\\1', $str));

		ob_end_clean();
		return $str;
	}


	function replace($str) {
		global $my;

		ob_start();
		
		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();

		$patterns = array();
		$replacements = array();

		// B
		$patterns[] = '/\[b\](.*?)\[\/b\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<b>\\1</b>';

		// I
		$patterns[] = '/\[i\](.*?)\[\/i\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<i>\\1</i>';

		// U
		$patterns[] = '/\[u\](.*?)\[\/u\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<u>\\1</u>';

		// S
		$patterns[] = '/\[s\](.*?)\[\/s\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<strike>\\1</strike>';

		// SUP
		$patterns[] = '/\[sup\](.*?)\[\/sup\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<sup>\\1</sup>';

		// SUB
		$patterns[] = '/\[sub\](.*?)\[\/sub\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<sub>\\1</sub>';

		// URL (local)
		global $mainframe;
		$liveSite = $mainframe->getCfg( 'live_site' );

		$patterns[] = '#\[url\]('.preg_quote($liveSite, '#').'[^\s<\"\']*?)\[\/url\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="\\1" target="_blank">\\1</a>';

		$patterns[] = '#\[url=('.preg_quote($liveSite, '#').'[^\s<\"\'\]]*?)\](.*?)\[\/url\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="\\1" target="_blank">\\2</a>';

		$patterns[] = '/\[url=(\#|\/)([^\s<\"\'\]]*?)\](.*?)\[\/url\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="\\1\\2" target="_blank">\\3</a>';

		// URL (external)
		$patterns[] = '#\[url\](http:\/\/)?([^\s<\"\']*?)\[\/url\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="http://\\2" rel="external nofollow" target="_blank">\\2</a>';

		$patterns[] = '/\[url=([a-z]*\:\/\/)([^\s<\"\'\]]*?)\](.*?)\[\/url\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="\\1\\2" rel="external nofollow" target="_blank">\\3</a>';

		$patterns[] = '/\[url=([^\s<\"\'\]]*?)\](.*?)\[\/url\]/i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<a href="http://\\1" rel="external nofollow" target="_blank">\\2</a>';

		$patterns[] = '#\[url\](.*?)\[\/url\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '\\1';

		// EMAIL
		$patterns[] = '#\[email\]([^\s\<\>\(\)\"\'\[\]]*?)\[\/email\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '\\1';

		// IMG
		$patterns[] = '#\[img\](http:\/\/)?([^\s\<\>\(\)\"\']*?)\[\/img\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '<img class="img" src="http://\\2" alt="" border="0" />';

		$patterns[] = '#\[img\](.*?)\[\/img\]#i' . JCOMMENTS_PCRE_UTF8;
		$replacements[] = '\\1';

		// HIDE
		$patterns[] = '/\[hide\](.*?)\[\/hide\]/i' . JCOMMENTS_PCRE_UTF8;
		if ($my->id) {
			$replacements[] = '\\1';
		} else {
			$replacements[] = '<span class="hidden">'.JText::_('HIDDEN_TEXT').'</span>';
		}

		// CODE
		$geshiEnabled = $config->getInt('enable_geshi', 0);
		$codePattern = '#\[code\=?([a-z0-9]*?)\](.*?)\[\/code\]#ism' . JCOMMENTS_PCRE_UTF8;

		if ($geshiEnabled) {
			if (JCOMMENTS_JVERSION == '1.0') {
				global $mainframe;
				include_once($mainframe->getCfg('absolute_path').DS.'mambots'.DS.'content'.DS.'geshi'.DS.'geshi.php');
			} else if (JCOMMENTS_JVERSION=='1.5') {
				jimport('geshi.geshi');
			}

			if (!function_exists('jcommentsProcessGeSHi')) {
				function jcommentsProcessGeSHi($matches) {
					$lang = $matches[1] != '' ? $matches[1] : 'php';
					$text = $matches[2];
					$html_entities_match = array('#\<br \/\>#', "#<#", "#>#", "|&#39;|", '#&quot;#', '#&nbsp;#');
					$html_entities_replace = array("\n", '&lt;', '&gt;', "'", '"', ' ');
					$text = preg_replace($html_entities_match, $html_entities_replace, $text);
					$text = preg_replace('#(\r|\n)*?$#ism', '', $text);
					$text = str_replace('&lt;', '<', $text);
					$text = str_replace('&gt;', '>', $text);
					$geshi = new GeSHi( $text, $lang );
					$text = $geshi->parse_code();
					return '[code]'.$text.'[/code]';
				}
			}

			$patterns[] = $codePattern;
			$replacements[] = '<span class="code">'.JText::_('CODE').'</span>\\2';
			$str = preg_replace_callback($codePattern, 'jcommentsProcessGeSHi', $str);

		} else {
			$patterns[] = $codePattern;
			$replacements[] = '<span class="code">'.JText::_('CODE').'</span><code>\\2</code>';

			if (!function_exists('jcommentsProcessCode')) {
				function jcommentsProcessCode($matches) {
					return (htmlspecialchars(trim($matches[0])));
				}
			}

			$str = preg_replace_callback($codePattern, 'jcommentsProcessCode', $str);
		}

		$str = preg_replace($patterns, $replacements, $str);

		// QUOTE
		$quotePattern = '#\[quote\s?name=\"([^\"\'\<\>\(\)]+)+\"\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/quote\]#i' . JCOMMENTS_PCRE_UTF8;
		$quoteReplace = '<span class="quote">'.JText::sprintf('Quoting', '\\1').'</span><blockquote>\\3</blockquote>';
		while(preg_match($quotePattern, $str)) {
			$str = preg_replace($quotePattern, $quoteReplace, $str);
		}
		$quotePattern = '#\[quote[^\]]*?\](<br\s?\/?\>)*([^\[]+)(<br\s?\/?\>)*\[\/quote\]#i' . JCOMMENTS_PCRE_UTF8;
		$quoteReplace = '<span class="quote">'.JText::_('QUOTE_SINGLE').'</span><blockquote>\\2</blockquote>';
		while(preg_match($quotePattern, $str)) {
			$str = preg_replace($quotePattern, $quoteReplace, $str);
		}

		// LIST
		$matches = array();
		$matchCount = preg_match_all('#\[list\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]#is' . JCOMMENTS_PCRE_UTF8, $str, $matches);
		for ($i = 0; $i < $matchCount; $i++) {
			$textBefore = preg_quote($matches[2][$i]);
			$textAfter = preg_replace('#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is' . JCOMMENTS_PCRE_UTF8, "</li><li>", $matches[2][$i]);
			$textAfter = preg_replace("#^</?li>#" . JCOMMENTS_PCRE_UTF8, "", $textAfter);
			$textAfter = str_replace("\n</li>", "</li>", $textAfter."</li>");
			$str = preg_replace('#\[list\](<br\s?\/?\>)*' . $textBefore . '(<br\s?\/?\>)*\[/list\]#is' . JCOMMENTS_PCRE_UTF8, "<ul>$textAfter</ul>", $str);
		}
		$matches = array();
		$matchCount = preg_match_all('#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*(.*?)(<br\s?\/?\>)*\[\/list\]#is' . JCOMMENTS_PCRE_UTF8, $str, $matches);
		for ($i = 0; $i < $matchCount; $i++) {
			$textBefore = preg_quote($matches[3][$i]);
			$textAfter = preg_replace('#(<br\s?\/?\>)*\[\*\](<br\s?\/?\>)*#is' . JCOMMENTS_PCRE_UTF8, "</li><li>", $matches[3][$i]);
			$textAfter = preg_replace("#^</?li>#" . JCOMMENTS_PCRE_UTF8, '', $textAfter);
			$textAfter = str_replace("\n</li>", "</li>", $textAfter."</li>");
			$str = preg_replace('#\[list=(a|A|i|I|1)\](<br\s?\/?\>)*' . $textBefore . '(<br\s?\/?\>)*\[/list\]#is' . JCOMMENTS_PCRE_UTF8, "<ol type=\\1>$textAfter</ol>", $str);
		}

		$str = preg_replace('#\[\/?(b|i|u|s|sup|sub|url|img|list|quote|code|hide)\]#' . JCOMMENTS_PCRE_UTF8, '', $str);
		unset($matches);
		ob_end_clean();
		return $str;
	}

	function removeQuotes( $text )
	{
		$text = preg_replace(array('#\n?\[quote.*?\].+?\[/quote\]\n?#isU' . JCOMMENTS_PCRE_UTF8, '#\[/quote\]#'), '', $text);
		$text = preg_replace('#<br />+#is', '', $text);
		return $text;
	}

	function removeHidden( $text )
	{
		$text = preg_replace('#\[hide\](.*?)\[\/hide\]#is' . JCOMMENTS_PCRE_UTF8, '', $text);
		$text = preg_replace('#<br />+#is', '', $text);
		return $text;
	}
}

class JCommentsCustomBBCode
{
        var $codes = array();
        var $patterns = array();
        var $filter_patterns = array();
        var $html_replacements = array();
        var $text_replacement = array();

	function JCommentsCustomBBCode()
	{
	        global $mainframe;

		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT * FROM #__jcomments_custom_bbcodes WHERE published = 1 ORDER BY ordering');
		$codes = $db->loadObjectList();

		$this->patterns = array();
		$this->html_replacements = array();
		$this->text_replacements = array();
		$this->codes = array();

		foreach($codes as $code) {
			
			if (JCOMMENTS_PCRE_UTF8 == 'u') {
				// fix \w pattern issue for UTF-8 encoding
				// details: http://www.phpwact.org/php/i18n/utf-8#w_w_b_b_meta_characters
				$code->pattern = preg_replace('#(\\\w)#u', '\p{L}', $code->pattern);
			}

		        // check button permission
			if (JCommentsBaseACL::check($code->button_acl)) {
		                if ($code->button_image != '') {
		                	if (strpos($code->button_image, $mainframe->getCfg('live_site')) === false) {
						$code->button_image = $mainframe->getCfg('live_site') . ($code->button_image[0] == '/' ? '' : '/') . $code->button_image;
		                	}
		                }
				$this->codes[] = $code;
			} else {
				$this->filter_patterns[] = '#' . $code->pattern . '#ism' . JCOMMENTS_PCRE_UTF8;
			}
				
			$this->patterns[] = '#' . $code->pattern . '#ism' . JCOMMENTS_PCRE_UTF8;
			$this->html_replacements[] = $code->replacement_html;
			$this->text_replacements[] = $code->replacement_text;
		}
	}

	function enabled()
	{
		return 1;
		//return count($this->codes) > 0;
	}

	function filter($str, $forceStrip = false)
	{
		if (count($this->filter_patterns)) {
			ob_start();
			$filter_replacement = $this->text_replacements;
			$str = preg_replace($this->filter_patterns, $filter_replacement, $str);
			ob_end_clean();
		}
		if ($forceStrip === true)  {
			ob_start();
			$str = preg_replace($this->patterns, $this->text_replacements, $str);
			ob_end_clean();
		}
		return $str;
	}

	function replace($str, $textReplacement = false)
	{
		if (count($this->patterns)) {
			ob_start();
			$str = preg_replace($this->patterns, ($textReplacement ? $this->text_replacements : $this->html_replacements), $str);
			ob_end_clean();
		}
		return $str;
	}
}

class JCommentsSecurity
{
	function notAuth()
	{
		header('HTTP/1.0 403 Forbidden');
		echo _NOT_AUTH;
		exit;
	}

	function badRequest()
	{
		if ((empty($_SERVER['HTTP_USER_AGENT']))
		|| (!$_SERVER['REQUEST_METHOD']=='POST')) {
			return 1;
		}
		return 0;
	}

	function checkFlood( $ip )
	{
		global $mainframe;

		$config = JCommentsFactory::getConfig();
		
		$floodInterval = $config->getInt('flood_time');

		if ($floodInterval > 0) {
			$db = & JCommentsFactory::getDBO();

			if (JCOMMENTS_JVERSION == '1.5') {
				$dateNow =& JFactory::getDate();
				$comment_date = $dateNow->toMySQL();
			} else {
				$comment_date = date('Y-m-d H:i:s', time() + $mainframe->getCfg('offset') * 60 * 60);
			}

			$query = "SELECT COUNT(*) "
				. "\nFROM #__jcomments "
				. "\nWHERE ip = '$ip' "
				. "\nAND '".$comment_date."' < DATE_ADD(date, INTERVAL " . $floodInterval . " SECOND)"
				. (($mainframe->getCfg('multilingual_support') == 1) ? "\nAND lang = '" . $mainframe->getCfg('lang') . "'" : "")
				;

			$db->setQuery($query);

			return ($db->loadResult() == 0) ? 0 : 1;
		}
		return 0;
	}

	function checkIsForbiddenUsername($str)
	{
		$config = & JCommentsFactory::getConfig();
		$names = $config->get('forbidden_names');

		if (!empty($names) && !empty($str) ) {
			$str = trim(strtolower($str));
			$forbidden_names = split(',', strtolower($names));
			foreach ($forbidden_names as $name) {
				if (trim((string) $name) == $str) {
					return 1;
				}
			}
			unset($forbidden_names);
		}
		return 0;
	}

	function checkIsRegisteredUsername($str)
	{
		$config = & JCommentsFactory::getConfig();
		
		if ($config->getInt('enable_username_check') == 1) {
			$db = & JCommentsFactory::getDBO();
			$str = $db->getEscaped($str);
			$db->setQuery("SELECT COUNT(*) FROM #__users WHERE name = '$str' OR username = '$str'");
			return ($db->loadResult() == 0) ? 0 : 1;
		}
		return 0;
	}

	function checkIsRegisteredEmail($str)
	{
		$config = & JCommentsFactory::getConfig();
		
		if ($config->getInt('enable_username_check') == 1) {
			$db = & JCommentsFactory::getDBO();
			$str = $db->getEscaped($str);
			$db->setQuery("SELECT COUNT(*) FROM #__users WHERE email = '$str'");
			return ($db->loadResult() == 0) ? 0 : 1;
		}
		return 0;
	}


	function fixAJAX($link) 
	{
		// fix to prevent cross-domain ajax call
		if (isset($_SERVER['HTTP_HOST'])) {
			$httpHost = (string) $_SERVER['HTTP_HOST'];
			if (strpos($httpHost, '://www.') !== false && strpos($link, '://www.') === false) {
				$link = str_replace('://', '://www.', $link);
			} else if (strpos($httpHost, '://www.') === false && strpos($link, '://www.') !== false) {
				$link = str_replace('://www.', '://', $link);
			}
		}
		return $link;
	}

}

/**
 * JComments Factory class
 * @static
 * @access public
 */
class JCommentsFactory
{
	/**
	 * Returns a reference to the global {@link JCommentsSmiles} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @static
	 * @access public
	 * @return JCommentsSmiles
	 */
	function &getSmiles()
	{
		static $instance = null;
		
		if (!is_object($instance)) {
			$instance = new JCommentsSmiles();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JUser} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @static
	 * @access public
	 * @return JUser
	 */
	function &getUser( $id = null )
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			if (!is_null($id)) {
				global $database;
				$user = new mosUser($database);
				$user->load($id);
			} else {
				global $mainframe;
				$user = $mainframe->getUser();
			}
		} else 
			if (JCOMMENTS_JVERSION == '1.5') {
				$user = & JFactory::getUser($id);
			}
		return $user;
	}

	/**
	 * Returns a reference to the global {@link JCommentsBBCode} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @static
	 * @access public
	 * @return JCommentsBBCode
	 */
	function &getBBCode()
	{
		static $instance = null;
		
		if (!is_object($instance)) {
			$instance = new JCommentsBBCode();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JCommentsCustomBBCode} object,
	 * only creating it if it doesn't already exist.
	 *
	 * @static
	 * @access public
	 * @return JCommentsCustomBBCode
	 */
	function &getCustomBBCode()
	{
		static $instance = null;
		
		if (!is_object($instance)) {
			$instance = new JCommentsCustomBBCode();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JCommentsCfg} object, 
	 * only creating it if it doesn't already exist.
	 *
	 * @static
	 * @access public
	 * @param $language string Language
	 * @return JCommentsCfg
	 */
	function &getConfig($language='')
	{
		return JCommentsCfg::getInstance($language);
	}
	
	/**
	 * Returns a reference to the global {@link JoomlaTuneTemplateRender} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @static
	 * @access public
	 * @return JoomlaTuneTemplateRender
	 */
	function &getTemplate( $object_id = 0, $object_group = 'com_content', $needThisUrl = true )
	{
		global $Itemid, $mainframe;

		ob_start();
		
		$config = & JCommentsFactory::getConfig();

		$templateName = $config->get('template'); 
		
		if (empty($templateName)) {
			$templateName = 'default';
			$config->set('template', $templateName);
		}

		include_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'template.php');

		$loadFromDefaultLocation = true;

		$templateDefaultDirectory = JCOMMENTS_BASE.DS.'tpl'.DS.$templateName;

		if (JCOMMENTS_JVERSION == '1.5') {
			$templateDirectory =  JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jcomments'.DS.$templateName;
			$templateUrl =  JURI::root() . 'templates/' . $mainframe->getTemplate() . '/html/com_jcomments/' . $templateName;

			$loadFromDefaultLocation = !is_dir($templateDirectory);
		}

		if ($loadFromDefaultLocation) {
			$templateDirectory = JCOMMENTS_BASE.DS.'tpl'.DS.$templateName;
			$templateUrl = $mainframe->getCfg('live_site') . '/components/com_jcomments/tpl/' . $templateName;
		}

		/**
		 * $tmpl JoomlaTuneTemplateRender
		 */
		$tmpl =& JoomlaTuneTemplateRender::getInstance();
		$tmpl->setRoot($templateDirectory);
		$tmpl->setDefaultRoot($templateDefaultDirectory);
		$tmpl->setBaseURI($templateUrl);
		$tmpl->addGlobalVar('siteurl', $mainframe->getCfg('live_site'));
		$tmpl->addGlobalVar('charset', strtolower(preg_replace('/charset=/', '', _ISO)));
		$tmpl->addGlobalVar('ajaxurl', JCommentsFactory::getLink('ajax', $object_id, $object_group));
		$tmpl->addGlobalVar('smilesurl', JCommentsFactory::getLink('smiles', $object_id, $object_group));
		$tmpl->addGlobalVar('rssurl', JCommentsFactory::getLink('rss', $object_id, $object_group));
		$tmpl->addGlobalVar('template', $templateName);
		$tmpl->addGlobalVar('template_url', $templateUrl);
		$tmpl->addGlobalVar('itemid', $Itemid ? $Itemid : 1);


		if (JCOMMENTS_JVERSION == '1.5') {
			$language = & JFactory::getLanguage();
			$tmpl->addGlobalVar('direction', $language->isRTL() ? 'rtl' : 'ltr');
		} else {
			$tmpl->addGlobalVar('direction', 'ltr');
		}

		$lang = $mainframe->getCfg('lang');

		if ($lang == 'russian' || $lang == 'ukrainian' || $lang == 'belorussian' || $lang == 'ru-RU' || $lang == 'uk-UA' || $lang == 'be-BY') {
			$tmpl->addGlobalVar('support', base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5qb29tbGF0dW5lLnJ1IiB0aXRsZT0iSkNvbW1lbnRzIiB0YXJnZXQ9Il9ibGFuayI+SkNvbW1lbnRzPC9hPg=='));
		} else {
			$tmpl->addGlobalVar('support', base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5qb29tbGF0dW5lLmNvbSIgdGl0bGU9IkpDb21tZW50cyIgdGFyZ2V0PSJfYmxhbmsiPkpDb21tZW50czwvYT4='));
		}

		$tmpl->addGlobalVar('comment-object_id', $object_id);
		$tmpl->addGlobalVar('comment-object_group', $object_group);

		if ($needThisUrl == true) {
			$tmpl->addGlobalVar('thisurl', JCommentsObjectHelper::getLink($object_id, $object_group));
		}

		ob_end_clean();

		return $tmpl;
	}

	/**
	 * Returns a reference to the global {@link JCommentsACL} object, 
	 * only creating it if it doesn't already exist.
	 *
	 * @static
	 * @access public
	 * @return JCommentsACL
	 */
	function &getACL()
	{
		static $instance = null;

		if (!is_object( $instance )) {
			$instance = new JCommentsACL();
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JDatabase} object
	 *
	 * @static
	 * @access public
	 * @return JDatabase
	 */
	function &getDBO()
	{
		static $instance = null;
		
		if (!is_object($instance)) {
			if (JCOMMENTS_JVERSION == '1.0') {
				global $database;
				$instance = $database;
			} elseif (JCOMMENTS_JVERSION == '1.5') {
				$instance = & JFactory::getDBO();
			}
		}
		return $instance;
	}

	/**
	 * Returns a reference to the global {@link JoomlaTuneAjaxResponse} object, 
	 * only creating it if it doesn't already exist.
	 * 
	 * @static
	 * @access public 
	 * @return JoomlaTuneAjaxResponse
	 */
	function &getAjaxResponse()
	{
		static $instance = null;
		
		if (!is_object($instance)) {
			$instance = new JoomlaTuneAjaxResponse(JCOMMENTS_ENCODING);
		}
		return $instance;
	}

	function getCmdHash($cmd, $id)
	{
	        global $mainframe;
		return md5($cmd . $id . $mainframe->getCfg('absolute_path') . $mainframe->getCfg('secret'));
	}

	function getCmdLink($cmd, $id)
	{
	        global $mainframe;

		$hash = JCommentsFactory::getCmdHash($cmd, $id);
	        $liveSite = $mainframe->getCfg('live_site');

		if (JCOMMENTS_JVERSION == '1.5') {
			$liveSite = str_replace(JURI::root(true), '', $liveSite);
			$link = $liveSite . JRoute::_('index.php?option=com_jcomments&amp;task=cmd&amp;cmd=' . $cmd . '&amp;id=' . $id . '&amp;hash=' . $hash . '&amp;format=raw');
		} else {
			$link = $liveSite . '/index2.php?option=com_jcomments&amp;task=cmd&amp;cmd=' . $cmd . '&amp;id=' . $id . '&amp;hash=' . $hash . '&amp;no_html=1';
		}
		return $link;
	}

	function getUnsubscribeLink($hash)
	{
	        global $mainframe;

	        $liveSite = $mainframe->getCfg('live_site');

		if (JCOMMENTS_JVERSION == '1.5') {
			$liveSite = str_replace(JURI::root(true), '', $liveSite);
			$link = $liveSite . JRoute::_('index.php?option=com_jcomments&amp;task=unsubscribe&amp;hash='.$hash.'&amp;format=raw');
		} else {
			$link = $liveSite . '/index2.php?option=com_jcomments&amp;task=unsubscribe&amp;hash='.$hash.'&amp;no_html=1';
		}
		return $link;
	}

	function getLink($type = 'ajax', $object_id = 0, $object_group='')
	{
		global $mainframe, $iso_client_lang;

		switch($type)
		{
			case 'rss':
				if (JCOMMENTS_JVERSION == '1.5') {
					$link = 'index.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.'&amp;format=raw';
					if ($mainframe->isAdmin()) {
						$link = JURI::root(true).'/'.$link;
					} else {
						$link = JRoute::_($link);
					}
					return $link;
				}
				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.'&amp;no_html=1';
				break;

			case 'noavatar':
				return $mainframe->getCfg('live_site') . '/components/com_jcomments/images/no_avatar.png';
				break;

			case 'smiles':
				return $mainframe->getCfg('live_site') . '/components/com_jcomments/images/smiles';
				break;

			case 'captcha':
				mt_srand((double)microtime()*1000000);
				$random = mt_rand(10000, 99999);

				if (JCOMMENTS_JVERSION == '1.5') {
					return JURI::root(true) . '/index.php?option=com_jcomments&amp;task=captcha&amp;tmpl=component&amp;ac=' . $random;
				}
				return $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=captcha&amp;no_html=1&amp;ac=' . $random;
				break;

			case 'ajax':
				$config = & JCommentsFactory::getConfig();

				// support alternate language files
				$lsfx = ($config->get('lsfx') != '') ? ('&amp;lsfx='.$config->get('lsfx')) : '';

				// support additional param for multilingual sites
				$lang = ($mainframe->getCfg('multilingual_support') == 1) ? ('&amp;lang='.$iso_client_lang) : '';

				if (JCOMMENTS_JVERSION == '1.5') {
					$link = JURI::root(true) . '/index.php?option=com_jcomments&amp;tmpl=component' . $lang . $lsfx;
				} else {
					$_Itemid = '&amp;Itemid=' . ((!empty($_REQUEST['Itemid'])) ? $_REQUEST['Itemid'] : 1);
					$link = $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;no_html=1' . $lang . $lsfx . $_Itemid;
				}
				return JCommentsSecurity::fixAJAX($link);
				break;

			case 'ajax-backend':
				if (JCOMMENTS_JVERSION == '1.5') {
					$link = $mainframe->getCfg('live_site') . '/administrator/index.php?option=com_jcomments&amp;tmpl=component';
				} else {
					$link = $mainframe->getCfg('live_site') . '/administrator/index3.php?option=com_jcomments&amp;no_html=1';
				}
				return JCommentsSecurity::fixAJAX($link);
				break;

			default:
				return '';
				break;
		}
	}

	/**
	 * Convert relative link to absolute (add http:// and site url)
	 * 
	 * @access public 
	 * @param string $link The relative url. 
	 * @return string
	 */
	function getAbsLink($link)
	{
		global $mainframe;

		$url = '';

		if (JCOMMENTS_JVERSION == '1.5') {
			$uri = & JFactory::getURI();
			$url = $uri->toString(array('scheme' , 'user' , 'pass' , 'host' , 'port'));
		} else {
			$url = $mainframe->getCfg('live_site');
		}

		if (strpos($link, $url) === false) {
			if (JCOMMENTS_JVERSION == '1.5') {
				$link = $url . $link;
			} else {
				$link = $url . '/' . $link;
			}
		}
		return $link;
	}
}

class JCommentsCache
{
	/**
	 * @static 
	 * @param string $group
	 * @return A function cache object
	 */
	function getCache($group='')
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JFactory::getCache($group);
		}
		return mosCache::getCache($group);
	}

	/**
	 * Clean cache for a group
	 * @static 
	 * @access	public
	 * @param	string	$group	The cache data group
	 */
	function cleanCache( $group=false )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			$cache = & JFactory::getCache($group);
			$cache->clean($group);
		} else {
			mosCache::cleanCache($group);
		}
	}
}

/**
 * @static
 */
class JCommentsInput
{
	/**
	 * Deprecated, use JCommentsInput::get() instead.
	 * 
	 * @deprecated As of version 2.1.0.5
	 * @see  JCommentsInput::getVar()
	 */
	function getParam( &$arr, $name, $def=null, $mask=0 )
	{
        	return JCommentsInput::getVar($name, $def, 'default', 'none', $mask);
	}

	/**
	 * Fetches and returns a given variable.
	 *
	 * @static
	 * @access public 
	 * @param string $name Variable name
	 * @param mixed $default Default value if the variable does not exist
	 * @param string $hash Where the var should come from (POST, GET, FILES, COOKIE, METHOD)
	 * @param string $type Return type for the variable, for valid values see {@link JFilterInput::clean()}
	 * @param int $mask Filter mask for the variable
	 * @return mixed Requested variable
	 */
	function getVar( $name, $default = null, $hash = 'default', $type = 'none', $mask = 0 )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JRequest::getVar($name, $default, $hash, 'none', $mask);
		} else {
			switch ($hash) {
				case 'GET' :
					$input = $_GET;
					break;
				case 'POST' :
					$input = $_POST;
					break;
				case 'FILES' :
					$input = $_FILES;
					break;
				case 'COOKIE' :
					$input = $_COOKIE;
					break;
				case 'ENV'    :
					$input = &$_ENV;
					break;
				case 'SERVER'    :
					$input = &$_SERVER;
					break;
				default:
					$input = $_REQUEST;
					break;
			}
			return mosGetParam($input, $name, $default, $mask);
		}
	}
}

class JCommentsMail
{
	/**
 	 * Mail function (uses phpMailer)
 	 *
 	 * @param string $from From e-mail address
 	 * @param string $fromName From name
 	 * @param mixed $recipient Recipient e-mail address(es)
 	 * @param string $subject E-mail subject
 	 * @param string $body Message body
 	 * @param boolean $mode false = plain text, true = HTML
 	 * @param mixed $cc CC e-mail address(es)
 	 * @param mixed $bcc BCC e-mail address(es)
 	 * @param mixed $attachment Attachment file name(s)
 	 * @param mixed $replyTo Reply to email address(es)
 	 * @param mixed $replyToName Reply to name(s)
 	 * @return boolean True on success
  	 */
	function send($from, $fromName, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyTo=NULL, $replyToName=NULL )
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			return JUTility::sendMail($from, $fromName, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyTo, $replyToName );
		}
		return mosMail($from, $fromName, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyTo, $replyToName );
	}
}

function JCommentsRedirect( $url, $msg='' )
{
	if (JCOMMENTS_JVERSION == '1.5') {
		global $mainframe;
		if (strpos($url, 'index2.php') === 1) {
			$url = str_replace('index2.php', 'index.php', $url);
		}
		$mainframe->redirect($url, $msg);
	}
	mosRedirect($url, $msg);
}

class JCommentsMultilingual
{
	function isEnabled()
	{
		static $enabled = null;

		if (!isset($enabled)) {
			global $mainframe;
			$enabled = $mainframe->getCfg('multilingual_support') == 1;

			// check if multilingual_support
			if ($enabled) {
				$config = & JCommentsFactory::getConfig();
				$enabled = $config->get('multilingual_support', $enabled);
			}
		}
		return $enabled;
	}

	function getLanguage()
	{
		static $language = null;

		if (!isset($language)) {
			if (JCOMMENTS_JVERSION == '1.5') {
				$lang = & JFactory::getLanguage();
				$language = $lang->getTag();
			} else {
				global $mainframe;
				$language = $mainframe->getCfg('lang');
			}
		}
		return $language;
	}
}
?>