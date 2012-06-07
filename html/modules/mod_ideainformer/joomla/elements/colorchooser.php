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
/**
 * @package     gantry
 * @subpackage  admin.elements
 */
 
class JElementColorChooser extends JElement {
	

	function fetchElement($name, $value, &$node, $control_name)
	{
		//global $stylesList;
        /**
         * @global Gantry $gantry
         */
		global $gantry;
		$output = '';
		$document =& JFactory::getDocument();
		
		$this->template = end(explode(DS, $gantry->templatePath));
		
		//$styles = '../modules/mod_reformal/styles/styles.php';
		//if (file_exists($styles)) include_once($styles);
		//else return "No styles file found";

        if (!defined('GANTRY_CSS')) {
			$document->addStyleSheet('../modules/mod_ideainformer/css/reform.css');
			define('GANTRY_CSS', 1);
		}
		
		if (!defined('GANTRY_MOORAINBOW')) {
			
			$document->addStyleSheet('../modules/mod_ideainformer/joomla/elements/colorchooser/css/mooRainbow.css');
			$document->addScript('../modules/mod_ideainformer/joomla/elements/colorchooser/js/mooRainbow.js');
			
			//$scriptconfig  = $this->populateStyles($stylesList);
			$scriptconfig = $this->rainbowInit();
			
			$document->addScriptDeclaration($scriptconfig);
			
			define('GANTRY_MOORAINBOW',1);
		}
	
		$scriptconfig = $this->newRainbow($name);
		
		$document->addScriptDeclaration($scriptconfig);

		
		$output .= "<div class='wrapper'>";
		$output .= "<input class=\"picker-input text-color\" id=\"".$control_name.$name."\" name=\"".$control_name."[".$name."]\" type=\"text\" size=\"7\" maxlength=\"7\" value=\"".$value."\" />";
		$output .= "<div class=\"picker\" id=\"myRainbow_".$name."_input\"><div class=\"overlay\"></div></div>\n";
		$output .= "</div>";
		//$output = false;
		
		return $output;
	}
	
	function newRainbow($name)
	{
		return "window.addEvent('domready', function() {
			var input = $('params".$name."');
			var r_".$name." = new MooRainbow('myRainbow_".$name."_input', {
				id: 'myRainbow_".$name."',
				startColor: $('params".$name."').getValue().hexToRgb(true),
				imgPath: '../modules/mod_ideainformer/joomla/elements/colorchooser/images/',
				onChange: function(color) {
					input.getNext().getFirst().setStyle('background-color', color.hex);
					input.value = color.hex;
					
					if (this.visible) this.okButton.focus();
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('".$name."', input.value.toString());
					}
				}
			});	
			
			r_".$name.".okButton.setStyle('outline', 'none');
			$('myRainbow_".$name."_input').addEvent('click', function() {
				(function() {r_".$name.".okButton.focus()}).delay(10);
			});
			input.addEvent('keyup', function(e) {
				if (e) e = new Event(e);
				if ((this.value.length == 4 || this.value.length == 7) && this.value[0] == '#') {
					var rgb = new Color(this.value);
					var hex = this.value;
					var hsb = rgb.rgbToHsb();
					var color = {
						'hex': hex,
						'rgb': rgb,
						'hsb': hsb
					}
					r_".$name.".fireEvent('onChange', color);
					r_".$name.".manualSet(color.rgb);
				};
			}).addEvent('set', function(value) {
				this.value = value;
				this.fireEvent('keyup');
			});
			input.getNext().getFirst().setStyle('background-color', r_".$name.".sets.hex);
			rainbowLoad('myRainbow_".$name."');
		});\n";
	}
	
	function populateStyles($list)
	{
		$script = "
		var stylesList = new Hash({});
		var styleSelected = null;
		window.addEvent('domready', function() {
			styleSelected = $('paramspresetStyle').getValue();
			$('paramspresetStyle').empty();\n";
		
		reset($list);
		while ( list($name) = each($list) ) {
  			$style =& $list[$name];
			$js = "			stylesList.set('$name', ['{$style->pstyle}'";
			$js .= ", '{$style->bgstyle}'";
			$js .= ", '{$style->fontfamily}'";
			$js .= ", '{$style->linkcolor}'";
			$js .= "]);\n";
			$script .= $js;
		}
			
		$script .= "		});";
		
		return $script;
	}
	
	function rainbowInit()
	{
		return "var rainbowLoad = function(name, hex) {
				if (hex) {
					var n = name.replace('params', '');
					$(n+'_input').getPrevious().value = hex;
					$(n+'_input').getFirst().setStyle('background-color', hex);
				}
			};
		";
	}
}

?>