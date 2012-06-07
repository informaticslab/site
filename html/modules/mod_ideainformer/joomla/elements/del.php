<?php
/*
 * @version		
 * @package		Joomla
 * @subpackage	Idea Informer
 * @copyright	Copyright (C) 2010 Dima Horror. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @url 		www.dimahorror.ru
 *
 * Module Idea Informer is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class JElementdel extends JElement {

	function fetchElement($name, $value, &$node, $control_name) {
		global $mainframe;

		JHTML::_('behavior.modal', 'a.modal');
		$link = JURI::root().'modules/mod_ideainformer/joomla/elements/delete.php';
		$html .= 'В целях безопасности после верификации проекта, мы <br>настоятельно рекомендуем <a class="modal" title="Удалить"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 450, y: 50}}">удалить скрипт</a> верификации'."\n";


		return $html;
	}

}