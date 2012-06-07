<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage _ECR_SUBPACKAGE_
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');


/**
 * Suggestion Table class
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class TableSuggestion extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * Thank-you URL
	 * @var string
	 */
	var $URL = null;

	/**
	 * PayPal email address to receive Bribes
	 * @var string
	 */
	var $email = null;

	/**
	 * Public Key from reCAPTCHA
	 * @var string
	 */
	var $pubk = null;

	/**
	 * private Key from reCAPTCHA
	 * @var string
	 */
	var $prvk = null;

	/**
	 * Maximum number of characters in a title of a Suggestion
	 * @var int
	 */
	var $max_title = 0;

	/**
	 * Maximum number of characters in a description of a Suggestion
	 * @var int
	 */
	var $max_desc = 0;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSuggestion(& $db) {
		parent::__construct('#__suggestvotecommentbribe', 'id', $db);
	}
}
?>
