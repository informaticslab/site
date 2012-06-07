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
 
//JURI::root()
defined('_JEXEC') or die('Direct Access');
$document =& JFactory::getDocument();
require_once (dirname(__FILE__).DS.'helper.php');
//$scr = modIdeareformalHelper::getScr($params->get('vid'));
$scr = 'http://widget.idea.informer.com/tabn2v3.js';
$subdomain = '';
$image = modIdeareformalHelper::getImage($params);
if ($params->get('type')=='0' or $params->get('type')=='1'){
$ps='<script type="text/javascript" language="JavaScript" src="'.$scr.'"></script><noscript><a href="http://'.$params->get('domain').'.useridea.com">'.$params->get('title').' feedback </a> <a href="http://useridea.com"><img src="http://widget.useridea.com/i/reformal_ru.png" /></a></noscript>';
}
if ($params->get('type')=='5'){
$ps='<div id="x_ot37"><div id="x_ne37"><script type="text/javascript" language="JavaScript" src="http://widget.idea.informer.com/tabn3v2.js"></script><div class="tgdw_mottob"><div class="dewopyb"> Powered by <a href="http://idea.informer.com" target="_blank"><img src="http://widget.idea.informer.com/i/wd/reformal2.png" width="62" height="9" alt="idea.informer.com" /></a></div></div></div></div>';
}
if ($params->get('price-container')!='' and $params->get('subdomaincheck')==0){
	$subdomain='reformal_wdg_vlink    = "'.$params->get('price-container').'";';
}
$font = modIdeareformalHelper::getFont($params->get('font'));
$script=$subdomain.'
reformal_wdg_w    = "'.$params->get('width').'";
reformal_wdg_h    = "'.$params->get('height').'";
reformal_wdg_domain    = "'.$params->get('domain').'";
reformal_wdg_mode    = '.$params->get('type').';
reformal_wdg_title   = "'.$params->get('title').'";
reformal_wdg_ltitle  = "'.$params->get('text').'";
reformal_wdg_lfont   = "'.$font.'";
reformal_wdg_lsize   = "'.$params->get('size').'px";
reformal_wdg_color   = "'.$params->get('colorzakl').'";
reformal_wdg_align   = "'.$params->get('position').'";
reformal_wdg_waction = '.$params->get('povedenie').';
reformal_wdg_bcolor  = "'.$params->get('bcolor').'";
reformal_wdg_tcolor  = "'.$params->get('tcolor').'";
reformal_wdg_vcolor  = "'.$params->get('vcolor').'";
reformal_wdg_cmline  = "'.$params->get('cmline').'";
reformal_wdg_glcolor  = "'.$params->get('glcolor').'";
reformal_wdg_tbcolor  = "'.$params->get('tbcolor').'";
reformal_wdg_cms      = "joomla";'.$image;
$document->addScriptDeclaration($script);
require(JModuleHelper::getLayoutPath('mod_ideainformer'));