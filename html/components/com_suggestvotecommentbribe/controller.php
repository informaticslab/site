<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage _ECR_SUBPACKAGE_
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.controller');

/**
 * Suggestion default Controller
 *
 * @package    Suggest Vote Comment Bribe
 * @subpackage Controllers
 */
class SuggestionController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access  public
	 */
	function display()
	{
		if($_REQUEST['view']=='sugg')
		{
			$cid = $_REQUEST['cid'];
			$layout= &JRequest::getVar('layout');
			if($layout=='form' && !$cid ){
//				JRequest::setVar('controller','sugg');
//				JRequest::setVar('task','edit');
			}else {
				$db=JFactory::getDBO();
				$thisuser=JFactory::getUser();
				$cids=implode(',',$_REQUEST['cid']);
				$db->setQuery("select * from #__suggestvotecommentbribe_sugg where ID in ($cids)");
				$item=$db->loadObjectlist();
				$item=$item[0];
				
				if($thisuser->id==0 && $item->UID == 0 && $item->state==0) {
					$this->setRedirect('index.php?option=com_suggestvotecommentbribe&view=suggs',JTEXT::_('THISWASUNPUBLISHED'));
				}
				if($item->published==0&&(($thisuser!=0||$thisuser!=$item->UID)&&!$_COOKIE['suggest'.$item->id]))
				{
					$this->setRedirect('index.php?option=com_suggestvotecommentbribe&view=suggs',JTEXT::_('THISWASUNPUBLISHED'));
				}
			}
		}
		parent::display();
	}// function


}// class
