<?php
/**
 * ReReplacer Item Model
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

// Import MODEL object class
jimport( 'joomla.application.component.model' );

require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'parameters.php';

/**
 * ReReplacer Item Model
 */
class ReReplacerModelItem extends JModel
{
	/**
	 * Item id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Item data
	 *
	 * @var object
	 */
	var $_data = null;

	/**
	 * Item params
	 *
	 * @var object
	 */
	var $_params = null;

	/**
	 * table_prefix - table prefix for all component table
	 *
	 * @var string
	 */
	var $_table_prefix = null;

	/**
	 * Custom Constructor
	 */
	function __construct()
	{
		parent::__construct();

		// initialize class property
		$this->_table_prefix = '#__';

		$array = JRequest::getVar( 'cid', 0, '', 'array' );

		$this->setId( (int) $array['0'] );

	}

	/**
	 * Method to set the list identifier
	 *
	 * @access	public
	 * @param	int list identifier
	 */
	function setId( $id )
	{
		// Set list id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a list
	 */
	function &getData( $getxml = 1, $params = false )
	{
		$this->_initData();

		// Load the list data
		if ( $params ) {
			$this->_params = $params;
			unset( $params );
		} else {
			$this->_loadParams();
		}

		$parameters =& NNePparameters::getParameters();
		$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rereplacer'.DS.'item_params.xml';

		$this->_data = $parameters->getParams( $this->_params->params, $xmlfile );
		foreach ( $this->_params as $key => $val ) {
			if ( $key != 'params' && !is_array( $val ) && !is_object( $val ) ) {
				$this->_data->$key = $val;
			}
		}

		$this->stripSlashesFromObject( $this->_data );

		if ( $getxml ) {
			$registry = new JRegistry();
			$registry->loadObject( $this->_data );
			$params = $registry->toString();

			$this->_data->_xml = new JParameter( $params, $xmlfile );
		}

		return $this->_data;
	}

	/**
	 * Method to checkout/lock the list
	 *
	 * @access	public
	 * @param	int	$uid	User ID of the user checking the article out
	 * @return	boolean	True on success
	 */
	function checkout( $uid = null )
	{
		if ( $this->_id ) {
			// Make sure we have a user id to checkout the article with
			if ( is_null( $uid ) ) {
				$user =& JFactory::getUser();
				$uid = $user->get( 'id' );
			}
			// Lets get to it and checkout the thing...
			$list =& $this->getTable();

			if ( !$list->checkout( $uid, $this->_id ) ) {
				$this->setError( $this->_db->getErrorMsg() );
				return 0;
			}
			return 1;
		}
		return 0;
	}
	/**
	 * Method to checkin/unlock the list
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function checkin()
	{
		if ( $this->_id ) {
			$list =& $this->getTable();
			if ( !$list->checkin( $this->_id ) ) {
				$this->setError( $this->_db->getErrorMsg() );
				return 0;
			}
			return 1;
		}
		return 0;
	}
	/**
	 * Tests if list is checked out
	 *
	 * @access	public
	 * @param	int	A user id
	 * @return	boolean	True if checked out
	 */
	function isCheckedOut( $uid=0 )
	{
		if ( $uid ) {
			return ( $this->_data->checked_out && $this->_data->checked_out != $uid );
		} else {
			return $this->_data->checked_out;
		}
	}

	/**
	 * Method to load content list data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _loadParams()
	{
		// Lets load the content if it doesn't already exist
		if ( !$this->_params ) {
			$query = 'SELECT * FROM '.$this->_table_prefix.'rereplacer WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_params = $this->_db->loadObject();
		}
		if ( !$this->_params ) {
			$this->_params = $this->_data;
			$this->_params->params = null;
		}
	}

	/**
	 * Method to initialise the list data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if ( !$this->_data ) {
			$detail = new stdClass();
			$detail->id					= $this->_id;
			$detail->published			= 1;
			$detail->checked_out		= 0;
			$detail->checked_out_time	= 0;
			$detail->ordering			= 0;
			$detail->area				= 'body';
			$this->_data				= $detail;
		}
	}

	/**
	 * Method to store the data
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store( $data )
	{
		// Load table class from com_rereplacer/tables/item.php
		$row =& $this->getTable();

		// Take all table row params from the params string
		// put them in the $data
		// and remove them from the params string
		$registry = new JRegistry();
		$registry->loadINI( $data['params'] );
		$params = $registry->toArray( );

		foreach( $row as $key => $val ) {
			if ( isset( $params[$key] ) ) {
				$data[$key] = $params[$key];
				unset( $params[$key] );
			}
		}

		if ( isset( $data['area'] ) ) {
			$params['area'] = $data['area'];
		}

		$registry = new JRegistry();
		$registry->loadArray( $params );
		$data['params'] = $registry->toString();

		// Bind the form fields to the list table
		if ( !$row->bind( $data ) ) {
			$this->setError( $this->_db->getErrorMsg() );
			return $this->_errors;
		}

		// Make sure the list table is valid
		// JTable return always true but there is space to put
		// our custom check method
		if ( !$row->check() ) {
			$this->setError( $this->_db->getErrorMsg() );
			return $this->_errors;
		}

		// Store the list table to the database
		if ( !$row->store() ) {
			$this->setError( $this->_db->getErrorMsg() );
			return $this->_errors;
		}

		$this->_id = $row->id;
		return 1;
	}

	/**
	 * Method to copy an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function copy( $cid = array() )
	{
		foreach( $cid as $id )
		{
			$this->_data = null;
			$this->_params = null;
			$this->_id = $id;
			$this->getData();
			$data = $this->_data;

			$data->id = '';
			$data->published = 0;
			$data->name = JText::sprintf( 'RR_COPY_OF', $data->name );

			$registry = new JRegistry();
			$registry->loadObject( $data );
			$params = array();
			$params['params'] = $registry->toString();

			$this->store( $params );
		}
		return 1;
	}

	/**
	 * Method to remove an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete( $cid = array() )
	{
		$result = false;

		if ( count( $cid ) ) {
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM '.$this->_table_prefix.'rereplacer WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if ( !$this->_db->query() ) {
				$this->setError( $this->_db->getErrorMsg() );
				return 0;
			}
		}
		return 1;
	}

	/**
	 * Method to (un)publish a list
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function publish( $cid = array(), $publish = 1 )
	{
		$user	=& JFactory::getUser();

		if ( count( $cid ) ) {
			$cids = implode( ',', $cid );

			$query = 'UPDATE '.$this->_table_prefix.'rereplacer'
				.' SET published = '.intval( $publish )
				.' WHERE id IN ( '.$cids.' )'
				.' AND ( checked_out = 0 OR ( checked_out = '.$user->get( 'id' ).' ) )'
				;
			$this->_db->setQuery( $query );
			if ( !$this->_db->query() ) {
				$this->setError( $this->_db->getErrorMsg() );
				return 0;
			}
		}
		return 1;
	}

	/**
	 * Method to move a item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function saveorder( $cid = array(), $order = 0 )
	{
		$query = ' SELECT * FROM '.$this->_table_prefix.'rereplacer';
		$itemlist = $this->_getList( $query, $this->getState( 'limitstart' ), $this->getState( 'limit' ) );

		$order_list = array();
		foreach( $cid as $i => $id ) {
			$order_list[$id] = ( $order[$i]*100000 ) - $i ;
		}
		
		$order_array = array();
		foreach( $itemlist as $item ) {
			if ( isset( $order_list[$item->id] ) ) {
				$order = $order_list[$item->id];
			} else {
				$order = $item->ordering*100000;
			}
			$order_array[$item->id] = $order + ( $item->id / 100000 );
		}

		asort( $order_array );
		$order_array = array_keys( $order_array );

		// Load table class from com_rereplacer/tables/item.php
		$row =& $this->getTable();

		// update ordering values
		$count = count( $order_array );
		$area = '';
		for( $i=0; $i < $count; $i++ ) {
			$row->load( (int) $order_array[$i] );
			if ( !$row->area ) {
				$row->area = 'body';
			}
			if ( !isset( $area->{$row->area} ) ) {
				$area->{$row->area} = 0;
			}
			$area->{$row->area}++;
			if ( $row->ordering != $area->{$row->area} ) {
				$row->ordering = $area->{$row->area};
				if ( !$row->store() ) {
					$this->setError( $this->_db->getErrorMsg() );
					return 0;
				}
			}
		}
		return 1;
	}

	/**
	 * Method to move a list
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function move( $direction )
	{
		// Load table class from com_rereplacer/tables/item.php
		$row =& $this->getTable();
		// we need to pass here id of list detail
		if ( !$row->load( $this->_id ) ) {
			$this->setError( $this->_db->getErrorMsg() );
			return 0;
		}

		$query = "UPDATE ".$row->_tbl."
			SET ordering = ".(int) $row->ordering."
			WHERE ordering = ".(int) ( $row->ordering + $direction )."
			AND area = ".$this->_db->Quote( $row->area )."
			AND published >= 0
			";
		$this->_db->setQuery( $query );
		if ( !$this->_db->query() ) {
			$err = $this->_db->getErrorMsg();
			JError::raiseError( 500, $err );
		}

		$query = "UPDATE ". $row->_tbl."
			SET ordering = ".(int) ( $row->ordering + $direction )."
			WHERE ".$row->_tbl_key." = ".$this->_db->Quote( $row->id )."
			AND published >= 0
			";
		$this->_db->setQuery( $query );
		if ( !$this->_db->query() ) {
			$err = $this->_db->getErrorMsg();
			JError::raiseError( 500, $err );
		}

		return 1;
	}

	function stripSlashesFromObject( &$obj, $exclude = array() )
	{
		foreach ( $obj as $key => $val ) {
			if ( is_string( $val ) && !in_array( $key, $exclude ) ) {
				$obj->$key = stripslashes( $val );
			}
		}
	}
}

if ( !function_exists( 'property_exists' ) ) {
	function property_exists( $class, $property ) {
		if ( is_object( $class ) ) {
			$vars = get_object_vars( $class );
		} else {
			$vars = get_class_vars( $class );
		}
		return array_key_exists( $property, $vars );
	}
}