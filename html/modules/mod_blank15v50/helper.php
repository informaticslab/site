<?php

/**
 *
 *
 * @package   mod_blank15v43
 * @subpackage
 * @link
 * @license GPL3
 */

// no direct access
defined('_JEXEC') or die('Restricted access');



function cssoutputs($modno4,$url4,$surmodulemedia4,$surroundstyle4,$keycolour4,$colour4 ,$bg4 ){

echo '<style type="text/css" media="screen">
/*<![CDATA[*/



td.corner1_' . $modno4 .
    '{padding:0;margin:0;background:url('.$url4.'modules/'.$surmodulemedia4.'/tmpl/images/surrounds/' .
    $surroundstyle4 . '/' . $keycolour4 .
    '/corner1.png) no-repeat ;

}
td.corner2_' . $modno4 .
    '{padding:0;margin:0;background:url('.$url4.'modules/'.$surmodulemedia4.'/tmpl/images/surrounds/' .
    $surroundstyle4 . '/' . $keycolour4 .
    '/corner2.png) no-repeat ;

}
td.corner3_' . $modno4 .
    '{padding:0;margin:0;background:url('.$url4.'modules/'.$surmodulemedia4.'/tmpl/images/surrounds/' .
    $surroundstyle4 . '/'  . $keycolour4 .
    '/corner3.png) no-repeat ;

}
td.corner4_' . $modno4 .
    '{padding:0;margin:0;background:url('.$url4.'modules/'.$surmodulemedia4.'/tmpl/images/surrounds/' .
    $surroundstyle4 . '/'  . $keycolour4.
    '/corner4.png) no-repeat ;

}


#contenttable' . $modno4 . '{
background:'.$colour4.';
}


#inner' . $modno4 . '{
padding:3px;
' . $bg4 .';
}

/*]]>*/
</style>';}



?>


