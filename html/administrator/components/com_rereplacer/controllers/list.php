<?php
/**
 * ReReplacer List Controller
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

// Import CONTROLLER object class
jimport( 'joomla.application.component.controller' );

/**
 * ReReplacer List Controller
 */
class ReReplacerControllerList extends JController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array() )
	{
		parent::__construct( $default );
	}

	/**
	 * Cancel Method
	 * Set Redirection to the main administrator index
	 */
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}

	/**
	 * Display Method
	 * Call the method and display the requested view
	 */
	function display( $cachable = false )
	{
		$document	=& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', 'list' );
		$viewLayout	= JRequest::getCmd( 'layout', 'default' );

		if ( $viewName == 'item' ) {
			// Hide the main menu
			JRequest::setVar( 'hidemainmenu', 1 );
		}

		$view =& $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath ) );

		// Get/Create the model
		if ( $model =& $this->getModel( $viewName ) ) {
			// Push the model into the view ( as default )
			$view->setModel( $model, true );
		}

		// Set the layout
		$view->setLayout( $viewLayout );

		// Display the view
		if ( $cachable ) {
			$option = JRequest::getCmd( 'option' );
			$cache =& JFactory::getCache( $option, 'view' );
			$cache->get( $view, 'display' );
		} else {
			$view->display();
		}
	}

	/**
	 * Import Method
	 * Call the method and display the import view
	 */
	function import()
	{
		JRequest::setVar( 'layout', 'import' );
		$this->display();
	}
}