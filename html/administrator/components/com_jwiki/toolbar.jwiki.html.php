<?php

/**
 * This file is part of JWiki.
 * JWiki is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JWiki is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JWiki. If not, see <http://www.gnu.org/licenses/>.
 *
 * @Copyright Copyright (C) 2009 - HalloWelt! - Medienwerkstatt GmbH
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/


// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class menuMamboWiki {

/**
* Draws the menu for to Edit a mediawiki
*/
	function EDIT_MENU()
	{
		JToolBarHelper::save( 'savemambowiki' );
		JToolBarHelper::cancel( 'cancelmambowiki' );
	}
/**
* Draws the default menu
*/
	function DEFAULT_MENU()
	{
		JToolBarHelper::back();
	}
}
?>