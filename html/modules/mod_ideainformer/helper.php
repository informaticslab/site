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
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modIdeareformalHelper
{
  function getFont($fonttype)
  {
    switch($fonttype){
	case 1 : $font = "Verdana, Geneva, sans-serif";
		break;
	case 2 : $font ="Georgia, 'Times New Roman', Times, serif" ;
		break;
	case 3 : $font ="'Courier New', Courier, monospace" ;
		break;
	case 4 : $font = "Arial, Helvetica, sans-serif";
		break;
	case 5 : $font = "Tahoma, Geneva, sans-serif";
		break;
	case 6 : $font = "'Trebuchet MS', Arial, Helvetica, sans-serif" ;
		break;
	case 7 : $font = "'Arial Black', Gadget, sans-serif";
		break;
	case 8 : $font = "'Times New Roman', Times, serif" ;
		break;
	case 9 : $font = "'MS Serif', 'New York', serif";
		break;
		}
   return $font;
   }
   function getScr($src){
	if  ($src=='classific'){
	$scr='http://widget.reformal.ru/tab5.js';
}
else{
	$scr='http://widget.idea.informer.com/tabn2v3.js';
	}
   return $scr;
   }
   function getImage($params){
	   if ($params->get('image')=='2'){
		   $color = preg_replace('/\#{1}/', '', $params->get('colorzakl')); 
		   $url = 'http://reformal.ru/btest800/button/?t='.urlencode(iconv('UTF-8', 'windows-1251',$params->get('text'))).'&c=hex'.$color;
		   $image='reformal_wdg_bimage = "'.$url.'"';
	   }else{
		   $image='reformal_wdg_bimage = "'.$params->get('imageurl').'"';
	   }
	   return $image;
	   }  
}

