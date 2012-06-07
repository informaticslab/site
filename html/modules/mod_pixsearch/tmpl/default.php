<?php
/**
* @package mod_pixsearch
* @copyright    Copyright (C) 2007 PixPro Stockholm AB. All rights reserved.
* @license              http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* PixSearch is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Grab the itemid
if ($params->get('man_itemid')) {

        $itemid = $params->get('man_itemid');

} else {

        $itemid = JRequest::getVar('Itemid', '', 'get', 'INT');

}

?>

<form name="pp_search" id="pp_search" action="<?php echo JURI::Base()?>" method="get">
<div class="pixsearch<?php echo $params->get('moduleclass_sfx'); ?>">
        <div id="ps_searchwrapper">
                <div class="ps_pretext"><?php echo $params->get('pretext'); ?></div>
                <input id="ps_search_str" name="searchword" alt="Search" title="Search" type="text" value="<?php echo JText::_('SEARCH'); ?>" autocomplete="off" />
                <div id="ps_icon_background">
      <!-- <input type="image" src="images/stories/search.png" border="0" value=" " alt="Search" title="Search">-->

                        
<!--<div id="ps_icon"></div>-->
                </div>
        </div>
        <input type="hidden" name="searchphrase" value="<?php echo $params->get("searchphrase")?>"/>
        <input type="hidden" name="limit" value="" />
        <input type="hidden" name="ordering" value="<?php echo $params->get("ordering")?>" />
        <input type="hidden" name="view" value="search" />
        <input type="hidden" name="Itemid" value="<?php echo $itemid?>" />
        <input type="hidden" name="option" value="com_search" />
        <div class="ps_posttext"><?php echo $params->get('posttext'); ?></div>
        <div id="ps_results"></div>
</div>

</form>
<div id="ps_results"></div>

<div id="pixsearch_tmpdiv" style="visibility:hidden;display:none;"></div>


