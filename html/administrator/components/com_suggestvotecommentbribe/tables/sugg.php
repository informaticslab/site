<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Tables
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

/**
 * Class for table suggestion_sugg
 *
 */
class Tablesugg extends JTable
{
	var $db = null;

	/**
	 * @var int
	 * Primary key
	 */
	var $id = 0;

	/**
	 * @var varchar
	 */
	var $title = NULL;

	/**
	 * @var text
	 */
	var $description = NULL;

	/**
	 * @var int
	 */
	// var $ordering = 0;

	/**
	 * @var int
	 */
	var $published = 1;

	/**
	 * @var int
	 */
	var $UID= 0;

	/**
	 * @var int
	 */
	var $state= 1;

	/**
	 * @var decimal
	 */
	var $amountDonated= 0;

	/**
	 * @var int
	 */
	var $noofVotes= 0;

	/**
	 * @var int
	 */
	var $noofComs=0;

	/**
	 * Constructor
	 *
	 * @param object $_db Database connector object
	 */
	function __construct( &$_db )
	{
		parent::__construct( '#__suggestvotecommentbribe_sugg', 'id', $_db );
		$this->db = $_db;
	}// function





	/**
	 * Overloaded bind function
	 * http://docs.joomla.org/Adding_a_multiple_item_select_list_parameter_type
	 *
	 * @param array $array  Array or object of values to bind
	 * @param mixed $ignore Array or space separated list of fields not to bind
	 *
	 * @return null|string Success returns null, failure returns an error
	 * @access public
	 * @see    JTable:bind
	 */
	function bind( $array, $ignore = '' )
	{
		if (key_exists( 'columnstoshow', $array ) && is_array( $array['columnstoshow'] )) {
			$array['columnstoshow'] = implode( ',', $array['columnstoshow'] );
		}

		return parent::bind( $array, $ignore );
	}








}// class
