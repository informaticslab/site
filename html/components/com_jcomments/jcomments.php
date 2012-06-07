<?php
/**
 * JComments - Joomla Comment System
 *
 * Frontend event handler
 *
 * @version 2.1
 * @package JComments
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

global $mainframe, $my;

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

ob_start();
// include legacy class
require_once (dirname(__FILE__).DS.'jcomments.legacy.php');

if (!defined('JCOMMENTS_ENCODING')) {
	DEFINE('JCOMMENTS_ENCODING', strtolower(preg_replace('/charset=/', '', _ISO)));
	if (JCOMMENTS_ENCODING == 'utf-8') {
		// pattern strings are treated as UTF-8
		DEFINE('JCOMMENTS_PCRE_UTF8', 'u');
	} else {
		DEFINE('JCOMMENTS_PCRE_UTF8', '');
	}
}

// regular expression for links
//DEFINE('_JC_REGEXP_LINK', '#(^|\s|\>|\()((http://|https://|news://|ftp://|www.)\w+[^\s\[\]\<\>\"\'\)]+)#i' . JCOMMENTS_PCRE_UTF8);
DEFINE('_JC_REGEXP_LINK', '#(^|\s|\>|\()((http://|https://|news://|ftp://|www.)\w+[^\s\<\>\"\'\)]+)#i' . JCOMMENTS_PCRE_UTF8);
DEFINE('_JC_REGEXP_EMAIL', '#([\w\.\-]+)@(\w+[\w\.\-]*?\.\w{1,4})#i' . JCOMMENTS_PCRE_UTF8);
DEFINE('_JC_REGEXP_EMAIL2', '#^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#i' . JCOMMENTS_PCRE_UTF8);

require_once (JCOMMENTS_BASE.DS.'jcomments.config.php');
require_once (JCOMMENTS_BASE.DS.'jcomments.class.php');
require_once (JCOMMENTS_BASE.DS.'model'.DS.'jcomments.php');
require_once (JCOMMENTS_HELPERS.DS.'object.php');
ob_end_clean();

$jc_task = JCommentsInput::getVar('task', '');

switch(trim($jc_task)) {
	case 'captcha':
		$config = & JCommentsFactory::getConfig();
		$captchaEngine = $config->get('captcha_engine', 'kcaptcha');
		if ($captchaEngine == 'kcaptcha' || $config->getInt('enable_mambots') == 0) {
			require_once (JCOMMENTS_BASE.DS.'jcomments.captcha.php');
			JCommentsCaptcha::image();
		} else {
			if ($config->getInt('enable_mambots') == 1) {
				require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
				JCommentsPluginHelper::importPlugin('jcomments');
				JCommentsPluginHelper::trigger('onJCommentsCaptchaImage');
			}
		}
		break;
	case 'rss':
		require_once (JCOMMENTS_BASE.DS.'jcomments.rss.php');
		JCommentsRSS::feedLastComments();
		break;
	case 'rss_full':
		require_once (JCOMMENTS_BASE.DS.'jcomments.rss.php');
		JCommentsRSS::feedLastCommentsGlobal();
		break;
	case 'unsubscribe':
		JComments::unsubscribe();
		break;
	case 'cmd':
		JComments::executeCmd();
		break;
	case 'go2object':
		JComments::redirectToObject();
		break;
	default:
		$jc_option = JCommentsInput::getVar('option', '');
		$jc_ajax = JCommentsInput::getVar('jtxf', '');

		if ($jc_option == 'com_jcomments' && $jc_ajax == '' && !$mainframe->isAdmin()) {

			$_Itemid = (int) JCommentsInput::getVar('Itemid');
			$_tmpl = JCommentsInput::getVar('tmpl');

			if ($_Itemid !== 0 && $_tmpl !== 'component') {
				if (JCOMMENTS_JVERSION == '1.5') {
					$params = & JComponentHelper::getParams('com_jcomments');
				} else {
					$menu = $mainframe->get('menu');
					if ($menu != null) {
						$params = new mosParameters($menu->params);
					} else {
						$params = new mosParameters('');
					}
				}

				$object_group = $params->get('object_group');
				$object_id = (int) $params->get('object_id', 0);

				if ($object_id != 0 && $object_group != '') {

					if ($params->get('language_suffix') != '') {
						JComments::loadAlternateLanguage($params->get('language_suffix'));
					}

					$keywords = $params->get('keywords');
					$description = $params->get('description');
					$pageTitle = $params->get('page_title');

					if (JCOMMENTS_JVERSION == '1.5') {
						$document =& JFactory::getDocument();
						if ($pageTitle != '') {
							$document->setTitle($pageTitle);
						}
						if ($keywords) {
							$document->setMetaData('keywords', $keywords);
						}
						if ($description) {
							$document->setDescription($description);
						}
					} else {
						if ($pageTitle != '') {
							$mainframe->setPageTitle($pageTitle);
						}
						if ($keywords) {
							$mainframe->appendMetaTag('keywords', $keywords);
						}
						if ($description) {
							$mainframe->appendMetaTag('description', $description);
						}
					}

					echo JComments::show($object_id, $object_group);
				} else {
					JCommentsRedirect($mainframe->getCfg('live_site').'/index.php');
				}
			} else {
				JCommentsRedirect($mainframe->getCfg('live_site').'/index.php');
			}
		}
		break;
}

if (isset($_REQUEST['jtxf'])) {
	require_once (JCOMMENTS_BASE.DS.'jcomments.ajax.php');

	JComments::loadAlternateLanguage();

	$jtx = new JoomlaTuneAjax();
	$jtx->setCharEncoding(JCOMMENTS_ENCODING);
	$jtx->registerFunction(array('JCommentsAddComment', 'JCommentsAJAX', 'addComment'));
	$jtx->registerFunction(array('JCommentsDeleteComment', 'JCommentsAJAX', 'deleteComment'));
	$jtx->registerFunction(array('JCommentsEditComment', 'JCommentsAJAX', 'editComment'));
	$jtx->registerFunction(array('JCommentsCancelComment', 'JCommentsAJAX', 'cancelComment'));
	$jtx->registerFunction(array('JCommentsSaveComment', 'JCommentsAJAX', 'saveComment'));
	$jtx->registerFunction(array('JCommentsPublishComment', 'JCommentsAJAX', 'publishComment'));
	$jtx->registerFunction(array('JCommentsQuoteComment', 'JCommentsAJAX', 'quoteComment'));
	$jtx->registerFunction(array('JCommentsShowPage', 'JCommentsAJAX', 'showPage'));
	$jtx->registerFunction(array('JCommentsShowComment', 'JCommentsAJAX', 'showComment'));
	$jtx->registerFunction(array('JCommentsJump2email', 'JCommentsAJAX', 'jump2email'));
	$jtx->registerFunction(array('JCommentsShowForm', 'JCommentsAJAX', 'showForm'));
	$jtx->registerFunction(array('JCommentsVoteComment', 'JCommentsAJAX', 'voteComment'));
	$jtx->registerFunction(array('JCommentsShowReportForm', 'JCommentsAJAX', 'showReportForm'));
	$jtx->registerFunction(array('JCommentsReportComment', 'JCommentsAJAX', 'reportComment'));
	$jtx->registerFunction(array('JCommentsSubscribe', 'JCommentsAJAX', 'subscribeUser'));
	$jtx->registerFunction(array('JCommentsUnsubscribe', 'JCommentsAJAX', 'unsubscribeUser'));
	$jtx->processRequests();
}

class JComments
{
	/*
	 * The main function that displays comments list & form (if needed)
	 *
	 * @static
	 * @return string
	 * @access public
	 */
	function show( $object_id, $object_group = 'com_content', $object_title = '' )
	{
		global $mainframe;

		// only one copy of JComments per page is allowed
		if (defined('JCOMMENTS_SHOW')) {
			return;
		}

		$object_id = (int) $object_id;
		$object_group = trim(strip_tags($object_group));
		$object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.]#is', '', $object_group);
		
		$object_title = trim($object_title);

		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();

		$tmpl = & JCommentsFactory::getTemplate($object_id, $object_group);
		$tmpl->load('tpl_index');

		if ($config->getInt('comments_locked', 0) == 1) {
			$config->set('enable_rss', 0);
			$tmpl->addVar('tpl_index', 'comments-form-locked', 1);
		}

		if (JCOMMENTS_JVERSION == '1.5') {
			$document = & JFactory::getDocument();
		}

		if (!defined('JCOMMENTS_CSS')) {
			include_once (JCOMMENTS_HELPERS.DS.'system.php');
			if ($mainframe->isAdmin()) {
				$tmpl->addVar('tpl_index', 'comments-css', 1);
			} else {
				$link = JCommentsSystemPluginHelper::getCSS();
				if (JCOMMENTS_JVERSION == '1.5') {
					$document->addStyleSheet($link);

					$language = & JFactory::getLanguage();
					if ($language->isRTL()) {
						$rtlCSS = JCommentsSystemPluginHelper::getCSS(true);
						if ($rtlCSS != '') {
							$document->addStyleSheet($rtlCSS);
						}
					}
				} else {
					$mainframe->addCustomHeadTag('<link href="' . $link . '" rel="stylesheet" type="text/css" />');
				}
			}
		}

		if (!defined('JCOMMENTS_JS')) {
			include_once (JCOMMENTS_HELPERS.DS.'system.php');
			if (JCOMMENTS_JVERSION == '1.5') {
				$document->addScript(JCommentsSystemPluginHelper::getCoreJS());
			} else {
				$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getCoreJS(true));
			}

			if (!defined('JOOMLATUNE_AJAX_JS')) {
				if (JCOMMENTS_JVERSION == '1.5') {
					$document->addScript(JCommentsSystemPluginHelper::getAjaxJS());
				} else {
					$mainframe->addCustomHeadTag(JCommentsSystemPluginHelper::getAjaxJS(true));
				}
				define('JOOMLATUNE_AJAX_JS', 1);
			}
		}

		$commentsCount = JCommentsModel::getCommentsCount($object_id, $object_group);
		$showForm = ($config->getInt('form_show') == 1) || ($config->getInt('form_show') == 2 && $commentsCount == 0);

		$tmpl->addVar('tpl_index', 'comments-form-captcha', $acl->check('enable_captcha'));
		$tmpl->addVar('tpl_index', 'comments-form-link', $showForm ? 0 : 1);

		if ($config->getInt('enable_rss') == 1) {
			$link = JCommentsFactory::getLink('rss', $object_id, $object_group);
			if (JCOMMENTS_JVERSION == '1.5') {
				$attribs = array('type' => 'application/rss+xml', 'title' => strip_tags($object_title));
				$document->addHeadLink($link, 'alternate', 'rel', $attribs);
			} else {
				$html = '<link rel="alternate" type="application/rss+xml" title="' . strip_tags($object_title) . '" href="' . $link . '" />';
				$mainframe->addCustomHeadTag( $html );
			}
		}

		$cacheEnabled = intval($mainframe->getCfg('caching')) == 1;

		if ($cacheEnabled == 0) {
			$jrecache = $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jrecache'.DS.'jrecache.config.php';

			if (is_file($jrecache)) {
				$cfg = new _JRECache_Config();
				$cacheEnabled = $cacheEnabled && $cfg->enable_cache;
			}
		}

		$load_cached_comments = intval($config->getInt('load_cached_comments', 0) && $commentsCount > 0);

		if ($cacheEnabled && $commentsCount > 0) {
			$tmpl->addVar('tpl_index', 'comments-anticache', 1);
		}

		if (!$cacheEnabled || $load_cached_comments === 1) {
			if ($config->get('template_view') == 'tree') {
				$tmpl->addVar('tpl_index', 'comments-list', $commentsCount > 0 ? JComments::getCommentsTree($object_id, $object_group) : '');
			} else {
				$tmpl->addVar('tpl_index', 'comments-list', $commentsCount > 0 ? JComments::getCommentsList($object_id, $object_group) : '');
			}
		}

		$needScrollToComment = ($cacheEnabled || ($config->getInt('comments_per_page') > 0)) && $commentsCount > 0;
		$tmpl->addVar('tpl_index', 'comments-gotocomment', (int) $needScrollToComment);
		$tmpl->addVar('tpl_index', 'comments-form', JComments::getCommentsForm($object_id, $object_group, $showForm));

		$result = $tmpl->renderTemplate('tpl_index');
		$tmpl->freeAllTemplates();

		define('JCOMMENTS_SHOW', 1);

		return $result;
	}

	function loadAlternateLanguage($languageSuffix = '')
	{
		if ($languageSuffix == '') {
			$languageSuffix = JCommentsInput::getVar('lsfx', '');
		}
		if ($languageSuffix != '') {
			$config = & JCommentsFactory::getConfig();
			$config->set('lsfx', $languageSuffix);

			$language = & JFactory::getLanguage();
			$language->load('com_jcomments.' . $languageSuffix, JPATH_SITE);
		}
	}

	function getCommentsForm( $object_id, $object_group, $showForm = true )
	{
		global $my;

		$object_id = (int) $object_id;
		$object_group = trim($object_group);

		$tmpl = & JCommentsFactory::getTemplate($object_id, $object_group);
		$tmpl->load('tpl_form');

		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();

		if ($acl->canComment()) {
			if ($config->getInt('comments_locked', 0) == 1 ) {
				$message = $config->get('message_locked');

				if ($message != '') {
					$message = preg_replace('/(\n|\r)+/', '<br />', stripslashes($message));
				} else {
					$message = JText::_('ERROR_CANT_COMMENT');
				}

				$tmpl->addVar('tpl_form', 'comments-form-message', 1);
				$tmpl->addVar('tpl_form', 'comments-form-message-header', JText::_('FORM_HEADER'));
				$tmpl->addVar('tpl_form', 'comments-form-message-text', $message);
				$result = $tmpl->renderTemplate('tpl_form');

				return $result;
			}

			if ($acl->check('enable_captcha') == 1) {
				$captchaEngine = $config->get('captcha_engine', 'kcaptcha');
				if ($captchaEngine != 'kcaptcha') {
					if ($config->getInt('enable_mambots') == 1) {
						require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onJCommentsCaptchaJavaScript');
					}
				}
			}

			if (!$showForm) {
				$tmpl->addVar('tpl_form', 'comments-form-link', 1);
				$result = $tmpl->renderTemplate('tpl_form');

				return $result;
			} else {
				if ($config->getInt('form_show') != 1) {
					$tmpl->addVar('tpl_form', 'comments-form-ajax', 1);
				}
			}

			if ($config->getInt('enable_mambots') == 1) {
				require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
				JCommentsPluginHelper::importPlugin('jcomments');

                                $htmlBeforeForm = JCommentsPluginHelper::trigger('onJCommentsBeforeFormDisplayed');
				$htmlAfterForm = JCommentsPluginHelper::trigger('onJCommentsAfterFormDisplayed');

				$tmpl->addVar('tpl_form', 'comments-form-html-before', implode("\n", $htmlBeforeForm));
				$tmpl->addVar('tpl_form', 'comments-form-html-after', implode("\n", $htmlAfterForm));
			}

			$policy = $config->get('message_policy_post');
			if (($policy != '') && ($acl->check('show_policy'))) {
				$policy = preg_replace('/(\n|\r)+/', '<br />', stripslashes($policy));
				$tmpl->addVar('tpl_form', 'comments-form-policy', 1);
				$tmpl->addVar('tpl_form', 'comments-policy', $policy);
			}

			if ($my->id) {
				$currentUser = JCommentsFactory::getUser($my->id);
				$my->name = $currentUser->name;
				unset($currentUser);
			}

			$tmpl->addObject('tpl_form', 'user', $my);

			if ($config->getInt('enable_smiles') == 1 && is_array($config->get('smiles'))) {
				$tmpl->addVar('tpl_form', 'comment-form-smiles', $config->get('smiles'));
			}

			$bbcode = & JCommentsFactory::getBBCode();

			if ($bbcode->enabled()) {
				$tmpl->addVar('tpl_form', 'comments-form-bbcode', 1);
				foreach($bbcode->getCodes() as $code) {
					$tmpl->addVar('tpl_form', 'comments-form-bbcode-' . $code, $bbcode->canUse($code));
				}
			}

			if ($config->getInt('enable_custom_bbcode')) {
				$customBBCode = & JCommentsFactory::getCustomBBCode();
				if ($customBBCode->enabled()) {
					$tmpl->addVar('tpl_form', 'comments-form-custombbcodes', $customBBCode->codes);
				}
			}

			$username_maxlength = $config->getInt('username_maxlength');
			if ( $username_maxlength <= 0 || $username_maxlength > 255 ) {
				$username_maxlength = 255;
			}
			$tmpl->addVar('tpl_form', 'comment-name-maxlength', $username_maxlength);

			if (($config->getInt('show_commentlength') == 1)
			&& ($acl->check('enable_comment_length_check'))) {
				$tmpl->addVar('tpl_form', 'comments-form-showlength-counter', 1);
				$tmpl->addVar('tpl_form', 'comment-maxlength', $config->getInt('comment_maxlength'));
			} else {
				$tmpl->addVar('tpl_form', 'comment-maxlength', 0);
			}

			if ($acl->check('enable_captcha') == 1) {
				$tmpl->addVar('tpl_form', 'comments-form-captcha', 1);

				$captchaEngine = $config->get('captcha_engine', 'kcaptcha');
				if ($captchaEngine == 'kcaptcha') {
					// TODO
				} else {
					if ($config->getInt('enable_mambots') == 1) {
						$captchaHTML = JCommentsPluginHelper::trigger('onJCommentsCaptchaDisplay');
						$tmpl->addVar('tpl_form', 'comments-form-captcha-html', implode("\n", $captchaHTML));
					}
				}
			}

			$canSubscribe = $acl->check('enable_subscribe');

			if ($my->id && $acl->check('enable_subscribe')) {
				require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');
				$manager =& JCommentsSubscriptionManager::getInstance();
				$canSubscribe = $canSubscribe && (!$manager->isSubscribed($object_id, $object_group, $my->id));
			}

			$tmpl->addVar('tpl_form', 'comments-form-subscribe', (int) $canSubscribe);
			$tmpl->addVar('tpl_form', 'comments-form-user-name', $my->id ? 0 : 1);
			$tmpl->addVar('tpl_form', 'comments-form-email-required', 0);

			switch ($config->getInt('author_email')) {
				case 2:
					if (!$my->id) {
						$tmpl->addVar('tpl_form', 'comments-form-email-required', 1);
						$tmpl->addVar('tpl_form', 'comments-form-user-email', 1);
					} else {
						$tmpl->addVar('tpl_form', 'comments-form-user-email', 0);
					}
					break;
				case 1:
					if (!$my->id) {
						$tmpl->addVar('tpl_form', 'comments-form-user-email', 1);
					} else {
						$tmpl->addVar('tpl_form', 'comments-form-user-email', 0);
					}
					break;
				case 0:
				default:
					$tmpl->addVar('tpl_form', 'comments-form-user-email', 0);

					if (!$my->id) {
						$tmpl->addVar('tpl_form', 'comments-form-subscribe', 0);
					}
					break;
			}

			$tmpl->addVar('tpl_form', 'comments-form-homepage-required', 0);

			switch($config->getInt('author_homepage')) {
				case 3:
					$tmpl->addVar('tpl_form', 'comments-form-homepage-required', 1);
					$tmpl->addVar('tpl_form', 'comments-form-user-homepage', 1);
					break;
				case 2:
					if (!$my->id) {
						$tmpl->addVar('tpl_form', 'comments-form-homepage-required', 1);
					}
					$tmpl->addVar('tpl_form', 'comments-form-user-homepage', 1);
					break;
				case 1:
					$tmpl->addVar('tpl_form', 'comments-form-user-homepage', 1);
					break;
				case 0:
				default:
					$tmpl->addVar('tpl_form', 'comments-form-user-homepage', 0);
					break;
			}

			$tmpl->addVar('tpl_form', 'comments-form-title-required', 0);

			switch($config->getInt('comment_title')) {
				case 3:
					$tmpl->addVar('tpl_form', 'comments-form-title-required', 1);
					$tmpl->addVar('tpl_form', 'comments-form-title', 1);
					break;
				case 1:
					$tmpl->addVar('tpl_form', 'comments-form-title', 1);
					break;
				case 0:
				default:
					$tmpl->addVar('tpl_form', 'comments-form-title', 0);
					break;
			}

			$result = $tmpl->renderTemplate('tpl_form');
			return $result;
		} else {
			$message = $config->get('message_policy_whocancomment');
			if ($message != '') {
				$header = JText::_('FORM_HEADER');
				$message = preg_replace('/(\n|\r)+/', '<br />', stripslashes($message));
			} else {
				$header = '';
				$message = '';
			}

			$tmpl->addVar('tpl_form', 'comments-form-message', 1);
			$tmpl->addVar('tpl_form', 'comments-form-message-header', $header);
			$tmpl->addVar('tpl_form', 'comments-form-message-text', $message);

			return $tmpl->renderTemplate('tpl_form');
		}
	}

	function getCommentsReportForm( $id, $object_id, $object_group )
	{
		global $my;

		$id = (int) $id;

		$tmpl = & JCommentsFactory::getTemplate($object_id, $object_group);
		$tmpl->load('tpl_report_form');
		$tmpl->addVar('tpl_report_form', 'comment-id', $id);
		$tmpl->addVar('tpl_report_form', 'isGuest', $my->id ? 0 : 1);
		$result = $tmpl->renderTemplate('tpl_report_form');
		return $result;
	}

	function getCommentsList( $object_id, $object_group = 'com_content', $page = 0 )
	{
		global $my;

		$object_id = (int) $object_id;
		$object_group = trim( $object_group );

		$acl = & JCommentsFactory::getACL();
		$dbo = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$comments_per_page = $config->getInt('comments_per_page');
		$comments_page_limit = $config->getInt('comments_page_limit');
		$canPublish = $acl->canPublish();
		$canComment = $acl->canComment();

		$limitstart = 0;
		$total = JCommentsModel::getCommentsCount($object_id, $object_group);

		if ($canComment == 0 && $total == 0) {
			return '';
		}

		if ($comments_per_page > 0) {

			$page = (int) $page;
			$page = max(1, $page);

			$total_pages = ceil( $total / $comments_per_page );

			if ($total > 0) {
				if (($comments_page_limit > 0)
				&& ($total_pages > $comments_page_limit)) {
					$total_pages = $comments_page_limit;
					$comments_per_page = ceil($total / $total_pages);

					// http://www.joomlatune.com/forum/index.php/topic,1551.0.html
					if (ceil($total / $comments_per_page) < $total_pages) {
						$total_pages = ceil($total / $comments_per_page);
  					}
				}

				if ($page <= 0) {
					$this_page = ($config->get('comments_order') == 'DESC') ? 1 : $total_pages;
				} else if ($page > $total_pages) {
					$this_page = $total_pages;
				} else {
					$this_page = $page;
				}
				$limitstart = (($this_page-1) * $comments_per_page);

			} else {
				$limitstart = 0;
				$this_page = 0;
			}
		}

		if ($total > 0) {
			$rows = JCommentsModel::getCommentsList($object_id, $object_group, $limitstart, $comments_per_page);
		} else {
			$rows = array();
		}

		$tmpl = & JCommentsFactory::getTemplate($object_id, $object_group);
		$tmpl->load('tpl_list');
		$tmpl->load('tpl_comment');

		if (count($rows)) {

			$isLocked = ($config->getInt('comments_locked', 0) == 1);

			$tmpl->addVar( 'tpl_list', 'comments-refresh', intval(!$isLocked));
			$tmpl->addVar( 'tpl_list', 'comments-rss', intval($config->getInt('enable_rss') && !$isLocked));
			$tmpl->addVar( 'tpl_list', 'comments-can-subscribe', intval($my->id && $acl->check('enable_subscribe') && !$isLocked));
			$tmpl->addVar( 'tpl_list', 'comments-count', count($rows));

			if ($my->id && $acl->check('enable_subscribe')) {
				require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');
				$manager =& JCommentsSubscriptionManager::getInstance();
				$isSubscribed = $manager->isSubscribed($object_id, $object_group, $my->id);
				$tmpl->addVar( 'tpl_list', 'comments-user-subscribed', $isSubscribed);
			}

			if ($config->get('comments_order') == 'DESC') {
			        if ($comments_per_page > 0) {
					$i = $total - ($comments_per_page*($page > 0 ? $page-1 : 0));
		        	} else {
		        		$i =  count($rows);
			        }
			} else {
				$i = $limitstart + 1;
			}

			if ($config->getInt('enable_mambots') == 1) {
				require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
				JCommentsPluginHelper::importPlugin('jcomments');
				JCommentsPluginHelper::trigger('onBeforeDisplayCommentsList', array(&$rows));

				if ($acl->check('enable_gravatar')) {
					JCommentsPluginHelper::trigger('onPrepareAvatars', array(&$rows));
				}
			}

			$items = array();

			foreach ($rows as $row) {
				if ($config->getInt('enable_mambots') == 1) {
					JCommentsPluginHelper::trigger('onBeforeDisplayComment', array(&$row));
				}

				// run autocensor, replace quotes, smiles and other pre-view processing
				JComments::prepareComment($row);

				// setup toolbar
				if (!$acl->canModerate($row)) {
					$tmpl->addVar('tpl_comment', 'comments-panel-visible', 0);
				} else {
					$tmpl->addVar('tpl_comment', 'comments-panel-visible', 1);
					$tmpl->addVar('tpl_comment', 'button-edit', $acl->canEdit($row));
					$tmpl->addVar('tpl_comment', 'button-delete', $acl->canDelete($row));
					$tmpl->addVar('tpl_comment', 'button-publish', $acl->canPublish($row));
					$tmpl->addVar('tpl_comment', 'button-ip', $acl->canViewIP($row));
				}

				$tmpl->addVar('tpl_comment', 'comment-show-vote', $config->getInt('enable_voting'));
				$tmpl->addVar('tpl_comment', 'comment-show-email', $acl->canViewEmail($row));
				$tmpl->addVar('tpl_comment', 'comment-show-homepage', $acl->canViewHomepage($row));
				$tmpl->addVar('tpl_comment', 'comment-show-title', $config->getInt('comment_title'));
				$tmpl->addVar('tpl_comment', 'button-vote', $acl->canVote($row));
				$tmpl->addVar('tpl_comment', 'button-quote', $acl->canQuote($row));
				$tmpl->addVar('tpl_comment', 'button-reply', $acl->canReply($row));
				$tmpl->addVar('tpl_comment', 'button-report', $acl->canReport($row));

				if (isset($row->_number)) {
					$tmpl->addVar('tpl_comment', 'comment-number', $row->_number);
				} else {
					$tmpl->addVar('tpl_comment', 'comment-number', $i);
				}

				$tmpl->addVar('tpl_comment', 'avatar', $acl->check('enable_gravatar'));

				$tmpl->addObject('tpl_comment', 'comment', $row);

				$items[$row->id] = $tmpl->renderTemplate('tpl_comment');

				if (!isset($row->_number)) {
					if ($config->get('comments_order') == 'DESC') {
						$i--;
					} else {
						$i++;
					}
				}
			}

			$tmpl->addObject('tpl_list', 'comments-items', $items);

			// build page navigation
			if (($comments_per_page > 0) && ($total_pages > 1)) {
				$tmpl->addVar('tpl_list', 'comments-nav-first', 1);
				$tmpl->addVar('tpl_list', 'comments-nav-total', $total_pages);
				$tmpl->addVar('tpl_list', 'comments-nav-active', $this_page);

				$pagination = $config->get('comments_pagination');

				// show top pagination
				if (($pagination == 'both') || ($pagination == 'top')) {
					$tmpl->addVar('tpl_list', 'comments-nav-top', 1);
				}

				// show bottom pagination
				if (($pagination == 'both') || ($pagination == 'bottom')) {
					$tmpl->addVar('tpl_list', 'comments-nav-bottom', 1);
				}
			}
			unset($rows);
		}
		return $tmpl->renderTemplate('tpl_list');
	}

	function getCommentsTree( $object_id, $object_group = 'com_content' )
	{
		global $my;

		$object_id = (int) $object_id;
		$object_group = trim($object_group);

		$acl = & JCommentsFactory::getACL();
		$dbo = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$canPublish = $acl->canPublish();
		$canComment = $acl->canComment();

		if ($canComment == 0) {
			$total = JCommentsModel::getCommentsCount($object_id, $object_group);
			if ($total == 0) {
				return '';
			}
		}

		$rows = JCommentsModel::getCommentsList($object_id, $object_group);

		$tmpl = & JCommentsFactory::getTemplate($object_id, $object_group);
		$tmpl->load('tpl_tree');
		$tmpl->load('tpl_comment');

		if (count($rows)){

			$isLocked = ($config->getInt('comments_locked', 0) == 1);

			$tmpl->addVar( 'tpl_tree', 'comments-refresh', intval(!$isLocked));
			$tmpl->addVar( 'tpl_tree', 'comments-rss', intval($config->getInt('enable_rss') && !$isLocked));
			$tmpl->addVar( 'tpl_tree', 'comments-can-subscribe', intval($my->id && $acl->check('enable_subscribe') && !$isLocked));
			$tmpl->addVar( 'tpl_tree', 'comments-count', count($rows));

			if ($my->id && $acl->check('enable_subscribe')) {

				require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');
				$manager = & JCommentsSubscriptionManager::getInstance();
				$isSubscribed = $manager->isSubscribed($object_id, $object_group, $my->id);

				$tmpl->addVar('tpl_tree', 'comments-user-subscribed', $isSubscribed);
			}

			$i = 1;

			if ($config->getInt('enable_mambots') == 1) {
				require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
				JCommentsPluginHelper::importPlugin('jcomments');
				JCommentsPluginHelper::trigger('onBeforeDisplayCommentsList', array(&$rows));

				if ($acl->check('enable_gravatar')) {
					JCommentsPluginHelper::trigger('onPrepareAvatars', array(&$rows));
				}
			}

			require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'tree.php');

			$tree = new JoomlaTuneTree($rows);
			$items = $tree->get();

			foreach ($rows as $row) {
				if ($config->getInt('enable_mambots') == 1) {
					JCommentsPluginHelper::trigger('onBeforeDisplayComment', array(&$row));
				}

				// run autocensor, replace quotes, smiles and other pre-view processing
				JComments::prepareComment($row);

				// setup toolbar
				if (!$acl->canModerate($row)) {
					$tmpl->addVar('tpl_comment', 'comments-panel-visible', 0);
				} else {
					$tmpl->addVar('tpl_comment', 'comments-panel-visible', 1);
					$tmpl->addVar('tpl_comment', 'button-edit', $acl->canEdit($row));
					$tmpl->addVar('tpl_comment', 'button-delete', $acl->canDelete($row));
					$tmpl->addVar('tpl_comment', 'button-publish', $acl->canPublish($row));
					$tmpl->addVar('tpl_comment', 'button-ip', $acl->canViewIP($row));
				}

				$tmpl->addVar('tpl_comment', 'comment-show-vote', $config->getInt('enable_voting'));
				$tmpl->addVar('tpl_comment', 'comment-show-email', $acl->canViewEmail($row));
				$tmpl->addVar('tpl_comment', 'comment-show-homepage', $acl->canViewHomepage($row));
				$tmpl->addVar('tpl_comment', 'comment-show-title', $config->getInt('comment_title'));
				$tmpl->addVar('tpl_comment', 'button-vote', $acl->canVote($row));
				$tmpl->addVar('tpl_comment', 'button-quote', $acl->canQuote($row));
				$tmpl->addVar('tpl_comment', 'button-reply', $acl->canReply($row));
				$tmpl->addVar('tpl_comment', 'button-report', $acl->canReport($row));
				$tmpl->addVar('tpl_comment', 'avatar', $acl->check('enable_gravatar'));

				if (isset($items[$row->id])) {
					$tmpl->addVar('tpl_comment', 'comment-number', '');
					$tmpl->addObject('tpl_comment', 'comment', $row);
					$items[$row->id]->html = $tmpl->renderTemplate('tpl_comment');
					$i++;
				}
			}

			$tmpl->addObject('tpl_tree', 'comments-items', $items);

			unset($rows);
		}
		return $tmpl->renderTemplate( 'tpl_tree' );
	}

	function getCommentListItem( &$comment )
	{
		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();

		if ($config->getInt('enable_mambots') == 1) {
			require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
			JCommentsPluginHelper::importPlugin('jcomments');
			JCommentsPluginHelper::trigger('onBeforeDisplayComment', array(&$comment));

			if ($acl->check('enable_gravatar')) {
				JCommentsPluginHelper::trigger('onPrepareAvatar', array(&$comment));
			}
		}

		// run autocensor, replace quotes, smiles and other pre-view processing
		JComments::prepareComment($comment);

		$total = JCommentsModel::getCommentsCount($comment->object_id, $comment->object_group, ' AND parent = ' . $comment->parent);

		$tmpl = JCommentsFactory::getTemplate($comment->object_id, $comment->object_group);
		$tmpl->load('tpl_list');
		$tmpl->load('tpl_comment');

		// setup toolbar
		if (!$acl->canModerate($comment)) {
			$tmpl->addVar('tpl_comment', 'comments-panel-visible', 'visibility', 0);
		} else {
			$tmpl->addVar('tpl_comment', 'comments-panel-visible', 1);
			$tmpl->addVar('tpl_comment', 'button-edit', $acl->canEdit($comment));
			$tmpl->addVar('tpl_comment', 'button-delete', $acl->canDelete($comment));
			$tmpl->addVar('tpl_comment', 'button-publish', $acl->canPublish($comment));
			$tmpl->addVar('tpl_comment', 'button-ip', $acl->canViewIP($comment));
			$tmpl->addVar('tpl_comment', 'comment-show-email', $acl->canViewEmail());
			$tmpl->addVar('tpl_comment', 'comment-show-homepage', $acl->canViewHomepage());
		}

		$tmpl->addVar('tpl_comment', 'comment-show-vote', $config->getInt('enable_voting'));
		$tmpl->addVar('tpl_comment', 'comment-show-email', $acl->canViewEmail($comment));
		$tmpl->addVar('tpl_comment', 'comment-show-homepage', $acl->canViewHomepage($comment));
		$tmpl->addVar('tpl_comment', 'comment-show-title', $config->getInt('comment_title'));
		$tmpl->addVar('tpl_comment', 'button-vote', $acl->canVote($comment));
		$tmpl->addVar('tpl_comment', 'button-quote', $acl->canQuote($comment));
		$tmpl->addVar('tpl_comment', 'button-reply', $acl->canReply($comment));
		$tmpl->addVar('tpl_comment', 'button-report', $acl->canReport($comment));
		$tmpl->addVar('tpl_comment', 'comment-number', '');
		$tmpl->addVar('tpl_comment', 'avatar', $acl->check('enable_gravatar'));

		$tmpl->addObject('tpl_comment', 'comment', $comment);

		$commentItem = $tmpl->renderTemplate('tpl_comment');

		$tmpl->addVar('tpl_list', 'comment-id', $comment->id);
		$tmpl->addVar('tpl_list', 'comment-item', $commentItem);
		$tmpl->addVar('tpl_list', 'comment-modulo', $total % 2 ? 1 : 0);

		return $tmpl->renderTemplate('tpl_list');
	}

	/**
	 * @param  $comment JCommentsDB
	 * @param boolean $isNew
	 * @return void
	 */
	function sendNotification( &$comment, $isNew = true)
	{
		global $mainframe, $my;

		$config = & JCommentsFactory::getConfig();

		if ($config->get('notification_email') != '') {
			$object = new stdClass();
			$object->object_title = JCommentsObjectHelper::getTitle($comment->object_id, $comment->object_group, $comment->lang);
			$object->object_link = JCommentsObjectHelper::getLink($comment->object_id, $comment->object_group);
			$object->object_link = JCommentsFactory::getAbsLink($object->object_link);

			$commentText = $comment->comment;

			$bbcode = & JCommentsFactory::getBBCode();
			$txt = JCommentsText::censor($comment->comment);
			$txt = $bbcode->replace($txt);

			if ($config->getInt('enable_custom_bbcode')) {
				$customBBCode = & JCommentsFactory::getCustomBBCode();
				// TODO: add control for replacement mode from CustomBBCode parameters
				$txt = $customBBCode->replace($txt, true);
			}


			$txt = trim(preg_replace('/(\s){2,}/i', '\\1', $txt));
			$txt = str_replace('class="quotebody"', 'style="margin: 5px 0 0 0;padding: 8px; border: 1px dashed #aaa;"', $txt);
			$comment->comment = $txt;
			unset($bbcode);

			$comment->author = JComments::getCommentAuthorName($comment);

			$tmpl = & JCommentsFactory::getTemplate($comment->object_id, $comment->object_group);
			$tmpl->load('tpl_email_administrator');
			$tmpl->addVar('tpl_email_administrator', 'notification-type', 'admin');
			$tmpl->addVar('tpl_email_administrator', 'comment-isnew', ($isNew) ? 1 : 0);
			$tmpl->addVar('tpl_email_administrator', 'comment-object_title', $object->object_title);
			$tmpl->addVar('tpl_email_administrator', 'comment-object_link', $object->object_link);
			$tmpl->addObject('tpl_email_administrator', 'comment', $comment);
			$tmpl->addObject('tpl_email_administrator', 'quick-moderation', $config->getInt('enable_quick_moderation'));

			$message = $tmpl->renderTemplate('tpl_email_administrator');

			$tmpl->freeTemplate('tpl_email_administrator');

			if ($isNew) {
				$subject = JText::sprintf('NOTIFICATION_SUBJECT_NEW', $object->object_title);
			} else {
				$subject = JText::sprintf('NOTIFICATION_SUBJECT_UPDATED', $object->object_title);
			}

			if (isset($subject) && isset($message)) {
				$emails = explode(',', $config->get('notification_email'));

				$mailFrom = $mainframe->getCfg('mailfrom');
				$fromName = $mainframe->getCfg('fromname');

				foreach ($emails as $email) {
					$email = trim($email);

					// don't send notification to message author
					if ($my->email != $email) {
						JCommentsMail::send($mailFrom, $fromName, $email, $subject, $message, true);
					}
				}
			}
			unset($emails, $object);

			$comment->comment = $commentText;
		}
	}

	function sendReport( &$comment, $name, $reason = '')
	{
		global $mainframe, $my;

		$config = & JCommentsFactory::getConfig();

		if ($config->get('notification_email') != '') {
			$object = new stdClass();
			$object->object_link = JCommentsObjectHelper::getLink($comment->object_id, $comment->object_group);
			$object->object_link = JCommentsFactory::getAbsLink($object->object_link);

			$commentText  = $comment->comment;

			$bbcode = & JCommentsFactory::getBBCode();
			$txt = JCommentsText::censor($comment->comment);
			$txt = $bbcode->replace($txt);

			if ($config->getInt('enable_custom_bbcode')) {
				$customBBCode = & JCommentsFactory::getCustomBBCode();
				// TODO: add control for replacement mode from CustomBBCode parameters
				$txt = $customBBCode->replace($txt, true);
			}

			$txt = trim(preg_replace('/(\s){2,}/i', '\\1', $txt));
			$txt = str_replace('class="quotebody"', 'style="margin: 5px 0 0 0;padding: 8px; border: 1px dashed #aaa;"', $txt);
			$comment->comment = $txt;
			unset($bbcode);

			$comment->author = JComments::getCommentAuthorName($comment);

			$tmpl = & JCommentsFactory::getTemplate($comment->object_id, $comment->object_group);
			$tmpl->load('tpl_email_report');
			$tmpl->addVar('tpl_email_report', 'comment-object_link', $object->object_link);
			$tmpl->addVar('tpl_email_report', 'report-name', $name);
			$tmpl->addVar('tpl_email_report', 'report-reason', $reason);
			$tmpl->addObject('tpl_email_report', 'comment', $comment);
			$tmpl->addObject('tpl_email_report', 'quick-moderation', $config->getInt('enable_quick_moderation'));

			$message = $tmpl->renderTemplate('tpl_email_report');

			$tmpl->freeTemplate('tpl_email_report');

			$subject = JText::sprintf('Reported comment', $comment->author);

			if (isset($subject) && isset($message)) {
				$emails = explode(',', $config->get('notification_email'));

				$mailFrom = $mainframe->getCfg('mailfrom');
				$fromName = $mainframe->getCfg('fromname');

				foreach ($emails as $email) {
					$email = trim((string) $email);

					// don't send notification to message author
					if ($my->email != $email) {
						JCommentsMail::send($mailFrom, $fromName, $email, $subject, $message, true);
					}
				}
			}
			unset($emails, $object);

			$comment->comment = $commentText;
		}
	}

	/**
	 * @param  $comment JCommentsDB
	 * @param boolean $isNew
	 * @return
	 */
	function sendToSubscribers( &$comment, $isNew = true)
	{
		global $mainframe;

		if (!$comment->published) {
			return;
		}

		$dbo = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$query = "SELECT DISTINCTROW `name`, `email`, `hash` "
			. "\nFROM #__jcomments_subscriptions "
			. "\nWHERE `object_group` = '" . $dbo->getEscaped($comment->object_group) . "'"
			. "\nAND `object_id`='" . intval($comment->object_id) . "'"
			. "\nAND `published`='1' "
			. (JCommentsMultilingual::isEnabled() ? "\nAND `lang` = '" . $dbo->getEscaped($comment->lang) . "'" : '')
			. "\nAND `email` <> '" . $dbo->getEscaped($comment->email) . "'"
			. ($comment->userid ? "\nAND `userid` <> '" . $comment->userid . "'" : '')
			;
		$dbo->setQuery( $query );
		$rows = $dbo->loadObjectList();

		if (count($rows)) {
			$object_title = JCommentsObjectHelper::getTitle($comment->object_id, $comment->object_group, $comment->lang);
			$object_link = JCommentsObjectHelper::getLink($comment->object_id, $comment->object_group);
			$object_link = JCommentsFactory::getAbsLink($object_link);

			$commentText  = $comment->comment;

			$bbcode = & JCommentsFactory::getBBCode();
			$txt = JCommentsText::censor($comment->comment);
			$txt = $bbcode->replace($txt);

			if ($config->getInt('enable_custom_bbcode')) {
				$customBBCode = & JCommentsFactory::getCustomBBCode();
				// TODO: add control for replacement mode from CustomBBCode parameters
				$txt = $customBBCode->replace($txt, true);
			}

			$txt = trim(preg_replace('/(\s){2,}/i', '\\1', $txt));
			$txt = str_replace( 'class="quotebody"', 'style="margin: 5px 0 0 0;padding: 8px; border: 1px dashed #aaa;"', $txt );
			$comment->comment = $txt;
			unset( $bbcode );

			$comment->author = JComments::getCommentAuthorName($comment);

			$tmpl = & JCommentsFactory::getTemplate($comment->object_id, $comment->object_group);
			$tmpl->load('tpl_email');
			$tmpl->addVar('tpl_email', 'notification-type', 'subscription');
			$tmpl->addVar('tpl_email', 'comment-isnew', ($isNew) ? 1 : 0);
			$tmpl->addVar('tpl_email', 'comment-object_title', $object_title);
			$tmpl->addVar('tpl_email', 'comment-object_link', $object_link);
			$tmpl->addObject('tpl_email', 'comment', $comment);

			if ($isNew) {
				$subject = JText::sprintf('NOTIFICATION_SUBJECT_NEW', $object_title);
			} else {
				$subject = JText::sprintf('NOTIFICATION_SUBJECT_UPDATED', $object_title);
			}

			if (isset($subject)) {
				$mailFrom = $mainframe->getCfg('mailfrom');
				$fromName = $mainframe->getCfg('fromname');

				foreach ($rows as $row) {
					$tmpl->addVar('tpl_email', 'hash', $row->hash);
					$message = $tmpl->renderTemplate('tpl_email');

					JCommentsMail::send($mailFrom, $fromName, $row->email, $subject, $message, true);
				}
			}

			$tmpl->freeTemplate('tpl_email');

			unset($rows);

			$comment->comment = $commentText;
		}
	}

	function prepareComment( &$comment )
	{
		if (isset($comment->_skip_prepare) && $comment->_skip_prepare == 1) {
			return;
		}

		$config = & JCommentsFactory::getConfig();
		$bbcode = & JCommentsFactory::getBBCode();
		$acl = & JCommentsFactory::getACL();

		// convert to datetime if variable contains string value
		if (is_string($comment->datetime)) {
			$comment->datetime = strtotime($comment->datetime);
		}

		// run autocensor
		if ($acl->check('enable_autocensor')) {
			$comment->comment = JCommentsText::censor($comment->comment);
		}

		// replace BBCode tags
		$comment->comment = $bbcode->replace($comment->comment);

		if ($config->getInt('enable_custom_bbcode')) {
			$customBBCode = & JCommentsFactory::getCustomBBCode();
			$comment->comment = $customBBCode->replace($comment->comment);
		}

		// fix long words problem
		$word_maxlength = $config->getInt('word_maxlength');
		if ($word_maxlength > 0) {
			$comment->comment = JCommentsText::fixLongWords($comment->comment, $word_maxlength);
			if ($comment->title != '') {
				$comment->title = JCommentsText::fixLongWords($comment->title, $word_maxlength);
			}
		}

		if ($acl->check('emailprotection')) {
			$comment->comment = JComments::maskEmail($comment->id, $comment->comment);
		}

		// autolink urls
		if ($acl->check('autolinkurls')) {
			$comment->comment = preg_replace_callback(_JC_REGEXP_LINK, array('JComments', 'urlProcessor'), $comment->comment);

			if ($acl->check('emailprotection') != 1) {
				$comment->comment = preg_replace(_JC_REGEXP_EMAIL, '<a href="mailto:\\1@\\2">\\1@\\2</a>', $comment->comment);
			}
		}

		// replace smile codes with images
		if ($config->get('enable_smiles') == '1') {
			$smiles = & JCommentsFactory::getSmiles();
			$comment->comment = $smiles->replace($comment->comment);
		}

		// Gravatar support
		$comment->gravatar = md5(strtolower($comment->email));

		if (empty($comment->avatar)) {
			$comment->avatar = '<img src="http://www.gravatar.com/avatar.php?gravatar_id='. $comment->gravatar .'&amp;default=' . urlencode(JCommentsFactory::getLink('noavatar')) . '" alt="" />';
		}

		$comment->author = JComments::getCommentAuthorName($comment);

		if ($config->getInt('enable_mambots') == 1) {
			JCommentsPluginHelper::trigger('onAfterPrepareComment', array(&$comment));
		}
	}

	function maskEmail( $id, $text )
	{
		$id = (int) $id;

		if ($id) {
			$GLOBALS['JCOMMENTS_COMMENTID'] = $id;
			$text = preg_replace_callback(_JC_REGEXP_EMAIL, array('JComments', 'maskEmailReplacer'), $text);
		}
		return $text;
	}

	function maskEmailReplacer( &$matches )
	{
		global $mainframe;

		return "<span onclick=\"jcomments.jump2email(" . $GLOBALS['JCOMMENTS_COMMENTID'] . ", '" . md5($matches[0]) . "');\" class=\"email\" onmouseover=\"this.className='emailactive';\" onmouseout=\"this.className='email';\">" . $matches[1] . "<img src=\"" . $mainframe->getCfg('live_site') . "/components/com_jcomments/images/email.png\" border=\"0\" alt=\"@\" />" . $matches[2] . "</span>";
	}

	function urlProcessor( &$matches )
	{
		global $mainframe;

		$link = $matches[2];
		$link_suffix = '';

		while (preg_match('#[\,\.]+#', $link[strlen($link) - 1])) {
			$sl = strlen($link)-1;
			$link_suffix .= $link[$sl];
			$link = substr($link, 0, $sl);
		}

		$link_text = preg_replace('#(http|https|news|ftp)\:\/\/#i', '', $link);

		$config = & JCommentsFactory::getConfig();
		$link_maxlength = $config->getInt('link_maxlength');

		if (($link_maxlength > 0) && (strlen($link_text) > $link_maxlength)) {
			$linkparts = split('/', preg_replace('#/$#i', '', $link_text));
			$cnt = count($linkparts);

			if ($cnt >= 2) {
				$linkSite = $linkparts[0];
				$linkSiteLength = strlen($linkSite);
				$linkDocument = $linkparts[$cnt - 1];
				$shortLink = $linkSite . '/.../' . $linkDocument;

				if ($cnt == 2) {
					$shortLink = $linkSite . '/.../';
				} else if (strlen($shortLink) > $link_maxlength) {
					$linkSite = str_replace('www.', '', $linkSite);
					$linkSiteLength = strlen($linkSite);
					$shortLink = $linkSite . '/.../' . $linkDocument;

					if (strlen($shortLink) > $link_maxlength) {
						if ($linkSiteLength < $link_maxlength) {
							$shortLink = $linkSite . '/.../...';
						} else if ($linkDocument < $link_maxlength) {
							$shortLink = '.../' . $linkDocument;
						} else {
							$link_protocol = preg_replace('#([^a-z])#i', '', $matches[3]);

							if ($link_protocol == 'www') {
								$link_protocol = 'http';
							}

							if ($link_protocol != '') {
								$shortLink = $link_protocol;
							} else {
								$shortLink = '/.../';
							}
						}
					}
				}
				$link_text = $shortLink;
			}
		}

		if (strpos($link, $mainframe->getCfg('live_site')) === false) {
			return $matches[1]."<a href=\"".((substr($link, 0, 3)=='www') ? "http://" : "").$link."\" target=\"_blank\" rel=\"external nofollow\">$link_text</a>" . $link_suffix;
		} else {
			return $matches[1]."<a href=\"$link\" target=\"_blank\">$link_text</a>" . $link_suffix;
		}
	}

	function getCommentPage($object_id, $object_group, $commentid)
	{
		$config = & JCommentsFactory::getConfig();

		$comments_per_page = $config->getInt('comments_per_page');
		$comments_page_limit = $config->getInt('comments_page_limit');

		if ($comments_per_page > 0) {
			$compare = ($config->get('comments_order') == 'DESC') ? '>=' : '<=';

			$total = JCommentsModel::getCommentsCount($object_id, $object_group);
			$total_pages = ceil($total / $comments_per_page);

			if (($comments_page_limit > 0) && ($total_pages > $comments_page_limit)) {
				$total_pages = $comments_page_limit;
				$comments_per_page = ceil($total / $total_pages);

				// http://www.joomlatune.com/forum/index.php/topic,1551.0.html
				if (ceil($total / $comments_per_page) < $total_pages) {
					$total_pages = ceil($total / $comments_per_page);
  				}
			}

			$prev = JCommentsModel::getCommentsCount($object_id, $object_group, "\n  AND id " . $compare . " " . $commentid);

			$this_page = ceil($prev / $comments_per_page);

			if ($this_page <= 0) {
				$this_page = 1;
			}
		} else {
			$this_page = 0;
		}
		return $this_page;
	}

	function getCommentAuthorName( $comment )
	{
		$name = '';

		if ($comment != null) {
			$config = & JCommentsFactory::getConfig();
			if ($comment->userid && $config->get('display_author') == 'username' && $comment->username != '') {
				$name = $comment->username;
			} else {
				$name = $comment->name ? $comment->name : JText::_('Guest');
			}
		}
		return $name;
	}

	function unsubscribe()
	{
		global $mainframe;

		$hash = JCommentsInput::getVar('hash','');
		$hash = preg_replace('#[^A-Z0-9]#i', '', $hash);

		if ($hash) {
			require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');

			$manager = & JCommentsSubscriptionManager::getInstance();
			$result = $manager->unsubscribeByHash($hash);

			if ($result) {
				JCommentsRedirect($mainframe->getCfg('live_site') . '/index.php');
			}
		}

		header('HTTP/1.0 404 Not Found');
		if (JCOMMENTS_JVERSION == '1.5') {
			JError::raiseError(404, JText::_('Resource Not Found'));
		}
		exit(404);
	}

	function executeCmd()
	{
		global $mainframe;

		$cmd = strtolower(JCommentsInput::getVar('cmd', ''));
		$hash = JCommentsInput::getVar('hash', '');
		$id = (int) JCommentsInput::getVar('id', 0);

		$error = '';
		$link = $mainframe->getCfg('live_site') . '/index.php';

		$checkHash = JCommentsFactory::getCmdHash($cmd, $id);
		if ($hash == $checkHash) {

			$config = & JCommentsFactory::getConfig();

			if ($config->getInt('enable_quick_moderation') == 1) {

				$dbo = & JCommentsFactory::getDBO();
				$comment = new JCommentsDB($dbo);

				if ($comment->load($id)) {
					$link = JCommentsObjectHelper::getLink($comment->object_id, $comment->object_group);
					$link = str_replace('&amp;', '&', $link);
					switch($cmd) {
						case 'publish':
							$comment->published = 1;
							$comment->store();
							$link .= '#comment-' . $comment->id;
							break;
						case 'unpublish':
							$comment->published = 0;
							$comment->store();

							$acl = & JCommentsFactory::getACL();
							if ($acl->canPublish()) {
								$link .= '#comment-' . $comment->id;
							} else {
								$link .= '#comments';
							}
							break;
						case 'delete':
							$comment->delete();
							$link .= '#comments';
							break;
					}
				}
			} else {
				$error = JText::_('Quick moderation function is disabled by administrator!');
			}
		} else {
			$error = JText::_('Incorrect hash for this operation!');
		}
		JCommentsRedirect($link, $error);
	}

	function redirectToObject()
	{
		global $mainframe;

		$object_id = (int) JCommentsInput::getVar('object_id', 0);
		$object_group = trim(strip_tags(JCommentsInput::getVar('object_group', 'com_content')));

		if ($object_id != 0 && $object_group != '') {
			$link = JCommentsObjectHelper::getLink($object_id, $object_group);
			$link = str_replace('amp;', '', $link);
			if ($link == '') {
				$link = $mainframe->getCfg('live_site');
			}
		} else {
			$link = $mainframe->getCfg('live_site');
		}
		JCommentsRedirect($link);
	}


	function getCommentsCount( $object_id, $object_group = 'com_content', $filter = '' )
	{
		return JCommentsModel::getCommentsCount( $object_id, $object_group, $filter);
	}

	/*
	 * @see JComments::show()
	 * @deprecated As of version 2.0.0
	 */
	function showComments( $object_id, $object_group = 'com_content', $object_title = '' )
	{
		return JComments::show($object_id, $object_group, $object_title);
	}

	/**
	 * @deprecated As of version 2.2.0.0
	 * @see  JCommentsModel::getLastComment
	 */
	function getLastComment( $object_id, $object_group = 'com_content', $parent = 0 )
	{
		return JCommentsModel::getLastComment( $object_id, $object_group, $parent);
	}

	/**
	 * @deprecated As of version 2.2.0.0
	 * @see  JCommentsModel::deleteComments
	 */
	function deleteComments( $object_id, $object_group = 'com_content' )
	{
	        JCommentsModel::deleteComments( $object_id, $object_group);
		return true;
	}
}
?>