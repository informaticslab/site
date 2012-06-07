<?php
/**
 * JComments - Joomla Comment System
 *
 * Frontend event handler
 *
 * @version 2.1
 * @package JComments
 * @subpackage Subscription
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

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

/**
 * JComments subscriptions table
 *
 */
class JCommentsSubscriptionsDB extends JoomlaTuneDBTable
{
	/** @var int Primary key */
	var $id = null;
	/** @var int */
	var $object_id = null;
	/** @var string */
	var $object_group = null;
	/** @var string */
	var $lang = null;
	/** @var int */
	var $userid = null;
	/** @var string */
	var $name = null;
	/** @var string */
	var $email = null;
	/** @var string */
	var $hash = null;
	/** @var boolean */
	var $published = null;

	/**
	* @param database A database connector object
	* @access public
	* @return void
	*/
	function JCommentsSubscriptionsDB( &$db ) {
		$this->JoomlaTuneDBTable('#__jcomments_subscriptions', 'id', $db);
	}
}

class JCommentsSubscriptionManager
{
	/**
	 * An array of errors
	 *
	 * @var	array of error messages
	 * @access	protected
	 */
	var $_errors = null;

	function JCommentsSubscriptionManager()
	{
		$this->_errors = array();
	}

	/**
	 * Returns a reference to a subscription manager object,
	 * only creating it if it doesn't already exist.
	 *
	 * @static
	 * @access public
	 * @return JCommentsSubscriptionManager	A JCommentsSubscriptionManager object
	 */
	function &getInstance()
	{
		static $instance = null;

		if (!is_object($instance)) {
			$instance = new JCommentsSubscriptionManager();
		}
		return $instance;
	}

	/**
	 * Return hash value for given params
	 *
	 * @access public
	 * @param int $object_id	The object identifier
	 * @param string $object_group	The object group (component name)
	 * @param int $userid	The registered user identifier
	 * @param string $email	The user email (for guests only)
	 * @param string $lang The user name (for guests only)
	 * @return string The hash for given params.
	 */
	function getHash($object_id, $object_group, $userid, $email = '', $lang = '')
	{
		if ($userid != 0 && $email == '') {
			$user = JCommentsFactory::getUser($userid);
			$email = $user->email;
			unset($user);
		}

		if ($lang == '') {
			$lang = JCommentsMultilingual::getLanguage();
		}

		return md5($object_id . $object_group . $userid . $email . $lang);
	}

	/**
	 * Subscribes user for new comments notifications for an object
	 *
	 * @param int $object_id	The object identifier
	 * @param string $object_group	The object group (component name)
	 * @param int $userid	The registered user identifier
	 * @param string $email	The user email (for guests only)
	 * @param string $name The user name (for guests only)
	 * @return boolean True on success, false otherwise.
	 */
	function subscribe($object_id, $object_group, $userid, $email = '', $name = '', $lang = '')
	{
		$object_id = (int) $object_id;
		$object_group = trim($object_group);
		$userid = (int) $userid;

		if ($lang == '') {
			$lang = JCommentsMultilingual::getLanguage();
		}

		$dbo = & JCommentsFactory::getDBO();

		if ($userid != 0) {
			$user = JCommentsFactory::getUser($userid);
			$name = $user->name;
			$email = $user->email;
			unset($user);
		}

		$query = "SELECT * "
			."\nFROM #__jcomments_subscriptions"
			."\nWHERE object_id = " . (int) $object_id
			."\nAND object_group = '" . $dbo->getEscaped($object_group) . "'"
			."\nAND email = '" . $dbo->getEscaped($email) . "'"
			.(JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . $lang . "'" : "")
			;

		$dbo->setQuery($query);
		$rows = $dbo->loadObjectList();

		if (count($rows) == 0) {
			$subscription = new JCommentsSubscriptionsDB($dbo);
			$subscription->object_id = $object_id;
			$subscription->object_group = $object_group;
			$subscription->name = $name;
			$subscription->email = $email;
			$subscription->userid = $userid;
			$subscription->hash = JCommentsSubscriptionManager::getHash($object_id, $object_group, $userid, $email, $lang);
			$subscription->lang = $lang;
			$subscription->published = 1;
			$subscription->store();

			return true;
		} else {
			// if current user is registered, but already exists subscription
			// on same email by guest - update subscription data
			if ($userid > 0 && $rows[0]->userid == 0) {
				$subscription = new JCommentsSubscriptionsDB($dbo);
				$subscription->id = $rows[0]->id;
				$subscription->userid = $userid;
				$subscription->lang = $lang;
				$subscription->hash = JCommentsSubscriptionManager::getHash($object_id, $object_group, $userid, $email, $lang);
				$subscription->store();
	
				return true;
			} else {
				$this->_errors[] = JText::_('Already subscribed');
			}
		}

		return false;
	}

	/**
	 * Unsubscribe guest from new comments notifications by subscription hash
	 *
	 * @param string $hash	The secret hash value of subscription
	 * @return boolean True on success, false otherwise.
	 */
	function unsubscribeByHash($hash)
	{
		if (!empty($hash)) {
			$dbo = & JCommentsFactory::getDBO();
			$dbo->setQuery("DELETE FROM #__jcomments_subscriptions WHERE `hash`='" . $hash . "'");
			$dbo->query();
			return true;
		}
		return false;
	}

	/**
	 * Unsubscribe registered user from new comments notifications for an object
	 *
	 * @param int $object_id	The object identifier
	 * @param string $object_group	The object group (component name)
	 * @param int $userid	The registered user identifier
	 * @return boolean True on success, false otherwise.
	 */
	function unsubscribe($object_id, $object_group, $userid)
	{
		if ($userid != 0) {
			$dbo = & JCommentsFactory::getDBO();

			$query = "DELETE"
					. "\n FROM #__jcomments_subscriptions"
					. "\n WHERE object_id = " . (int) $object_id
					. "\n AND object_group = '" . $dbo->getEscaped($object_group) . "'"
					. "\n AND userid = " . (int) $userid
					.(JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
					;

			$dbo->setQuery($query);
			$dbo->query();
			return true;
		}
		return false;
	}

	/**
	 * Checks if given user is subscribed to new comments notifications for an object
	 *
	 * @param int $object_id	The object identifier
	 * @param string $object_group	The object group (component name)
	 * @param int $userid	The registered user identifier
	 * @param string $email	The user email (for guests only)
	 * @return int
	 */
	function isSubscribed( $object_id, $object_group, $userid, $email = '', $lang = '')
	{
		static $cache = null;

		if (isset($cache[$object_id . $object_group . $userid . $email])) {
			return $cache[$object_id . $object_group . $userid . $email];
		}

		$dbo = & JCommentsFactory::getDBO();

		if ($lang == '') {
			$lang = JCommentsMultilingual::getLanguage();
		}

		$query = "SELECT COUNT(*) "
				."\n FROM #__jcomments_subscriptions"
				."\n WHERE object_id = " . (int) $object_id
				."\n AND object_group = '" . $dbo->getEscaped($object_group) . "'"
				."\n AND userid = " . (int) $userid
				.(($userid == 0) ? "\n AND email = '" . $dbo->getEscaped($email) . "'" : '')
				.(JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . $lang . "'" : "")
				;
		$dbo->setQuery($query);
		$cnt = $dbo->loadResult();

		$cache[$object_id . $object_group . $userid . $email] =  (int) $cnt > 0;

		return ($cnt > 0 ? 1 : 0);
	}

	/**
	 * Return an array of errors messages
	 *
	 * @return Array The array of error messages
	 */
	function getErrors()
	{
		return $this->_errors;
	}
}
?>