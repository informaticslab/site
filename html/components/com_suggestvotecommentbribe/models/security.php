<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Models
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.model');

class SuggestionModelsecurity extends JModel
{
	function __construct()
	{
		parent::__construct();
	}

	function store($data)
	{
		$db = &JFactory::getDBO();
		$user =& JFactory::getUser();

		// if this is a vote
		if($data['type']=='vote')
		{
			$type='vote'.$data['VID'];
			setcookie($type,1);
		}
		else
		{
			$type=$data['type'];
		}

		// if user logged in
		if($user->id)
		{
			$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where UID='.$user->id.' and action="'.$type.'"');
		}
		else	// user not logged in
		{
			$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" and action="'.$type.'"');
		}
		$exists=$db->loadObjectlist();
		if($user->id)
		{
			if($exists[0]->c)
			{
				$db->setQuery('update #__suggestvotecommentbribe_security set `time`=now() where UID='.$user->id.' and action="'.$type.'"');
			}
			else
			{
				$db->setQuery('insert #__suggestvotecommentbribe_security set `time`=now() ,UID='.$user->id.' ,action="'.$type.'"');
			}
		}
		else	// user not logged in
		{
			if($exists[0]->c)
			{
				$db->setQuery('update #__suggestvotecommentbribe_security set `time`=now() where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" and action="'.$type.'"');
			}
			else
			{
				$db->setQuery('insert #__suggestvotecommentbribe_security set `time`=now() ,IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" ,action="'.$type.'"');
			}
		}
		$db->query();
		return true;
	}

	function canVote($VID,$SID)
	{
		$db = &JFactory::getDBO();
		$user =& JFactory::getUser();
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
		
		if(is_array($SID)||$SID[0]!=0||$SID!=0)
		{
			if(is_array($SID))
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID[0]");
			}
			else
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID");
			}
			$sugg=$db->loadObjectlist();
			if($sugg[0]->state==0)
			{
				return JText::_('CANTVOTE');
			}
		}
		else
		{
			return JText::_("INVSUGG");
		}
		if((is_array($VID)&&$VID[0]!=0)||($VID!=0&&!is_array($VID)))
		{
			if($_COOKIE['vote'.$SID[0]])
			{
				$db->setQuery('select 1 as c');
			}
			else
			{
				if($user->id)
				{
					$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_vote where UID="'.$user->id.'"  and id='.$VID);
				}
			}
			$can=$db->loadObjectlist();
			if($can[0]->c!=1)
			{
				return JText::_("cantremvote");
			}
		}
		else
		{
			if(isset($settings->login) && $settings->login)
			{
				if(!$user->id)
				{
					return JText::_('needtologinvote');
				}
			}
			if($user->id)
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_vote where UID="'.$user->id.'"  and SID='.$SID[0]);
				$can=$db->loadObjectlist();
				if($can[0]->c==1)
				{
					return JText::_('alreadyvoted');
				}
			}
			else
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'"  and action="vote'.$SID[0].'"');
			}
			$can=$db->loadObjectlist();
			if($can[0]->c==1)
			{
				return JText::_('alreadyvoted');
			}
		}
		return true;
	}

	function canComment($CID,$SID)
	{
		$db = &JFactory::getDBO();
		$user =& JFactory::getUser();
		$params 				= &JComponentHelper::getParams('com_suggestvotecommentbribe');
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
		
		if(is_array($SID)||$SID[0]!=0||$SID!=0)
		{
			if(is_array($SID))
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID[0]");
			}
			else
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID");
			}
			$sugg=$db->loadObjectlist();
			if($sugg[0]->state==0)
			{
				return JText::_('CANTCOMMENT');
			}
		}
		else
		{
			return JText::_("INVSUGG");
		}
		if(!is_array($CID)||$CID[0]==0)
		{
			if($settings->login)
			{
				if(!$user->id)
				{
					return JText::_('needtologincomm');
				}
			}
			if($user->id)
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where UID='.$user->id.' and `time`>now()-interval 3 second and action="comment"');
			}
			else
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" and `time`>now()-interval 3 second and action="comment"');
			}
			$can=$db->loadObjectlist();
			if($can[0]->c==1)
			{
				return JText::_('COMMENTWAIT');
			}

		}
		else
		{
			return JText::_('COMMENTMODIFY');
		}
		return true;
	}

	/**
	 * Tests if a user can make a suggestion
	 * @param integer $CID Application ID
	 * @return an error message or "true" if ok
	 */
	function canSuggest($CID)
	{
		if( !is_array($CID) || $CID[0]==0 )
		{
			$user =& JFactory::getUser();

			/* make sure user logged in if they need to be */
			$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
			$menuitemid = JRequest::getInt( 'Itemid' );
			if ($menuitemid)
			{
				$menu = JSite::getMenu();
				$menuparams = $menu->getParams( $menuitemid );
				$params->merge( $menuparams );
			}
			$useraccess = $params->get( 'useraccess' );
			if(	$useraccess=="must_be_logged_in" )
			{
				if(!isset($user->id) || $user->id<1)	// user is not logged in
				{
					return JText::_('NEEDTOLOGINSUGG');
				}
			}

			/* make sure user hasnt made a suggestion too recently */
			$db = &JFactory::getDBO();
			if($user->id)	// user is logged in
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where UID='.$user->id.' and `time`>now()-interval 3 second and action="suggest"');
			}
			else	// user is not logged in
			{
				$db->setQuery('select count(*) as c from #__suggestvotecommentbribe_security where IP="'.$_SERVER [ 'REMOTE_ADDR' ].'" and `time`>now()-interval 1 minute and action="suggest"');
			}
			$can=$db->loadObjectlist();
			if($can[0]->c==1)
			{
				return JText::_('SUGGWAIT');
			}
		}
		else
		{
			return JText::_('SUGGMODIFY');
		}

		// user can make a suggestion
		return true;
	}

	/**
	 * Tests if a user can bribe on a suggestion.
	 * The only requirement is that a Suggestion is "open".
	 * @param integer $SID Suggestion ID
	 * @return an error message or "true" if ok
	 */
	function canBribe($SID)
	{
		if( is_array($SID) || $SID[0]!=0 || $SID!=0 )
		{
			/* make sure the Suggestion is "open" */
			$db = &JFactory::getDBO();
			if(is_array($SID))
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID[0]");
			}
			else
			{
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where id=$SID");
			}
			$sugg=$db->loadObjectlist();
			if($sugg[0]->state==0)
			{
				return JText::_('CANTBRIBE');
			}

		}
		else	// invalid Suggestion
		{
			return JText::_("INVSUGG");
		}

		// user can bribe
		return true;
	}
}
