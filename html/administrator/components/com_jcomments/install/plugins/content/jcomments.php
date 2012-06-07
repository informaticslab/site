<?php
/**
 * JComments - Joomla Comment System
 *
 * Plugin for attaching comments list and form to content item
 *
 * @version 2.1
 * @package JComments
 * @subpackage Content
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
} else {
	global $mainframe;
	include_once ($mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
}

// if component doesn't exists (may be already uninstalled) - return
if (!defined('JCOMMENTS_JVERSION')) {
	return;
}

if (defined('JPATH_ROOT') && defined('JPATH_LIBRARIES')) {
	jimport( 'joomla.plugin.plugin');

	$GLOBALS['JC_CONTENT_TASK'] = JRequest::getCmd('view') == 'article' ? 'view' : '';

	class plgContentJComments extends JPlugin
	{
		function plgContentJComments(&$subject, $config)
		{
			parent::__construct($subject, $config);

			if (!isset($this->params)) {
				$this->params = new JParameter('');
			}

			if (!class_exists('ContentHelperRoute')) {
				require_once(JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
			}
		}

		function onPrepareContent(&$article, &$params, $limitstart = 0)
		{
			require_once (JCOMMENTS_HELPERS.DS.'content.php');

			// check whether plugin has been unpublished
			if (!JPluginHelper::isEnabled('content', 'jcomments')) {
				JCommentsContentPluginHelper::clear($article, true);
				return;
			}

			$application = &JFactory::getApplication('site');
			$option = JRequest::getCmd('option');
			$view = JRequest::getCmd('view');

			if (!isset($article->id) 
			|| ($option != 'com_content' && $option != 'com_alphacontent' && $option != 'com_customproperties')) {
				return;
			}
			        
			if (!isset($params) || $params == null) {
				$params = new JParameter('');
			} else if (strpos($params->_raw, 'moduleclass_sfx') !== false) {
				return '';
			}

			if ($view == 'frontpage') {
				if ($this->params->get('show_frontpage', 1) == 0) {
					return;
				}
			}

			require_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
			require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');

			JCommentsContentPluginHelper::processForeignTags($article);

			$config = & JCommentsFactory::getConfig();

			$categoryEnabled = JCommentsContentPluginHelper::checkCategory($article->catid);
			$commentsEnabled = JCommentsContentPluginHelper::isEnabled($article) || $categoryEnabled;
			$commentsDisabled = JCommentsContentPluginHelper::isDisabled($article) || !$commentsEnabled;
			$commentsLocked = JCommentsContentPluginHelper::isLocked($article);

			if ($article->state == -1 && $config->getInt('enable_for_archived') == 0) {
				$commentsLocked = true;
			}

			$config->set('comments_on', intval($commentsEnabled));
			$config->set('comments_off', intval($commentsDisabled));
			$config->set('comments_locked', intval($commentsLocked));

			if ($view != 'article') {
				$user = & JFactory::getUser();

				if ($article->access <= $user->get('aid', 0)) {
					$readmore_link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug, $article->sectionid));
					$readmore_register = 0;
				} else {
					$readmore_link = JRoute::_('index.php?option=com_user&task=register');
					$readmore_register = 1;
				}

				// load template for comments & readmore links
				$tmpl = & JCommentsFactory::getTemplate($article->id, 'com_content', false);
				$tmpl->load('tpl_links');

				$tmpl->addVar('tpl_links', 'comments_link_style', ($readmore_register ? -1 : 1));
				$tmpl->addVar('tpl_links', 'content-item', $article);
				$tmpl->addVar('tpl_links', 'show_hits', intval($this->params->get('show_hits', 0) && $params->get('show_hits', 0)));
				$tmpl->addVar('tpl_links', 'link-comment', $readmore_link);
				$tmpl->addVar('tpl_links', 'link-comments-class', $this->params->get('comments_css_class', 'comments-link'));

				$readmoreDisabled = false;

				if (($params->get('show_readmore') == 0) || (@$article->readmore == 0)) {
					$readmoreDisabled = true;
				} else if(@$article->readmore > 0) {
					$readmoreDisabled = false;
				}

				if ($this->params->get('readmore_link', 1) == 0) {
					$readmoreDisabled = true;
				}

				$tmpl->addVar('tpl_links', 'readmore_link_hidden', intval($readmoreDisabled));

				// don't fill any readmore variable if it disabled
				if (!$readmoreDisabled) {
					if ($readmore_register == 1) {
						$readmore_text = JText::_('Register to read more...');
					} else if (isset($params) && $readmore = $params->get('readmore')) {
						$readmore_text = $readmore;
					} else {
						$readmore_text = JText::_('Read more...');
					}
					$tmpl->addVar('tpl_links', 'link-readmore', $readmore_link);
					$tmpl->addVar('tpl_links', 'link-readmore-text', $readmore_text);
					$tmpl->addVar('tpl_links', 'link-readmore-title', $article->title);
					$tmpl->addVar('tpl_links', 'link-readmore-class', $this->params->get('readmore_css_class', 'readmore-link'));
				}

				$commentsDisabled = false;

				if ($config->getInt('comments_off', 0) == 1) {
					$commentsDisabled = true;
				} else if ($config->getInt('comments_on', 0) == 1) {
					$commentsDisabled = false;
				}

				$tmpl->addVar('tpl_links', 'comments_link_hidden', intval($commentsDisabled));

				$count = 0;

				// do not query comments count if comments disabled and link hidden
				if (!$commentsDisabled && $this->params->get('comments_count', 1) != 0) {
					require_once (JCOMMENTS_BASE.DS.'model'.DS.'jcomments.php');
					$count = JCommentsModel::getCommentsCount($article->id, 'com_content');
					$tmpl->addVar('tpl_links', 'comments-count', $count);

					if ($config->getInt('use_plural_forms', 0)) {
						require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'language.tools.php');
						$tmpl->addVar('tpl_links', 'use-plural-forms', $config->getInt('use_plural_forms', 0));
					}
				}

				JCommentsContentPluginHelper::clear($article, true);

				// hide comments link if comments enabled but link disabled in plugin params
				if ((($this->params->get('comments_count', 1) == 0)
				|| ($count == 0 && $this->params->get('add_comments', 1) == 0)
				|| ($count == 0 && $readmore_register == 1))
				&& !$commentsDisabled) {
					$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
				}

				//links_position
				if ($this->params->get('links_position', 1) == 1) {
					$article->text .= $tmpl->renderTemplate('tpl_links');
				} else {
					$article->text = $tmpl->renderTemplate('tpl_links') . $article->text;
				}

				$tmpl->freeTemplate('tpl_links');

				if ($this->params->get('readmore_link', 1) == 1) {
					$article->readmore = 0;

					if (isset($params)) {
						$params->set('show_readmore', 0);
					}

					$article->readmore_link = '';
					$article->readmore_register = false;
				}
			} else {
				if ($this->params->get('show_comments_event') == 'onPrepareContent') {
					$isEnabled = ($config->getInt('comments_on', 0) == 1) && ($config->getInt('comments_off', 0) == 0);

					if ($isEnabled && $view == 'article') {
						require_once (JCOMMENTS_BASE.DS.'jcomments.php');
						$article->text .= JComments::show($article->id, 'com_content', $article->title);
					}
				} else {
					$user = JFactory::getUser();
					if ($user->usertype == 'Super Administrator') {
						$application = &JFactory::getApplication('site');
						$template = $application->getTemplate();
						$articleTemplate = DS.'templates'.DS.$template.DS.'html'.DS.'com_content'.DS.'article'.DS.'default.php';
						if (is_file(JPATH_SITE.$articleTemplate)) {
							$tmpl = implode('', file(JPATH_SITE.$articleTemplate));
							if (strpos($tmpl, 'afterDisplayContent') === false) {
								JError::raiseWarning(500, JText::sprintf('The article template (%s) doesn\'t have afterDisplayContent event!',  $articleTemplate));
							}
						}
					}
				}
				JCommentsContentPluginHelper::clear($article, true);
			}
			return;
		}

		function onAfterDisplayContent(&$article, &$params, $limitstart = 0)
		{
			if ($this->params->get('show_comments_event', 'onAfterDisplayContent') == 'onAfterDisplayContent') {
				require_once (JCOMMENTS_HELPERS.DS.'content.php');

				$application = &JFactory::getApplication('site');
				$view = JRequest::getCmd('view');

				// check whether plugin has been unpublished
				if (!JPluginHelper::isEnabled('content', 'jcomments')
				|| ($view != 'article')
				|| $params->get('intro_only')
				|| $params->get('popup')
				|| JRequest::getBool('fullview')
				|| JRequest::getVar('print')) {
					JCommentsContentPluginHelper::clear($article, true);
					return '';
				}

				require_once (JCOMMENTS_BASE.DS.'jcomments.php');

				$config = & JCommentsFactory::getConfig();
				$isEnabled = ($config->getInt('comments_on', 0) == 1) && ($config->getInt('comments_off', 0) == 0);

				if ($isEnabled && $view == 'article') {
					JCommentsContentPluginHelper::clear($article, true);
					return JComments::show($article->id, 'com_content', $article->title);
				}
			}
			return '';
		}
	}
} else {
	global $_MAMBOTS;
	$_MAMBOTS->registerFunction('onAfterDisplayContent', 'plgContentJCommentsViewJ10');
	$_MAMBOTS->registerFunction('onPrepareContent', 'plgContentJCommentsLinksJ10');

	function plgContentJCommentsViewJ10( &$row, &$params, $page = 0)
	{
		global $task, $option;

		if (!isset($params)) {
			$params = new mosParameters('');
		}

		$pvars = array_keys(get_object_vars($params->_params));

		if ($params->get('popup') || in_array('moduleclass_sfx', $pvars)) {
			return '';
		}

		if (isset($GLOBALS['jcomments_params_readmore'])
		&& isset($GLOBALS['jcomments_row_readmore'])) {
			$params->set('readmore', $GLOBALS['jcomments_params_readmore']);
			$row->readmore = $GLOBALS['jcomments_row_readmore'];
		}

		require_once (JCOMMENTS_BASE.DS.'jcomments.php');
		require_once (JCOMMENTS_HELPERS.DS.'content.php');

		JCommentsContentPluginHelper::processForeignTags($row, false, false);

		if (JCommentsContentPluginHelper::isDisabled($row)) {
			return '';
		}

		if (($task == 'view')
		&& (JCommentsContentPluginHelper::checkCategory($row->catid)
			|| JCommentsContentPluginHelper::isEnabled($row))) {

			if (JCommentsContentPluginHelper::isLocked($row)) {
				$config = & JCommentsFactory::getConfig();
				$config->set('comments_locked', 1);
			}
			return JComments::show($row->id, 'com_content', $row->title);
		} else if (($option == 'com_events') && ($task == 'view_detail')) {
			return JComments::show($row->id, 'com_events', $row->title);
		}
		return '';
	}

	function plgContentJCommentsLinksJ10( $published, &$row, &$params, $page = 0)
	{
		global $mainframe, $task, $option, $Itemid, $my;

		// disable comments link in 3rd party components (except Events and AlphaContent)
		if ($option != 'com_content' && $option != 'com_frontpage'
		&& $option != 'com_alphacontent' && $option != 'com_events') {
			return;
		}

		require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
		require_once (JCOMMENTS_HELPERS.DS.'content.php');
		require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'language.tools.php');
	
		if (!isset($params) || $params == null) {
			$params = new mosParameters('');
		}

		$pvars = array_keys(get_object_vars($params->_params));
		if (!$published || $params->get('popup') || in_array('moduleclass_sfx', $pvars)) {
			JCommentsContentPluginHelper::processForeignTags($row, true);
			JCommentsContentPluginHelper::clear($row, true);
			return;
		}

		if ($option == 'com_frontpage') {
			$pluginParams = JCommentsPluginHelper::getParams('jcomments.content', 'content');
			if ((int)$pluginParams->get('show_frontpage', 1) == 0) {
				return;
			}
		}

		require_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
		require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');

		if ($task != 'view') {
			// replace other comment systems tags to JComments equivalents like {jcomments on}
			JCommentsContentPluginHelper::processForeignTags($row, false);

			// show link to comments only
			if ($row->access <= $my->gid) {
				$readmore_link = JCommentsObjectHelper::getLink($row->id, 'com_content');
				$readmore_register = 0;
			} else {
				$readmore_link = sefRelToAbs('index.php?option=com_registration&amp;task=register');
				$readmore_register = 1;
			}

			$tmpl = & JCommentsFactory::getTemplate($row->id, 'com_content', false);
			$tmpl->load('tpl_links');

			$tmpl->addVar('tpl_links', 'comments_link_style', ($readmore_register ? -1 : 1));
			$tmpl->addVar('tpl_links', 'link-comment', $readmore_link);
			$tmpl->addVar('tpl_links', 'link-readmore', $readmore_link);
			$tmpl->addVar('tpl_links', 'content-item', $row);

			if (($params->get('readmore') == 0) || (@$row->readmore == 0)) {
				$tmpl->addVar('tpl_links', 'readmore_link_hidden', 1);
			} else if (@$row->readmore > 0) {
				$tmpl->addVar('tpl_links', 'readmore_link_hidden', 0);
			}

			$config = & JCommentsFactory::getConfig();

			$commentsDisabled = false;

			if (!JCommentsContentPluginHelper::checkCategory($row->catid)) {
				$commentsDisabled = true;
			}
			if ($config->getInt('comments_off', 0) == 1) {
				$commentsDisabled = true;
			} else if ($config->getInt('comments_on', 0) == 1) {
				$commentsDisabled = false;
			}

			$tmpl->addVar('tpl_links', 'comments_link_hidden', intval($commentsDisabled));

			$count = 0;
			// do not query comments count if comments disabled and link hidden
			if (!$commentsDisabled) {
				require_once (JCOMMENTS_BASE.DS.'model'.DS.'jcomments.php');
				$count = JCommentsModel::getCommentsCount($row->id, 'com_content');
				$tmpl->addVar('tpl_links', 'comments-count', $count);

				if ($config->getInt('use_plural_forms', 0)) {
					require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'language.tools.php');
					$tmpl->addVar('tpl_links', 'use-plural-forms', $config->getInt('use_plural_forms', 0));
				}
			}

			if ($readmore_register == 1 && $count == 0) {
				$tmpl->addVar('tpl_links', 'comments_link_hidden', 1);
			}

			if ($readmore_register == 1) {
				$readmore_text = JText::_('READMORE_REGISTER');
			} else {
				$readmore_text = JText::_('READMORE');
			}

			$tmpl->addVar('tpl_links', 'link-readmore-text', $readmore_text);
			$tmpl->addVar('tpl_links', 'link-readmore-title', $row->title);
			$tmpl->addVar('tpl_links', 'link-readmore-class', 'readmore-link');
			$tmpl->addVar('tpl_links', 'link-comments-class', 'comments-link');

			JCommentsContentPluginHelper::clear($row, true);

			$row->text .= $tmpl->renderTemplate('tpl_links');

			$GLOBALS['jcomments_params_readmore'] = $params->get('readmore');
			$GLOBALS['jcomments_row_readmore'] = $row->readmore;

			$params->set('readmore', 0);
			$row->readmore = 0;
		} else {
			JCommentsContentPluginHelper::processForeignTags($row, true);
			JCommentsContentPluginHelper::clear($row, true);
		}
		return;
	}
}
?>