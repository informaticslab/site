<?php
/**
 * JComments - Joomla Comment System
 *
 * Frontend event handler
 *
 * @version 2.1
 * @package JComments
 * @subpackage Ajax
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

ob_start();

if (!defined('JOOMLATUNE_AJAX')) {
	require_once (JCOMMENTS_LIBRARIES.DS.'joomlatune'.DS.'ajax.php');
}

class JCommentsAJAX
{
	function convertEncoding( $value )
	{
		$iso = explode('=', _ISO);
		$charset = strtolower($iso[1]);

		if (($charset != 'utf-8')
		&& (is_file(JCOMMENTS_LIBRARIES.DS.'convert'.DS.'maps'.DS.$charset))) {
			if (!defined('CONVERT_TABLES_DIR')) {
				require_once(JCOMMENTS_LIBRARIES.DS.'convert'.DS.'utf8.class.php');
			}

			$encoding = & JCommentsUtf8::getInstance($charset);
			$needEntities = false;

			if (is_array($value)) {
				$newArray = array();

				foreach ($value as $k => $v) {
					if (is_array($v)) {
						$newArray[$k] = JCommentsAJAX::convertEncoding($v);
					} else {
						if ($v != '') {

							if ($needEntities === true) {
								$newArray[$k] = $encoding->utf8_to_entities($v);
							} else {
								$newArray[$k] = JCommentsText::isUTF8($v) ? $encoding->utf8ToStr($v) : $v;

								if ($encoding->encodingFailed($newArray[$k])) {
									$newArray[$k] = $encoding->utf8_to_entities($v);
									$needEntities = true;
								}
							}
						}
					}
				}
				return $newArray;
			} else if ($value != '') {
				$text = $value;
				if (JCommentsText::isUTF8($value)) {
					$text = $encoding->utf8ToStr($value);
					if ($encoding->encodingFailed($text)) {
						$text = $encoding->utf8_to_entities($value);
					}
				}

				return $text;
			}
		}
		return $value;
	}

	function prepareValues( &$values )
	{
		foreach ($values as $k => $v) {

			if ($k == 'comment') {
				// strip all HTML except [code]
				$m = array();
				preg_match_all('#(\[code\=?([a-z0-9]*?)\].*\[\/code\])#isU' . JCOMMENTS_PCRE_UTF8, trim($v), $m);

				$tmp = array();
				$key = '';
				
				foreach($m[1] as $code) {
					$key = '{' . md5($code.$key). '}';
					$tmp[$key] = $code;
					$v = preg_replace('#' . preg_quote($code, '#') . "#isU" . JCOMMENTS_PCRE_UTF8, $key, $v);
				}

				$v = trim(strip_tags($v));

				// handle magic quotes compatibility
				if (get_magic_quotes_gpc() == 1) {
					$v = stripslashes($v);
				}
				$v = JCommentsText::nl2br($v);
				//$v = JCommentsText::nl2br(stripslashes($v));

				foreach($tmp as $key=>$code) {

					if (get_magic_quotes_gpc() == 1) {
						$code = str_replace('\"', '"', $code);
						$code = str_replace("\'", "'", $code);
					}

					$v = preg_replace('#' . preg_quote($key, '#') . "#isU" . JCOMMENTS_PCRE_UTF8, $code, $v);
				}
				unset($tmp, $m);
				$values[$k] = $v;
			} else {
				$values[$k] = trim(strip_tags($v));

				// handle magic quotes compatibility
				if (get_magic_quotes_gpc() == 1) {
					$values[$k] = stripslashes($values[$k]);
				}

			}
		}

		// for Joomla 1.5 change encoding is not needed
		if (JCOMMENTS_JVERSION != '1.5') {
			return JCommentsAJAX::convertEncoding($values);
		} else {
			return $values;
		}
	}

	function showErrorMessage($message, $name = '', $target = '')
	{
		$message = str_replace("\n", '\n', $message);
		$message = str_replace('\n', '<br />', $message);
		$message = JCommentsText::jsEscape($message);

		$response = & JCommentsFactory::getAjaxResponse();
		$response->addScript("jcomments.error('$message','$target','$name');");
	}

	function showInfoMessage($message, $target = '')
	{
		$message = str_replace("\n", '\n', $message);
		$message = str_replace('\n', '<br />', $message);
		$message = JCommentsText::jsEscape($message);

		$response = & JCommentsFactory::getAjaxResponse();
		$response->addScript("jcomments.message('$message', '$target');");
	}

	function showForm( $object_id, $object_group, $target )
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$response = & JCommentsFactory::getAjaxResponse();

		$form = JComments::getCommentsForm($object_id, $object_group);
		$response->addAssign($target, 'innerHTML', $form);
		return $response;
	}

	function showReportForm( $id, $target )
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$response = & JCommentsFactory::getAjaxResponse();
		$db = & JCommentsFactory::getDBO();

		$comment = new JCommentsDB($db);
		if ($comment->load($id)) {
			$form = JComments::getCommentsReportForm($id, $comment->object_id, $comment->object_group);
			$response->addAssign($target, 'innerHTML', $form);
		}
		return $response;
	}

	function addComment( $values = array() )
	{
		global $my, $mainframe;

		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();

		if ($acl->canComment()) {
			$values = JCommentsAJAX::prepareValues( $_POST );
			$userIP = $acl->getUserIP();

			if (!$my->id) {
				$noErrors = false;

				if (empty($values['name'])) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_NAME'), 'name');
				} else if (JCommentsSecurity::checkIsRegisteredUsername($values['name']) == 1) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_NAME_EXISTS'), 'name');
				} else if (JCommentsSecurity::checkIsForbiddenUsername($values['name']) == 1) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_FORBIDDEN_NAME'), 'name');
				} else if (preg_match('/[\"\'\[\]\=\<\>\(\)\;]+/', $values['name'])) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_INVALID_NAME'), 'name');
				} else if (($config->get('username_maxlength') != 0)
					&& (JCommentsText::strlen($values['name']) > $config->get('username_maxlength'))) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_TOO_LONG_USERNAME'), 'name');
				} else if (($config->get('author_email') == 2) && empty($values['email'])) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_EMAIL'), 'email');
				} else if (!empty($values['email']) && (!preg_match( _JC_REGEXP_EMAIL2, $values['email']))) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_INCORRECT_EMAIL'), 'email');
				} else if (($config->get('author_email') != 0) && JCommentsSecurity::checkIsRegisteredEmail($values['email']) == 1) {
				        // TODO: change this error message with more appropriate
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_NAME_EXISTS'), 'email');
				} else if (empty($values['homepage']) && ($config->get('author_homepage') == 2)) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_HOMEPAGE'), 'homepage');
				} else {
					$noErrors = true;
				}

				if (!$noErrors) {
					return $response;
				}
			}

			if (($acl->check('floodprotection') == 1) && (JCommentsSecurity::checkFlood($userIP))) {
				JCommentsAJAX::showErrorMessage(JText::_('ERROR_TOO_QUICK'));
			} else if (empty($values['homepage']) && ($config->get('author_homepage') == 3)) {
				JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_HOMEPAGE'), 'homepage');
			} else if (empty($values['title']) && ($config->get('comment_title') == 3)) {
				JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_TITLE'), 'title');
			} else if (empty($values['comment'])) {
				JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_COMMENT'), 'comment');
			} else if (($config->getInt('comment_maxlength') != 0)
				&& ($acl->check('enable_comment_length_check') == 1)
				&& (JCommentsText::strlen($values['comment']) > $config->get('comment_maxlength'))) {
				JCommentsAJAX::showErrorMessage(JText::_('Your comment is too long'), 'comment');
			} else if (($config->getInt('comment_minlength', 0) != 0)
				&& ($acl->check('enable_comment_length_check') == 1)
				&& (JCommentsText::strlen($values['comment']) < $config->get('comment_minlength'))) {
				JCommentsAJAX::showErrorMessage(JText::_('Your comment is too short'), 'comment');
			} else {
				if ($acl->check('enable_captcha') == 1) {

					$captchaEngine = $config->get('captcha_engine', 'kcaptcha');

					if ($captchaEngine == 'kcaptcha') {
						require_once( JCOMMENTS_BASE.DS.'jcomments.captcha.php' );

						if (!JCommentsCaptcha::check($values['captcha-refid'])) {
							JCommentsAJAX::showErrorMessage(JText::_('ERROR_CAPTCHA'), 'captcha');
							JCommentsCaptcha::destroy();
							$response->addScript("jcomments.clear('captcha');");
							return $response;
						}
					} else {
						if ($config->getInt('enable_mambots') == 1) {
							require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
							JCommentsPluginHelper::importPlugin('jcomments');
							$result = JCommentsPluginHelper::trigger('onJCommentsCaptchaVerify', array($values['captcha-refid'], &$response));
							// if all plugins returns false
							if (!in_array(true, $result, true)) {
								JCommentsAJAX::showErrorMessage(JText::_('ERROR_CAPTCHA'));
								return $response;
							}
						}
					}
				}

				$db = & JCommentsFactory::getDBO();

				// small fix (by default $my has empty 'name' and 'email' field)
				if ($my->id) {
					$currentUser = JCommentsFactory::getUser($my->id);
					$my->name = $currentUser->name;
					$my->username = $currentUser->username;
					$my->email = $currentUser->email;
					unset($currentUser);
				}

				$comment = new JCommentsDB($db);
				$comment->id = 0;
				$comment->name = $my->id ? $my->name : preg_replace("/[\'\"\>\<\(\)\[\]]?+/i", '', $values['name']);
				$comment->username = $my->id ? $my->username : $comment->name;
				$comment->email = $my->id ? $my->email : (isset($values['email']) ? $values['email'] : '');

				if (($config->getInt('author_homepage') != 0)
				&& !empty($values['homepage'])) {
					$comment->homepage = JCommentsText::url($values['homepage']);
				}

				$comment->comment = $values['comment'];
				//$comment->comment = JCommentsText::nl2br(stripslashes($values['comment']));

				// filter forbidden bbcodes
				$bbcode = JCommentsFactory::getBBCode();
				$comment->comment = $bbcode->filter( $comment->comment );

				if ($comment->comment != '') {
					if ($config->getInt('enable_custom_bbcode')) {
						// filter forbidden custom bbcodes
						$commentLength = strlen($comment->comment);
						$customBBCode = & JCommentsFactory::getCustomBBCode();
						$comment->comment = $customBBCode->filter( $comment->comment );

						if (strlen($comment->comment) == 0 && $commentLength > 0) {
							JCommentsAJAX::showErrorMessage(JText::_('You have no rights to use this tag'), 'comment');
							return $response;
						}
					}
				}

				if ($comment->comment == '') {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_COMMENT'), 'comment');
					return $response;
				}

				$commentWithoutQuotes = $bbcode->removeQuotes($comment->comment);
				if ($commentWithoutQuotes == '') {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_NOTHING_EXCEPT_QUOTES'), 'comment');
					return $response;
				} else if (($config->getInt('comment_minlength', 0) != 0)
					&& ($acl->check('enable_comment_length_check') == 1)
					&& (JCommentsText::strlen($commentWithoutQuotes) < $config->get('comment_minlength'))) {
					JCommentsAJAX::showErrorMessage(JText::_('Your comment is too short'), 'comment');
					return $response;
				}
				unset($commentWithoutQuotes);


				$values['subscribe'] = isset($values['subscribe']) ? (int) $values['subscribe'] : 0;

				if ($values['subscribe'] == 1 && $comment->email == '') {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_SUBSCRIPTION_EMAIL'), 'email');
					return $response;
				}

				$object_group = trim(strip_tags($values['object_group']));
				$object_group = preg_replace('#[^0-9A-Za-z\-\_\,\.]#is', '', $object_group);

				$comment->object_id = (int) $values['object_id'];
				$comment->object_group = $object_group;
				$comment->title = isset($values['title']) ? $values['title'] : '';
				$comment->parent = isset($values['parent']) ? intval($values['parent']) : 0;
				$comment->lang = JCommentsMultilingual::getLanguage();
				$comment->ip = $userIP;
				$comment->userid = $my->id ? $my->id : 0;
				$comment->published = $acl->check('autopublish');

				if (JCOMMENTS_JVERSION == '1.5') {
					$dateNow =& JFactory::getDate();
					$comment->date = $dateNow->toMySQL();
				} else {
					$comment->date = date('Y-m-d H:i:s', time() + $mainframe->getCfg('offset') * 60 * 60);
				}

				$query = "SELECT COUNT(*) "
						. "\nFROM #__jcomments "
						. "\nWHERE comment = '" . $db->getEscaped($comment->comment) . "'"
						. "\n  AND ip = '" . $db->getEscaped($comment->ip) . "'"
						. "\n  AND name = '" . $db->getEscaped($comment->name) . "'"
						. "\n  AND userid = '" . $comment->userid . "'"
						. "\n  AND object_id = " . $comment->object_id
						. "\n  AND parent = " . $comment->parent
						. "\n  AND object_group = '" . $db->getEscaped($comment->object_group) . "'"
						. (JCommentsMultilingual::isEnabled() ? "\nAND lang = '" . JCommentsMultilingual::getLanguage() . "'" : "")
						;
				$db->setQuery($query);
				$found = $db->loadResult();

				// if duplicates is not found
				if ($found == 0) {
					// trigger onBeforeCommentAdded event
					$allowed = true;

					if ($config->getInt('enable_mambots') == 1) {
						require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onBeforeCommentAdded', array(&$comment, &$response, &$allowed));
					}

					if ($allowed === false) {
						return $response;
					}

					// save comments subscription
					if ($values['subscribe']) {
						require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');
						$manager = & JCommentsSubscriptionManager::getInstance();
						$manager->subscribe($comment->object_id, $comment->object_group, $comment->userid, $comment->email, $comment->name, $comment->lang);
					}

					$merged = false;
					$merge_time = $config->getInt('merge_time', 0);

					// merge comments from same author
					if ($my->id && $merge_time > 0) {
						// load previous comment for same object and group
						$prevComment = JComments::getLastComment($comment->object_id, $comment->object_group, $comment->parent);

						if ($prevComment != null) {
							// if previous comment from same author and it currently not edited
							// by any user - we'll update comment, else - insert new record to database
							if (($prevComment->userid == $comment->userid)
							&& ($prevComment->parent == $comment->parent)
							&& (!$acl->isLocked($prevComment))) {

								$newText = $prevComment->comment . '<br /><br />' . $comment->comment;
								$timeDiff = strtotime($comment->date) - strtotime($prevComment->datetime);

								if ($timeDiff < $merge_time) {

									$maxlength = $config->getInt('comment_maxlength');
									$needcheck = $acl->check('enable_comment_length_check');

									// validate new comment text length and if it longer than specified -
									// disable union current comment with previous
									if (($needcheck == 0) || (($needcheck == 1) && ($maxlength != 0)
										&& (JCommentsText::strlen($newText) <= $maxlength))) {
										$comment->id = $prevComment->id;
										$comment->comment = $newText;
										$merged = true;
									}
								}
							}
							unset($prevComment);
						}
					}

					if ($comment->parent > 0) {
						$parent = new JCommentsDB($db);
						if ($parent->load($comment->parent)) {
							if ($config->getInt('comment_title') == 1 && $comment->title == '') {
								if (!empty($parent->title)) {							
									$comment->title = JText::_('Re') . ' ' . $parent->title;
								}
							}
							$comment->level = $parent->level + 1;
							$comment->path = $parent->path . ',' . $parent->id;
						}
					} else {
						if ($config->getInt('comment_title') == 1 && $comment->title == '') {
							$object_title = JCommentsObjectHelper::getTitle($comment->object_id, $comment->object_group, $comment->lang);
							$comment->title = JText::_('Re') . ' ' . $object_title;
						}
						$comment->path = '0';
					}

					// save new comment to database
					if (!$comment->store()) {
						$response->addScript("jcomments.clear('comment');");
						if ($acl->check('enable_captcha') == 1) {
							JCommentsCaptcha::destroy();
							$response->addScript("jcomments.clear('captcha');");
						}

						$errorMessage = $db->getErrorMsg();
						if ($errorMessage != '') {
							if ($my->usertype == 'Super Administrator') {
								JCommentsAJAX::showErrorMessage($db->getErrorMsg());
							}
						}
						return $response;
					}

					// datetime field is used in prepareComment function
					$comment->datetime = $comment->date;

					if (is_string($comment->datetime)) {
						$comment->datetime = strtotime($comment->datetime);
					}

					if ($config->getInt('enable_mambots') == 1) {
						require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onAfterCommentAdded', array(&$comment, &$response, &$allowed));
					}

					// send notification to administrators
					if ($config->getInt('enable_notification') == 1) {
						if ($config->check('notification_type', 1) == true) {
							JComments::sendNotification($comment, true);
						}
					}

					// if comment published we need update comments list
					if ($comment->published) {
						// send notification to comment subscribers
						JComments::sendToSubscribers($comment, true);

						$comment->usertype = ($my->id != 0) ? str_replace(' ', '-', strtolower($my->usertype)) : 'guest';

						if ($merged) {
							$commentText = $comment->comment;
							JComments::prepareComment($comment);

							$tmpl = & JCommentsFactory::getTemplate();
							$tmpl->load('tpl_comment');
							$tmpl->addVar('tpl_comment', 'get_comment_body', 1);
							$tmpl->addObject('tpl_comment', 'comment', $comment);

							$html = $tmpl->renderTemplate('tpl_comment');
							$html = JCommentsText::jsEscape($html);

							$response->addScript("jcomments.updateComment(".$comment->id.", '$html');");
							$comment->comment = $commentText;
						} else {
							$count = JCommentsModel::getCommentsCount($comment->object_id, $comment->object_group);

							if ($config->get('template_view') == 'tree') {
								if ($count > 1) {
									$html = JComments::getCommentListItem($comment);
									$html = JCommentsText::jsEscape($html);
									$response->addScript("jcomments.updateTree('$html','$comment->parent');");
								} else {
									$html = JComments::getCommentsTree($comment->object_id, $comment->object_group);
									$html = JCommentsText::jsEscape($html);
									$response->addScript("jcomments.updateTree('$html',null);");
								}
							} else {
								// if pagination disabled and comments count > 1...
								if ($config->getInt('comments_per_page') == 0 && $count > 1) {
									// update only added comment
									$html = JComments::getCommentListItem($comment);
									$html = JCommentsText::jsEscape($html);

									if ($config->get('comments_order') == 'DESC') {
										$response->addScript("jcomments.updateList('$html','p');");
									} else {
										$response->addScript("jcomments.updateList('$html','a');");
									}
								} else {
									// update comments list
									$html = JComments::getCommentsList($comment->object_id, $comment->object_group, JComments::getCommentPage($comment->object_id, $comment->object_group, $comment->id));
									$html = JCommentsText::jsEscape($html);
									$response->addScript("jcomments.updateList('$html','r');");
								}

								// scroll to first comment
								if ($config->get('comments_order') == 'DESC') {
									$response->addScript("jcomments.scrollToList();");
								}
							}
						}
						JCommentsAJAX::showInfoMessage(JText::_('Thank you for your submission!'));
					} else {
						JCommentsAJAX::showInfoMessage(JText::_('Thank you, your comment will be published once reviewed'));
					}

					// clear comments textarea & update comment length counter if needed
					$response->addScript("jcomments.clear('comment');");

					unset($comment);

					if ($acl->check('enable_captcha') == 1) {
						$captchaEngine = $config->get('captcha_engine', 'kcaptcha');

						if ($captchaEngine == 'kcaptcha') {
							require_once( JCOMMENTS_BASE.DS.'jcomments.captcha.php' );
							JCommentsCaptcha::destroy();
							$response->addScript("jcomments.clear('captcha');");
						}
					}
				} else {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_DUPLICATE_COMMENT'), 'comment');
				}
			}
		} else {
			$response->addAlert(JText::_('ERROR_CANT_COMMENT'));
		}

		return $response;
	}

	function deleteComment($id)
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();

		$comment = new JCommentsDB($db);

		if ($comment->load((int) $id)) {
			if ($acl->isLocked($comment)) {
				$response->addAlert(JText::_('ERROR_BEING_EDITTED'));
			} else if ($acl->canDelete($comment)) {

				$object_id = $comment->object_id;
				$object_group = $comment->object_group;

				if ($config->getInt('enable_mambots') == 1) {
					$allowed = true;

					require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
					JCommentsPluginHelper::importPlugin('jcomments');
					JCommentsPluginHelper::trigger('onBeforeCommentDeleted', array(&$comment, &$response, &$allowed));

					if ($allowed === false) {
						return $response;
					}

					$comment->delete();

					JCommentsPluginHelper::trigger('onAfterCommentDeleted', array(&$comment, &$response));
				} else {
					$comment->delete();
				}

				$count = JCommentsModel::getCommentsCount($object_id, $object_group);

				if ($count > 0) {
					$response->addScript("jcomments.updateComment('$id','');");
				} else {
					if ($config->get('template_view') == 'tree') {
						$response->addScript("jcomments.updateTree('',null);");
					} else {
						$response->addScript("jcomments.updateList('','r');");
					}
				}
			} else {
				$response->addAlert(JText::_('ERROR_CANT_DELETE'));
			}
		}
		unset($comment);
		return $response;
	}

	function publishComment($id)
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();

		$comment = new JCommentsDB($db);

		if ($comment->load((int) $id)) {
			if ($acl->isLocked($comment)) {
				$response->addAlert(JText::_('ERROR_BEING_EDITTED'));
			} else if ($acl->canPublish()) {

				$object_id = $comment->object_id;
				$object_group = $comment->object_group;
				$page = JComments::getCommentPage($object_id, $object_group, $comment->id);
				$comment->published = !$comment->published;

				$result = false;

				if ($config->getInt('enable_mambots') == 1) {
					$allowed = true;

					require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
					JCommentsPluginHelper::importPlugin('jcomments');
					JCommentsPluginHelper::trigger('onBeforeCommentPublished', array(&$comment, &$response, &$allowed));

					if ($allowed === false) {
						return $response;
					}

					$result = $comment->store();

					JCommentsPluginHelper::trigger('onAfterCommentPublished', array(&$comment, &$response));
				} else {
					$result = $comment->store();
				}

				if ($result) {
					if ($comment->published) {
						// send notification to comment subscribers
						JComments::sendToSubscribers($comment, true);
					}

					JCommentsAJAX::updateCommentsList($response, $object_id, $object_group, $page);
				}
			} else {
				$response->addAlert(JText::_('ERROR_CANT_PUBLISH'));
			}
		}
		unset($comment);
		return $response;
	}

	function cancelComment( $id )
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$db = & JCommentsFactory::getDBO();
		$response = & JCommentsFactory::getAjaxResponse();
		$comment = new JCommentsDB($db);

		if ($comment->load((int) $id)) {
			$acl = & JCommentsFactory::getACL();

			if (!$acl->isLocked($comment)) {
				$comment->checkin();
			}
		}
		unset($comment);
		return $response;
	}

	function editComment( $id, $loadForm = 0 )
	{
		global $my;

		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$db = & JCommentsFactory::getDBO();
		$response = & JCommentsFactory::getAjaxResponse();
		$comment = new JCommentsDB($db);
		$id = (int) $id;

		if ($comment->load($id)) {
			$acl = & JCommentsFactory::getACL();

			if ($acl->isLocked($comment)) {
				$response->addAlert(JText::_('ERROR_BEING_EDITTED'));
			} else if ($acl->canEdit($comment)) {
					$comment->checkout($my->id);

					$name = ($comment->userid) ? '' : JCommentsText::jsEscape($comment->name);
					$email = ($comment->userid) ? '' : JCommentsText::jsEscape($comment->email);
					$homepage = JCommentsText::jsEscape($comment->homepage);
					$text = JCommentsText::jsEscape(JCommentsText::br2nl($comment->comment));
					$title = JCommentsText::jsEscape(str_replace("\n", '', JCommentsText::br2nl($comment->title)));

					if (intval($loadForm) == 1) {
						$form = JComments::getCommentsForm($comment->object_id, $comment->object_group, true);
						$response->addAssign('comments-form-link', 'innerHTML', $form);
					}
					$response->addScript("jcomments.showEdit(" . $comment->id . ", '$name', '$email', '$homepage', '$title', '$text');");
				} else {
					$response->addAlert(JText::_('ERROR_CANT_EDIT'));
				}
		}
		unset($comment);
		return $response;
	}

	function saveComment( $values = array() )
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();

		$response = & JCommentsFactory::getAjaxResponse();
		$values = JCommentsAJAX::prepareValues($_POST);
		$comment = new JCommentsDB($db);
		$id = (int) $values['id'];

		if ($comment->load($id)) {
			$acl = & JCommentsFactory::getACL();

			if ($acl->canEdit($comment)) {
				if ($values['comment'] == '') {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_EMPTY_COMMENT'), 'comment');
				} else if (($config->getInt('comment_maxlength') != 0)
					&& ($acl->check('enable_comment_length_check') == 1)
					&& (JCommentsText::strlen($values['comment']) > $config->getInt('comment_maxlength'))) {
					JCommentsAJAX::showErrorMessage(JText::_('ERROR_TOO_LONG_COMMENT'), 'comment');
				} else if (($config->getInt('comment_minlength') != 0)
					&& ($acl->check('enable_comment_length_check') == 1)
					&& (JCommentsText::strlen($values['comment']) < $config->getInt('comment_minlength'))) {
					JCommentsAJAX::showErrorMessage(JText::_('Your comment is too short'), 'comment');
				} else {
					$bbcode = & JCommentsFactory::getBBCode();

					$comment->comment = $values['comment'];
					$comment->comment = $bbcode->filter($comment->comment);
					$comment->published = $acl->check('autopublish');


					if (($config->getInt('comment_title') != 0) && isset($values['title'])) {
						$comment->title = stripslashes((string)$values['title']);
					}

					if (($config->getInt('author_homepage') == 1) && isset($values['homepage'])) {
						$comment->homepage = JCommentsText::url($values['homepage']);
					} else {
						$comment->homepage = '';
					}

					$allowed = true;

					if ($config->getInt('enable_mambots') == 1) {
						require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onBeforeCommentChanged', array(&$comment, &$response, &$allowed));
					}

					if ($allowed == false) {
						return $response;
					}

					$comment->store();
					$comment->checkin();

					$comment->datetime = $comment->date;

					if ($config->getInt('enable_mambots') == 1) {
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onAfterCommentChanged', array(&$comment, &$response));
					}

					if ($config->getInt('enable_notification') == 1) {
						if ($config->check('notification_type', 1) == true) {
							JComments::sendNotification($comment, false);
						}
					}

					JComments::prepareComment($comment);

					$tmpl = & JCommentsFactory::getTemplate();
					$tmpl->load('tpl_comment');
					$tmpl->addVar('tpl_comment', 'get_comment_body', 1);
					$tmpl->addObject('tpl_comment', 'comment', $comment);

					$html = $tmpl->renderTemplate('tpl_comment');
					$html = JCommentsText::jsEscape($html);

					$response->addScript("jcomments.updateComment(" . $comment->id . ", '$html');");
				}
			} else {
				$response->addAlert(JText::_('ERROR_CANT_EDIT'));
			}
		}
		unset($comment);
		return $response;
	}

	function quoteComment( $id, $loadForm = 0 )
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$db = & JCommentsFactory::getDBO();
		$acl = & JCommentsFactory::getACL();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();
		$comment = new JCommentsDB($db);
		$id = (int) $id;

		if ($comment->load($id)) {
			$comment_name = JComments::getCommentAuthorName($comment);
			$comment_text = JCommentsText::br2nl($comment->comment);

			if ($config->getInt('enable_nested_quotes') == 0) {
				$bbcode = & JCommentsFactory::getBBCode();
				$comment_text = $bbcode->removeQuotes($comment_text);
			}

			if ($config->getInt('enable_custom_bbcode')) {
				$customBBCode = & JCommentsFactory::getCustomBBCode();
				$comment_text = $customBBCode->filter($comment_text, true);
			}

			if ($acl->getUserId() == 0) {
				$bbcode = & JCommentsFactory::getBBCode();
				$comment_text = $bbcode->removeHidden($comment_text);
			}

			if ($comment_text != '') {
				if ($acl->check('enable_autocensor')) {
					$comment_text = JCommentsText::censor($comment_text);
				}

				if (intval($loadForm) == 1) {
					$form = JComments::getCommentsForm($comment->object_id, $comment->object_group, true);
					$response->addAssign('comments-form-link', 'innerHTML', $form);
				}

				$comment_text = JCommentsText::jsEscape($comment_text);
				$text = "[quote name=\"" . $comment_name . "\"]" . $comment_text . "[/quote]\\n";
				$response->addScript("jcomments.insertText('" . $text . "');");
			} else {
				$response->addAlert(JText::_('ERROR_NOTHING_TO_QUOTE'));
			}
		}
		unset($comment);
		return $response;
	}

	function updateCommentsList( &$response, $object_id, $object_group, $page )
	{
		$config = & JCommentsFactory::getConfig();

		if ($config->get('template_view') == 'tree') {
			$html = JComments::getCommentsTree($object_id, $object_group);
			$html = JCommentsText::jsEscape($html);
			$response->addScript("jcomments.updateTree('$html',null);");
		} else {
			$html = JComments::getCommentsList($object_id, $object_group, $page);
			$html = JCommentsText::jsEscape($html);
			$response->addScript("jcomments.updateList('$html','r');");
		}
	}

	function showPage($object_id, $object_group, $page)
	{
		$response = & JCommentsFactory::getAjaxResponse();

		$object_id = (int) $object_id;
		$object_group = strip_tags($object_group);
		$page = intval($page);

		JCommentsAJAX::updateCommentsList($response, $object_id, $object_group, $page);
		return $response;
	}

	function showComment($id)
	{
		$response = & JCommentsFactory::getAjaxResponse();
		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();
		$comment = new JCommentsDB($db);

		if ($comment->load((int) $id) && ($acl->canPublish() || $comment->published)) {
			if ($config->get('template_view') == 'tree') {
				$page = 0;
			} else {
				$page = JComments::getCommentPage($comment->object_id, $comment->object_group, $comment->id);
			}
			JCommentsAJAX::updateCommentsList($response, $comment->object_id, $comment->object_group, $page);
			$response->addScript("jcomments.scrollToComment('$id');");
		} else {
			$response->addAlert(JText::_('ERROR_NOT_FOUND'));
		}
		unset($comment);
		return $response;
	}

	function jump2email($id, $hash)
	{
		$db = & JCommentsFactory::getDBO();
		$response = & JCommentsFactory::getAjaxResponse();
		$comment = new JCommentsDB($db);

		$hash = strip_tags($hash);
		$hash = preg_replace('#[\(\)\'\"]#is', '', $hash);

		if ((strlen($hash) == 32) && ($comment->load( (int) $id))) {
		    $matches = array();
			preg_match_all( _JC_REGEXP_EMAIL, $comment->comment, $matches);
			foreach($matches[0] as $email) {
				if (md5((string) $email) == $hash) {
					$response->addScript("window.location='mailto:$email';");
				}
			}
			unset($matches);
		}
		unset($comment);
		return $response;
	}

	function subscribeUser($object_id, $object_group)
	{
		global $my, $mainframe;

		if (!isset($my)) {
			$my = $mainframe->getUser();
		}

		$response = & JCommentsFactory::getAjaxResponse();

		if ($my->id) {

			require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');

			$manager = & JCommentsSubscriptionManager::getInstance();
			$result = $manager->subscribe($object_id, $object_group, $my->id);

			if ($result) {
				$response->addScript("jcomments.updateSubscription(true, '" . JText::_('Unsubscribe') . "');");
			} else {
				$errors = $manager->getErrors();
				if (count($errors)) {
					$response->addAlert(implode('\n', $errors));
				}
			}
		}

		return $response;
	}

	function unsubscribeUser($object_id, $object_group)
	{
		global $my, $mainframe;

		if (!isset($my)) {
			$my = $mainframe->getUser();
		}

		$response = & JCommentsFactory::getAjaxResponse();

		if ($my->id) {

			require_once (JCOMMENTS_BASE.DS.'jcomments.subscription.php');

			$manager = & JCommentsSubscriptionManager::getInstance();
			$result = $manager->unsubscribe($object_id, $object_group, $my->id);

			if ($result) {
				$response->addScript("jcomments.updateSubscription(false, '" . JText::_('Subscribe') . "');");
			} else {
				$errors = $manager->getErrors();
				$response->addAlert(implode('\n', $errors));
			}
		}
		return $response;
	}

	function voteComment( $id, $value )
	{
		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();

		$id = (int) $id;
		$value = (int) $value;
		$value = ($value > 0) ? 1 : -1;

		$ip = $acl->getUserIP();

		$query = 'SELECT COUNT(*) FROM `#__jcomments_votes` WHERE commentid = ' . $id;

		if ($acl->getUserId()) {
			$query .= ' AND userid = ' . $acl->getUserId();
		} else {
			$query .= ' AND userid = 0 AND ip = "' . $ip . '"';
		}
		$db->setQuery( $query );
		$voted = $db->loadResult();

		if ($voted == 0) {
			$comment = new JCommentsDB($db);

			if ($comment->load($id)) {
				if ($acl->canVote($comment)) {

					$allowed = true;

					if ($config->getInt('enable_mambots') == 1) {
						require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
						JCommentsPluginHelper::importPlugin('jcomments');
						JCommentsPluginHelper::trigger('onCommentVote', array(&$comment, &$response, &$allowed, &$value));
					}

					if ($allowed !== false) {

						if ($value > 0) {
							$comment->isgood++;
						} else {
							$comment->ispoor++;
						}
						$comment->store();

						$query = "INSERT INTO `#__jcomments_votes`(`commentid`,`userid`,`ip`,`date`,`value`)"
							. "VALUES('".$comment->id."', '".$acl->getUserId()."','".$db->getEscaped($ip)."', now(), ".$value.")";
						$db->setQuery($query);
						$db->query();
					}

					$tmpl = & JCommentsFactory::getTemplate();
					$tmpl->load('tpl_comment');
					$tmpl->addVar('tpl_comment', 'get_comment_vote', 1);
					$tmpl->addObject('tpl_comment', 'comment', $comment);

					$html = $tmpl->renderTemplate('tpl_comment');
					$html = JCommentsText::jsEscape($html);
					$response->addScript("jcomments.updateVote('" . $comment->id . "','$html');");
				} else {
					$response->addAlert(JText::_('ERROR_CANT_VOTE'));
				}
			} else {
				$response->addAlert(JText::_('ERROR_NOT_FOUND'));
			}
			unset($comment);
		} else {
			$response->addAlert(JText::_('ERROR_ALREADY_VOTED'));
		}
		return $response;
	}

	function reportComment()
	{
		if (JCommentsSecurity::badRequest() == 1) {
			JCommentsSecurity::notAuth();
		}

		$acl = & JCommentsFactory::getACL();
		$db = & JCommentsFactory::getDBO();
		$config = & JCommentsFactory::getConfig();
		$response = & JCommentsFactory::getAjaxResponse();

		$values = JCommentsAJAX::prepareValues( $_POST );

		$id = (int) $values['commentid'];
		$reason = trim(strip_tags($values['reason']));
		$name = trim(strip_tags($values['name']));
		$ip = $acl->getUserIP();

		if ($reason == '') {
			JCommentsAJAX::showErrorMessage(JText::_('Please enter the reason for your report!'), '', 'comments-report-form');
			return $response;
		}

		$query = 'SELECT COUNT(*) FROM `#__jcomments_reports` WHERE commentid = ' . $id;
		if ($acl->getUserId()) {
			$query .= ' AND userid = ' . $acl->getUserId();
		} else {
			$query .= ' AND ip = "' . $ip . '"';
		}
		$db->setQuery( $query );
		$reported = $db->loadResult();

		if (!$reported) {
			$query = 'SELECT COUNT(*) FROM `#__jcomments_reports` WHERE commentid = ' . $id;
			$db->setQuery( $query );
			$reported = $db->loadResult();
			if (!$reported) {
			
				$comment = new JCommentsDB($db);
		
				if ($comment->load($id)) {

					if ($acl->canReport($comment)) {

						$allowed = true;

						if ($config->getInt('enable_mambots') == 1) {
							require_once (JCOMMENTS_HELPERS.DS.'plugin.php');
							JCommentsPluginHelper::importPlugin('jcomments');
							JCommentsPluginHelper::trigger('onReportComment', array(&$comment, &$response, &$allowed, &$value));
						}

						if ($allowed !== false) {

							if ($acl->getUserId()) {
								$user = JCommentsFactory::getUser();
								$name = $user->name;
							} else {
								if ($name == '') {
									$name = JText::_('Guest');
								}
							}

							$query = "INSERT INTO `#__jcomments_reports`(`commentid`,`userid`, `name`,`ip`,`date`,`reason`)"
								. "VALUES('".$comment->id."', '".$acl->getUserId()."', '".$db->getEscaped($name)."', '".$db->getEscaped($ip)."', now(), '".$db->getEscaped($reason)."')";
							$db->setQuery($query);
							$db->query();

							if ($config->getInt('enable_notification') == 1) {
								if ($config->check('notification_type', 2)) {

									$comment->datetime = $comment->date;

									if (is_string($comment->datetime)) {
										$comment->datetime = strtotime($comment->datetime);
									}

									JComments::sendReport($comment, $name, $reason);
								}
							}

							$html = JText::_('Report successfully sent!');
							$html = str_replace("\n", '\n', $html);
							$html = str_replace('\n', '<br />', $html);
							$html = JCommentsText::jsEscape($html);

							$response->addScript("jcomments.closeReport('$html');");
						}
					} else {
						JCommentsAJAX::showErrorMessage(JText::_('You have no rights to report comment!'), '', 'comments-report-form');
					}
				} else {
					$response->addAlert(JText::_('ERROR_NOT_FOUND'));
				}
				unset($comment);
			} else {
				JCommentsAJAX::showErrorMessage(JText::_('Comment already reported to the site administrator'), '', 'comments-report-form');
			}
		} else {
			JCommentsAJAX::showErrorMessage(JText::_('You can\'t report the same comment more than once!'), '', 'comments-report-form');
		}
		return $response;
	}
}

$result = ob_get_contents();
ob_end_clean();
?>