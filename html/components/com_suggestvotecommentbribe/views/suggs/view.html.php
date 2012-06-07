<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Views
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */
// LOCATION: views/suggs/view.html.php
//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.view');

class SuggestionViewsuggs extends JView
{

	function display($tpl = null)
	{
		JHTML::stylesheet( 'suggestvotecommentbribe.css', 'components/com_suggestvotecommentbribe/assets/' );


		/** determine User information **/
		$user =& JFactory::getUser();
		$user_id = $user->id;
		$this->assignRef('user_id', $user_id);

		/** determine columns to show **/
		$params = &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		$columnstoshow = $params->get( 'columnstoshow' );
		if(!is_array($columnstoshow))
		{
			$columnstoshow = array(0 => $columnstoshow);
		}
		// determine whether to show a column
		$showid       = in_array("showId", $columnstoshow);
		$showtitle    = in_array("showTitle", $columnstoshow);
		$showvotes    = in_array("showVotes", $columnstoshow);
		$showcomments = in_array("showComments", $columnstoshow);
		$showbribes   = in_array("showBribes", $columnstoshow);
		$showauthor   = in_array("showAuthor", $columnstoshow);
		$showstate    = in_array("showState", $columnstoshow);
		// bring values to the presentation
		$this->assignRef('showid', $showid);
		$this->assignRef('showtitle', $showtitle);
		$this->assignRef('showvotes', $showvotes);
		$this->assignRef('showcomments', $showcomments);
		$this->assignRef('showbribes', $showbribes);
		$this->assignRef('showauthor', $showauthor);
		$this->assignRef('showstate', $showstate);

		/** items from Data **/
		$items   = & $this->get( 'Data');
		$this->assignRef('items', $items);

		/** active menu item ID **/
		$Itemid = JRequest::getInt( 'Itemid' );
		$this->assignRef('Itemid', $Itemid);

		/** lists **/
		$lists = & $this->get('List');
		$this->assignRef('lists', $lists);
		// ordering
		$ordering = ($lists['order'] == 'ordering');
		$this->assignRef('ordering', $ordering);

		/** pagination **/
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);

		/** settings **/
//		$db = &JFactory::getDBO();
//		$db->setQuery('select*from #__suggestvotecommentbribe');
//		$settings=$db->loadObjectlist();
		$settings = new stdClass();
		$settings->URL 			= $params->get("URL","");
		$settings->email 		= $params->get("email","");
		$settings->pubk 		= $params->get("pubk","");
		$settings->prvk 		= $params->get("prvk","");
		$settings->max_title 	= $params->get("max_title","");
		$settings->max_desc 	= $params->get("max_desc","");

		$this->assignRef('settings', $settings);#$this->assignRef('settings', $settings[0]);


		parent::display($tpl);
	}// function

}// class
