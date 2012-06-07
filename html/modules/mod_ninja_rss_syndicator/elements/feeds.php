<?php
/*
* @version		$id $
* @package		mod_ninja_rss_syndicator
* @author 		NinjaForge
* @author email	support@ninjaforge.com
* @link			http://ninjaforge.com
* @license      http://www.gnu.org/copyleft/gpl.html GNU GPL
* @copyright	Copyright (C) 2010 NinjaForge - All rights reserved.
*/
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
class JElementFeeds extends JElement
{
   var   $_name = 'Feeds';
   function fetchElement($name, $value, &$node, $control_name)
   {
		if (file_exists(JPATH_SITE.'/components/com_ninjarsssyndicator/ninjarsssyndicator.php')){
			$size = ( $node->attributes('size') ? $node->attributes('size') : 5 );
			$db =& JFactory::getDBO();
			$query = 'SELECT id, feed_name AS title FROM #__ninjarsssyndicator_feeds WHERE published = 1 ORDER BY feed_name';
			$db->setQuery($query);
			$options = $db->loadObjectList();
			return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.'][]',  ' multiple="multiple" size="' . $size .'" class="inputbox"', 'id', 'title', $value, $control_name.$name);
	   } else {
		   return JText::_('Ninja RSS Syndicator is not Installed!');
	   }
   }
}
