<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.raw.php 304 2010-11-17 12:34:57Z nikosdion $
 * @since 2.2
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.view');

class AkeebaViewFtpbrowser extends JView
{
	function display($tpl = null)
	{
		$model = $this->getModel();
		$list = $model->getListing();

		// Pass along the directory list, breadcrumbs and any error messages
		$this->assign('error', $model->getError() );
		$this->assign('list', $list);
		$this->assign('breadcrumbs', $model->parts);
		$this->assign('directory', $model->directory);
		$this->assign('parent_directory', $model->parent_directory);

		// Add the stylesheet
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'../media/com_akeeba/theme/browser.css');

		parent::display();
	}
}
?>
