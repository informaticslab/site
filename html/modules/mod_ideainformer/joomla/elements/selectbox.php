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

class JElementSelectBox extends JElement {
	

	function fetchElement($name, $value, &$node, $control_name, $options = false, $translation = true) {
        global $gantry;
		$document =& JFactory::getDocument();

		if (!defined('GANTRY_SELECTBOX')) {
			$this->template = end(explode(DS, $gantry->templatePath));
			$document->addScript('../modules/mod_ideainformer/joomla/elements/selectbox/js/selectbox.js');
			
			define('GANTRY_SELECTBOX', 1);
		}
		
		$lis = $activeElement = "";
		$xml = false;
		
		if (!$options) {
			$options = $node->children();
			$xml = true;
		}
		
		$isPreset = ($node->attributes('preset')) ? $node->attributes('preset') : false;
		
		foreach($options as $option) {
			if ($xml) {
				$optionData = $option->data();
				$optionValue = $option->attributes('value');
				$optionDisabled = $option->attributes('disable');
			} else {
				$optionData = $option->text;
				$optionValue = $option->value;
				$optionDisabled = $option->disable;
			}

			$disabled = ($optionDisabled == 'disable') ? "disabled='disabled'" : "";
			$selected = ($value == $optionValue) ? "selected='selected'" : "";
			$active = ($value == $optionValue) ? "class='active'" : "";
			if (strlen($active)) $activeElement = $optionData;
			
			if (strlen($disabled)) $active = "class='disabled'";
			
			$imapreset = ($isPreset) ? "im-a-preset" : "";
			
			$text = ($translation) ? JTEXT::_($optionData) : $optionData;
			
			$options .= "<option value='$optionValue' $selected $disabled>".$text."</option>\n";
			$lis .= "<li ".$active.">".$text."</li>";
		}
		
		$html  = "<div class='wrapper'>";
		$html .= "<div class='selectbox-wrapper'>";
		
		$html .= "	<div class='selectbox'>";

		$html .= "		<div class='selectbox-top'>";
		$html .= "			<div class='selected'><span>".JTEXT::_($activeElement)."</span></div>";
		$html .= "			<div class='arrow'></div>";
		$html .= "		</div>";
		$html .= "		<div class='selectbox-dropdown'>";
		$html .= "			<ul>".$lis."</ul>";
		$html .= "			<div class='selectbox-dropdown-bottom'><div class='selectbox-dropdown-bottomright'></div></div>";
		$html .= "		</div>";

		$html .= "	</div>";
		
		$html .= "	<select id='params".$name."' name='params[".$name."]' class='selectbox-real ".$imapreset."'>";
		$html .= 		$options;
		$html .= "	</select>";
		$html .= "</div>";
		$html .= "<div class='clr'></div>";
		$html .= "</div>";
		
		return $html;
	}
		
}

?>