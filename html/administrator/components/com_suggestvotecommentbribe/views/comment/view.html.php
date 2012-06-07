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

class SuggestionsViewcomment extends JView
{
	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'administrator/components/com_suggestvotecommentbribe/assets/' );

		//Data from model
		$item =& $this->get('Data');
		$isNew = ($item->id < 1);
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );

		JToolBarHelper::title(   '&nbsp;&nbsp;' .JText::_( 'comment' ).': <small><small>[ ' . $text.' ]</small></small>', 'comment');

		JToolBarHelper::save();
		JToolBarHelper::cancel();
		$db = &JFactory::getDBO();
		$db->setQuery('select*from #__suggestvotecommentbribe_sugg where id='.$item->SID);
		$sugg=$db->loadObjectlist();
		if(count($sugg))
		$item->Sname=$sugg[0]->title;
		else $item->Sname='';
		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);

		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		$this->assignRef('lists', $lists);

		$this->assignRef('item', $item);
		parent::display($tpl);
	}
}
