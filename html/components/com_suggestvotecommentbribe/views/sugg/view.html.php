<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Views
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.view');

class SuggestionViewsugg extends JView
{

	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'' );

		//Data from model
		$item =& $this->get('Data');
		$this->assignRef('item', $item);

		$isNew = ($item->id < 1);
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );

		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);

		// active Item ID
		$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$Itemid = $menu->id;
		$this->assignRef('Itemid', $Itemid);

		/** determine columns to show **/
		$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
/*		echo "<pre>";
		print_r($params->_raw);
		echo "</pre>";*/
		$columnstoshow = $params->get( 'columnstoshow' );
		if(!is_array($columnstoshow))
		{
			$columnstoshow = array(0 => $columnstoshow);
		}
		// determine whether to show a column
		$showid       = in_array("showId", $columnstoshow);
		$showtitle    = in_array("showTitle", $columnstoshow);
		$showvotes    = in_array("showVotes", $columnstoshow);
		$showcomments = in_array("showComments", $columnstoshow);
		$showbribes   = in_array("showBribes", $columnstoshow);
		$showauthor   = in_array("showAuthor", $columnstoshow);
		$showstate    = in_array("showState", $columnstoshow);
		// bring values to the presentation
		$this->assignRef('showid', $showid);
		$this->assignRef('showtitle', $showtitle);
		$this->assignRef('showvotes', $showvotes);
		$this->assignRef('showcomments', $showcomments);
		$this->assignRef('showbribes', $showbribes);
		$this->assignRef('showauthor', $showauthor);
		$this->assignRef('showstate', $showstate);

		/** determine User information **/
		$user =& JFactory::getUser();
		$user_id = $user->id;
		$this->assignRef('user_id', $user_id);
		$user_name = isset($user->name)?$user->name:isset($user->username)?$user->username:JText::_('ANONYMOUS');
		$this->assignRef('user_name', $user_name);
		/** determine if CAPTCHA is required **/
		$useraccess = $params->get( 'useraccess' );
		$isGuestUser = $user->guest;
		$requiresCaptcha = ($useraccess=="everyone_enters_captcha" || ($useraccess=="guests_enter_captcha" && $isNew && $isGuestUser) );
		$this->assignRef('requiresCaptcha', $requiresCaptcha);

		/** determine if login is required **/
		$requireslogin = ($useraccess=="must_be_logged_in");
		$this->assignRef('requireslogin', $requireslogin);


		/** get Votes and Comments **/
		$cids='';
		foreach($_COOKIE as $key=>$val)
		{
			if($val==1&&strstr($key,'comment'))
			{
				$cids.=substr($key, 7).',';
			}
		}
		$cids=trim($cids,",");
		$db=JFactory::getDBO();
		$cids.='0';
		// comments
		$db->setQuery('SELECT * FROM #__suggestvotecommentbribe_comment where SID='.$item->id.' and (published=1 or (UID='.$user->id.' and UID!=0) or id in('.$cids.')) order by id');
		$comments = $db->loadObjectlist();
		$this->assignRef('comments', $comments);
		// votes
		$db->setQuery('SELECT * FROM #__suggestvotecommentbribe_vote where SID='.$item->id.' and (published=1 or (UID='.$user->id.' and UID!=0)) order by id');
		$votes = $db->loadObjectlist();
		$this->assignRef('votes', $votes);

		/** lists **/
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		$lists['state'] = JHTML::_('select.booleanlist',  'state', 'class="inputbox"', $item->state );
		$this->assignRef('lists', $lists);
				/** settings **/
//		$db = &JFactory::getDBO();
//		$db->setQuery('select*from #__suggestvotecommentbribe');
//		$settings=$db->loadObjectlist();
		$settings = new stdClass();
		$settings->URL 			= $params->get("URL","");
		$settings->email 		= $params->get("email","");
		$settings->pubk 		= $params->get("pubk","");
		$settings->prvk 		= $params->get("prvk","");
		$settings->max_title 	= $params->get("max_title","");
		$settings->max_desc 	= $params->get("max_desc","");

		$this->assignRef('settings', $settings);#$this->assignRef('settings', $settings[0]);

		
		parent::display($tpl);
	}// function

}// class