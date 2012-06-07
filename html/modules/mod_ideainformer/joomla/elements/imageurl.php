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

class JElementimageurl extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Text';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        /*
         * Required to avoid a cycle of encoding &
         * html_entity_decode was used in place of htmlspecialchars_decode because
         * htmlspecialchars_decode is not compatible with PHP 4
         */
		 JHTML::_('behavior.modal', 'a.modal');
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
		$link = JURI::root().'modules/mod_ideainformer/joomla/elements/imageupload.php';
		return '<div id="image-container" style="display:none; margin-top:10px;">'.JText::_('LINK').': &nbsp; <input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' /><br><div class="button2-left" style="margin-left:80px;margin-top:5px;"><div class="blank"><a class="modal" title="'.JText::_('Uploadimage').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 550, y: 100}}">'.JText::_('Uploadimage').'</a></div></div></div>';
	}
}