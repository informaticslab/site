<?php
/**
 * JComments - Joomla Comment System
 *
 * Migration wizard (import comments for 3d party extensions)
 *
 * @version 2.1
 * @package JComments
 * @subpackage Migration
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

class JCommentsImportedComment extends JCommentsDB
{
	/** @var int */
	var $source_id = null;

	function JCommentsImportedComment( &$db )
	{
		parent::JCommentsDB($db);
	}

	function store( $updateNulls=false )
	{
		if ($this->source != '') {
			if ($this->name == '') {
				$this->name = 'Guest';
			} else {
				$this->name = JCommentsMigrationTool::processName($this->name);
			}

			if ($this->username == '') {
				$this->username = $row->name;
			} else {
				$this->username = JCommentsMigrationTool::processName($this->username);
			}

			$this->email = strip_tags($this->email);
			$this->homepage = strip_tags($this->homepage);
			$this->title = strip_tags($this->title);
			$this->comment = JCommentsMigrationTool::processComment(stripslashes($this->comment));

			if (!isset($this->source_id)) {
				$this->source_id = 0;
			}
		}
		return parent::store($updateNulls);
	}
}

class JOtherCommentSystem
{
	var $code = null;
	var $name = null;
	var $author = null;
	var $license = null;
	var $license_url = null;
	var $homepage = null;
	var $table = null;
	var $found = false;
	var $count = 0;

	function JOtherCommentSystem( $code, $name, $author, $license, $license_url, $homepage, $table )
	{
		$this->code = $code;
		$this->name = $name;
		$this->author = $author;
		$this->homepage = $homepage;
		$this->license = $license;
		$this->license_url = $license_url;
		$this->table = $table;
	}

	function UpdateCount()
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery('SELECT COUNT(*) FROM ' . $this->table );
		$this->count = $db->loadResult();
	}
}


class yvCommentSystem extends JOtherCommentSystem
{
	function UpdateCount()
	{
		$this->count = $this->getCount();
	}

	function getCount()
	{
	        $yvHelper = JPATH_SITE.DS.'components'.DS.'com_yvcomment'.DS.'helpers.php';
	        if (is_file($yvHelper)) {
	        	require_once($yvHelper);
	        	$yvComment = &yvCommentHelper::getInstance();

	        	$where = array();

			if ($yvComment->UseDesignatedSectionForComments()) {
				$where[] = "(c.sectionid=" . $yvComment->getSectionForComments() . ")";
			} else {
				$where[] = '(c.parentid<>0)';    
			}

	        	$query = "SELECT count(*)"
				. "\nFROM " .  $yvComment->getTableName() . " AS c"
				. "\nLEFT JOIN #__content AS ar ON c.parentid=ar.id"
				. "\nWHERE " . implode(' AND ', $where)
				;

			$db = & JCommentsFactory::getDBO();
			$db->setQuery($query);
			return $db->loadResult();
	        }
	        return 0;
	}

	function getList()
	{
	        $yvHelper = JPATH_SITE.DS.'components'.DS.'com_yvcomment'.DS.'helpers.php';
	        if (is_file($yvHelper)) {
	        	require_once($yvHelper);
	        	$yvComment = &yvCommentHelper::getInstance();

	        	$where = array();

			if ($yvComment->UseDesignatedSectionForComments()) {
				$where[] = "(c.sectionid=" . $yvComment->getSectionForComments() . ")";
			} else {
				$where[] = '(c.parentid<>0)';    
			}

	        	$query = "SELECT c.*, u.email as email, u.name, u.username"
				. "\nFROM " .  $yvComment->getTableName() . " AS c"
				. "\nLEFT JOIN #__content AS ar ON c.parentid=ar.id"
				. "\nLEFT JOIN #__users AS u ON c.created_by = u.id"
				. "\nWHERE " . implode(' AND ', $where)
				;

			$db = & JCommentsFactory::getDBO();
			$db->setQuery($query);
			return $db->loadObjectList();
	        }
	        return array();
	}
}

class JCommentsMigrationTool
{
	function showImport()
	{
		HTML_JCommentsMigrationTool::showImport();
	}


	function doImport()
	{
		$vars = JCommentsInput::getVar('vars', array());
	        $source = trim(strtolower($vars['import']));
		$cnt = 0;

	        if ($source != '' && $source != 'com_jcomments') {

			JCommentsMigrationTool::deleteCommentsBySource($source);

			$language = JCommentsInput::getVar($source . '_lang', '');

			switch($source)
			{
				case 'akocomment':
					JCommentsMigrationTool::importAkoComment($source, $language);
					break;
				case 'moscom':
					JCommentsMigrationTool::importMosCom($source, $language);
					break;
				case 'combomax':
					JCommentsMigrationTool::importComboMax($source, $language);
					break;
				case 'joomlacomment':
					JCommentsMigrationTool::importJoomlaComment($source, $language);
					break;
				case 'jomcomment':
					JCommentsMigrationTool::importJomComment($source, $language);
					break;
				case 'urcomment':
					JCommentsMigrationTool::importUrComment($source, $language);
					break;
				case 'datsogallery':
					JCommentsMigrationTool::importDatsoGalleryComment($source, $language);
					break;
				case 'joomgallery':
					JCommentsMigrationTool::importJoomGalleryComment($source, $language);
					break;
				case 'icegallery':
					JCommentsMigrationTool::importIceGalleryComment($source, $language);
					break;
				case 'remository':
					JCommentsMigrationTool::importRemositoryComment($source, $language);
					break;
				case 'paxxgallery':
					JCommentsMigrationTool::importPAXXGalleryComment($source, $language);
					break;
				case 'phocagallery':
					JCommentsMigrationTool::importPhocaGalleryComment($source, $language);
					break;
				case 'cinema':
					JCommentsMigrationTool::importCinemaComment($source, $language);
					break;
				case 'jmovies':
					JCommentsMigrationTool::importJMoviesComment($source, $language);
					break;
				case 'mosetstree':
					JCommentsMigrationTool::importMosetsTree($source, $language);
					break;
				case 'linkdirectory':
					JCommentsMigrationTool::importLinkDirectory($source, $language);
					break;
				case 'mxcomment':
					JCommentsMigrationTool::importmXcomment($source, $language);
					break;
				case 'zoommediagallery':
					JCommentsMigrationTool::importZoom($source, $language);
					break;
				case 'rsgallery2':
					JCommentsMigrationTool::importRSGallery2($source, $language);
					break;
				case 'hotornot2':
					JCommentsMigrationTool::importHotOrNot2($source, $language);
					break;
				case 'easycomments':
					JCommentsMigrationTool::importEasyComments($source, $language);
					break;
				case 'musicbox':
					JCommentsMigrationTool::importMusicBox($source, $language);
					break;
				case 'jreviews':
					JCommentsMigrationTool::importJReviews($source, $language);
					break;
				case 'tutorials':
					JCommentsMigrationTool::importTutorialsComments($source, $language);
					break;
				case 'idoblog':
					JCommentsMigrationTool::importIDoBlogComments($source, $language);
					break;
				case 'sobi2reviews':
					JCommentsMigrationTool::importSobi2Reviews($source, $language);
					break;
				case 'jreactions':
					JCommentsMigrationTool::importJReactions($source, $language);
					break;
				case 'virtuemart':
					JCommentsMigrationTool::importVirtueMart($source, $language);
					break;
				case 'jxtendedcomments':
					JCommentsMigrationTool::importJXtendedComments($source, $language);
					break;
				case 'chronocomments':
					JCommentsMigrationTool::importChronoComments($source, $language);
					break;
				case 'akobook':
					JCommentsMigrationTool::importAkoBook($source, $language);
					break;
				case 'jambook':
					JCommentsMigrationTool::importJamBook($source, $language);
					break;
				case 'k2':
					JCommentsMigrationTool::importK2($source, $language);
					break;
				case 'smartblog':
					JCommentsMigrationTool::importSmartBlog($source, $language);
					break;
				case 'yvcomment':
					JCommentsMigrationTool::importYvComment($source, $language);
					break;
				case 'zimb':
					JCommentsMigrationTool::importZimbComment($source, $language);
					break;
				case 'rdbscomment':
					JCommentsMigrationTool::importRDBSComment($source, $language);
					break;
				case 'lyftenbloggie':
					JCommentsMigrationTool::importLyftenBloggie($source, $language);
					break;
				case 'webee':
					JCommentsMigrationTool::importWebeeComment($source, $language);
					break;
				case 'resource':
					JCommentsMigrationTool::importResourceComments($source, $language);
					break;
				case 'jacomment':
					JCommentsMigrationTool::importJAComment($source, $language);
					break;
				case 'tpdugg':
					JCommentsMigrationTool::importTPDuggComments($source, $language);
					break;
				case 'zoo':
					JCommentsMigrationTool::importZooComments($source, $language);
					break;
				case 'beeheard':
					JCommentsMigrationTool::importBeeHeardComments($source, $language);
					break;
				case 'jmylife':
					JCommentsMigrationTool::importJMyLifeComments($source, $language);
					break;
				case 'muscol':
					JCommentsMigrationTool::importMusicCollectionsComments($source, $language);
					break;
				case 'rscomments':
					JCommentsMigrationTool::importRSComments($source, $language);
					break;
			}
			$cnt = JCommentsMigrationTool::countCommentsBySource($source);
		}


		if ( $cnt > 0) {
			JCommentsMigrationTool::updateParent($source);
			$message = sprintf( JText::_('A_IMPORT_DONE'), $cnt);
		} else {
			$message = JText::_('A_IMPORT_FAILED');
		}

		return $message;
	}

	function processComment( $str ) {

		// change \n to <br />	
		$str = preg_replace( array( '/\r/', '/^\n+/', '/\n+$/' ), '', $str);
		$str = preg_replace('/\n/', '<br />', $str);

		// strip BBCode's
		$patterns = array( 
				  '/\[font=(.*?)\](.*?)\[\/font\]/i'
				, '/\[size=(.*?)\](.*?)\[\/size\]/i'
				, '/\[color=(.*?)\](.*?)\[\/color\]/i'
				, '/\[b\](null|)\[\/b\]/i'
				, '/\[i\](null|)\[\/i\]/i'
				, '/\[u\](null|)\[\/u\]/i'
				, '/\[s\](null|)\[\/s\]/i'
				, '/\[url=null\]null\[\/url\]/i'
				, '/\[img\](null|)\[\/img\]/i'
				, '/\[url=(.*?)\](.*?)\[\/url\]/i'
				, '/\[email](.*?)\[\/email\]/i'

				// JA Comment syntax
				, '/\[quote=\"?([^\:\]]+)(\:[0-9]+)?\"?\]/ism'
				, '/\[link=\"?([^\]]+)\"?\]/ism'
				, '/\[\/link\]/ism'
				, '/\[youtube ([^\s]+) youtube\]/ism'
				);

		$replacements = array( 
     				  '\\2'
    				, '\\2'
    				, '\\2'
	    			, ''
    				, ''
    				, ''
    				, ''
	    			, ''
    				, ''
    				, '\\2 ([url]\\1[/url])'
    				, '\\1'
    				, '[quote name="\\1"]'
    				, '[url=\\1]'
    				, '[/url]'
    				, '[youtube]\\1[/youtube]'
	    			);
		$str = preg_replace( $patterns, $replacements, $str);

		//convert smiles 
		$patterns = array( 
				  '/\:eek/i'
				, '/\:roll/i'
				, '/\:sigh/i'
				, '/\:grin/i'
				, '/\:p/i'
				, '/\:0\s/i'
				, '/\:cry/i'
				, '/\:\'\(/i'
				, '/\:upset/i'
				, '/\>\:\(/i'
				, '/\:\(/i'
				, '/\:\)/i'
				, '/\;\)/i'
				, '/\:x/i'
				, '/\:\?/i'
				, '/\;\?/i'
				, '/\:\-\\\\/i'
				, '/\;D/i'

				, '/\:angry\:/i'
				, '/\:angry-red\:/i'
				, '/\:sleep\:/i'
				
				);

		$replacements = array( 
     				  ':eek:'
	    			, ':roll:'
    				, ':sigh:'
    				, ':D'
    				, ':P'
				, ':o '
				, ':cry:'
				, ':cry:'
				, ''
				, ':sad:'
				, ':sad:'
				, ':-)'
				, ';-)'
				, ':-x'
				, ':-?'
				, ':-?'
				, ':sigh:'
				, ';-)'

				, ':sad:'
				, ':sad:'
				, ':zzz'

    				);

		$str = preg_replace( $patterns, $replacements, $str);

		return $str;
	}

	function processName( $str )
	{
		return preg_replace("/[\'\"\>\<\(\)\[\]]?+/i", '', $str );
	}

	function updateParent($source)
	{
		$db = & JCommentsFactory::getDBO();
		$query = "UPDATE `#__jcomments` c1, `#__jcomments` c2"
			. "\nSET c1.parent = c2.id"
			. "\nWHERE c1.id <> c2.id"
			. "\nAND c1.parent <> 0"
			. "\nAND c1.parent = c2.source_id"
			;
		$db->setQuery($query);
		$db->query();
	}

	function deleteCommentsBySource($source)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery("DELETE FROM #__jcomments WHERE source = '".$source."';");
		$db->query();
	}

	function countCommentsBySource($source)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery("SELECT COUNT(*) FROM `#__jcomments` WHERE source = '".$source."';");
		return $db->loadResult();
	}

	function importMosCom($source, $language) {

		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.id as userid"
			. "\n, u.email as user_email, u.name as user_name, u.username as user_username "
			. "\nFROM `#__content_comments` AS c"
			. "\nLEFT JOIN #__users AS u ON u.email=c.email AND u.name=c.name"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment( $db );

			$comment->object_id 	= $row->articleid;
			$comment->object_group 	= 'com_content';
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->homepage;
			$comment->comment	= $row->entry;
			$comment->published 	= $row->published;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", strtotime($row->date . ' ' . $row->time));
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importAkoComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__akocomment`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= 'com_content';
			$comment->userid	= isset($row->userid) ? $row->userid : (isset($row->iduser) ? $row->iduser : 0);
			$comment->name 		= $row->name;
			$comment->username 	= $comment->name;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->web;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJoomlaComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.email as user_email, u.name as user_name, u.username as user_username "
			. "\nFROM #__comment AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			if (isset($row->component)) {
				if (trim($row->component) == '') {
					$row->component = 'com_content';
				}
			} else {
				$row->component = 'com_content';
			}

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= $row->component;
			$comment->parent	= isset($row->parentid) ? $row->parentid : 0;
			$comment->userid	= isset($row->userid) && strtolower($row->usertype) != 'unregistered' ? $row->userid : 0;
			$comment->name 		= $row->user_name ? $row->user_name : $row->name;
			$comment->username 	= $row->user_username ? $row->user_username : $row->name;
			$comment->email 	= $row->user_email ? $row->user_email : $row->email;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->homepage	= isset($row->website) ? $row->website : '';
			$comment->isgood	= isset($row->voting_yes) ? $row->voting_yes : 0;
			$comment->ispoor	= isset($row->voting_no) ? $row->voting_no : 0;
			$comment->published	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importComboMax($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__combomax`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= 'com_content';
			$comment->name 		= $row->name;
			$comment->username 	= $comment->name;
			$comment->email 	= $row->email;		
			$comment->homepage	= $row->url;		
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->published 	= $row->approved;
			$comment->date 		= $row->date;
			$comment->userid	= $row->myid;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJomComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.email as user_email, u.name as user_name, u.username as user_username "
			. "\nFROM #__jomcomment AS c"
			. "\nLEFT JOIN #__users AS u ON c.user_id = u.id"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$iso = explode( '=', _ISO );
		$charset = strtolower((string) $iso[1]);

		if ($charset != 'utf-8')
		{
			$entity_replace = create_function('$string', '
				$num = substr($string, 0, 1) === \'x\' ? hexdec(substr($string, 1)) : (int) $string;
				return $num < 0x20 || $num > 0x10FFFF || ($num >= 0xD800 && $num <= 0xDFFF) ? \'\' : ($num < 0x80 ? \'&#\' . $num . \';\' : ($num < 0x800 ? chr(192 | $num >> 6) . chr(128 | $num & 63) : ($num < 0x10000 ? chr(224 | $num >> 12) . chr(128 | $num >> 6 & 63) . chr(128 | $num & 63) : chr(240 | $num >> 18) . chr(128 | $num >> 12 & 63) . chr(128 | $num >> 6 & 63) . chr(128 | $num & 63))));');

			require_once( JCOMMENTS_BASE.DS.'libraries'.DS.'convert'.DS.'utf8.class.php');
			$encoding =& JCommentsUtf8::getInstance( $charset );
		}

		foreach($rows as $row) {

			if ($charset != 'utf-8') {
				$row->comment = preg_replace('~(&#(\d{1,7}|x[0-9a-fA-F]{1,6});)~e', '$entity_replace(\'\\2\')', $row->comment);
				$row->comment = $encoding->utf8ToStr($row->comment);

				$row->name = preg_replace('~(&#(\d{1,7}|x[0-9a-fA-F]{1,6});)~e', '$entity_replace(\'\\2\')', $row->name);
				$row->name = $encoding->utf8ToStr($row->name);

				$row->username = preg_replace('~(&#(\d{1,7}|x[0-9a-fA-F]{1,6});)~e', '$entity_replace(\'\\2\')', $row->username);
				$row->username = $encoding->utf8ToStr($row->username);

				$row->title = preg_replace('~(&#(\d{1,7}|x[0-9a-fA-F]{1,6});)~e', '$entity_replace(\'\\2\')', $row->title);
				$row->title = $encoding->utf8ToStr( $row->title );
			}

			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= (isset($row->option) && $row->option != '' ) ? $row->option : 'com_content';
			$comment->userid 	= $row->user_id;
			$comment->name 		= $row->user_name ? $row->user_name : $row->name;
			$comment->username 	= $row->user_username ? $row->user_username : $row->name;
			$comment->email 	= $row->user_email ? $row->user_email : $row->email;
			$comment->homepage	= $row->website;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;
		
			$comment->store();
		}
	}

	function importmXcomment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.email as user_email, u.name as user_name, u.username as user_username "
			. "\nFROM #__mxc_comments AS c"
			. "\nLEFT JOIN #__users AS u ON c.iduser = u.id"
			. "\nORDER BY c.id, c.parentid"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= (isset($row->component) && $row->component != '') ? $row->component : 'com_content';
			$comment->parent	= isset($row->parentid) ? $row->parentid : 0;
			$comment->userid	= $row->iduser;
			$comment->name 		= $row->user_name ? $row->user_name : $row->name;
			$comment->username 	= $row->user_username ? $row->user_username : $row->name;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->web;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importDatsoGalleryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__datsogallery_comments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->cmtpic;
			$comment->object_group 	= 'com_datsogallery';
			$comment->name 		= $row->cmtname;
			$comment->username	= $comment->name;
			$comment->comment	= $row->cmttext;
			$comment->ip 		= $row->cmtip;
			$comment->published 	= $row->published;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", $row->cmtdate);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJoomGalleryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.id as userid, u.email, u.name, u.username "
			. "\nFROM #__joomgallery_comments AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id "
			;

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$isJG155 = false;
		if (JCOMMENTS_JVERSION == '1.5') {
			$isJG155 = is_file(JPATH_SITE.DS.'components'.DS.'com_joomgallery'.DS.'controller.php');
		}

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->cmtpic;
			$comment->object_group 	= 'com_joomgallery';
			$comment->userid	= $row->userid;
			$comment->name 		= isset($row->cmtname) ? $row->cmtname : $row->name;
			$comment->username	= $comment->username;
			$comment->comment	= $row->cmttext;
			$comment->ip 		= $row->cmtip;
			$comment->published 	= $row->published && $row->approved;
			$comment->date 		= $isJG155 ? $row->cmtdate : strftime("%Y-%m-%d %H:%M:00", $row->cmtdate);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importIceGalleryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT c.* FROM #__ice_comments AS c" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->imgid;
			$comment->object_group 	= 'com_icegallery';
			$comment->name 		= $row->cmtname;
			$comment->username	= $comment->name;
			$comment->comment	= $row->cmtcontent;
			$comment->ip 		= $row->hostaddr;
			$comment->published 	= $row->published;
			$comment->date 		= $row->cmtdate;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importRemositoryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.id as userid, u.email, u.name, u.username "
			. "\nFROM #__downloads_reviews AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id "
			;

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->itemid;
			$comment->object_group 	= 'com_remository';
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->userid	= $row->userid;
			$comment->email 	= $row->email;		
			$comment->homepage	= $row->userURL;
			$comment->title		= $row->title;		
			$comment->comment	= $row->comment;
			$comment->published	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importPAXXGalleryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.id, u.email, u.name, u.username "
			. "\nFROM #__paxxcomments AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id "
			;

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->pic;
			$comment->object_group 	= 'com_paxxgallery';
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->userid	= $row->userid;
			$comment->email 	= $row->email;		
			$comment->comment	= html_entity_decode($row->text, ENT_QUOTES);
			$comment->published	= 1;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", $row->date);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importPhocaGalleryComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.id, u.email, u.name, u.username "
			. "\nFROM #__phocagallery_comments AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id "
			;

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->catid;
			$comment->object_group 	= 'com_phocagallery';
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->userid	= $row->userid;
			$comment->email 	= $row->email;		
			$comment->title		= isset($row->title) ? $row->title : '';
			$comment->comment	= $row->comment;
			$comment->published	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importCinemaComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__cinema_comments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->cmtpic;
			$comment->object_group 	= 'com_cinema';
			$comment->name 		= $row->cmtname;
			$comment->username 	= $comment->name;
			$comment->comment	= $row->cmttext;
			$comment->ip 		= $row->cmtip;
			$comment->published 	= $row->published;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", $row->cmtdate);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJMoviesComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__jmovies_comments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->cmtpic;
			$comment->object_group 	= 'com_jmovies';
			$comment->name 		= $row->cmtname;
			$comment->username 	= $comment->name;
			$comment->comment	= $row->cmttext;
			$comment->ip 		= $row->cmtip;
			$comment->userid	= $row->cmtiduser;
			$comment->published 	= $row->published;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", $row->cmtdate);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importMosetsTree($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.email, u.name, u.username"
			. "\nFROM #__mt_reviews AS c"
			. "\nLEFT JOIN #__users AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->link_id;
			$comment->object_group 	= 'com_mtree';
			$comment->name 		= $row->user_id ? $row->name : $row->guest_name;
			$comment->username 	= $row->username ? $row->username : $comment->name;
			$comment->email 	= $row->email;
			$comment->comment	= $row->rev_text;
			$comment->userid	= $row->user_id;
			$comment->published 	= $row->rev_approved;
			$comment->date 		= $row->rev_date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importLinkDirectory($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.email, u.name, u.username"
			. "\nFROM #__ldcomment AS c"
			. "\nLEFT JOIN #__users AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->link_id;
			$comment->object_group 	= 'com_linkdirectory';
			$comment->name 		= $row->user_id ? $row->name : $row->guest_name;
			$comment->username 	= $row->username ? $row->username : $comment->name;
			$comment->email 	= $row->email;
			$comment->comment	= $row->rev_text;
			$comment->userid	= $row->user_id;
			$comment->published 	= $row->rev_approved;
			$comment->date 		= $row->rev_date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importZoom($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__zoom_comments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->imgid;
			$comment->object_group 	= 'com_zoom';
			$comment->name 		= $row->cmtname;
			$comment->username 	= $comment->name;
			$comment->comment	= $row->cmtcontent;
			$comment->published 	= 1;
			$comment->date 		= $row->cmtdate;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importRSGallery2($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__rsgallery2_comments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= isset($row->picid) ? $row->picid : $row->item_id;
			$comment->object_group 	= 'com_rsgallery2';
			$comment->parent	= isset($row->parent_id) ? $row->parent_id : 0;
			$comment->userid 	= isset($row->user_id) ? $row->user_id : 0;
			$comment->name 		= isset($row->name) ? $row->name : $row->user_name;
			$comment->username 	= $comment->name;
			$comment->comment	= $row->comment;
			$comment->ip		= isset($row->user_ip) ? $row->user_ip : '';
			$comment->published 	= 1;
			$comment->date 		= isset($row->date) ? $row->date : $row->datetime;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importHotOrNot2($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.email as user_email, u.name as user_name, u.username as user_username"
			. "\nFROM `#__hotornot_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.username = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->idx;
			$comment->object_group 	= 'com_hotornot2';
			$comment->name 		= $row->user_name != '' ? $row->user_name : 'Guest';
			$comment->username 	= $row->user_username != '' ? $row->user_username : 'Guest';
			$comment->email 	= $row->user_email;
			$comment->userid 	= $row->username;
			$comment->comment	= $row->comment;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importEasyComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( "SELECT * FROM `#__easycomments`" );
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= 'com_content';
			$comment->parent	= $row->parentid;
			$comment->userid	= 0;
			$comment->name 		= $row->name;
			$comment->username 	= $comment->name;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->email 	= $row->email;
			$comment->published	= $row->published;
			$comment->date 		= strftime( "%Y-%m-%d %H:%M:00", $row->date );
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importMusicBox($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.email, u.name, u.username"
			. "\nFROM `#__musicboxrewiev` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->albumid;
			$comment->object_group 	= 'com_musicbox';
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->text;
			$comment->published	= $row->published;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJReviews($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery("SELECT c.* FROM `#__jreviews_comments` AS c");
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->pid;
			$comment->object_group 	= 'com_content';
			$comment->userid	= $row->userid;
			$comment->ip		= $row->ipaddress;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->title		= $row->title;
			$comment->comment	= $row->comments;
			$comment->email 	= $row->email;
			$comment->published	= $row->published;
			$comment->date 		= $row->created;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importTutorialsComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.email, u.name, u.username"
			. "\nFROM `#__tutorials_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->tutorialid;
			$comment->object_group 	= 'com_tutorials';
			$comment->userid	= $row->userid;
			$comment->ip		= $row->userip;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->title		= $row->title;
			$comment->comment	= $row->comments;
			$comment->email 	= $row->email;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importIDoBlogComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name"
			. "\nFROM `#__idoblog_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.created_by = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->idarticle;
			$comment->object_group 	= 'com_idoblog';
			$comment->parent	= $row->parent;
			$comment->userid	= $row->created_by;
			$comment->ip		= $row->userip;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->title		= $row->title;
			$comment->comment	= $row->text;
			$comment->email 	= $row->email;
			$comment->published 	= $row->publish;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importSobi2Reviews($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name"
			. "\nFROM `#__sobi2_plugin_reviews` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->itemid;
			$comment->object_group 	= 'com_sobi2';
			$comment->parent	= 0;
			$comment->userid	= $row->userid;
			$comment->ip		= $row->ip;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->title		= $row->title;
			$comment->comment	= $row->review;
			$comment->email 	= $row->email;
			$comment->published 	= $row->published;
			$comment->date 		= $row->added;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJReactions($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username"
			. "\nFROM `#__jreactions` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= 'com_content';
			$comment->parent	= 0;
			$comment->userid	= $row->userid;
			$comment->ip		= $row->ip;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->title		= $row->title;
			$comment->comment	= $row->comments;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->website;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importVirtueMart($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username, u.email, u.name"
			. "\nFROM `#__vm_product_reviews` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->product_id;
			$comment->object_group 	= 'com_virtuemart';
			$comment->parent	= 0;
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment;
			$comment->email 	= $row->email;
			$comment->published 	= $row->published;
			$comment->date 		= strftime("%Y-%m-%d %H:%M:00", $row->time);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJXtendedComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery("SHOW TABLE LIKE '%jxcomments_threads%';");
		$tables = $db->loadResultArray();

		if (count($tables) == 0) {
			$query = "SELECT c.*, c.context_id as object_id, c.context as object_group, u.username"
				. "\nFROM `#__jxcomments_comments` AS c"
				. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
				;
		} else {
			$query = "SELECT c.*, t.context_id as object_id, t.context as object_group, u.username"
				. "\nFROM `#__jxcomments_comments` AS c"
				. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
				. "\nLEFT JOIN `#__jxcomments_threads` AS t on c.thread_id = t.id "
				;
		}

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->object_id;
			$comment->object_group 	= $row->object_group == 'content' ? 'com_' . $row->object_group : $row->object_group;
			$comment->parent	= 0;
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->body;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->url;
			$comment->ip		= $row->address;
			$comment->published 	= $row->published;
			$comment->date 		= $row->created_date;
			$comment->source 	= $language;
			$comment->lang 		= $source;

			$comment->store();
		}
	}

	function importChronoComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username"
			. "\nFROM `#__chrono_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->pageid;
			$comment->object_group 	= $row->component;
			$comment->parent	= $row->parentid;
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->text;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->url;
			$comment->published 	= $row->published;
			$comment->date 		= $row->datetime;
			$comment->isgood	= $row->rating > 0 ? $row->rating : 0;
			$comment->ispoor	= $row->rating < 0 ? abs($row->rating) : 0;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}
	
	function importAkoBook($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.gbname, c.gbmail, c.gbip, c.gbpage, c.gbdate, c.published, c.gbtext"
			. "\n, u.username, u.id as userid"
			. "\nFROM `#__akobook` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.gbname = u.username and c.gbmail = u.email "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= 1;
			$comment->object_group 	= 'com_akobook';
			$comment->parent	= 0;
			$comment->userid	= isset($row->userid) ? intval($row->userid) : 0;
			$comment->name 		= $row->gbname;
			$comment->username 	= $row->gbname == '' ? $row->username : $row->gbname;
			$comment->comment	= $row->gbtext;
			$comment->email 	= $row->gbmail;
			$comment->homepage	= $row->gbpage;
			$comment->ip		= $row->gbip;
			$comment->published 	= $row->published;
			$comment->date 		= strftime( "%Y-%m-%d %H:%M:00", $row->gbdate);
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJamBook($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.username, u.name, u.id as userid"
			. "\nFROM `#__jx_jambook` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.created_by = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= 0;
			$comment->object_group 	= 'com_jambook';
			$comment->parent	= 0;
			$comment->userid	= isset($row->userid) ? intval($row->userid) : 0;
			$comment->name 		= isset($row->authoralias) ? $row->authoralias : $row->name;
			$comment->username 	= isset($row->authoralias) ? $row->authoralias : $row->username;
			$comment->comment	= $row->content;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->url;
			$comment->ip		= $row->fromip;
			$comment->published 	= 1;
			$comment->date 		= $row->created;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importK2($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.name"
			. "\nFROM `#__k2_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->itemID;
			$comment->object_group 	= 'com_k2';
			$comment->parent	= 0;
			$comment->userid	= isset($row->userID) ? intval($row->userID) : 0;
			$comment->name 		= isset($row->userName) ? $row->userName : $row->name;
			$comment->username 	= isset($row->userName) ? $row->userName : $row->name;
			$comment->comment	= $row->commentText;
			$comment->email 	= $row->commentEmail;
			$comment->homepage	= $row->commentURL;
			$comment->ip		= '';
			$comment->published 	= $row->published;
			$comment->date 		= $row->commentDate;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importSmartBlog($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.username, u.name, u.email, u.id as userid"
			. "\nFROM `#__blog_comment` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->post_id;
			$comment->object_group 	= 'com_blog';
			$comment->parent	= 0;
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment_desc;
			$comment->title		= $row->comment_title;
			$comment->email 	= $row->email;
			$comment->homepage	= '';
			$comment->ip		= $row->comment_ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->comment_date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importUrComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.email as user_email, u.name as user_name, u.username as user_username "
			. "\nFROM #__urcomment AS c"
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id"
			. "\nORDER BY c.id, c.parentid"
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= (isset($row->component) && $row->component != '') ? $row->component : 'com_content';
			$comment->parent	= isset($row->parentid) ? $row->parentid : 0;
			$comment->userid	= $row->userid;
			$comment->name 		= $row->user_name ? $row->user_name : $row->name;
			$comment->username 	= $row->user_username ? $row->user_username : $row->name;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->website;
			$comment->title		= $row->title;
			$comment->comment	= $row->comment;
			$comment->ip 		= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->isgood	= $row->rate_good > 0 ? $row->rate_good : 0;
			$comment->ispoor	= $row->rate_bad < 0 ? $row->rate_bad : 0;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importYvComment($source, $language)
	{
		$yvHelper = JPATH_SITE.DS.'components'.DS.'com_yvcomment'.DS.'helpers.php';
		if (!is_file($yvHelper)) {
			return;
		}

		$db = & JCommentsFactory::getDBO();

		require_once($yvHelper);
		$yvComment = &yvCommentHelper::getInstance();

		$rows = yvCommentSystem::getList();

		$guestId = $yvComment->getGuestID();

		foreach($rows as $row) {

			$yvEmail = trim($yvComment->getValueFromIni($row->metadata, 'created_by_email'));

			if ($row->created_by == $guestId) {
				$yvUsername = trim($yvComment->getValueFromIni($row->metadata, 'created_by_username'));
				$yvAlias = trim($yvComment->getValueFromIni($row->metadata, 'created_by_alias'));

				$row->created_by = 0;
				$row->username = $yvUsername ? $yvUsername : ($yvAlias ? $yvAlias : $row->created_by_alias);
				$row->name = $yvUsername ? $yvUsername : ($yvAlias ? $yvAlias : $row->created_by_alias);
				$row->email = $yvEmail;
			}

			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->parentid;
			$comment->object_group 	= 'com_content';
			$comment->parent	= 0;
			$comment->userid	= $row->created_by;
			$comment->username 	= $row->created_by_alias ? $row->created_by_alias : $row->username;
			$comment->name 		= $row->created_by_alias ? $row->created_by_alias : $row->name;
			$comment->email 	= $yvEmail ? $yvEmail : $row->email;
			$comment->homepage	= $yvComment->getValueFromIni($row->metadata, 'created_by_link');
			$comment->title		= $row->title;
			$comment->comment	= $row->introtext . $row->fulltext;
			$comment->published 	= ($row->state == 1) ? 1 : 0;
			$comment->date 		= $row->created;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importZimbComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.username, u.name, u.email, u.id as userid"
			. "\nFROM `#__zimbComment_Comment` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.iduser = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->articleId;
			$comment->object_group 	= 'com_content';
			$comment->parent	= 0;
			$comment->userid	= $row->iduser;
			$comment->username 	= isset($row->handle) ? $row->handle : $row->username;
			$comment->name 		= $row->name;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->url;
			$comment->title		= '';
			$comment->comment	= $row->content;
			$comment->published 	= $row->published;
			$comment->date 		= $row->saved;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importRDBSComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username"
			. "\nFROM `#__rdbs_comment_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.created_by = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->refid;
			$comment->object_group 	= isset($row->application) ? $row->application : 'com_content';
			$comment->parent	= $row->parent;
			$comment->userid	= $row->created_by;
			$comment->title 	= $row->title;
			$comment->name 		= $row->name;
			$comment->username 	= $row->created_by_alias;
			$comment->comment	= $row->comment;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->web;
			$comment->ip	 	= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->created;
			$comment->isgood	= $row->usefull_yes > 0 ? $row->usefull_yes : 0;
			$comment->ispoor	= $row->usefull_no < 0 ? $row->usefull_no : 0;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importLyftenBloggie($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username"
			. "\nFROM `#__bloggies_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->entry_id;
			$comment->object_group 	= 'com_lyftenbloggie';
			$comment->parent	= 0;
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->author;
			$comment->username 	= isset($row->username) ? $row->username : $row->author;
			$comment->comment	= $row->content;
			$comment->email 	= $row->author_email;
			$comment->homepage	= $row->author_url;
			$comment->ip	 	= $row->author_ip;
			$comment->published 	= ($row->state == 1) ? 1 : 0;
			$comment->date 		= $row->date;
			$comment->isgood	= $row->karma > 0 ? $row->karma : 0;
			$comment->ispoor	= $row->karma < 0 ? $row->karma : 0;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importWebeeComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.username, u.name, u.email as user_email, u.id as userid"
			. "\nFROM `#__webeeComment_Comment` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.isuser = 1 AND c.handle = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);
			
			$comment->object_id 	= $row->articleId;
			$comment->object_group 	= 'com_content';
			$comment->parent	= 0;
			$comment->userid	= $row->isuser ? $row->handle : 0;
			$comment->username 	= $row->isuser ? $row->username : $row->handle;
			$comment->name 		= $row->isuser ? $row->name : $row->handle;
			$comment->email 	= $row->isuser ? $row->user_email : $row->email;
			$comment->homepage	= $row->url;
			$comment->title		= '';
			$comment->ip		= isset($row->ipAddress) ? $row->ipAddress : '';
			$comment->comment	= $row->content;
			$comment->published 	= $row->published;
			$comment->date 		= $row->saved;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importResourceComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*"
			. "\n, u.username, u.email as user_email"
			. "\nFROM `#__js_res_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->record_id;
			$comment->object_group 	= 'com_resource';
			$comment->parent	= $row->parent;
			$comment->userid	= $row->user_id;
			$comment->username 	= isset($row->username) ? $row->username : $row->name;
			$comment->name 		= $row->name;
			$comment->email 	= isset($row->user_email) ? $row->user_email : $row->email;
			$comment->title		= $row->subject;
			$comment->comment	= $row->comment;
			$comment->ip		= $row->ip;
			$comment->published 	= $row->published;
			$comment->date 		= $row->ctime;
			$comment->isgood	= $row->rate > 0 ? $row->rate : 0;
			$comment->ispoor	= $row->rate < 0 ? abs($row->rate) : 0;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= isset($row->langs) ? $row->langs : $language;

			$comment->store();
		}
	}

	function importJAComment($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.username"
			. "\nFROM `#__jacomment_items` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->contentid;
			$comment->object_group 	= $row->option;
			$comment->parent	= $row->parentid;
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment;
			$comment->ip	 	= $row->ip;
			$comment->email 	= $row->email;
			$comment->homepage	= $row->website;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->isgood	= $row->voted > 0 ? $row->voted : 0;
			$comment->ispoor	= $row->voted < 0 ? abs($row->voted) : 0;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importTPDuggComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name, u.username, u.email"
			. "\nFROM `#__tpdugg_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.userid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->duggid;
			$comment->object_group 	= 'com_tpdugg';
			$comment->parent	= $row->parentid;
			$comment->userid	= $row->userid;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment;
			$comment->ip	 	= $row->ipaddress;
			$comment->email 	= $row->email;
			$comment->published 	= $row->published;
			$comment->date 		= $row->created;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importZooComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name, u.username, u.email"
			. "\nFROM `#__zoo_comment` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->item_id;
			$comment->object_group 	= 'com_zoo';
			$comment->parent	= $row->parent_id;
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->name;
			$comment->username 	= $row->author;
			$comment->comment	= $row->content;
			$comment->ip	 	= $row->ip;
			$comment->email 	= $row->email;
			$comment->homepage 	= $row->url;
			$comment->published 	= $row->state == 1;
			$comment->date 		= $row->created;
			$comment->source 	= $source;
			$comment->source_id	= $row->id;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importBeeHeardComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name, u.username, u.email"
			. "\nFROM `#__beeheard_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->suggestion_id;
			$comment->object_group 	= 'com_beeheard';
			$comment->parent	= 0;
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment_text;
			$comment->email 	= $row->email;
			$comment->published 	= 1;
			$comment->date 		= $row->created_at;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importJMyLifeComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name, u.username, u.email"
			. "\nFROM `#__jmylife_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.author_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->sid;
			$comment->object_group 	= 'com_jmylife';
			$comment->userid	= $row->author_id;
			$comment->name 		= $row->name ? $row->name : $row->author;
			$comment->username 	= $row->username ? $row->username : $row->author;
			$comment->comment	= $row->message;
			$comment->email 	= $row->email ? $row->email : '';
			$comment->published 	= $row->published;
			$comment->date 		= JHTML::_('date',  $row->time, '%Y-%m-%d %H:%M:%s');
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importMusicCollectionsComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name, u.username, u.email"
			. "\nFROM `#__muscol_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.user_id = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->album_id;
			$comment->object_group 	= 'com_muscol';
			$comment->userid	= $row->user_id;
			$comment->name 		= $row->name;
			$comment->username 	= $row->username;
			$comment->comment	= $row->comment;
			$comment->email 	= $row->email;
			$comment->published 	= 1;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}

	function importRSComments($source, $language)
	{
		$db = & JCommentsFactory::getDBO();
		$query	= "SELECT c.*, u.name as user_name, u.username, u.email as user_email"
			. "\nFROM `#__rscomments_comments` AS c"
			. "\nLEFT JOIN `#__users` AS u ON c.uid = u.id "
			;
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		foreach($rows as $row) {
			$comment = new JCommentsImportedComment($db);

			$comment->object_id 	= $row->id;
			$comment->object_group 	= $row->option;
			$comment->userid	= $row->uid;
			$comment->name 		= isset($row->user_name) ? $row->user_name : $row->name;
			$comment->username 	= $row->username;
			$comment->email 	= isset($row->user_email) ? $row->user_email : $row->email;
			$comment->homepage 	= $row->website;
			$comment->ip	 	= $row->ip;
			$comment->title		= $row->subject;
			$comment->comment	= $row->comment;
			$comment->published 	= $row->published;
			$comment->date 		= $row->date;
			$comment->source 	= $source;
			$comment->lang 		= $language;

			$comment->store();
		}
	}
}

class HTML_JCommentsMigrationTool
{
	function showImport()
	{
		global $mainframe;

		$CommentSystems = array();
		
		$CommentSystems[] = new JOtherCommentSystem( 
						'AkoComment'
						, 'AkoComment'
						, 'Arthur Konze'
						, 'http://www.konze.de/content/view/8/26/'
						, 'http://www.konze.de/content/view/8/26/'
						, 'http://mamboportal.com'
						, '#__akocomment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'MosCom'
						, 'MosCom'
						, 'Chanh Ong'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://ongetc.com'
						, '#__content_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'ComboMax'
						, 'ComboMax'
						, 'Phil Taylor'
						, 'Commercial (22.50 GPB)'
						, ''
						, 'http://www.phil-taylor.com/Joomla/Components/ComboMAX/'
						, '#__combomax'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'JoomlaComment'
						, 'JoomlaComment'
						, 'Frantisek Hliva'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://cavo.co.nr'
						, '#__comment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'mXcomment'
						, 'mXcomment'
						, 'Bernard Gilly'
						, 'Creative Commons'
						, ''
						, 'http://www.visualclinic.fr'
						, '#__mxc_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'JomComment'
						, 'JomComment'
						, 'Azrul Rahim'
						, 'Commercial/Free'
						, ''
						, 'http://www.azrul.com'
						, '#__jomcomment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'jxtendedcomments'
						, 'JXtended Comments'
						, 'JXtended LLC'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://jxtended.com/products/comments.html'
						, '#__jxcomments_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'chronocomments'
						, 'Chrono Comments'
						, 'Chronoman'
						, 'CC'
						, ''
						, 'http://www.chronoengine.com/'
						, '#__chrono_comments'
						);


		$CommentSystems[] = new JOtherCommentSystem( 
						'jacomment'
						, 'JA Comment'
						, 'JoomlArt'
						, 'Copyrighted Commercial Software'
						, ''
						, 'www.joomlart.com'
						, '#__jacomment_items'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'DatsoGallery'
						, 'DatsoGallery comments'
						, 'Andrey Datso'
						, 'Free'
						, ''
						, 'http://www.datso.fr'
						, '#__datsogallery_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'JoomGallery'
						, 'JoomGallery comments'
						, 'M. Andreas Boettcher'
						, 'Free'
						, ''
						, 'http://www.joomgallery.net'
						, '#__joomgallery_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'IceGallery'
						, 'IceGallery comments'
						, 'Markus Donhauser'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://joomlacode.org/gf/project/ice/'
						, '#__ice_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'Remository'
						, 'Remository file reviews'
						, 'Martin Brampton'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.remository.com'
						, '#__downloads_reviews'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'PAXXGallery'
						, 'PAXXGallery comments'
						, 'Tobias Floery'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.paxxgallery.com'
						, '#__paxxcomments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'PhocaGallery'
						, 'PhocaGallery comments'
						, 'Jan Pavelka'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.phoca.cz'
						, '#__phocagallery_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'JMovies'
						, 'JMovies comments'
						, 'Luscarpa &amp; Vamba'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.jmovies.eu/'
						, '#__jmovies_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'Cinema'
						, 'Cinema comments'
						, 'Vamba'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.joomlaitalia.com'
						, '#__cinema_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'MosetsTree'
						, 'Mosets Tree reviews'
						, 'Mosets Consulting'
						, 'Commercial'
						, ''
						, 'http://www.mosets.com'
						, '#__mt_reviews'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'LinkDirectory'
						, 'LinkDirectory link comments'
						, 'Soner Ekici'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.sonerekici.com/'
						, '#__ldcomment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'zOOmMediaGallery'
						, 'zOOm Media Gallery comments'
						, 'Mike de Boer'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.zoomfactory.org/'
						, '#__zoom_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'rsgallery2'
						, 'RSGallery2 comments'
						, 'rsgallery2.net'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://rsgallery2.net/'
						, '#__rsgallery2_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'hotornot2'
						, 'Hotornot2 comments'
						, 'Aron Watson'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://joomlacode.org/gf/project/com_hotornot2/frs/'
						, '#__hotornot_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'easycomments'
						, 'EasyComments (www.easy-joomla.org)'
						, 'EasyJoomla'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.easy-joomla.org/'
						, '#__easycomments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'musicbox'
						, 'MusicBox'
						, 'Vamba'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.joomlaitalia.com'
						, '#__musicboxrewiev'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'jreviews'
						, 'JReviews'
						, 'Alejandro Schmeichler'
						, 'Commercial'
						, ''
						, 'http://www.reviewsforjoomla.com'
						, '#__jreviews_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'tutorials'
						, 'Tutorials (comments for items)'
						, 'NSOrg Project'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.nsorg.com'
						, '#__tutorials_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'idoblog'
						, 'IDoBlog'
						, 'Sunshine studio'
						, 'GNU/GPL'
						, ''
						, 'http://idojoomla.com'
						, '#__idoblog_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'sobi2reviews'
						, 'SOBI2 Reviews'
						, 'SOBI2 Developer Team'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.sigsiu.net'
						, '#__sobi2_plugin_reviews'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'jreactions'
						, 'J! Reactions'
						, 'SDeCNet Software'
						, ''
						, ''
						, 'http://jreactions.sdecnet.com'
						, '#__jreactions'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'virtuemart'
						, 'VirtueMart product reviews'
						, 'The VirtueMart Development Team'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.virtuemart.net'
						, '#__vm_product_reviews'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'akobook'
						, 'AkoBook'
						, 'Arthur Konze'
						, ''
						, ''
						, 'http://mamboportal.com'
						, '#__akobook'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'jambook'
						, 'JamBook'
						, 'Olle Johansson'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.jxdevelopment.com/'
						, '#__jx_jambook'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'k2'
						, 'K2 Comments'
						, 'JoomlaWorks'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://k2.joomlaworks.gr/'
						, '#__k2_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'smartblog'
						, 'SmartBlog Comments'
						, 'Aneesh S'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.aarthikaindia.com'
						, '#__blog_comment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'urcomment'
						, 'UrComment'
						, 'Comdev Software Sdn Bhd'
						, 'GPL, Commercial Software'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://joomla.comdevweb.com'
						, '#__urcomment'
						);

		$CommentSystems[] = new yvCommentSystem( 
						'yvcomment'
						, 'yvComment'
						, 'Yuri Volkov'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://yurivolkov.com/Joomla/yvComment/index_en.html'
						, '#__yvcomment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'zimb'
						, 'ZiMB Comment'
						, 'ZiMB LLC'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.zimbllc.com/Software/zimbcomment'
						, '#__zimbcomment_comment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'rdbscomment'
						, 'RDBS Commment'
						, 'Robert Deutz'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.rdbs.de'
						, '#__rdbs_comment_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'lyftenbloggie'
						, 'LyftenBloggie'
						, 'Lyften Designs'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.lyften.com'
						, '#__bloggies_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'webee'
						, 'Webee Comment'
						, 'Onno Groen'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.onnogroen.nl/webee/'
						, '#__webeecomment_comment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'resource'
						, 'MightyExtensions Resource comments'
						, 'MightyExtensions'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://mightyextensions.com/'
						, '#__js_res_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'tpdugg'
						, 'TPDugg'
						, 'TemplatePlazza'
						, ''
						, ''
						, 'http://templateplazza.com/'
						, '#__tpdugg_comments'
						);
						
		$CommentSystems[] = new JOtherCommentSystem( 
						'zoo'
						, 'ZOO Comments'
						, 'YOOtheme'
						, 'GNU/GPLv2'
						, 'http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only'
						, 'http://zoo.yootheme.com'
						, '#__zoo_comment'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'beeheard'
						, 'BeeHeard Comments'
						, 'Kaysten Mazerino'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://www.cmstactics.com'
						, '#__beeheard_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'jmylife'
						, 'JMyLife Comments'
						, 'Jeff Channell'
						, 'GNU/GPL'
						, 'http://www.gnu.org/copyleft/gpl.html'
						, 'http://jeffchannell.com'
						, '#__jmylife_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'muscol'
						, 'Music Colllection Comments'
						, 'Germinal Camps'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.joomlamusicsolutions.com'
						, '#__muscol_comments'
						);

		$CommentSystems[] = new JOtherCommentSystem( 
						'rscomments'
						, 'RSComments'
						, 'RSJoomla'
						, 'GNU/GPL'
						, 'http://www.gnu.org/licenses/gpl-2.0.html'
						, 'http://www.rsjoomla.com/joomla-components/joomla-comments.html'
						, '#__rscomments_comments'
						);

		$db = & JCommentsFactory::getDBO();							
		$db->setQuery("SHOW tables");
		$tables = $db->loadResultArray();
	
		foreach ($tables as $tblval) {
			for($i=0,$n=count($CommentSystems); $i < $n; $i++ ) {
				$table_mask = str_replace( '#_', '', $CommentSystems[$i]->table );

				if (preg_match('/'.$table_mask.'$/i', $tblval)) {
					$CommentSystems[$i]->found = true;
					$CommentSystems[$i]->UpdateCount();
				} 
			}
		}

		$languages = array();

		$joomfish = JOOMLATUNE_JPATH_SITE.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';

		if (is_file($joomfish)) {
			$db = & JCommentsFactory::getDBO();
			$db->setQuery("SELECT name, `code` as value FROM #__languages WHERE active = 1");
			$languages = $db->loadObjectList();
		}

		if (JCOMMENTS_JVERSION == '1.5') {
			$params = JComponentHelper::getParams('com_languages');
			$lang = $params->get("site", 'en-GB');
		} else {
		 	$lang = JCommentsMultilingual::getLanguage();
		}

		$ajaxUrl = JCommentsFactory::getLink('ajax-backend');
?>
<script type="text/javascript" src="<?php echo $mainframe->getCfg( 'live_site' );?>/components/com_jcomments/libraries/joomlatune/ajax.js?v=2"></script>
<script type="text/javascript" src="<?php echo $mainframe->getCfg( 'live_site' );?>/administrator/components/com_jcomments/assets/jcomments-backend-v2.1.js"></script>
<script type="text/javascript">
<!--
function JCommentsImportCommentsAJAX() {
	try{
		jtajax.setup({url:'<?php echo $ajaxUrl; ?>'});
		return jtajax.call('JCommentsImportCommentsAjax',null,'post','adminForm');
	}catch(e){
		return false;
	}
}

function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}

	JCommentsImportCommentsAJAX();
}
//-->
</script>
<script type="text/javascript">
<!--
var jc_comments = new Array(
<?php
		$jsArray = array();
		foreach($CommentSystems as $CommentSystem) {
			if($CommentSystem->found) {
				$jsArray[] = $CommentSystem->code;
			}
		}
		echo "'" . implode("', '", $jsArray) . "'";
?>
			);

function importMode( mode ) {
	if(document.getElementById) {
		for(var i=0;i<jc_comments.length;i++) {
		        if (mode == jc_comments[i]) {
				document.getElementById('import' + jc_comments[i]).checked = true;
				document.getElementById('import' + jc_comments[i]+'Info').style.display = '';
			} else {
				document.getElementById('import' + jc_comments[i]).checked = false;
				document.getElementById('import' + jc_comments[i]+'Info').style.display = 'none';
			}
		}
	}
}
//-->
</script>

<style type="text/css">
#jcomments-message {padding: 0 0 0 25px;margin: 0; width: auto; float: right; font-size: 14px; font-weight: bold;}
.jcomments-message-error {background: transparent url(components/com_jcomments/assets/error.gif) no-repeat 4px 50%; color: red;}
.jcomments-message-info {background: transparent url(components/com_jcomments/assets/info.gif) no-repeat 4px 50%; color: green;}
fieldset { border: 1px #999 solid; }
span.note { color: #777; }
table.componentinfo td { color: #777; padding: 0; }
</style>

<div id="jc">
<form action="<?php echo JCOMMENTS_INDEX; ?>" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_jcomments" />
<input type="hidden" name="task" value="" />
<?php
		if ( JCOMMENTS_JVERSION == '1.0' ) {
?>
<table class="adminheading">
<tr>
	<th style="background-image: none; padding: 0;"><img src="./components/com_jcomments/assets/import48x48.png" width="48" height="48" align="middle">&nbsp;<?php echo JText::_('A_IMPORT'); ?></th>
</tr>
</table>
<?php
		}
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td align="right">&nbsp;</td>
		<td width="50%" align="right"><div id="jcomments-message-holder"></div></td>
	</tr>
</table>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminform">
<tr>
	<td>
		<fieldset>
		<legend><?php echo JText::_('A_IMPORT_SELECT_SOURCE'); ?></legend>

		<table cellpadding="1" cellspacing="1" border="0">

<?php
		$foundSources = 0;
		foreach($CommentSystems as $CommentSystem) {
			if($CommentSystem->found) {
				$foundSources++;
?>
		<tr valign="top" align="left">
			<td><input type="radio" id="import<?php echo $CommentSystem->code; ?>" name="vars[import]" value="<?php echo $CommentSystem->code; ?>" onclick="importMode('<?php echo $CommentSystem->code; ?>')" <?php echo ($CommentSystem->found ? '' : 'disabled') ?> /></td>
			<td><label for="import<?php echo $CommentSystem->code; ?>"><?php echo $CommentSystem->name; ?> <?php echo ($CommentSystem->found ? '' : '<span class="note">['.JText::_('A_IMPORT_COMPONENT_NOT_INSTALLED').']</span>') ?></label></td>
			<td><div id="jcomments-message-<?php echo strtolower($CommentSystem->code); ?>"></div></td>
		</tr>
		<tr id="import<?php echo $CommentSystem->code; ?>Info" style="display: none;">
			<td>&nbsp;</td>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" class="componentinfo">
				<tr>
					<td width="150px"><?php echo JText::_('A_IMPORT_COMPONENT_AUTHOR'); ?></td>
					<td><?php echo $CommentSystem->author; ?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('A_IMPORT_COMPONENT_HOMEPAGE'); ?></td>
					<td><a href="<?php echo $CommentSystem->homepage; ?>" target="_blank"><?php echo str_replace('http://', '', $CommentSystem->homepage); ?></a></td>
				</tr>
				<tr>
					<td><?php echo JText::_('A_IMPORT_COMPONENT_LICENSE'); ?></td>
					<td>
<?php
				if ($CommentSystem->license_url != '') {
?>					
						<a href="<?php echo $CommentSystem->license_url; ?>" target="_blank"><?php echo $CommentSystem->license; ?></a>
<?php
				} else {
?>					
						<?php echo $CommentSystem->license; ?>
<?php
				}
?>					
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr valign="top" align="left">
					<td>
						<?php echo JText::_('A_IMPORT_COMPONENT_COMMENTS_COUNT'); ?>
					</td>
					<td>
					        <label for="import<?php echo $CommentSystem->code; ?>"><?php echo $CommentSystem->count; ?></label>
					        <br />
<?php
				if (count($languages)) {
					echo JCommentsHTML::selectList( $languages, strtolower($CommentSystem->code) . '_lang', 'class="inputbox" size="1"', 'value', 'name', $lang) . '&nbsp;';
				}
?>					        
					        <input type="button" id="import<?php echo $CommentSystem->code; ?>" name="import<?php echo $CommentSystem->code; ?>" value="<?php echo JText::_('A_IMPORT_DO_IMPORT'); ?>" onclick="submitbutton('doimport')" <?php echo ($CommentSystem->count ? '' : 'disabled') ?> />
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
<?php
                	}
		}

		if ($foundSources == 0) {
?>
		<tr>
			<td><?php echo JText::_('A_IMPORT_NO_SOURCES'); ?></td>
		</tr>
<?php
		}
?>
		</table>
	</fieldset>
	</td>
</tr>
</table>
</form>
</div>
<?php
	}
}
?>