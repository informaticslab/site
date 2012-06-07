<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		1.5.5
 * @copyright	Copyright (C) 2007 - 2011 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die( 'Restricted access' );

class highslide {
	
	/**
	 * Import files to header
	 * 
	 * @return array
	 */
	function importFiles() {
		return array(
			'highslide-full.min.js',
			'highslide.css'
		);
	}
	
	/**
	 * Script declaration
	 * 
	 * @param $params
	 * @return string
	 */
	function scriptDeclaration($params = null) {
		
		// define database parameters
		$outlineType = $params->get('outlineType', 'rounded-white');
		$outlineWhileAnimating = (int) $params->get('outlineWhileAnimating', 1);
		$showCredits = (int) $params->get('showCredits', 1);
		$expandDuration = (int) $params->get('expandDuration', 250);
		$anchor = $params->get('anchor', 'auto');
		$align = $params->get('align', 'auto');
		$transitions = $params->get('transitions', 'expand');
		$dimmingOpacity = $params->get('dimmingOpacity', '0');
		// end

		// define script parameters
		switch ($outlineWhileAnimating)
		{
			case 1:
				$outlineWhileAnimating = 'true';
				break;
			case 0:
				$outlineWhileAnimating = 'false';
				break;
			default:
				$outlineWhileAnimating = 'true';
				break;
		}
		
		if ($showCredits) {
			$showCredits = 'false';
		} else {
			$showCredits = 'false';
		}

		switch ($transitions)
		{
			case 'expand':
				$transitions = '["expand"]';
				break;
			case 'fade':
				$transitions = '["fade"]';
				break;
			case 'expand+fade':
				$transitions = '["expand", "fade"]';
				break;
			case 'fade+expand':
				$transitions = '["fade", "expand"]';
				break;
			default:
				$transitions = '["expand"]';
				break;
		}
		// end
		
		$script = "
		<!--
		hs.graphicsDir = '" . JScriptegrator::folder() . "/libraries/highslide/graphics/';
    	hs.outlineType = '" . $outlineType . "';
    	hs.outlineWhileAnimating = " . $outlineWhileAnimating . ";
    	hs.showCredits = " . $showCredits . ";
    	hs.expandDuration = " . $expandDuration . ";
		hs.anchor = '" . $anchor . "';
		hs.align = '" . $align . "';
		hs.transitions = " . $transitions . ";
		hs.dimmingOpacity = " . $dimmingOpacity . ";
		hs.lang = {
		   loadingText :     '" . JText::_('CDS_LOADING', true) . "',
		   loadingTitle :    '" . JText::_('CDS_CANCELCLICK', true) . "',
		   focusTitle :      '" . JText::_('CDS_FOCUSCLICK', true) . "',
		   fullExpandTitle : '" . JText::_('CDS_FULLEXPANDTITLE', true) . "',
		   fullExpandText :  '" . JText::_('CDS_FULLEXPANDTEXT', true) . "',
		   creditsText :     '" . JText::_('CDS_CREDITSTEXT', true) . "',
		   creditsTitle :    '" . JText::_('CDS_CREDITSTITLE', true) . "',
		   previousText :    '" . JText::_('CDS_PREVIOUSTEXT', true) . "',
		   previousTitle :   '" . JText::_('CDS_PREVIOUSTITLE', true) . "',
		   nextText :        '" . JText::_('CDS_NEXTTEXT', true) . "',
		   nextTitle :       '" . JText::_('CDS_NEXTTITLE', true) . "',
		   moveTitle :       '" . JText::_('CDS_MOVETITLE', true) . "',
		   moveText :        '" . JText::_('CDS_MOVETEXT', true) . "',
		   closeText :       '" . JText::_('CDS_CLOSETITLE', true) . "',
		   closeTitle :      '" . JText::_('CDS_CLOSETEXT', true) . "',
		   resizeTitle :     '" . JText::_('CDS_RESIZETITLE', true) . "',
		   playText :        '" . JText::_('CDS_PLAYTEXT', true) . "',
		   playTitle :       '" . JText::_('CDS_PLAYTITLE', true) . "',
		   pauseText :       '" . JText::_('CDS_PAUSETEXT', true) . "',
		   pauseTitle :      '" . JText::_('CDS_PAUSETITLE', true) . "',   
		   number :          '" . JText::_('CDS_NUMBER', true) . "',
		   restoreTitle :    '" . JText::_('CDS_RESTORETITLE', true) . "'
		};
		//-->
		";
		
		return $script;
	}
}

?>