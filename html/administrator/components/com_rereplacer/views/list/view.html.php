<?php
/**
 * ReReplacer List View
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
 * ReReplacer List View
 */
class ReReplacerViewList extends JView
{
	/**
	 * Custom Constructor
	 */
	function __construct( $config = array() )
	{
		/** set up global variable for sorting etc
		 * $context is used in VIEW abd in MODEL
		 **/
		global $context;
		$context = 'list.list.';

		parent::__construct( $config );
	}

	/**
	 * Display the view
	 * take data from MODEL and put them into
	 * reference variables
	 */

	function display( $tpl = null )
	{
		$mainframe =& JFactory::getApplication();
		$viewLayout	= JRequest::getCmd( 'layout', 'default' );

		$config =& JComponentHelper::getParams( 'com_rereplacer' );

		$document =& JFactory::getDocument();
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/nonumberelements/css/style.css' );
		$document->addStyleSheet( JURI::root( true ).'/administrator/components/com_rereplacer/css/rereplacer.css' );

		if ( $viewLayout == 'import' ) {
			// Set document title
			$document->setTitle( JText::_( 'REREPLACER_IMPORT_ITEMS' ) );
			// Set ToolBar title
			JToolBarHelper::title( JText::_( 'RR_IMPORT_ITEMS' ), 'rereplacer.png' );
			// Set toolbar items for the page
			JToolBarHelper::back();
		} else {
			// Set document title
			$document->setTitle( JText::_( 'REREPLACER_LIST' ) );
			// Set ToolBar title
			JToolBarHelper::title( JText::_( 'RR_LIST' ), 'rereplacer.png' );
			// Set toolbar items for the page
			JToolBarHelper::addNewX();
			JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
			JToolBarHelper::editListX();
			JToolBarHelper::deleteList( 'VALIDDELETEITEMS' );
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::customX( 'export', 'export.png', 'export_f2.png', 'RR_EXPORT' ) ;
			JToolBarHelper::custom( 'import', 'import.png', 'import_f2.png', 'RR_IMPORT', false, false ) ;
			JToolBarHelper::preferences( 'com_rereplacer', '200' );
			$bar = & JToolBar::getInstance('toolbar');
			// Add a configuration button
			jimport('joomla.language.help');
			$url = JHelp::createURL( 'help', 'com_rereplacer' );
			$bar->appendButton( 'Popup', 'help', 'Help', $url, '570', '500' );
		}

		// Set ToolBar title
		$uri	=& JFactory::getURI();

		// give me ordering from request
		$filter_order		= $mainframe->getUserStateFromRequest( 'rereplacer.list.filter_order',		'filter_order',		'ordering' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'lirereplacerst.list.filter_order_Dir',	'filter_order_Dir',	'' );

		// get value to show unpublished items in list
		$show_unpublished	= $mainframe->getUserStateFromRequest( 'rereplacer.list.show_unpublished',	'show_unpublished',	$config->get( 'show_unpublished', 1 ) );
		// get value to show search and replace colomns in list
		$show_searchreplace	= $mainframe->getUserStateFromRequest( 'rereplacer.list.show_searchreplace',	'show_searchreplace',	$config->get( 'show_searchreplace', 0 ) );

		// remember the actual order and column
		$lists['order'] = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;

		// Get data from the model
		if ( $show_unpublished == 1 ) {
			$items =& $this->get( 'AllParams' );
		} else {
			$items =& $this->get( 'AllPublishedParams' );
		}
		$total =& $this->get( 'Total');
		$pagination =& $this->get( 'Pagination' );

		// save a reference into view
		$this->assignRef( 'user',		JFactory::getUser() );
		$this->assignRef( 'lists',		$lists );
		$this->assignRef( 'items',		$items );
		$this->assignRef( 'pagination',	$pagination );
		$this->assignRef( 'request_url',	$uri->toString() );
		$this->assignRef( 'show_searchreplace',	$show_searchreplace );
		$this->assignRef( 'show_unpublished',	$show_unpublished );

		// call parent display
		parent::display( $tpl );
	}

	function maxlen( $string='', $maxlen=60 )
	{
		if ( JString::strlen( $string ) > $maxlen ) {
			$string = JString::substr( $string, 0, $maxlen-3 ).'...';
		}
		return $string;
	}
}