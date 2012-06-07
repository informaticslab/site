<?php
/**
 * ReReplacer Item Controller
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
 * ReReplacer Item Controller
 */
class ReReplacerControllerItem extends JController
{
	/**
	 * admin_url - url of the main component administrator
	 *
	 * @var string
	 */
	var $_admin_url = null;

	/**
	 * Custom Constructor
	 */
	function __construct( $default = array() )
	{
		parent::__construct( $default );

		// initialize class property
		$this->_admin_url = 'index.php?option=com_rereplacer';

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
	}

	/**
	 * Display Method
	 * Call the method and display the requested view
	 */
	function display( $cachable=false )
	{
		$document	=& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', 'item' );
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
	 * Edit Method
	 * Create a new item or edit existing item
	 */
	function edit()
	{
		// Set the view to the item
		JRequest::setVar( 'view', 'item' );

		ReReplacerControllerItem::display();

		// Checkout the item
		$model = $this->getModel( 'item' );
		$model->checkout();
	}

	/**
	 * Save Method
	 * Save the selected item specified by id
	 * and set Redirection to the list of items
	 */
	function save()
	{
		$post = JRequest::get( 'post' );
		$cid = JRequest::getVar( 'cid', array(0), 'method', 'array' );
		$cid = array( (int) $cid['0'] );
		$post['id'] = $cid['0'];

		$params = '';

		foreach ( $post['params'] as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = implode( ',', $value );
			}
			if ( in_array( $key, array(
				'search',
				'replace',
				'other_replace',
				'assignto_urls_selection',
				'assignto_urls_selection_sef',
				'assignto_php_selection'
			) ) ) {
				$value = str_replace( '\n', '[:REGEX_ENTER:]', $value );
			}
			if ( $key == 'search' || $key == 'replace' ) {
				$value = htmlspecialchars( $value );
			}
			$value = str_replace( "\r\n", '\n', $value );
			$value = addslashes( $value );
			$value = str_replace( '|', '\|', $value );
			$params .= $key.'='.$value."\n";
		}

		$post['params'] = $params;

		$model = $this->getModel( 'item' );

		$saved = $model->store( $post );
		if ( $saved == 1 ) {
			$msg = JText::_( 'Item Saved' );
		} else {
			$msg = JText::_( 'Error Saving Item' );
			if ( is_array( $saved ) ) {
				$saved = array_diff( $saved, array('') );
				if ( count( $saved ) ) {
					$msg .= ' ( '.implode( ' | ', $saved ).' )';
				}
			}
			return $msg;
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		$this->id = $model->_id;

		$model->saveorder( array(), array() );

		$this->setRedirect( $this->_admin_url, $msg );

		return 1;
	}

	/**
	 * Apply Method
	 * Save the selected item specified by id
	 * and set Redirection to the item
	 */
	function apply()
	{
		$saved = $this->save();
		if ( $saved == 1 ) {
			$msg = JText::_( 'Item Saved' );
		} else {
			$msg = $saved;
		}

		$this->setRedirect( 'index.php?option=com_rereplacer&controller=item&cid[]='.$this->id, $msg );
	}

	/**
	 * Save And New Method
	 * Save the selected item specified by id
	 * and set Redirection to a new item
	 */
	function saveAndNew()
	{
		$saved = $this->save();
		if ( $saved == 1 ) {
			$msg = JText::_( 'Item Saved' );
		} else {
			$msg = $saved;
		}

		$this->setRedirect( 'index.php?option=com_rereplacer&controller=item', $msg );
	}

	/**
	 * Copy Method
	 * Copy all items specified by array cid
	 * and set Redirection to the list of items
	 */
	function copy()
	{
		$cid = JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1 ) {
			JError::raiseError( 500, JText::_( 'Select an item to copy' ) );
		}

		$model = $this->getModel( 'item' );
		if ( !$model->copy( $cid ) ) {
			echo "<script> alert( '".$model->getError( true )."' ); window.history.go( -1 ); </script>\n";
		}

		$model->saveorder( array(), array() );

		$msg = JText::sprintf( 'Items copied', count( $cid ) );
		$this->setRedirect( $this->_admin_url, $msg );
	}

	/**
	 * Delete Method
	 * Delete all items specified by array cid
	 * and set Redirection to the list of items
	 */
	function remove()
	{
		$cid = JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1 ) {
			JError::raiseError( 500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel( 'item' );
		if ( !$model->delete( $cid ) ) {
			echo "<script> alert( '".$model->getError( true )."' ); window.history.go( -1 ); </script>\n";
		}

		$model->saveorder( array(), array() );

		$msg = JText::sprintf( 'Items removed', count( $cid ) );
		$this->setRedirect( $this->_admin_url, $msg );
	}

	/**
	 * Publish Method
	 * Publish all items specified by array cid
	 * and set Redirection to the list of items
	 */
	function publish()
	{
		$cid	= JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1 ) {
			JError::raiseError( 500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel( 'item' );
		if ( !$model->publish( $cid, 1 ) ) {
			echo "<script> alert( '".$model->getError( true )."' ); window.history.go( -1 ); </script>\n";
		}

		$msg = JText::sprintf( 'Items published', count( $cid ) );
		$this->setRedirect( $this->_admin_url, $msg );
	}

	/**
	 * Publish Method
	 * Unpublish all items specified by array cid
	 * and set Redirection to the list of items
	 */
	function unpublish()
	{
		$cid	= JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1 ) {
			JError::raiseError( 500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel( 'item' );
		if ( !$model->publish( $cid, 0 ) ) {
			echo "<script> alert( '".$model->getError( true )."' ); window.history.go( -1 ); </script>\n";
		}

		$msg = JText::sprintf( 'Items unpublished', count( $cid ) );
		$this->setRedirect( $this->_admin_url, $msg );
	}

	/**
	 * Cancel Method
	 * Check in the selected item
	 * and set Redirection to the list of items
	 */
	function cancel()
	{
		// Checkin the item
		$model = $this->getModel( 'item' );
		$model->checkin();
		$this->setRedirect( $this->_admin_url );
	}

	/**
	 * Orderup Method
	 * change order up
	 * and set Redirection to the list of items
	 */
	function orderup()
	{
		$model = $this->getModel( 'item' );
		$model->move( -1 );

		$this->setRedirect( $this->_admin_url );
	}

	/**
	 * Orderdown Method
	 * change order down
	 * and set Redirection to the list of items
	 */
	function orderdown()
	{
		$model = $this->getModel( 'item' );
		$model->move( 1 );

		$this->setRedirect( $this->_admin_url );
	}

	/**
	 * Saveorder Method
	 * saveorder of the items
	 * and set Redirection to the list of items
	 */
	function saveorder()
	{
		$cid	= JRequest::getVar( 'cid', array( 0 ), 'post', 'array' );
		$order	= JRequest::getVar( 'order', array( 0 ), 'post', 'array' );

		$model	= $this->getModel( 'item' );
		$model->saveorder( $cid, $order );

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( $this->_admin_url, $msg );
	}

	/**
	 * Export Method
	 * Export the selected items specified by id
	 */
	function export()
	{
		$post = JRequest::get( 'post' );
		$cid = JRequest::getVar( 'cid', array(0), 'method', 'array' );

		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__rereplacer WHERE id IN ( ".implode( ',', $cid )." )";
		$db->setQuery( $sql );
		$rows = $db->loadObjectList();

		$string = '';
		foreach( $rows as $row ){
			unset( $row->id );
			unset( $row->checked_out );
			unset( $row->checked_out_time );
			$string .= '<RR_ITEM_START>'."\n";
			foreach( $row as $key => $val ){
				$string .= '<RR_KEY>'.$key;
				$string .= '<RR_VAL>'.$val;
				$string .= '<RR_END>'."\n";
			}
			$string .= '<RR_ITEM_END>'."\n\n";
		}

		$filename = 'ReReplacer Item';
		if ( count( $rows ) == 1 ) {
			$filename .= ' ('.preg_replace( '#(.*?)_*$#', '\1', str_replace( '__', '_', preg_replace( '#[^a-z0-9_-]#', '_', strtolower( html_entity_decode($rows['0']->name ) ) ) ) ).')';
		} else {
			$filename .= 's';
		}

		// SET DOCUMENT HEADER
		if ( ereg( 'Opera(/| )([0-9].[0-9]{1,2})', $SERVER['HTTP_USER_AGENT'] ) ) {
			$UserBrowser = "Opera";
		}
		elseif ( ereg( 'MSIE ([0-9].[0-9]{1,2})', $SERVER['HTTP_USER_AGENT'] ) ) {
			$UserBrowser = "IE";
		} else {
			$UserBrowser = '';
		}
		$mime_type = ( $UserBrowser == 'IE' || $UserBrowser == 'Opera' ) ? 'application/octetstream' : 'application/octet-stream';
		@ob_end_clean();
		ob_start();

		header( 'Content-Type: ' . $mime_type );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );

		if ( $UserBrowser == 'IE' ) {
			header( 'Content-Disposition: inline; filename="'.$filename.'.rrbak"' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Pragma: public' );
		}
		else {
			header( 'Content-Disposition: attachment; filename="'.$filename.'.rrbak"' );
			header( 'Pragma: no-cache' );
		}

		// PRINT STRING
		echo $string;
		exit();
	}

	/**
	 * Import Method
	 * Import the selected items specified by id
	 * and set Redirection to the list of items
	 */
	function import()
	{
		jimport( 'joomla.filesystem.file' );
		$file = JRequest::getVar( 'file', '', 'files', 'array' );
		$publish_all = JRequest::getInt( 'publish_all', 0 );

		if( is_array( $file ) ) {
			$ext = explode( ".", $file['name'] );

			if( $ext[count( $ext )-1] != 'rrbak' ) {
				$msg = JText::_( 'RR_PLEASE_CHOOSE_A_VALID_FILE' );
				$this->setRedirect( $this->_admin_url.'&task=import', $msg );
			}

			$data = file_get_contents( $file['tmp_name'] );
			$data = explode( '<RR_ITEM_START>', $data );

			$items = array();
			foreach( $data as $data_item ) {
				$data_item = trim( str_replace( '<RR_ITEM_END>', '', $data_item ) );
				if ( $data_item ) {
					$data_item_keyvals = explode( '<RR_KEY>', $data_item );
					$item = array();
					foreach( $data_item_keyvals as $data_item_keyval ) {
						$data_item_keyval = trim( str_replace( '<RR_END>', '', $data_item_keyval ) );
						if ( $data_item_keyval ) {
							$data_item_keyval = explode( '<RR_VAL>', $data_item_keyval );
							$item[$data_item_keyval['0']] = ( isset( $data_item_keyval['1'] ) ) ? $data_item_keyval['1'] : '';
						}
					}
					$items[] = $item;
				}
			}

			$model = $this->getModel( 'item' );

			$msg = JText::_( 'Items saved' );

			foreach ( $items as $item ) {
				unset( $item['id'] );
				if ( $publish_all == 0 ) {
					unset( $item['published'] );
				} else if ( $publish_all == 1 ) {
					$item['published'] = 1;
				}
				$saved = $model->store( $item );
				if ( $saved != 1 ) {
					$msg = JText::_( 'Error Saving Item' ) .' ( '.$saved.' )';
				}
			}
			$this->setRedirect( $this->_admin_url, $msg );
		} else {
			$msg = JText::_( 'RR_PLEASE_CHOOSE_A_VALID_FILE' );
			$this->setRedirect( $this->_admin_url.'&task=import', $msg );
		}
	}
}