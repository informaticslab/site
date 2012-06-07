<?php
/**
 * Element: Toggler
 * Adds slide in and out functionality to elements based on an elements value
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Toggler Element
 *
 * To use this, make a start xml param tag with the param and value set
 * And an end xml param tag without the param and value set
 * Everything between those tags will be included in the slide
 *
 * Available extra parameters:
 * param			The name of the reference parameter
 * value			a comma seperated list of value on which to show the elements
 */
class JElementToggler extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Toggler';

	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		return;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$option = JRequest::getCmd( 'option' );

		// do not place toggler stuff on JoomFish pages
		if ( $option == 'com_joomfish' ) { return; }

		$param =			$node->attributes( 'param' );
		$value =			$node->attributes( 'value' );
		$nofx =				$node->attributes( 'nofx' );
		$horz =				$node->attributes( 'horizontal' );
		$method =			$node->attributes( 'method' );
		$overlay =			$node->attributes( 'overlay' );
		$casesensitive =	$node->attributes( 'casesensitive' );

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'functions.php';
		$this->functions =& NNFunctions::getFunctions();
		$mt_version = $this->functions->getJSVersion();

		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/js/script'.$mt_version.'.js' );
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/elements/toggler'.$mt_version.'.js' );
		$document->addStyleSheet( JURI::root(true).'/plugins/system/nonumberelements/elements/style.css' );

		if ( $param != '' ) {
			$set_groups = explode( '|', $param );
			$set_values = explode( '|', $value );
			$ids = array();
			foreach ( $set_groups as $i => $group ) {
				$count = $i;
				if ( $count >= count( $set_values ) ) {
					$count = 0;
				}
				$values = explode( ',', $set_values[$count] );
				foreach ( $values as $val ) {
					$ids[] = $group.'.'.$val;
				}
			}
			$html = '<div id="'.rand( 1000000, 9999999 ).'___'.implode( '___', $ids ).'" class="nntoggler';
			if ( $nofx ) {
				$html .= ' nntoggler_nofx';
			}
			if ( $horz ) {
				$html .= ' nntoggler_horizontal';
			}
			if ( $method == 'and' ) {
				$html .= ' nntoggler_and';
			}
			if ( $overlay ) {
				$html .= ' nntoggler_overlay';
			}
			if ( $casesensitive ) {
				$html .= ' nntoggler_casesensitive';
			}
			$html .= '" style="visibility: hidden;">';
			$html .= '<table width="100%" class="paramlist admintable" cellspacing="1">';
			$html .= '<tr style="height:auto;"><td colspan="2" class="paramlist_value">';
			$random = rand( 100000, 999999 );
			$html .= '<div id="end-'.$random.'"></div><script type="text/javascript">NoNumberElementsHideTD( "end-'.$random.'" );</script>';
		} else {
			$random = rand( 100000, 999999 );
			$html = '<div id="end-'.$random.'"></div><script type="text/javascript">NoNumberElementsHideTD( "end-'.$random.'" );</script>';
			$html .= '</td></tr></table>';
			$html .= '</div>';
		}

		return $html;
	}
}