<?php
/**
 * Image loader Include File
 * Loads the regex image via the img html tag
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

echo '<img src="'.JURI::base( true ).'/components/com_rereplacer/images/regular-expressions-cheat-sheet-v2.png" />';
exit;
