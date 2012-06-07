<?php
/**
 * Element: Browsers
 * Displays a multiselectbox of different browsers
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JSSection Element
 */
class JElementBrowsers extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Browsers';

	function fetchElement( $name, $value, &$node, $control_name)
	{
		$size = $node->attributes( 'size' );

		if ( !is_array( $value ) ) {
			$value = explode( ',', $value );
		}

		$browsers = array(
			'Chrome'	=>	'Chrome',
			'- Chrome 1'	=>	'Chrome/1',
			'- Chrome 2'	=>	'Chrome/2',
			'- Chrome 3'	=>	'Chrome/3',
			'- Chrome 4'	=>	'Chrome/4',
			'- Chrome 5'	=>	'Chrome/5',
			'- Chrome 6'	=>	'Chrome/6',
			'@1'	=>	'',
			'Firefox'	=>	'Firefox',
			'- Firefox 2.0'	=>	'Firefox/2.0',
			'- Firefox 3.0'	=>	'Firefox/3.0',
			'- Firefox 3.5 '	=>	'Firefox/3.5 ',
			'- Firefox 3.6'	=>	'Firefox/3.6',
			'@2'	=>	'',
			'Internet Explorer'	=>	'MSIE',
			'- Internet Explorer 6'	=>	'MSIE 6',
			'- Internet Explorer 7'	=>	'MSIE 7',
			'- Internet Explorer 8'	=>	'MSIE 8',
			'- Internet Explorer 9'	=>	'MSIE 9',
			'@4'	=>	'',
			'Opera'	=>	'Opera',
			'- Opera 8.0'	=>	'Opera/8.0',
			'- Opera 9.0'	=>	'Opera/9.0',
			'- Opera 9.5'	=>	'Opera/9.5',
			'- Opera 10.0'	=>	'Opera/10.0',
			'- Opera 10.5'	=>	'Opera/10.5',
			'@5'	=>	'',
			'Safari'	=>	'Safari',
			'- Safari 2'	=>	'Safari/41',
			'- Safari 3'	=>	'Safari/52',
			'- Safari 4'	=>	'Safari/531',
			'- Safari 5'	=>	'Safari/533',
			'@6'	=>	'',
			'Others'	=>	'',
			'Amaya'	=>	'amaya',
			'- Amaya 9.0'	=>	'amaya/9.0',
			'- Amaya 10.0'	=>	'amaya/10.0',
			'- Amaya 11.0'	=>	'amaya/11.0',
			'AOL Explorer'	=>	'AOL Explorer',
			'Avant'	=>	'Avant',
			'Camino'	=>	'Camino',
			'- Camino 1'	=>	'Camino/1',
			'- Camino 2'	=>	'Camino/2',
			'Epiphany'	=>	'Epiphany',
			'Flock'	=>	'Flock',
			'- Flock 1'	=>	'Flock/1',
			'- Flock 2'	=>	'Flock/2',
			'Konqueror'	=>	'Konqueror',
			'Netscape'	=>	'Netscape',
			'- Netscape 8'	=>	'Netscape/8',
			'- Netscape 9'	=>	'Netscape/9',
			'SeaMonkey'	=>	'SeaMonkey',
			'- SeaMonkey 1'	=>	'SeaMonkey/1',
			'- SeaMonkey 2'	=>	'SeaMonkey/2',
			'Shiira'	=>	'Shiira',
		);

		$options = array();
		foreach ( $browsers as $key => $val ) {
			if ( substr( $key, 0, 1 ) == '@' ) {
				$options[]	= JHTML::_( 'select.option', '-', '&nbsp;', 'value', 'text', true );
			} else if ( !$val ) {
				$options[]	= JHTML::_( 'select.option', '', $key, 'value', 'text', true );
			} else {
				$options[]	= JHTML::_( 'select.option', $val, $key, 'value', 'text' );
			}
		}

		$attribs = 'class="inputbox" multiple="multiple"';
		if( $size ) {
			$attribs .= ' size="'.$size.'"';
		} else {
			$attribs .= ' size="'.( ( count( $options) > 10 ) ? 10 : count( $options) ).'"';
		}

		return JHTML::_( 'select.genericlist', $options, ''.$control_name.'['.$name.'][]', $attribs, 'value', 'text', $value, $control_name.$name );
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}