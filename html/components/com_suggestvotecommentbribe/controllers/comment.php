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

class SuggestionControllercomment extends JController
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
		$user=JFactory::getUser();
		$this->_query = 'UPDATE #__suggestvotecommentbribe_comment'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .')  '
		;
		return $this->_query;
	}
	function edit()
	{
		$model = $this->getModel( 'security' );
		$can=$model->canComment(JRequest::getVar('cid'),JRequest::getVar('SID'));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		JRequest::setVar( 'view', 'comment' );
		JRequest::setVar( 'layout', 'form'  );
		parent::display();
	}

	function publish()
	{
		$cid     = JRequest::getVar( 'cid', array(), '', 'array' );
		$sid     = JRequest::getVar( 'SID' );
		$this->publish = ( $this->getTask() == 'publish' ? 1 : 0 );

		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)
		{
			$action = $publish ? 'publish' : 'unpublish';
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$model = $this->getModel( 'security' );
		$can=$model->canComment(JRequest::getVar('cid'),JRequest::getVar('SID'));
		if($can!==true&&!$_COOKIE['comment'.$cid[0]])
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		$this->cids = implode( ',', $cid );

		$query = $this->_buildQuery();
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		for($i=0;$i<count($this->cid);$i++)
		{
			$db->setQuery('update #__suggestvotecommentbribe_sugg set noofComs=(select count(*) from #__suggestvotecommentbribe_comment where published=1 and SID=(select SID from #__suggestvotecommentbribe_comment where id='.$this->cid[$i].')) where id=(select SID from #__suggestvotecommentbribe_comment where id='.$this->cid[$i].')');
			$db->query();
		}
		$user =& JFactory::getUser();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$sid;
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
		$post1['description'].=' a comment at '.date(DATE_RFC822);
		$model1->store($post1);

		$link = 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[0]='.$sid.'&Itemid='.JRequest::getVar('Itemid');
		$this->setRedirect($link, '');
	}

	function save()
	{
		$post = JRequest::get('post');
		$cid  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		#_ECR_SMAT_DESCRIPTION_CONTROLLER1_
		$post['id'] = (int) $cid[0];
		$model_sec 	= $this->getModel( 'security' );
		$user 		=JFactory::getUser();
		$can		=$model_sec->canComment(JRequest::getVar('cid'),JRequest::getVar('SID'));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		$params 	= &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		$max_title 	= $params->get('max_title',100);
		$captcha 	= $params->get('captcha');
		$prvk 		= $params->get('prvk');
		$max_desc 	= $params->get('max_desc');
		
		$URL 		= $params->get("URL","");
		$email 		= $params->get("email","");
		$pubk 		= $params->get("pubk","");
		
		$useracces 	= $params->get("useraccess","");
//		echo $useracces;
		$recaptchatheme = $params->get("recaptchatheme","");
		$recaptchalng 	= $params->get("recaptchalng","");
		$db 			= &JFactory::getDBO();

/*
		$db->setQuery('select * from #__suggestvotecommentbribe');
		$captcha=$db->loadObjectlist();
*/
#		if($captcha[0]->captcha&&!$user->id)
		if( ($useracces =='guests_enter_captcha'&& !$user->id )||$useracces =='everyone_enters_captcha' ){		
			include(JPATH_ROOT."/components/com_suggestvotecommentbribe/recaptchalib.php");
			$resp = recaptcha_check_answer ($prvk,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);

			if (!$resp->is_valid)
			{
				$link = 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[0]='.$post['SID'].'&Itemid='.JRequest::getVar('Itemid');
				$this->setRedirect( $link, 'You entered a wrong CAPTCHA');
				return;
			}
		}
		$post['title']=substr($_POST['title'], 0,$max_title);
		$post['description']=substr($_POST['description'], 0,$max_desc);
		$post['title']=(htmlentities($post['title'],ENT_NOQUOTES));
		$post['description']=((htmlentities($post['description'],ENT_NOQUOTES)));
		$post['title']=str_replace("\\\\", "\\", $post['title']);
		$post['title']=str_replace("\\\"", "\"", $post['title']);
		$post['title']=str_replace("\\'", "'", $post['title']);
		$post['description']=str_replace("\\\\", "\\", $post['description']);
		$post['description']=str_replace("\\\"", "\"", $post['description']);
		$post['description']=str_replace("\\'", "'", $post['description']);
		$post['title']=str_replace(' ','&nbsp;',$post['title']);
		$post['description']=nl2br(str_replace(' ','&nbsp;',$post['description']));
		$post['UID']=$user->id;

		if($post['title']=='')
		{
			$t=time();
			$link = 'index.php?option=com_suggestvotecommentbribe&controller=comment&task=edit&SID='.$post['SID'].'&ses=s'.$t.'&Itemid='.JRequest::getVar('Itemid');
			$this->setRedirect( $link, 'title is required');
			$_SESSION['s'.$t]=$_POST['description'];
			return;
		}
		$model = $this->getModel( 'comment' );
		$can=$model_sec->canComment(JRequest::getVar('cid'),JRequest::getVar('SID'));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		
		if ($model->store($post)) {
			$msg = JText::_( 'Item Saved' );
			if(!$user->id)
			{
				$post['title']=htmlentities($post['title'],ENT_NOQUOTES);
				$post['description']=nl2br(htmlentities($post['description'],ENT_NOQUOTES));
				$db->setQuery("select max(id) as id from #__suggestvotecommentbribe_comment where SID=$post[SID]");
				$CID=$db->loadObjectlist();
				setcookie('comment'.$CID[0]->id,1);
			}
			$model1 = $this->getModel( 'sugg' );
			JRequest::setVar('cid',array($post['SID']));
			$sugg=$model1->getData();

			$model1 = $this->getModel( 'log' );
			$post1['title']=$post['SID'];
			if($user->id)
			{
				$post1['description']=$user->name;
			}
			else
			{
				$post1['description']=JText::_( 'ANONYMOUS' );
			}
			$post1['description'].=' has commented on '.$sugg->title.' at '.date(DATE_RFC822);
			$model1->store($post1);
			$post2['type']='comment';
			$model = $this->getModel( 'security' );
			$model->store($post2);
		} else {
			$msg = JText::_( 'Error Saving Item' );
		}
		$db->setQuery('update #__suggestvotecommentbribe_sugg set noofComs=(select count(*) from #__suggestvotecommentbribe_comment where published=1 and SID='.$post['SID'].') where id='.$post['SID']);
		$db->query();

		$link = 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[0]='.$post['SID'].'&Itemid='.JRequest::getVar('Itemid');
		$this->setRedirect( $link, $msg );
	}


}
