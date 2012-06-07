<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 303 2010-11-17 12:24:26Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

$json = json_encode($this->result);

echo "###$json###";
die(); // <-- I hate myself for doing that, but some plugins consistently fuck up the JSON responses :@