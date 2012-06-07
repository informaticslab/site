<?php
/**
 * @version		$Id: titlemanager.php 12 2008-08-28 12:03:31Z pentacle $
 * @package		Title Manager
 * @copyright	(C) 2008 Ercan Ozkaya. All rights reserved.
 * @license		GNU/GPL 2.0
 * @author		Ercan Ozkaya <ozkayaercan@gmail.com>
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemTitleManager extends JPlugin
{

	function plgSystemTitleManager(& $subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	function onAfterDispatch()
	{
		global $mainframe;
		// if it's administrator section, then do nothing
		if ( $mainframe->isAdmin() ) {
			return;
		}
		$document =& JFactory::getDocument();

		// plugin parameter set? if yes use it, if no use the global site name
		$sitename = ( trim($this->params->get('sitename')) == '' ) ? $mainframe->getCfg('sitename') : $this->params->get('sitename');

		// in frontpage, user is allowed to set the title only to site name
		if ( $this->params->get( 'frontpage' ) == '1' ) {
			$menu =& JSite::getMenu();
			if ($menu->getActive() == $menu->getDefault()) {
				$document->setTitle( $sitename );
				return;
			}
		}

		// i'm using {s} just because to protect the leading and trailing spaces
		$separator = str_replace( '{s}', ' ', $this->params->get( 'separator' ) );
		$oldtitle = $document->getTitle();

		// set the new title according to the parameter
		if ( $this->params->get( 'position' ) == 'after' ) {
			$newtitle = $oldtitle . $separator . $sitename;
		} else {
			$newtitle = $sitename . $separator . $oldtitle;
		}

		// let's do it!
		$document->setTitle( $newtitle );
		return true;
	}
}