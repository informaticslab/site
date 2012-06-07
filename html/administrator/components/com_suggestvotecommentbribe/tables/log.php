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
 * Class for table suggestion_log
 *
 */
class Tablelog extends JTable
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
	 * Constructor
	 *
	 * @param object $_db Database connector object
	 */
	function __construct( &$_db )
	{
		parent::__construct( '#__suggestvotecommentbribe_log', 'id', $_db );
		$this->db = $_db;
	}// function

}// class
