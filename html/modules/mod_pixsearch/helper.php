<?php
/**
* @package mod_pixsearch
* @copyright	Copyright (C) 2007 PixPro Stockholm AB. All rights reserved.
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* PixSearch is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class modPixsearchHelper
{
	function inizialize( $css_style, $offset, $display_icon, $params )
	{
		JHTML::_('behavior.mootools');
		$document =& JFactory::getDocument();
		if( $css_style == 1 )
			$document->addStyleSheet( JURI::base().'modules/mod_pixsearch/css/pixsearch_default.css' );
		$document->addScript( JURI::base().'modules/mod_pixsearch/js/pixsearch.js' );
		$document->addStyleDeclaration( '#ps_results{margin-left:'.$offset.'px;}' );
		if( $display_icon == 0 )
			$document->addStyleDeclaration( '#ps_icon_background{display:none;}' );

		$script = 'setSpecifiedLanguage("'.
			JText::_('RESULTS').'","'.
			JText::_('CLOSE').'","'.
			JText::_('SEARCH').'","'.
			JText::_('READMORE').'","'.
			JText::_('NORESULTS').'","'.
			JText::_('ADVSEARCH').'","'.
			JURI::Base().htmlentities($params->get('search_page')).'","'.
			JURI::Base().'","'.
			$params->get('limit', '10').'","'.
			$params->get('ordering', 'newest').'","'.
			$params->get('searchphrase', 'any').'","'.
			$params->get('hide_divs', '').'",'.
			$params->get('include_link', 1).',"'.
			JText::_('VIEWALL').'",'.
			$params->get('include_category', 1).','.
			$params->get('show_readmore', 1).','.
			$params->get('show_description', 1).
			');';
		$script = 'window.addEvent("domready", function() {'.$script.'});';
		$document->addScriptDeclaration( $script );
	}
}