<?php
/**
 * JComments - Joomla Comment System
 *
 * Export comments to rss
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
(defined('_VALID_MOS') or defined('_JEXEC')) or die('Restricted access');

class JoomlaTuneFeedItem
{
	var $title = "";
	var $link = "";
	var $description = "";
	var $author = "";
	var $category = "";
	var $pubDate = "";
	var $source = "";
}

class JoomlaTuneFeed
{
	var $encoding = "";
	var $timezone = "+0000";
	var $offset = "";
	var $title = "";
	var $link = "";
	var $syndicationURL = "";
	var $description = "";
	var $lastBuildDate = "";
	var $pubDate = "";
	var $copyright = "";
	var $items = array();

	function __construct()
	{
		$this->items = array();
	}

	function JoomlaTuneFeed()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	function addItem( &$item )
	{
		$item->source = $this->link;
		$this->items[] = $item;
	}

	function htmlspecialchars($str)
	{
		return (strtoupper($this->encoding) == 'UTF-8') ? htmlspecialchars($str, ENT_COMPAT, 'UTF-8') : htmlspecialchars($str);
	}

	function setOffset($offset)
	{
		$h = intval($offset);
		$m = ($offset - intval($offset)) * 60;
		$this->offset = $offset;
		$this->timezone = (($offset >= 0) ? '+' : '-') . sprintf("%02d%02d", $h, $m);
	}

	function toRFC822($date = 'now')
	{
		if ($date == 'now' || empty($date)) {
			$date = strtotime(gmdate("M d Y H:i:s", time()));
		} else if (is_string($date)) {
			$date = strtotime($date);
		}

		if ($this->offset != '') {
			$date = $date + $this->offset * 3600;
		}

		return str_replace('UTC', 'UT', date('D, d M Y H:i:s', $date) . ' ' . $this->timezone);
	}

	function render()
	{
		$this->link = str_replace('&amp;', '&', $this->link);
		$this->link = str_replace('&', '&amp;', $this->link);

		$feed = "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
		$feed.= "	<channel>\n";
		$feed.= "		<title>".$this->title."</title>\n";
		$feed.= "		<description>".$this->description."</description>\n";
		$feed.= "		<link>".$this->link."</link>\n";
		$feed.= "		<lastBuildDate>".$this->htmlspecialchars($this->toRFC822())."</lastBuildDate>\n";
		$feed.= "		<generator>JComments</generator>\n";

		if ($this->syndicationURL != '') {
			$feed.= "		<atom:link href=\"".str_replace(' ', '%20', $this->syndicationURL)."\" rel=\"self\" type=\"application/rss+xml\" />\n";
		}

		foreach($this->items as $item)
		{
			/**
			 * @var $item JoomlaTuneFeedItem
			 */
			$item->link = str_replace('&amp;', '&', $item->link);
			$item->link = str_replace('&', '&amp;', $item->link);

			$feed.= "		<item>\n";
			$feed.= "			<title>".$this->htmlspecialchars(strip_tags($item->title))."</title>\n";
			$feed.= "			<link>".$item->link."</link>\n";
			$feed.= "			<description><![CDATA[".$item->description."]]></description>\n";

			if ($item->author != "") {
				// $feed.= "			<author>".$this->htmlspecialchars($item->author)."</author>\n";
				$feed.= "			<dc:creator>".$this->htmlspecialchars($item->author)."</dc:creator>\n";
			}

			if ($item->pubDate != "") {
				$feed.= "			<pubDate>".$this->htmlspecialchars($this->toRFC822($item->pubDate))."</pubDate>\n";
			}
			$feed.= "			<guid>" . $item->link . "</guid>\n";
			$feed.= "		</item>\n";
		}
		$feed.= "	</channel>\n";
		$feed.= "</rss>\n";
		return $feed;
	}

	function display()
	{
		$rss = $this->render();

		if (!headers_sent()) {
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 900) . ' GMT');
			header('Content-Type: application/xml');
		}
        echo "<?xml version=\"1.0\" encoding=\"".$this->encoding."\"?>\n";
		echo $rss;
	}
}

class JCommentsRSS
{
	function feedLastComments()
	{
		global $mainframe;

		$object_id = (int) JCommentsInput::getVar('object_id', 0);
		$object_group = trim(strip_tags(JCommentsInput::getVar('object_group', 'com_content')));
		$object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.]#is', '', $object_group);

		$limit = (int) JCommentsInput::getVar('limit', 10);

		$config = & JCommentsFactory::getConfig();

		if ($config->get('enable_rss') == '1') {

			// if no group or id specified - return 404
			if ($object_id == 0 || $object_group == '') {
				header('HTTP/1.0 404 Not Found');

				if (JCOMMENTS_JVERSION == '1.5') {
					JError::raiseError(404, JText::_("Resource Not Found"));
				}
				exit(404);
			}

			$lang = JCommentsMultilingual::isEnabled() ? JCommentsMultilingual::getLanguage() : null;

			$object_title = JCommentsObjectHelper::getTitle($object_id, $object_group, $lang);
			$object_link = JCommentsObjectHelper::getLink($object_id, $object_group);
			$object_link = JCommentsFactory::getAbsLink($object_link);

			$iso = explode('=', _ISO);
			$charset = strtolower((string) $iso[1]);

			if (JCOMMENTS_JVERSION == '1.5') {
				$offset = $mainframe->getCfg('offset');
			} else {
				$offset = $mainframe->getCfg('offset') + date( 'O' ) / 100;
			}

			$lm = $limit <> 100 ? ('&amp;limit='.$limit) : '';
			if (JCOMMENTS_JVERSION == '1.5') {
				$liveSite = str_replace(JURI::root(true), '', $mainframe->getCfg('live_site'));
				$syndicationURL = $liveSite . JRoute::_('index.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.$lm.'&amp;format=raw');
			} else {
				$syndicationURL = $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=rss&amp;object_id='.$object_id.'&amp;object_group='.$object_group.$lm.'&amp;no_html=1';
			}

			$rss = new JoomlaTuneFeed();
			$rss->setOffset($offset);
			$rss->encoding = $charset;
			$rss->title = $object_title;
			$rss->link = $object_link;
			$rss->syndicationURL = $syndicationURL;
			$rss->description = JText::_('COMMENTS_FOR') . ' ' . $rss->title;

			$object_link = str_replace('amp;', '', $object_link);

			$db = & JCommentsFactory::getDBO();

			$query = "SELECT id, title, userid, name, username, date, UNIX_TIMESTAMP(date) as date_ts, comment "
					. "\nFROM #__jcomments "
					. "\nWHERE object_id = '" . $object_id . "'"
					. "\nAND object_group ='" . $db->getEscaped($object_group) . "'"
					. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\nAND published = '1'"
					. "\nORDER BY date DESC"
					;
			$db->setQuery($query, 0, $limit);
			$rows = $db->loadObjectList();

			$word_maxlength = $config->getInt('word_maxlength');

			foreach ($rows as $row) {
				$comment = JCommentsText::cleanText($row->comment);
				$title = $row->title;
				$author = JComments::getCommentAuthorName($row);

				if ($comment != '') {

					// apply censor filter
					$title = JCommentsText::censor($title);
					$comment = JCommentsText::censor($comment);

					// fix long words problem
					if ($word_maxlength > 0) {
						$comment = JCommentsText::fixLongWords($comment, $word_maxlength, ' ');
						if ($title != '') {
							$title = JCommentsText::fixLongWords($title, $word_maxlength, ' ');
						}
					}

					$item = new JoomlaTuneFeedItem();
					$item->title = ($title != '') ? $title : $author . ' ' . JText::_('Wrote');
					$item->link = $object_link . '#comment-' . $row->id;
					$item->description = $comment;
					$item->source = $object_link;

					if (JCOMMENTS_JVERSION == '1.5') {
						$item->pubDate = $row->date;
					} else {
						$date = strtotime($row->date) - $offset * 3600;
						$item->pubDate = date('Y-m-d H:i:s', $date);
					}

					$item->author = $author;
					$rss->addItem($item);
				}
			}

			$rss->display();

			unset($rows, $rss);
			exit();
		}
	}

	function feedLastCommentsGlobal()
	{
		global $mainframe;

		$object_group = trim(strip_tags(JCommentsInput::getVar('object_group', '')));
		$object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.]#is', '', $object_group);

		$limit = (int) JCommentsInput::getVar('limit', 100);

		$config = & JCommentsFactory::getConfig();

		if ($config->get('enable_rss') == '1') {

			$iso = explode('=', _ISO);
			$charset = strtolower((string) $iso[1]);

			if (JCOMMENTS_JVERSION == '1.5') {
				$offset = $mainframe->getCfg('offset');
			} else {
				$offset = $mainframe->getCfg('offset') + date( 'O' ) / 100;
			}

			$object_group = preg_replace('#[\'\"]#ism', '', $object_group);

			$og = $object_group ? ('&amp;object_group='.$object_group) : '';
			$lm = $limit <> 100 ? ('&amp;limit='.$limit) : '';

			if (JCOMMENTS_JVERSION == '1.5') {
				$syndicationURL = JoomlaTuneRoute::_('index.php?option=com_jcomments&amp;task=rss_full'.$og.$lm.'&amp;tmpl=component');
			} else {
				$syndicationURL = $mainframe->getCfg('live_site') . '/index2.php?option=com_jcomments&amp;task=rss_full'.$og.$lm.'&amp;no_html=1';
			}

			$rss = new JoomlaTuneFeed();
			$rss->setOffset($offset);
			$rss->encoding = $charset;
			$rss->title = JText::_('Comments');
			$rss->link = $mainframe->getCfg('live_site');
			$rss->syndicationURL = $syndicationURL;
			$rss->description = JText::_('COMMENTS_FOR') . ' ' . $mainframe->getCfg('sitename');

			if ($object_group != '') {
				$groups = explode(',', $object_group);
			} else {
				$groups = array();
			}

			$db = & JCommentsFactory::getDBO();

			$query = "SELECT id, title, object_id, object_group, userid, name, username, date, UNIX_TIMESTAMP(date) as date_ts, comment"
					. "\nFROM #__jcomments "
					. "\nWHERE published = '1'"
					. ((count($groups) > 0) ? "\n AND (object_group = '" . implode("' OR object_group='", $groups) . "')" : '')
					. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					. "\nORDER BY date DESC"
					;
			$db->setQuery($query, 0, $limit);
			$rows = $db->loadObjectList();

			$word_maxlength = $config->getInt('word_maxlength');
			$lang = JCommentsMultilingual::isEnabled() ? JCommentsMultilingual::getLanguage() : null;

			foreach ($rows as $row) {
				$comment = JCommentsText::cleanText($row->comment);
				$author = JComments::getCommentAuthorName($row);

				if ($comment != '') {
					$object_title = JCommentsObjectHelper::getTitle($row->object_id, $row->object_group, $lang);
					$object_link = JCommentsObjectHelper::getLink($row->object_id, $row->object_group);
					$object_link = str_replace('amp;', '', $object_link);
					$object_link = JCommentsFactory::getAbsLink($object_link);

					// apply censor filter
					$object_title = JCommentsText::censor($object_title);
					$comment = JCommentsText::censor($comment);

					// fix long words problem
					if ($word_maxlength > 0) {
						$comment = JCommentsText::fixLongWords($comment, $word_maxlength, ' ');
						if ($comment != '') {
							$comment = JCommentsText::fixLongWords($comment, $word_maxlength, ' ');
						}
					}

					$item = new JoomlaTuneFeedItem();
					$item->title = $object_title;
					$item->link = $object_link . '#comment-' . $row->id;
					$item->description = $author . ' ' . JText::_('Wrote') . ' &quot;' . $comment . '&quot;';
					$item->source = $object_link;
					
					if (JCOMMENTS_JVERSION == '1.5') {
						$item->pubDate = $row->date;
					} else {
						$date = strtotime((string) $row->date) - $offset * 3600;
						$item->pubDate = date('Y-m-d H:i:s', $date);
					}

					$item->author = $author;
					$rss->addItem($item);
				}
			}

			$rss->display();

			unset($rows, $rss);
			exit();
		}
	}
}
?>