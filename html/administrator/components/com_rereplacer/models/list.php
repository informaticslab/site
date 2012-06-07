<?php
/**
 * ReReplacer List Model
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
// Include Item Model object class
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rereplacer'.DS.'models'.DS.'item.php';

/**
 * ReReplacer List Model
 */
class ReReplacerModelList extends JModel
{

	/**
	 * List data
	 *
	 * @var array
	 */
	var $_data = array();
	/**
	 * Category total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * show_unpublished
	 *
	 * @var boolean
	 */
	var $_show_unpublished = 1;

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

		$mainframe =& JFactory::getApplication();

		// initialize class property
		$this->_table_prefix = '#__';

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'list.list.limit', 'limit', $mainframe->getCfg( 'list_limit' ), 0 );
		$limitstart = $mainframe->getUserStateFromRequest( 'list.list.limitstart', 'limitstart', 0 );

		$this->setState( 'limit', $limit );
		$this->setState( 'limitstart', $limitstart );

	}

	/**
	 * Method to get a rereplacer data
	 *
	 * this method is called from the owner VIEW by VIEW->get( 'Data' );
	 * - get list of all rereplacer for the current data page.
	 * - pagination is spec. by variables limitstart,limit.
	 * - ordering of list is build in _buildContentOrderBy
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_data ) ) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query, $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		}
	}

	/**
	 * Method to get all params data
	 *
	 * this method is called from the owner VIEW by VIEW->get( 'Data' );
	 * - get list of all rereplacer for the current data page
	 * - pagination is spec. by variables limitstart,limit
	 * - ordering of list is build in _buildContentOrderBy
	 */
	function getAllParams()
	{
		$this->getData();

		$data_array = array();
		foreach( $this->_data as $dat ) {
			$item = new ReReplacerModelItem();
			$item->_id = $dat->id;
			$item->getData( 0, $dat );
			$data_array[] = $item->_data;
		}
		return $data_array;
	}

	/**
	 * Method to get all params data of published items only
	 *
	 * this method is called from the owner VIEW by VIEW->get( 'Data' );
	 * - get list of all rereplacer for the current data page.
	 * - pagination is spec. by variables limitstart,limit.
	 * - ordering of list is build in _buildContentOrderBy
	 */
	function getAllPublishedParams()
	{
		$this->_show_unpublished = 0;

		return $this->getAllParams();
	}

	/**
	 * Method to get the total number of rereplacer items
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_total ) ) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount( $query );
		}

		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the rereplacer
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_pagination ) ) {
			jimport( 'joomla.html.pagination' );
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		}

		return $this->_pagination;
	}

	function _buildQuery()
	{
		$query = ' SELECT * FROM '.$this->_table_prefix.'rereplacer';
		if ( !$this->_show_unpublished ) { $query .= ' WHERE published != 0'; }
		$query .= $this->_buildContentOrderBy();
		return $query;
	}

	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option	= JRequest::getCmd( 'option' );

		$orderby = '( `area` != \'articles\' ), ( `area` != \'component\' ), ( `area` != \'body\' AND `area` != \'\' ),( `area` != \'everywhere\' ), `ordering`, `id`';
		if ( $option == 'com_rereplacer' ) {
			// give me ordering from request
			$filter_order		= $mainframe->getUserStateFromRequest( 'rereplacer.list.filter_order',		'filter_order',		'ordering' );
			$filter_order_Dir	= $mainframe->getUserStateFromRequest( 'rereplacer.list.filter_order_Dir',	'filter_order_Dir',	'' );
			$orderby = '`'.$filter_order.'` '.$filter_order_Dir.', '.$orderby;
			if ( $filter_order == 'ordering' ) {
				$orderby = '( `area` != \'articles\' ), ( `area` != \'component\' ), ( `area` != \'body\' AND `area` != \'\' ),( `area` != \'everywhere\' ), '.$orderby;
			}
		}

		// all countries are in the same category (no category)
		$orderby	= ' ORDER BY '.$orderby;

		return $orderby;
	}

}