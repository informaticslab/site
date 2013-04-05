<?php
session_start();
ob_start();
?>


<?php require("login/login3_iphone.php"); ?> 
<?php require("bsniff.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles_iphone.css" type="text/css" />
<link
        rel="stylesheet"
        type="text/css"
        href="styles_iphone_retina.css"
        media="only screen and (-webkit-min-device-pixel-ratio: 2)" />
<link rel="stylesheet" href="comments/css/stylesheet_iphone.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>





</head>
<meta name="viewport" content="width=320" />
<body onload="MM_preloadImages('images_iphone/download_iphone_hover.png')">


<div id="wrap">



<div id="header">
<a href="http://www.phiresearchlab.org"><img src="images_iphone/banner.png" title="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" alt="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" border="0" width="320px" height"130px" /></a>

</div><!--end of header-->

<div id="back_to_iphone"><span style="color:#0069ac;"><</span> <a href="index_iphone2.php">All iPad prototypes</a>
</div><!--end of disclaimer_iphone-->



<div id="other_links_iphone"><a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="http://epiinfoios.codeplex.com">Get source code ></a>

</div>


<div id="iphone_detail_icons"><img src="images/epi_icon.png" alt="Epi Info"/>
</div>



<div id="app_name_iphone">StatCalc by Epi Info<sup style="font-size:5px;">TM</sup></div>

<div id="stats_iphone">
<strong>Category:</strong> Epidemiology<br/>

<strong>Version:</strong> 0.9<br/>
<strong>Cost:</strong> Free<br/>

</div><!--end of stats-->

<div id="wrap_requirements">
<div id="requirements_iphone">

<br/>
</div>

</div>






<div id="dotted_line3_iphone"></div>

<div id="detail_text_iphone">



<span style="font-size:11px;"><strong>Description:</strong></span>

<p>StatCalc statistical calculators have long been a feature of CDC's Epi Info desktop software. Each calculator has been adapted for iOS and is included in this app. The app controls and facilitates user inputs by taking advantage of the iPad's touchscreen interface and using input devices such as sliders and steppers.</p> 
<p>Included calculators are:

<ul><li>2x2xn calculator with associated confidence intervals and statistical tests</li>

<li>Pair-matched case control 2x2 calculator with associated confidence intervals and statistical tests</li>

<li>Chi-square calculator for trend detection</li>

<li>Binomial calculator for determining the probability of an observed proportion</li>

<li>Poisson calculator for determining the probability of an observed number of successes</li>

<li>Sample size calculators:
<ul>
<li>For unmatched case-control studies</li>

<li>For cohort studies</li>

<li>For population surveys</li>
</ul>
</li>
 </ul>

Future development plans include adding other Epi Info desktop features such as data analysis, graphing, mapping, form design, and data collection.</p>



<br/>

<strong>Screenshots:</strong> 
<div id="screen_row_iphone"><img src="images_iphone/epi_screen1.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/epi_screen2.png" alt="screenshot of Epi Info 2x2 calculator" title="screenshot of Epi Info 2x2 calculator"/></div> 

<div id="screen_row_iphone"><img src="images_iphone/epi_screen3.png" alt="screenshot of Epi Info 2x2 calculator, summary results" title="screenshot of Epi Info 2x2 calculator, summary results"/></div> 

<div id="screen_row_iphone"><img src="images_iphone/epi_screen4.png" alt="screenshot of Epi Info Sample Size Calculation" title="screenshot of Epi Info Sample Size Calculation"/></div> 







<div id="dotted_line4_iphone"></div>
<br/>
<div id="feedback_iphone">


<?php

$page_id = "epi";
$reference = "EPI INFO";
$path_to_comments_folder = "comments/";
define ('IN_COMMENTICS', 'true'); //no need to edit this line
require $path_to_comments_folder . "includes/commentics.php"; //no need to edit this line

?>





</div><!--end of feedback-->


</div><!--end of second_column-->




</div><!--end of detail_text-->


<div id="footer"><span class="footer_text"><img src="images_iphone/footer_iphone.png" border="0" alt="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" title="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" /></span></div>
<div id="bottom_line"></div>

</div><!--end of wrap-->

</body>
</html>
