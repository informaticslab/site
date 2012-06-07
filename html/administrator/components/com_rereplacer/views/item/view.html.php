<?php
/**
 * ReReplacer Item View
 *
 * @package     ReReplacer
 * @version     2.13.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import VIEW object class
jimport( 'joomla.application.component.view' );

/**
 * ReReplacer Item View
 */
class ReReplacerViewItem extends JView
{
	/**
	 * Display the view
	 */
	function display( $tpl = null )
	{
		$mainframe =& JFactory::getApplication();
		$option	= JRequest::getCmd( 'option' );

		// set document title
		$document =& JFactory::getDocument();
		$document->setTitle( JText::_( 'REREPLACER_ITEM' ) );
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/nonumberelements/css/style.css' );
		$document->addStyleSheet( JURI::root( true ).'/administrator/components/com_rereplacer/css/rereplacer.css' );

		$uri	=& JFactory::getURI();
		$user	=& JFactory::getUser();
		$model	=& $this->getModel();

		// prepare array
		$lists = array();

		// get the rereplacer
		$detail	=& $this->get( 'data' );

		// the new record ? Edit or Create?
		$isNew		= ( $detail->id < 1 );

		// fail if checked out not by 'me'
		if ( $model->isCheckedOut( $user->get( 'id' ) ) ) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'RR_THE_ITEM' ), $detail->descript );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Set toolbar items for the page
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title( JText::_( 'RR_ITEM' ).': <small><small>[ '.$text.' ]</small></small>', 'rereplacer.png' );
		JToolBarHelper::custom( 'apply', 'save-apply.png', 'apply.png', 'Save', false);
		JToolBarHelper::custom( 'saveAndNew', 'save-new.png', 'save.png', 'RR_SAVE_NEW', false);
		JToolBarHelper::custom( 'save', 'save-close.png', 'save.png', 'RR_SAVE_CLOSE', false);
		JToolBarHelper::cancel( 'cancel', 'Close' );
		JToolBarHelper::help( 'help', TRUE );

		// Edit or Create?
		if ( !$isNew ) {
			$model->checkout( $user->get( 'id' ) );
		} else {
			// initialise new record
			$detail->published = 1;
			$detail->order	= 0;
		}

		// build the html select list
		$lists['published']		= JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $detail->published );

		// Clear rereplacer HTML data
		jimport( 'joomla.filter.filteroutput' );
		JFilterOutput::objectHTMLSafe( $detail, ENT_QUOTES );

		$this->assignRef( 'lists',		$lists );
		$this->assignRef( 'detail',		$detail );
		$this->assignRef( 'request_url',	$uri->toString() );

		parent::display( $tpl );
	}

}