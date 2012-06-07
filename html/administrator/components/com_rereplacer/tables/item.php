<?php
/**
 * ReReplacer Item Table
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

/**
 * ReReplacer Item Table
 */
class TableItem extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $name = null;

	/**
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $search = null;

	/**
	 * @var string
	 */
	var $replace = null;

	/**
	 * @var string
	 */
	var $area = 'body';

	/**
	 * @var string
	 */
	var $params = null;

	/**
	 * @var int
	 */
	var $published = null;

	/**
	 * @var boolean
	 */
	var $checked_out = 0;

	/**
	 * @var time
	 */
	var $checked_out_time = 0;

	/**
	 * @var int
	 */
	var $ordering = null;

	/**
	 * table_prefix - table prefix for all component table
	 *
	 * @var string
	 */
	var $_table_prefix = null;

	/**
	 * Constructor
	 */
	function TableItem( &$db )
	{
		// initialize class property
		$this->_table_prefix = '#__';

		parent::__construct( $this->_table_prefix.'rereplacer', 'id', $db );
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	*/

	function bind( $array, $ignore = '' )
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ) ) {
			$registry = new JRegistry();
			$registry->loadArray( $array['params'] );
			$array['params'] = $registry->toString();
		}

		return parent::bind( $array, $ignore );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check()
	{
		/** check for valid name */
		if ( trim( $this->name ) == '' ) {
			$this->_error = JText::_( 'RR_THE_ITEM_MUST_HAVE_A_NAME' );
			return 0;
		}

		/** check for valid search */
		if ( ( strpos( $this->params, 'view_state=2' ) === false ) || ( strpos( $this->params, 'use_xml=1' ) === false ) ) {
			if ( trim( $this->search ) == '' ) {
				$this->_error = JText::_( 'RR_THE_ITEM_MUST_HAVE_SOMETHING_TO_SEARCH_FOR' );
				return 0;
			} else if ( strlen( trim( $this->search ) ) < 3 ) {
				$this->_error = JText::sprintf( 'RR_THE_SEARCH_STRING_SHOULD_BE_LONGER', 2 );
				return 0;
			}
		}
		return 1;
	}
}