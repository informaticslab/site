<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: ftpbrowser.php 304 2010-11-17 12:34:57Z nikosdion $
 * @since 2.2
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.controller');

/**
 * Folder bowser controller
 *
 */
class AkeebaControllerFtpbrowser extends JController
{
	public function  __construct($config = array()) {
		parent::__construct($config);
		if(AKEEBA_JVERSION=='16')
		{
			// Access check, Joomla! 1.6 style.
			if (!JFactory::getUser()->authorise('akeeba.configure', 'com_akeeba')) {
				$this->setRedirect('index.php?option=com_akeeba');
				return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
				$this->redirect();
			}
		}
	}

	public function display()
	{
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', $this->getName() );

		$view = & $this->getView( $viewName, $viewType, '', array( 'base_path'=>$this->_basePath));

		// Get/Create the model
		if ($model = & $this->getModel($viewName)) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Grab the data and push them to the model
		$model->host = JRequest::getString('host','');
		$model->port = JRequest::getInt('port',21);
		$model->passive = JRequest::getInt('passive',1);
		$model->ssl = JRequest::getInt('ssl',0);
		$model->username = JRequest::getVar('username','');
		$model->password = JRequest::getVar('password','');
		$model->directory = JRequest::getVar('directory', '');

		// Set the layout
		$view->setLayout('default');

		$view->display();
	}
}