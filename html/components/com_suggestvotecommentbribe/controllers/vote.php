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

class SuggestionControllervote extends JController
{
	var $cid;

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  ,    'edit' );

		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}

	function edit()
	{
		$model = $this->getModel( 'security' );
		$can=$model->canVote(JRequest::getVar('CID'),array(JRequest::getVar('SID')));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		JRequest::setVar( 'view', 'vote' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}
	function save()
	{
		$post = JRequest::get('post');
		$cid  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		#_ECR_SMAT_DESCRIPTION_CONTROLLER1_
		$post['id']    = (int) $cid[0];
		$SID=JRequest::getVar('SID');
		$model = $this->getModel( 'security' );
		$can=$model->canVote($cid,array($post['SID']));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
		 return;
		}
		$user =& JFactory::getUser();
		$db = &JFactory::getDBO();
		$params 	= &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		$settings->max_title 	= $params->get('max_title',100);
		$settings->pubk 		= $params->get('pubk');
		$settings->prvk 		= $params->get('prvk');
		$settings->max_desc 	= $params->get('max_desc');
		$settings->email 		= $params->get('email');
		$settings->URL 			= $params->get('URL');
		
		$captcha[]=$settings;
		if($captcha[0]->captcha&&!$user->id) {
			include(JPATH_ROOT."/components/com_suggestvotecommentbribe/recaptchalib.php");
			$resp = recaptcha_check_answer ($captcha[0]->prvk,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);

			if (!$resp->is_valid)
			{
				$link = 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[0]='.$SID.'&Itemid='.JRequest::getVar('Itemid');
				$this->setRedirect( $link, 'You entered a wrong captcha');
				return;
			}
		}
		$post['UID']=$user->id;
		$post['published']=1;
		$model = $this->getModel( 'vote' );
		if ($model->store($post)) {
			$msg = JText::_( 'Item Saved' );
			$post2['type']='vote';
			$post2['VID']=$SID;
			$model = $this->getModel( 'security' );
			$model->store($post2);
		} else {
			$msg = JText::_( 'Error Saving Item' );
		}

		$db->setQuery('update #__suggestvotecommentbribe_sugg set noofVotes=(select count(*) from #__suggestvotecommentbribe_vote where SID='.$SID.' and published=1) where id='.$SID);
		$db->query();
		$model1 = $this->getModel( 'sugg' );
		JRequest::setVar('cid',array($SID));
		$sugg=$model1->getData();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$SID;
		if($user->id)
		{
				
			$post1['description']=$user->name;
		}
		else
		{
			$post1['description']=JText::_( 'ANONYMOUS' );
		}
		$post1['description'].=' has voted for '.$sugg->title.' at '.date(DATE_RFC822);
		$model1->store($post1);

		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid');
		$this->setRedirect( $link, $msg );
	}

	function remove()
	{
		$post = JRequest::get('post');
		$model = $this->getModel( 'security' );
		$user =& JFactory::getUser();
		$SID=$post['SID'];
		$can=$model->canVote($post['cid'],array($SID));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
		 return;
		}
		$model = $this->getModel('vote');
		if(!$model->delete()) {
			$msg = JText::_( 'Error Deleting Item' );
		} else {
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
			$model1 = $this->getModel( 'sugg' );
			JRequest::setVar('cid',array($SID));
			$sugg=$model1->getData();
			foreach($cids as $cid) {
				$model1 = $this->getModel( 'log' );
				$post1['title']=$SID;
				if($user->id)
				{
					$post1['description']=$user->name;
				}
				else
				{
					$post1['description']='Anonymous';
				}
				$post1['description'].=' has removed his vote for '.$sugg->title.' at '.date(DATE_RFC822);
				$model1->store($post1);
				$msg = JText::_( 'Vote removed' );
			}
		}
		$db = &JFactory::getDBO();
		$db->setQuery('update #__suggestvotecommentbribe_sugg set noofVotes=(select count(*) from #__suggestvotecommentbribe_vote where SID='.$SID.' and published=1) where id='.$SID);
		$db->query();
		if($user->id)
		{
			$db->setQuery('delete from #__suggestvotecommentbribe_security where UID='.$user->id.' and action="vote'.$SID.'"');
		}
		else
		{
			$db->setQuery('delete from #__suggestvotecommentbribe_security where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" and action="vote'.$SID.'"');
		}
		$db->query();
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[0]='.$SID.'&Itemid='.JRequest::getVar('Itemid'), $msg );
	}
}
