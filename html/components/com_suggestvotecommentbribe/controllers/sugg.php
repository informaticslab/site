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

class SuggestionControllersugg extends JController
{
	var $cid;

	function __construct($config = array())
	{
		parent::__construct($config);
		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
		$this->registerTask( 'unpublish',   'publish');
	}// function

	function display()
	{
		parent::display();
	}// function

	function _buildQuery()
	{
		$user=JFactory::getUser();
		$this->_query = 'UPDATE #__suggestvotecommentbribe_sugg'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'
		;
		return $this->_query;
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	function edit()
	{
		$model = $this->getModel( 'security' );
		$can=$model->canSuggest(JRequest::getVar('cid'));
		// if $can!==true then $can contains the error message for display 
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		JRequest::setVar( 'view', 'sugg' );
		JRequest::setVar( 'layout', 'form'  );
		parent::display();
	}

	function publish()
	{
		$cid     = JRequest::getVar( 'cid', array(), '', 'array' );
		$this->publish = ( $this->getTask() == 'publish' ? 1 : 0 );

		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)
		{
			$action = $publish ? 'publish' : 'unpublish';
			JError::raiseError(500, JText::_( 'SELECT_AN_ITEM_TO' ) .$action, true );
		}

		$this->cids = implode( ',', $cid );

		$model = $this->getModel( 'security' );
		$can=$model->canSuggest(JRequest::getVar('cid'));
		if($can!==true&&!$_COOKIE['suggest'.$cid[0]])
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}

		$query = $this->_buildQuery();
		$db = &JFactory::getDBO();
		$db->setQuery($query);
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$user =& JFactory::getUser();
		$model1 = $this->getModel( 'log' );
		$post1['title']=$cid[0];
		if($user->id)
		{
			$post1['description']=$user->get('name');
		}
		else
		{
			$post1['description']=JText::_( 'ANONYMOUS' );
		}
		$post1['description'].=' '.JText::_( 'HAS' ).' ';
		$post1['description'].=$this->getTask().'ed';
		$post1['description'].=' '.JText::_( 'A_SUGGESTION_AT' ).' '.date(DATE_RFC822);
		$model1->store($post1);
		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid');
		$this->setRedirect($link, '');
	}

	function save()
	{
		$post = JRequest::get('post');
		$cid  = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$model_can = $this->getModel( 'security' );
		$can=$model_can->canSuggest($cid);
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		
		#_ECR_SMAT_DESCRIPTION_CONTROLLER1_
		$post['id']    = (int) $cid[0];
		$params 	= &JComponentHelper::getParams( 'com_suggestvotecommentbribe' );
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
//echo "<pre>";
//print_r($params->_registry['_default']['data']);
//echo "</pre>";
//exit();
		$max_title 	= $params->get('max_title',100);
		$captcha 	= $params->get('captcha');
		$prvk 		= $params->get('prvk');
		$max_desc 	= $params->get('max_desc');
		$useraccess = $params->get('useraccess');
		$db = &JFactory::getDBO();

		$user=JFactory::getUser();
//		echo '<h1>'.$useraccess.'</h1>';exit();
		if($useraccess == 'everyone_enters_captcha' || ($useraccess=='guests_enter_captcha'&&!$user->id))
		{
			include(JPATH_ROOT."/components/com_suggestvotecommentbribe/recaptchalib.php");
			$resp = recaptcha_check_answer ($prvk,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
//			echo "<pre>";print_r($resp);echo "</pre>";exit();
			if (!$resp->is_valid)
			{
				$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid');
				$this->setRedirect( $link, JText::_('ENTERED_WRONG_CAPTCHA') );
				return;
			}
		}
		if($post['title']=='')
		{
			$t = time();
			$link = 'index.php?option=com_suggestvotecommentbribe&controller=sugg&task=edit&ses=s'.$t.'&Itemid='.JRequest::getVar('Itemid');
			$_SESSION['s'.$t]=$_POST['description'];
			$this->setRedirect( $link, JText::_('TITLE_IS_REQUIRED'));
			return;
		}
		
		#$post['title']=substr(JRequest::getVar('title'), 0,$max_title);
		$post['title']=substr($_POST['title'], 0,$max_title);
		#$post['description']=substr(JRequest::getVar('description'), 0,$max_desc);
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

		if($post['id']===0)
		{
			$posted='posted';
		}
		else
		{
			$posted='updated';
		}
		$model = $this->getModel( 'sugg' );
		$can=$model_can->canSuggest($cid);
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid'), $can );
			return;
		}
		if ($model->store($post)) {
			$msg = JText::_( 'ITEM_SAVED' );
			$user =& JFactory::getUser();
			$post['title']=htmlentities($post['title'],ENT_NOQUOTES);
			$post['description']=nl2br(htmlentities($post['description'],ENT_NOQUOTES));
			if($post[id]==0)
			{
				$CID=mysql_insert_id();
			}
			else
			{
				$CID=$post[id];
			}
			if($CID[0]->id)
			{
				$CID=$CID[0]->id;
			}
			if(!$user->id)
			{
				setcookie('suggest'.$CID,1);
			}
			$model1 = $this->getModel( 'log' );
			$post1['title']=$CID;
			if($user->id)
			{
				$post1['description']=$user->name;
			}
			else
			{
				$post1['description']=JText::_( 'ANONYMOUS' );
			}
			$post1['description'].=' '.JText::_( 'HAS' ).'  '.$posted.' '.JText::_( 'A_SUGGESTION_AT' ).' '.date(DATE_RFC822);
			$model1->store($post1);
			$post2['type']='suggest';
			$model = $this->getModel( 'security' );
			$model->store($post2);

		}
		else
		{
			$msg = JText::_( 'ERROR_SAVING_ITEM' );
		}

		$link = 'index.php?option=com_suggestvotecommentbribe&view=suggs'.'&Itemid='.JRequest::getVar('Itemid');
		$this->setRedirect( $link, $msg );
	}
}//class
