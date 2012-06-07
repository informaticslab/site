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

class SuggestionViewvote extends JView
{
	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'components/com_suggestvotecommentbribe/assets/' );

		//Data from model
		$item =& $this->get('Data');
		$isNew = ($item->id < 1);
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );

		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);

		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		$this->assignRef('lists', $lists);

		// active Item ID
		$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$Itemid = $menu->id;
		$this->assignRef('Itemid', $Itemid);
				
		$this->assignRef('item', $item);
		parent::display($tpl);
	}
}