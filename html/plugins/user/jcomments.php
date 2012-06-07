<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgUserJComments extends JPlugin
{
	function plgUserJComments(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterStoreUser($user, $isNew, $success, $msg)
	{
		if ($success && !$isNew) {
			$userId = intval($user['id']);

			if ($userId != 0 && trim($user['username']) != '' && trim($user['email']) != '') {
				$db = & JFactory::getDBO();

				// update name, username and email in comments
				$query = "UPDATE #__jcomments"
					. "\nSET name = " . $db->Quote($user['name'])
					. "\n, username = " . $db->Quote($user['username'])
					. "\n, email = " . $db->Quote($user['email'])
					. "\nWHERE userid = " . $userId
					;

				$db->setQuery($query);
				$db->query();

				// update email in subscriptions
				$query = "UPDATE #__jcomments_subscriptions"
					. "\nSET email = " . $db->Quote($user['email'])
					. "\nWHERE userid = " . $userId
					;

				$db->setQuery($query);
				$db->query();
			}
		}
	}

	function onAfterDeleteUser($user, $success, $msg)
	{
		if (!$success) {
			return false;
		}

		if (intval($user['id']) != 0) {
			$db =& JFactory::getDBO();
			$db->setQuery('DELETE FROM #__jcomments_subscriptions WHERE userid = '.$db->Quote($user['id']));
			$db->query();

			$db->setQuery('DELETE FROM #__jcomments_votes WHERE userid = '.$db->Quote($user['id']));
			$db->query();
		}
		return true;
	}
}