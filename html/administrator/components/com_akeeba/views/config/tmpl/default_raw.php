<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: default_raw.php 267 2010-10-08 23:36:08Z nikosdion $
 * @since 1.3
 *
 * The main page of the Akeeba Backup component is where all the fun takes place :)
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

$document = JFactory::getDocument();
$document->setMimeEncoding('text/plain');
echo '###'.json_encode($this->result).'###';