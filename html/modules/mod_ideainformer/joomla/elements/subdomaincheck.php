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

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();


class JElementsubdomaincheck extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Radio';

	function fetchElement($name, $value, &$node, $control_name)
	{
				$document =& JFactory::getDocument();
$script_extra="
function checkPriceType(val) {

    if (val > 1) {
        $('paramsprice-container').removeClass('required');
        
        $('price-container').setStyle('display', 'none');
        $('paramsprice-container').setProperty('value', '');
       

    } else {
        $('paramsprice-container').addClass('required');
        
        $('price-container').setStyle('display', 'block');

    }

}
function InfoSubdomain(){
	$('InfoSubdomain').setStyle('display', 'block');
}

function verefic(){
	$('verefic').setStyle('display', 'block');
}
";
$document->addScriptDeclaration($script_extra);

		$options = array ();
		foreach ($node->children() as $option)
		{
			$val	= $option->attributes('value');
			$onclick = $option->attributes('onclick');
			$text	= $option->data();
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}

		return JHTML::_('select.radiolist', $options ,''.$control_name.'['.$name.'] "onclick="'.$onclick, '', 'value', 'text', $value, $control_name.$name ).'<div style="float:right; margin-right:20px; margin-top:5px;"><a href="javascript:void(0)" onclick="InfoSubdomain()">'.JText::_('HOWSETTING').'</a></div> ';
	}
}
