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

// Load framework base classes
jimport('joomla.application.component.view');

/**
 * Akeeba Backup Configuration Wizard view class
 *
 */
class AkeebaViewConfwiz extends JView
{
	function display()
	{
		$registry =& AEFactory::getConfiguration();
		// Set the toolbar title
		JToolBarHelper::title(JText::_('AKEEBA').':: <small>'.JText::_('AKEEBA_CONFWIZ').'</small>','akeeba');
		JToolBarHelper::back('Back', 'index.php?option='.JRequest::getCmd('option'));
		
		// Add references to CSS and JS files
		AkeebaHelperIncludes::includeMedia(false);
		
		// Load the Configuration Wizard Javascript file
		$document = JFactory::getDocument();
		$document->addScript( JURI::base().'../media/com_akeeba/js/confwiz.js' );

		// Add live help
		AkeebaHelperIncludes::addHelp();
		
		$this->setLayout('wizard');

		parent::display();
	}
}