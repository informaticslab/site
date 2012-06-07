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

class SuggestionsControllercomment extends JController
{
	var $cid;

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  ,    'edit' );
		$this->registerTask( 'unpublish',   'publish');

		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}
	function _buildQuery()
	{
		$this->_query = 'UPDATE #__suggestvotecommentbribe_comment'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'
		;
		return $this->_query;
	}
	function edit()
	{
		JRequest::setVar( 'view', 'comment' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}

	function cancel()
	{
		$msg = JText::_( 'OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=comments', $msg );
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
		$model=$this->getModel( 'comment' );
		$comm=$model->getdata();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$comm->SID;
		if($user->id){
			$post1['description']=$user->get('name');
		}
		else
		{
			$post1['description']=JText::_( 'ANONYMOUS' );
		}
		$post1['description'].=JText::_('HAS');
		$post1['description'].=$this->getTask().'ed';
		$post1['description'].=JText::_('A COMMENT AT').date(DATE_RFC822);
		$model1->store($post1);
		for($i=0;$i<count($this->cid);$i++)
		{
			$db->setQuery('update #__suggestvotecommentbribe_sugg set noofComs=(select count(*) from #__suggestvotecommentbribe_comment where published=1 and SID='.$comm->SID.') where id='.$comm->SID);
			$db->query();
		}
		$link = 'index.php?option=com_suggestvotecommentbribe&view=comments';
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
			$link = 'index.php?option=com_suggestvotecommentbribe&controller=comment&task=edit&cid[]='.$post['id'].'&ses=s'.$t;
			$this->setRedirect( $link, 'title is required');
			$_SESSION['s'.$t]=$_POST['description'];
			return;
		}
		if(!$post['SID'])
		{
			$link = 'index.php?option=com_suggestvotecommentbribe&view=comments';
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
$settings = array($setting);

		$post['title']=substr($_POST['title'], 0,$settings[0]->max_title);
		$post['description']=substr($_POST['description'], 0,$settings[0]->max_desc);
		$post['title']=(htmlentities($post['title'],ENT_NOQUOTES));
		$post['description']=((htmlentities($post['description'],ENT_NOQUOTES)));
		$post['title']=str_replace("\\\\", "\\", $post['title']);
		$post['title']=str_replace("\\\"", "\"", $post['title']);
		$post['title']=str_replace("\\'", "'", $post['title']);
		$post['description']=str_replace("\\\\", "\\", $post['description']);
		$post['description']=str_replace("\\\"", "\"", $post['description']);
		$post['description']=str_replace("\\'", "'", $post['description']);
		$post['title']=str_replace(" ", "&nbsp;", $post['title']);
		$post['description']=nl2br(str_replace(" ", "&nbsp;", $post['description']));
		$model = $this->getModel( 'comment' );
		if ($model->store($post)) {
			$msg = JText::_( 'ITEM_SAVED' );
			$model1 = $this->getModel( 'sugg' );
			$user =& JFactory::getUser();
			JRequest::setVar('cid',array($post['SID']));
			$sugg=$model1->getData();

			$model1 = $this->getModel( 'log' );
			$post1['title']=$post['SID'];
			if($user->id)
			$post1['description']=$user->get('name');
			else $post1['description']=JText::_( 'ANONYMOUS' );
			$post1['description'].=' has modified a comment on '.$sugg->title.' at '.date(DATE_RFC822);
			$model1->store($post1);
		} else {
			$msg = JText::_( 'ERROR_SAVING_ITEM' );
		}
		$db = &JFactory::getDBO();
		$db->setQuery('update #__suggestvotecommentbribe_sugg set noofComs=(select count(*) from #__suggestvotecommentbribe_comment where published=1 and SID='.$post['SID'].') where id='.$post['SID']);
		$db->query();
		$link = 'index.php?option=com_suggestvotecommentbribe&view=comments';
		$this->setRedirect( $link, $msg );
	}

	function remove()
	{
		$model = $this->getModel('comment');
		$comm=$model->getData();
		if(!$model->delete()) {
			$msg = JText::_( 'ERROR_DELETING_ITEM' );
		} else {
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
			$model1 = $this->getModel( 'log' );
			$post1['title']=$comm->SID;
			$user =& JFactory::getUser();
			foreach($cids as $cid) {
				if($user->id){
					$post1['description']=$user->get('name');
				}
				else
				{
					$post1['description']=JText::_( 'ANONYMOUS' );
				}
				$post1['description'].=' has removed a comment at '.date(DATE_RFC822);
				$model1->store($post1);
				$msg .= JText::_( 'Item Deleted '.' : '.$cid );
			}
		}
		$db = &JFactory::getDBO();
		for($i=0;$i<count($cids);$i++)
		{
			$db->setQuery('update #__suggestvotecommentbribe_sugg set noofComs=(select count(*) from #__suggestvotecommentbribe_comment where published=1 and SID='.$comm->SID.') where id='.$comm->SID);
			$db->query();
		}
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=comments', $msg );
	}


}
