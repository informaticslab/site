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


class JElementToggle extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Toggle';

	function fetchElement($name, $value, &$node, $control_name='params')
	{
		global $gantry;
		$hidden = '<input type="hidden" name="'.$name.'" value="_" />';
		
		$options = array ();
        $options[] = array('value'=>1,'text'=>'On/Off','id'=>$name);

		$document =& JFactory::getDocument();

		if (!defined('GANTRY_TOGGLE')) {
			$this->template = end(explode(DS, $gantry->templatePath));
			
            $document->addScript('../modules/mod_ideainformer/joomla/elements/toggle/js/touch.js');
            $document->addScript('../modules/mod_ideainformer/joomla/elements/toggle/js/toggle.js');
            define('GANTRY_TOGGLE',1);
        }


		$document->addScriptDeclaration($this->toggleInit($name));
		
		$checked = ($value == 0) ? '' : 'checked="checked"';
		
		return "
		<div class='wrapper'>
			<input name='".$control_name."[".$name."]' value='$value' type='hidden' />
			<input type='checkbox' class='toggle' id='params$name' $checked />
		</div>
		";
    }

	function toggleInit($id) {
		$js = "
			window.addEvent('domready', function() {
				window.toggle".str_replace("-", "", $id)." = new Toggle('params".$id."', {
					focus: true, 
					onChange: function(state) {
						var value = (state) ? 1 : 0;
						this.container.getPrevious().value = value;
						
						if (Gantry.MenuItemHead) {
							var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
							if (!cache) cache = new Hash({});
							cache.set('".$id."', value.toString()); 
						}
						
						if (this.container.getParent().getParent() != this.container.getParent().getParent().getParent().getFirst()) return;
						
						var nexts = this.container.getParent().getParent().getParent().getChildren();
						
						if (nexts.length) {
							nexts.each(function(chain) {
								var cls = chain.className.split(' '), type = '';
								cls.each(function(val) {
									if (val.contains('chain-')) type = val.replace('chain-', '');
								});
								
								if (['position', 'groupedselection', 'showmax', 'animation', 'dateformats', 'menuids'].contains(type)) {
									var select = chain.getElement('select');
									if ($(select).fireEvent('detach')) {
										if (value) select.fireEvent('attach');
										else select.fireEvent('detach');
									}
								}
								if (['text'].contains(type)) {
									var text = chain.getElement('input[type=\"text\"]');
									if ($(text).fireEvent('detach')) {
										if (value) text.fireEvent('attach');
										else text.fireEvent('detach');
									}
								}
								if (['toggle'].contains(type) && chain != this.container.getParent().getParent().getParent().getFirst()) {
									var checkbox = chain.getElement('input[type=checkbox]');
									if (checkbox) {
										(function() {
										if (value) checkbox.fireEvent('attach');
										else checkbox.fireEvent('detach');
										}).delay(10);
									}
								}
							}, this);
						}
					}
				});
			});
		";
		
		return $js;
	}
}
