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
class JElementsize extends JElement {
	

	function fetchElement($name, $value, &$node, $control_name)
	{
		$output = '';
		$document =& JFactory::getDocument();
		$document->addStyleSheet('../modules/mod_ideainformer/joomla/elements/size/css/bluecurve.css');
		$document->addScript('../modules/mod_ideainformer/joomla/elements/size/js/range.js');
		$document->addScript('../modules/mod_ideainformer/joomla/elements/size/js/slider.js');
		$document->addScript('../modules/mod_ideainformer/joomla/elements/size/js/timer.js');
		$script1='
function getQueryString( sProp ) {
	var re = new RegExp( sProp + "=([^\\&]*)", "i" );
	var a = re.exec( document.location.search );
	if ( a == null )
		return "";
	return a[1];
};
';
		$document->addScriptDeclaration($script1);

		$output .= "<input class=\"text-short\" id=\"slider-input\" name=\"".$control_name."[".$name."]\" type=\"text\" size=\"7\"  value=\"".$value."\"  onchange=\"s.setValue(parseInt(this.value))\" /> px";
		$output .= "<div class=\"slider\" id=\"slider-1\" tabIndex=\"1\"><input class=\"slider-input\" id=\"slider-input-1\"/></div>";
		$output .= '<script type="text/javascript">

var s = new Slider(document.getElementById("slider-1"), document.getElementById("slider-input-1"));

s.onchange = function () {
	document.getElementById("slider-input").value = s.getValue();

};
s.setValue('.$value.');

window.onresize = function () {
	s.recalculate();
};

</script>';


		
		return $output;
	}
	
	
	

	
}

?>