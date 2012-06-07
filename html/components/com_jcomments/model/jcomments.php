<?php
/**
 * JComments - Joomla Comment System
 *
 * JComments model
 *
 * @version 2.2
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

class JCommentsModel
{
	/**
	 * Returns a comments count for given object
	 *
	 * @static
	 * @access public
	 * @param int $object_id
	 * @param string $object_group
	 * @param string $filter
	 * @return int
	 */
	function getCommentsCount( $object_id, $object_group = 'com_content', $filter = '' )
	{
		static $cache = array();
		
		$object_id = (int) $object_id;
		$object_group = trim($object_group);
		
		$key = md5($object_id . $object_group . $filter);
		if (!isset($cache[$key])) {
			$acl = & JCommentsFactory::getACL();
			$db = & JCommentsFactory::getDBO();

			$query = "SELECT count(*) "
				."\nFROM #__jcomments "
				."\nWHERE object_id = ".$object_id
				."\nAND object_group = '".$db->getEscaped($object_group)."'"
				.(($acl->canPublish() == 0) ? "\nAND published = 1" : "")
				.(JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
				."\n".$filter
				;
			$db->setQuery($query);
			$cache[$key] = (int) $db->loadResult();
		}
		return $cache[$key];
	}

	function getCommentsList( $object_id, $object_group = 'com_content', $limitStart = 0, $limit = 0 )
	{
		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$options['object_id'] = (int) $object_id;
		$options['object_group'] = trim($object_group);
		$options['published'] = $acl->canPublish() ? null : 1;
		$options['orderBy'] = ($config->get('template_view') == 'tree') ? 'c.parent, c.date ASC' : ('c.date ' . $config->get('comments_order'));
		$options['limit'] = $limit;
		$options['limitStart'] = $limitStart;

		$db->setQuery(JCommentsModel::_getCommentsQuery($options));
		$rows = $db->loadObjectList();

		return $rows;
	}

	function getLastComment( $object_id, $object_group = 'com_content', $parent = 0 )
	{
		$comment = null;

		$db = & JCommentsFactory::getDBO();

		$options['object_id'] = (int) $object_id;
		$options['object_group'] = trim($object_group);
		$options['parent'] = (int) $parent;
		$options['published'] = 1;
		$options['orderBy'] = 'c.date DESC';
		$options['limit'] = 1;
		$options['limitStart'] = 0;

		$db->setQuery(JCommentsModel::_getCommentsQuery($options));
		$rows = $db->loadObjectList();
		if (count($rows)) {
			$comment = $rows[0];
		}

		return $comment;
	}

	function _getCommentsQuery(&$options)
	{
		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();

		$object_id = @$options['object_id'];
		$object_group = @$options['object_group'];
		$parent = @$options['parent'];
		$published = @$options['published'];

		$orderBy = @$options['orderBy'];
		$limitStart = @$options['limitStart'];
		$limit = @$options['limit'];

		$where = array();

		if ($object_id) {
			$where[] = "c.object_id = " . $object_id;
		}

		if ($object_group != '') {
			$where[] = "c.object_group = '".$db->getEscaped($object_group)."'";
		}

		if ($parent !== null) {
			$where[] = "c.parent = " . $parent;
		}

		if ($published !== null) {
			$where[] = "c.published = " . $published;
		}

		if (JCommentsMultilingual::isEnabled()) {
			$where[] = "c.lang = '" . JCommentsMultilingual::getLanguage() . "'";
		}

		$query = "SELECT c.id, c.parent, c.object_id, c.object_group, c.userid, c.name, c.username, c.title, c.comment"
			. "\n, c.email, c.homepage, c.date as datetime, c.ip, c.published, c.checked_out, c.checked_out_time"
			. "\n, c.isgood, c.ispoor"
			. "\n, v.value as voted"
			. "\n, case when c.userid = 0 then 'guest' else replace(lower(u.usertype), ' ', '-') end as usertype"
			. "\nFROM #__jcomments AS c"
			. "\nLEFT JOIN #__jcomments_votes AS v ON c.id = v.commentid " . ($acl->getUserId() ? " AND  v.userid = ".$acl->getUserId() : " AND v.userid = 0 AND v.ip = '".$acl->getUserIP()."'")
			. "\nLEFT JOIN #__users AS u ON c.userid = u.id"
			. (count($where) ? ("\nWHERE " . implode(' AND ', $where)) : "" )
			. "\nORDER BY " . $orderBy
			. (($limit > 0) ? "\nLIMIT $limitStart, $limit" : "")
			;

		return $query;
	}

	/**
	 * Delete all comments for given ids
	 *
	 * @static
	 * @access public 
	 * @param  $ids Array of comments ids
	 * @return void
	 */
	function deleteCommentsByIds( $ids )
	{
		if (is_array($ids)) {
			if (count($ids)) {
				$db = & JCommentsFactory::getDBO();
				$db->setQuery("SELECT DISTINCT object_group, object_id FROM #__jcomments WHERE parent IN (" . implode(',', $ids) . ")");
				$objects = $db->loadObjectList();
			
				if (count($objects)) {
					require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'tree.php');

					$descendants = array();

					foreach($objects as $o) {
						$query = "SELECT id, parent" 
							. "\nFROM #__jcomments" 
							. "\nWHERE `object_group` = '" . $o->object_group . "'"
							. "\nAND `object_id`='" . $o->object_id . "'"
							;
						$db->setQuery($query);
						$comments = $db->loadObjectList();

						$tree = new JoomlaTuneTree($comments);

						foreach ($ids as $id) {
							$descendants = array_merge($descendants, $tree->descendants((int) $id));
						}
						unset($tree);
						$descendants = array_unique($descendants);
					}
					$ids = array_merge($ids, $descendants);
				}
				unset($descendants);

				$ids = implode(',', $ids);

				$db->setQuery("DELETE FROM #__jcomments WHERE id IN (". $ids . ")");
				$db->query();

				$db->setQuery("DELETE FROM #__jcomments_votes WHERE commentid IN (". $ids . ")");
				$db->query();

				$db->setQuery("DELETE FROM #__jcomments_reports WHERE commentid IN (". $ids . ")");
				$db->query();
			}
		}
	}

	function deleteComments( $object_id, $object_group = 'com_content' )
	{
		$object_group = trim($object_group);
		$oids = is_array($object_id) ? $object_id : array($object_id);
		$oids = implode(',', $oids);

		$db = & JCommentsFactory::getDBO();
		$query = "SELECT id FROM #__jcomments "
			. "\n WHERE object_group = '".$db->getEscaped($object_group)."'"
			. "\n AND object_id IN (". $oids . ")"
			;
		$db->setQuery($query);
		$cids = $db->loadResultArray();

		JCommentsModel::deleteCommentsByIds($cids);

		return true;
	}
}
?>