<?php
/**
 * Core Design Login module for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	Content
 * @category	Module
 * @version		1.1.9
 * @copyright	Copyright (C) 2007 - 2010 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modCdLoginHelper
{
	function getReturnURL($params, $type) {
		if($itemid =  $params->get($type)) {
			$menu =& JSite::getMenu();
			$item = $menu->getItem($itemid);
			if ($item) {
				$url = JRoute::_($item->link.'&Itemid='.$itemid, false);
			}
			else {
				// stay on the same page
				$uri = JFactory::getURI();
				$url = $uri->toString(array('path', 'query', 'fragment'));
			}
		}
		else {
			// stay on the same page
			$uri = JFactory::getURI();
			$url = $uri->toString(array('path', 'query', 'fragment'));
		}

		return base64_encode($url);
	}
	
	function getType()
	{
		$user = &JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}

	function loadScripts($name)
	{
		$document = &JFactory::getDocument();
		$live_path = JURI::base(true) . '/'; // define live site

		// add CSS stylesheet
		$document->addStyleSheet($live_path . "modules/$name/tmpl/css/$name.css", "text/css");
		
		// add OpenID
		if (modCdLoginHelper::getType() === 'login' && JPluginHelper::isEnabled('authentication', 'openid')) {
			$document->addScript($live_path . "modules/$name/tmpl/js/cd_openid.js");
		}
	}

	function setForgotUsernameLink($define_links, $custom_link_forgot_username)
	{
		switch ($define_links)
		{
			case '0':
			default:
				$forgot_username_link = JRoute::_('index.php?option=com_user&view=remind');
				break;
			case '1':
				$forgot_username_link = JRoute::_($custom_link_forgot_username);
				break;
		}
		return $forgot_username_link;
	}

	function setForgotPasswordLink($define_links, $custom_link_forgot_password)
	{
		switch ($define_links)
		{
			case '0':
			default:
				$forgot_password_link = JRoute::_('index.php?option=com_user&view=reset');
				break;
			case '1':
				$forgot_password_link = JRoute::_($custom_link_forgot_password);
				break;
		}
		return $forgot_password_link;
	}

	function setRegisterLink($define_links, $custom_link_register)
	{
		switch ($define_links)
		{
			case '0':
			default:
				$register_link = JRoute::_('index.php?option=com_user&view=register');
				break;
			case '1':
				$register_link = JRoute::_($custom_link_register);
				break;
		}
		return $register_link;
	}

	function getFormName($form_name, $greeting)
	{
		$user = &JFactory::getUser();
		if ($form_name)
		{
			$form_name = $user->get('name');
		} else
		{
			$form_name = $user->get('username');
		}

		if ($greeting) {
			$form_name = JText::sprintf('CDLOGIN_HINAME', $form_name);
		} else {
			$form_name =  JText::_('CDLOGIN_HI_LOGOUT');
		}
		return $form_name;
	}

}
?>
