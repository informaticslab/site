<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Controllers
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.controller');

class SuggestionsControllerlog extends JController
{
	var $cid;

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'unpublish', 	'publish');

		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}
	function _buildQuery()
	{
		$this->_query = 'UPDATE #__suggestvotecommentbribe_log'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'
		;
		return $this->_query;
	}
	/*	function edit()
	 {
		JRequest::setVar( 'view', 'log' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
		}
		*/
	function cancel()
	{
		$msg = JText::_( 'OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=logs', $msg );
	}
	function publish()
	{
		$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
		$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );

		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)
		{
			$action = $publish ? 'publish' : 'unpublish';
			JError::raiseError(500, JText::_( 'SELECT_AN_ITEM_TO' .$action, true ) );
		}

		$this->cids = implode( ',', $cid );

		$query = $this->_buildQuery();
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_suggestvotecommentbribe&view=logs';
		$this->setRedirect($link, $msg);
	}

	function save()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		#_ECR_SMAT_DESCRIPTION_CONTROLLER1_
		$post['id'] 	= (int) $cid[0];

		$model = $this->getModel( 'log' );
		if ($model->store($post)) {
			$msg = JText::_( 'ITEM_SAVED' );
		} else {
			$msg = JText::_( 'ERROR_SAVING_ITEM' );
		}

		$link = 'index.php?option=com_suggestvotecommentbribe&view=logs';
		$this->setRedirect( $link, $msg );
	}

	function remove()
	{
		$model = $this->getModel('log');
		if(!$model->delete()) {
			$msg = JText::_( 'ERROR_DELETING_ITEM' );
		} else {
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
			foreach($cids as $cid) {
				$msg .= JText::_( 'ITEM_DELETED'.' : '.$cid );
			}
		}

		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=logs', $msg );
	}


}
