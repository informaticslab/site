<?php
/**
 * JComments - Joomla Comment System
 *
 * System plugin for attaching JComments CSS & JavaScript to HEAD tag
 *
 * @version 2.1
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

if (defined('JPATH_ROOT') && defined('JPATH_LIBRARIES')) {
	jimport( 'joomla.plugin.plugin');

	class plgSystemJComments extends JPlugin
	{
		function plgSystemJComments(&$subject, $config)
		{
			parent::__construct($subject, $config);

			if (!isset($this->params)) {
				$this->params = new JParameter('');
			}

			// small hack to allow CAPTCHA display even if any notice or warning occurred
			$option = JRequest::getCmd('option');
			$task = JRequest::getCmd('task');
			if ($option == 'com_jcomments' && $task == 'captcha') {
				@ob_start();
			}
		}

		function onAfterRender()
		{
		        if ((defined('JCOMMENTS_CSS') || defined('JCOMMENTS_JS'))
		        	&& !defined('JCOMMENTS_SHOW')) {

				$app =& JFactory::getApplication();

				if ($app->getName() != 'site') {
					return true;
				}

				$buffer = JResponse::getBody();

				$regexpJS = '#(\<script(\stype=\"text\/javascript\")? src="[^\"]*\/com_jcomments\/[^\>]*\>\<\/script\>[\s\r\n]*?)#ismU';
				$regexpCSS = '#(\<link rel="stylesheet" href="[^\"]*\/com_jcomments\/[^>]*>[\s\r\n]*?)#ismU';

				$jcommentsTestJS = '#(JCommentsEditor|new JComments)#ismU';
				$jcommentsTestCSS = '#(comment-link|jcomments-links)#ismU';

				$jsFound = preg_match($jcommentsTestJS, $buffer);
				$cssFound = preg_match($jcommentsTestCSS, $buffer);

				if (!$jsFound) {
					// remove JavaScript if JComments isn't loaded
					$buffer = preg_replace($regexpJS, '', $buffer);
				}

				if (!$cssFound && !$jsFound) {
					// remove CSS if JComments isn't loaded
					$buffer = preg_replace($regexpCSS, '', $buffer);
				}

				if ($buffer != '') {
					JResponse::setBody($buffer);
				}
			}
			return true;
		}

		function onAfterRoute()
		{
			include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');

			$mainframe = & JFactory::getApplication('site');
			$mainframe->getRouter();
			$document = & JFactory::getDocument();

			if ($document->getType() == 'pdf') {
				return;
			}

			if ($mainframe->isAdmin()) {
				$document->addStyleSheet(JURI::base().'components/com_jcomments/assets/icon.css?v=2');
				
				$option = JAdministratorHelper::findOption();
				$task = JRequest::getCmd('task');
				$type = JRequest::getCmd('type', '', 'post');

				// remove comments if content item deleted from trash
				if ($option == 'com_trash' && $task == 'delete' && $type == 'content') {
					$cid = JRequest::getVar('cid', array(0), 'post', 'array');
					JArrayHelper::toInteger($cid, array(0));
					include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
					JComments::deleteComments($cid, 'com_content');
				}
			} else {
				$option = JRequest::getCmd('option');

				if ($option == 'com_content' || $option == 'com_alphacontent') {
					include_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
					include_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
					include_once (JCOMMENTS_HELPERS.DS.'system.php');

					// include JComments CSS
					if ($this->params->get('disable_template_css', 0) == 0) {
						$document->addStyleSheet(JCommentsSystemPluginHelper::getCSS());

						$language = & JFactory::getLanguage();
						if ($language->isRTL()) {
							$rtlCSS = JCommentsSystemPluginHelper::getCSS(true);
							if ($rtlCSS != '') {
								$document->addStyleSheet($rtlCSS);
							}
						}
					}

					if (!defined('JCOMMENTS_CSS')) {
						define('JCOMMENTS_CSS', 1);
					}

					$config = & JCommentsCfg::getInstance();

					// include JComments JavaScript library
					$document->addScript(JCommentsSystemPluginHelper::getCoreJS());
					if (!defined('JOOMLATUNE_AJAX_JS')) {
						$document->addScript(JCommentsSystemPluginHelper::getAjaxJS());
						define('JOOMLATUNE_AJAX_JS', 1);
					}

					if (!defined('JCOMMENTS_JS')) {
						define('JCOMMENTS_JS', 1);
					}
				}
			}
		}
	} // class plgSystemJComments
} else {
	// define directory separator short constant
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}

	global $_MAMBOTS;
	$_MAMBOTS->registerFunction('onAfterStart', 'plgSystemJComments');

	function plgSystemJComments()
	{
		global $mosConfig_absolute_path, $mainframe;
		include_once ($mosConfig_absolute_path.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
	
		// if component doesn't exists (may be already uninstalled) - return
		if (!defined('JCOMMENTS_JVERSION')) {
			return;
		}
	
		include_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
		include_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
		include_once (JCOMMENTS_HELPERS.DS.'system.php');
		
		// include JComments CSS
		$mainframe->addCustomHeadTag('<link href="' . JCommentsSystemPluginHelper::getCSS() . '" rel="stylesheet" type="text/css" />');

		if (!defined('JCOMMENTS_CSS')) {
			define('JCOMMENTS_CSS', 1);
		}

		if (!$mainframe->isAdmin()) {
			$config = & JCommentsCfg::getInstance();
			// include JComments JavaScript library
			$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getCoreJS(true));
			if (!defined('JOOMLATUNE_AJAX_JS')) {
				$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getAjaxJS(true));
				define('JOOMLATUNE_AJAX_JS', 1);
			}

			if (!defined('JCOMMENTS_JS')) {
				define('JCOMMENTS_JS', 1);
			}
		}
	}
}
?>