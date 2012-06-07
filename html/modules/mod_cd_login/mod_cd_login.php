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

// include functions only once
require_once (dirname(__file__) . DS . 'helper.php');
// end

// database parameters
$greeting = $params->def('greeting', 1);
$form_name = $params->def('name', 1);
$define_links = $params->def('define_links', '0');
$display_links = $params->def('display_links', '1');
$custom_link_register = $params->def('link_new_account', '');
$custom_link_forgot_password = $params->def('link_forgot_password', '');
$custom_link_forgot_username = $params->def('link_forgot_username', '');
$cd_login_border = $params->def('cd_login_border', 'none');

$outlineType = $params->def('outlineType', 'rounded-white');
$align = $params->def('align', 'auto');
$anchor = $params->def('anchor', 'auto');
$dimmingOpacity = $params->def('dimmingOpacity', '0');
// end

// helper
$type = modCdLoginHelper::getType();
$return = modCdLoginHelper::getReturnURL($params, $type);
$loadScripts = modCdLoginHelper::loadScripts('mod_cd_login'); // load CSS stylesheet
$name = modCdLoginHelper::getFormName($form_name, $greeting); // set username or name
$forgot_username_link = modCdLoginHelper::setForgotUsernameLink($define_links, $custom_link_forgot_username); // set Forgot Username link
$forgot_password_link = modCdLoginHelper::setForgotPasswordLink($define_links, $custom_link_forgot_password); // set Forgot Password link
$register_link = modCdLoginHelper::setRegisterLink($define_links, $custom_link_register); // set Register link
// end

$user = &JFactory::getUser();

require (JModuleHelper::getLayoutPath('mod_cd_login'));

?>
