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

class SuggestionsViewsugg extends JView
{
	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'administrator/components/com_suggestvotecommentbribe/assets/' );

		//Data from model
		$item =& $this->get('Data');
		$isNew = ($item->id < 1);
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );

		JToolBarHelper::title(   '  ' .JText::_( 'Suggestion' ).': <small><small>[ ' . $text.' ]</small></small>', 'sugg');

		JToolBarHelper::save();
		JToolBarHelper::cancel();

		$editor =& JFactory::getEditor();
		$this->assignRef('editor', $editor);

		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		$lists['state'] = JHTML::_('select.booleanlist',  'state', 'class="inputbox"', $item->state );
		$this->assignRef('lists', $lists);

		$this->assignRef('item', $item);
		parent::display($tpl);
	}
}
