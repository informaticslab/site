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

class SuggestionViewcomment extends JView
{
	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'' );
		
		
		//Data from model
		$item =& $this->get('Data');
		$isNew = ($item->id < 1);
		if($isNew){
			$SID=JRequest::getVar('SID');
			$item->SID = $SID;
		}

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );

		// active Item ID
		$Itemid = JRequest::getVar('Itemid');
		$this->assignRef('Itemid', $Itemid);

		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);

		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		$this->assignRef('lists', $lists);

		/** settings **/
		$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		
		$settings = new stdClass();
		$settings->URL 				= $params->get("URL","");
		$settings->email 			= $params->get("email","");
		$settings->pubk 			= $params->get("pubk","");
		$settings->prvk 			= $params->get("prvk","");
		$settings->max_title 		= $params->get("max_title","");
		$settings->max_desc 		= $params->get("max_desc","");
		
		$settings->useraccess 		= $params->get("useraccess","");
		$settings->recaptchatheme 	= $params->get("recaptchatheme","");
		$settings->recaptchalng 	= $params->get("recaptchalng","");
		
		

		$this->assignRef('settings', $settings);#$this->assignRef('settings', $settings[0]);

		// SID
		$SID=JRequest::getVar('SID');
		$this->assignRef('SID', $SID);
		
		$this->assignRef('item', $item);
		parent::display($tpl);
	}
}
