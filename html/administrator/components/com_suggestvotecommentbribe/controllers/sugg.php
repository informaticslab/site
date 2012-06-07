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
class SuggestionsControllersugg extends JController
{
	var $cid;

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  ,    'edit' );
		$this->registerTask( 'unpublish',   'publish');
		$this->registerTask( 'Open',   'Close');

		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}
	function _buildQuery()
	{
		$this->_query = 'UPDATE #__suggestvotecommentbribe_sugg'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'
		;
		return $this->_query;
	}
	function edit()
	{
		JRequest::setVar( 'view', 'sugg' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}

	function cancel()
	{
		$msg = JText::_( 'OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs', $msg );
	}
	function publish()
	{
		$cid     = JRequest::getVar( 'cid', array(), '', 'array' );
		$this->publish = ( $this->getTask() == 'publish' ? 1 : 0 );

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
		$user =& JFactory::getUser();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$this->cids;
		if($user->id)
		{
		$post1['description']=$user->get('name');
		}
		else
		{
			$post1['description']=JText::_( 'ANONYMOUS' );
		}
		$post1['description'].=' has ';
		$post1['description'].=$this->getTask().'ed';
		$post1['description'].=' a suggestion at '.date(DATE_RFC822);
		$model1->store($post1);
		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs';
		$this->setRedirect($link, $msg);
	}



	function Close()
	{
		$cid     = JRequest::getVar( 'cid', array(), '', 'array' );
		$this->state= ( $this->getTask() == 'Open' ? 0 : 1 );

		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)
		{
			$action = $state? 'Open' : 'Close';
			JError::raiseError(500, JText::_( 'SELECT_AN_ITEM_TO' .$action, true ) );
		}

		$this->cids = implode( ',', $cid );
		$query='UPDATE #__suggestvotecommentbribe_sugg'
		. ' SET state= ' . (int) $this->state
		. ' WHERE id IN ( '. $this->cids .' )'
		;
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$user =& JFactory::getUser();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$this->cids;
		if($user->id)
		{
			$post1['description']=$user->get('name');
		}
		else
		{
		   $post1['description']='Anonymous';
		}
		$post1['description'].=' has ';
		$post1['description'].=$this->getTask()!='Open'?'opened':'closed';
		$post1['description'].=' a suggestion at '.date(DATE_RFC822);
		$model1->store($post1);
		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs';
		$this->setRedirect($link, $msg);
	}

	function save()
	{
		$post = JRequest::get('post');
		$cid  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		#_ECR_SMAT_DESCRIPTION_CONTROLLER1_
		$post['id']    = (int) $cid[0];
		if($_POST['title']=='')
		{
			$t=time();
			$link = 'index.php?option=com_suggestvotecommentbribe&controller=sugg&task=edit&ses=s'.$t;
			$_SESSION['s'.$t]=$_POST['description'];
			$this->setRedirect( $link, 'title is required');
			return;
		}
		$db = &JFactory::getDBO();
/*		$db->setQuery('select * from #__suggestvotecommentbribe');
		$settings=$db->loadObjectlist();*/
		$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$setting = new stdClass();
		$setting->URL 			= $params->get("URL","");
		$setting->email 		= $params->get("email","");
		$setting->pubk 		= $params->get("pubk","");
		$setting->prvk 		= $params->get("prvk","");
		$setting->max_title 	= $params->get("max_title","");
		$setting->max_desc 	= $params->get("max_desc","");
		$settings[] = $setting;
		$post['title']=substr($_POST['title'], 0,$settings[0]->max_title);
		$post['description']=substr($_POST['description'], 0,$settings[0]->max_desc);
		$post['title']=(htmlspecialchars($post['title'],ENT_NOQUOTES));
		$post['description']=((htmlspecialchars($post['description'],ENT_NOQUOTES)));
		$post['title']=str_replace("\\\\", "\\", $post['title']);
		$post['title']=str_replace("\\\"", "\"", $post['title']);
		$post['title']=str_replace("\\'", "'", $post['title']);
		$post['description']=str_replace("\\\\", "\\", $post['description']);
		$post['description']=str_replace("\\\"", "\"", $post['description']);
		$post['description']=str_replace("\\'", "'", $post['description']);
		$post['title']=str_replace(" ", '&nbsp;', $post['title']);
		$post['description']=nl2br(str_replace(" ", '&nbsp;', $post['description']));
		$model = $this->getModel( 'sugg' );
		if ($model->store($post)) {
			$msg = JText::_( 'Item Saved' );
			$user =& JFactory::getUser();
			$model1 = $this->getModel( 'log' );
			//         $post['title']=htmlentities($post['title'],ENT_NOQUOTES);
			//         $post['description']=nl2br(htmlentities($post['description'],ENT_NOQUOTES));
			if($post[id]==0)
			{
				$CID=mysql_insert_id();
			}
			else
			{
				$CID=$post[id];
			}
			$post1['title']=$CID;
			if($post[id]==0)
			{
				$posted='posted';
			}
			else
			{
				$posted='edited';
			}
			if($user->id)
			{
				$post1['description']=$user->get('name');
			}
			else
			{
				$post1['description']=JText::_( 'ANONYMOUS' );
			}
			$post1['description'].=' has '.$posted.' a suggestion at '.date(DATE_RFC822);
			$model1->store($post1);

		} else {
			$msg = JText::_( 'Error Saving Item' );
		}

		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs';
		$this->setRedirect( $link, $msg );
	}

	function remove()
	{
		$model = $this->getModel('sugg');
		if(!$model->delete()) {
			$msg = JText::_( 'Error Deleting Item' );
		}
		else
		{
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
			$model1 = $this->getModel( 'log' );
			$post1['title']=$cids[0];
			$user =& JFactory::getUser();
			foreach($cids as $cid) {
				if($user->id)
				{
					$post1['description']=$user->get('name');
				}
				else
				{
					$post1['description']='Anonymous';
				}
				$post1['description'].=' has removed a suggestion at '.date(DATE_RFC822);
				$model1->store($post1);

				$msg .= JText::_( 'ITEM_DELETED'.': '.$cid.'<br />' );
			}
		}

		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs', $msg );
	}
}
