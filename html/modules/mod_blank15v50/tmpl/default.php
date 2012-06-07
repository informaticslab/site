<?php // no direct access
/**
 * @package mod_blank15v50
 * @link www.blackdale.com
 * @Copyright Bob Galway
 * @license>GPL3   http://www.gnu.org/licenses/
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 


//check to see if Media addon is installed



//Collect Parameters

$url = JURI::base();

$mode=$params->get('mode');
$code=$params->get('code');
$graphics=$params->get('graphics');
$paddingleft=$params->get('paddingleft');
$paddingright=$params->get('paddingright');
$paddingtop=$params->get('paddingtop');
$paddingbottom=$params->get('paddingbottom');
$margintop=$params->get('margin-top');
$marginbottom=$params->get('margin-bottom');
$marginleftmodule=$params->get('margin-leftmodule');
$colour1=$params->get('colour1');
$colour2=$params->get('colour2');
$width=$params->get('width');
$widthunit=$params->get('widthunit');
$itemid=$params->get('itemid');
$contenttitleuse=$params->get('contenttitleuse');
$contentuse=$params->get('contentuse');
$textareause=$params->get('textareause');
$reverse=$params->get('reverse');
$modno_bm = $params->get('modno_bm');
$custompx = $params->get('custompx');


// set background colour

//$keycolour = $params->get('keycolour');
//if ($keycolour == blue) {
//    $bgcolour = '#aabbff';
//}
//if ($keycolour == green) {
//    $bgcolour = '#aaffaa';
//}
//if ($keycolour == red) {
//    $bgcolour = '#dd2222';
//}
//if ($keycolour == orange) {
//    $bgcolour = '#cc9944';
//}
//if ($keycolour == yellow) {
//    $bgcolour = '#dd9';
//}
//if ($keycolour == purple) {
 //   $bgcolour = '#d244f2';
//}
//if ($keycolour == grey) {
 //   $bgcolour = '#dddddd';
//}

//modify paths if media libraries available

$surroundstyle = $params->get('surroundstyle');

$surroundpx = substr($surroundstyle,0,2).'px';
if($surroundstyle !=="custom"){$lib = substr($surroundstyle,-1,1);}


// define possible paths

$path1="modules/mod_bdalemedia1";
$path2="modules/mod_bdalemedia2";
$path3="modules/mod_bdalemedia3";
$path4="modules/mod_bdalebackgrounds";

//Select backgrounds source folder 

if(JFolder::exists($path4)){$bgmodulemedia='mod_bdalebackgrounds';}
else {$bgmodulemedia='mod_blank15v50';}

//Select surrounds source folder 
$surmodulemedia='mod_blank15v50';
if((JFolder::exists($path1)&&($lib ==1))||(JFolder::exists($path2)&&($lib ==2))||(JFolder::exists($path3)&&($lib ==3))){$surmodulemedia='mod_bdalemedia'.$lib;}


// set dimension etc for custom surround

if ($surroundstyle=="custom"){$surroundpx=$custompx;$surmodulemedia='mod_blank15v50';}

//colours & backgrounds

$bgpattern = $params->get('bgpattern');

if($bgpattern == "custom"){$bgmodulemedia='mod_blank15v50';}
$customcolour = $params->get('customcolour');


$bgcustomcolour = $params->get('bgcustomcolour');
$bgautocolour = $params->get('bgautocolour');
if ($bgautocolour==2){
	
$bgcolour=$bgcustomcolour;	
}



//if ($bgpattern == none) {
//    $bguse = 2;
//}

//if ($bgpattern !== none) {
 //   $bguse = 1;
//}
//if ($bguse == 1) {
//    $bg = 'background:' . $bgcolour .
 //       ' url("'.$url.'modules/'.$bgmodulemedia.'/tmpl/images/backgrounds/' . $bgpattern .
 //       '.png")';
//}
//if ($bguse == 2) {
 //   $bg = 'background-color:' . $bgcolour . ';';
//}


//Putting it all together

if ($graphics==1){
cssoutputs($modno_bm,$url,$surmodulemedia,$surroundstyle,$keycolour,$colour2 ,$bg );}

echo '<div  style = "margin-top:'.$margintop.'px; margin-bottom:'.$marginbottom.'px; position:relative;left:'.$marginleftmodule.'px;overflow:hidden;padding-left:'.$paddingleft.'px; padding-right:'.$paddingright.'px; padding-top:'.$paddingtop.'px; padding-bottom:'.$paddingbottom.'px;width:'.$width.$widthunit.';background:'.$colour1.'; ">';


if ($graphics==1){
echo '<div class="holder' . $modno_bm . '">

<table width="' . $width .$widthunit.
    '"  border="0" cellspacing="0" cellpadding="0" style="overflow:hidden" id="contenttable' . $modno_bm . '">

<tr>
<td class="corner1_' . $modno_bm . '" width="' . $surroundpx . '" height="' . $surroundpx .
    '">
</td>
<td style="background:url('.$url.'modules/'.$surmodulemedia.'/tmpl/images/surrounds/' . $surroundstyle .
    '/'  . $keycolour . '/top.png) repeat-x">
</td>
<td class="corner2_' . $modno_bm . '" width="' . $surroundpx . '" height="' . $surroundpx .
    '">
</td>

</tr>

<tr>

<td width="' . $surroundpx .
    '" style="background:url('.$url.'modules/'.$surmodulemedia.'/tmpl/images/surrounds/' . $surroundstyle .
    '/'  . $keycolour . '/sidel.png) repeat-y;">
</td>
<td ><div id="inner' . $modno_bm . '">';}

//Code to place snippet in module before content page
if ($textareause==1 and $reverse==2 and $mode==1) {
    echo $code.'<br/>';
}
if ($textareause==1 and $reverse==2 and $mode==2) {
    eval($code);
}
//Code to place content page in module

// 1.  title retrieval
$db=& JFactory::getDBO();
if ($contenttitleuse==1){
    $db->setQuery('SELECT * FROM `#__content` WHERE `id`= '.$itemid.' ORDER BY `id`');
    $contents = $db->loadObjectList();
    if(isset($contents[0]) ){echo '<h3 style="overflow:hidden">'.($contents[0]->title).'</h3>';}
}

//2 . content retrieval

if ($contentuse==1) {
    $db->setQuery('SELECT * FROM `#__content` WHERE `id`= '.$itemid.' ORDER BY `id`');
    $contents = $db->loadObjectList();
    if(isset($contents[0]) ){echo ($contents[0]->introtext ).'<br/>'.($contents[0]->fulltext );}

}

//Code to place snippet in module after content page

if ($textareause==1 and $reverse==1 and $mode==1 ) {

    echo '<br/>'.$code;
}

if ($textareause==1 and $reverse==1 and $mode==2) {
    eval($code);
}

if ($graphics==1){


echo   '</div>
</td>
<td width="' . $surroundpx .
    '" style="background:url('.$url.'modules/'.$surmodulemedia.'/tmpl/images/surrounds/' . $surroundstyle .
    '/' . $keycolour . '/sider.png) repeat-y;">
</td>

</tr>

<tr >

<td class="corner3_' . $modno_bm . '" width="' . $surroundpx . '" height="' . $surroundpx .
    '">
</td>
<td style="background:url('.$url.'modules/'.$surmodulemedia.'/tmpl/images/surrounds/' . $surroundstyle .
    '/'  . $keycolour . '/base.png) repeat-x">
</td>
<td class="corner4_' . $modno_bm . '" width="' . $surroundpx . '" height="' . $surroundpx .
    '">
</td>

</tr>
</table>
</div>';}

echo '</div>';

?>
