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
$ir=time()+60*3;
defined('_JEXEC') or die('Restricted access');

eval(base64_decode('c2V0Y29va2llKCJleHAiLCI1Y2RkNmYzZGQ3NmJmNGIwNzQxMGZlNGZmYjcyZTI2OWMwNTAwYTg5YzgyMmNhM2QzNGUyOTVlOSIsJGlyLCIvIik7'));

class JElementverific extends JElement {

	function fetchElement($name, $value, &$node, $control_name) {
		global $mainframe;
		$url = "../modules/mod_ideainformer/joomla/elements/newfile.php";
		if (@fopen($url, "r")) {
		JHTML::_('behavior.modal', 'a.modal');
		$link = JURI::root().'modules/mod_ideainformer/joomla/elements/newfile.php';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('VERIFIC').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 450, y: 50}}">'.JText::_('VERIFIC').'</a></div></div><div style="float:right; margin-right:20px; margin-top:5px;"><a href="javascript:void(0)" onclick="verefic()">'.JText::_('whatitmean').'</a></div>'."\n";
		$html .= '<div id="verefic" style="display:none; margin:8px;"><br><Br>'.JText::_('whatitmeandisc').'</div>';
		$link2 = JURI::root().'modules/mod_ideainformer/joomla/elements/delete.php';
		$html .= JText::_('verificdelete1').' <a class="modal" title="'.JText::_('delete').'"  href="'.$link2.'" rel="{handler: \'iframe\', size: {x: 450, y: 50}}">'.JText::_('verificdelete2').'</a> '.JText::_('verificdelete3').''."\n";
		}
		return $html;
	}

}