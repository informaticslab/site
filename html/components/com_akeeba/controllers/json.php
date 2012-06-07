<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 2, or later
 * @version $Id: json.php 256 2010-09-24 17:24:33Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

defined('AKEEBA_BACKUP_ORIGIN') or define('AKEEBA_BACKUP_ORIGIN','json');

// Load framework base classes
jimport('joomla.application.component.controller');

class AkeebaControllerJson extends JController
{
	/**
	 * Starts a backup
	 * @return
	 */
	public function display()
	{
		// If JSON functions don't exist, load our compatibility layer
		if( (!function_exists('json_encode')) || (!function_exists('json_decode')) )
		{
			require_once JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_akeeba'.DS.'helpers'.DS.'jsonlib.php';
		}

		JRequest::setVar('format', 'raw');
		$document =& JFactory::getDocument();
		$document->setType('raw');

		parent::display(false);
	}

}

