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

class SuggestionsViewsuggs extends JView
{

	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'administrator/components/com_suggestvotecommentbribe/assets/' );
		JToolBarHelper::title(   '  ' .JText::_( 'Suggestions' ), 'sugg');
		JToolBarHelper::preferences( 'com_suggestvotecommentbribe',500,500 );

		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		$items   = & $this->get( 'Data');
		$pagination =& $this->get('Pagination');

		$lists = & $this->get('List');

		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('lists', $lists);
		parent::display($tpl);
	}// function

}// class
