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

defined('JPATH_BASE') or die();
class JElementpx extends JElement {
	

	function fetchElement($name, $value, &$node, $control_name)
	{


		$output .= "<input class=\"text-short\"  name=\"".$control_name."[".$name."]\" type=\"text\"   value=\"".$value."\"   /> px";
		
		return $output;
	}
	
	
	

	
}

?>