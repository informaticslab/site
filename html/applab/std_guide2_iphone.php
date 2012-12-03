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


<link rel="stylesheet" type="text/css" href="comments/css/stylesheet_iphone.css"/>
<script type="text/javascript" src="common.js"></script>


</head>
<meta name="viewport" content="width=320" />
<body onload="MM_preloadImages('images_iphone/download_iphone_hover.png')">


<div id="wrap">



<div id="header">
<a href="http://www.phiresearchlab.org"><img src="images_iphone/banner.png" title="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" alt="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" border="0" width="320px" height"130px" /></a>

</div><!--end of header-->

<div id="back_to_iphone"><span style="color:#0069ac;"><</span> <a href="index_iphone.php">All prototypes</a>
</div><!--end of disclaimer_iphone-->



<div id="other_links_iphone"><a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="https://github.com/informaticslab/std2">Get source code ></a>

</div>


<div id="iphone_detail_icons"><img src="images/std2_icon.png" alt="STD Guide, Version 2"/>
</div>



<div id="app_name_iphone2">STD Guide, Version 2</div>

<div id="stats_iphone">
<strong>Category:</strong> Reference<br/>
<strong>Released:</strong> 6/4/2012<br/>
<strong>Version:</strong> 0.9.3.001<br/>
<strong>Size:</strong> 2.36MB<br/>
</div><!--end of stats-->


<div id="download_detail_iphone"><a id="std2-applab-download" href="itms-services://?action=download-manifest&url=http://www.phiresearchlab.org/applab/downloads/std2/0.9.3.001/manifest.plist"><img src="images_iphone/download_iphone.png" alt="Download app" title="Download app" name="Image4" width="65" height="20" border="0" id="Image4" /></a></div>

<div id="wrap_requirements">
<div id="requirements_iphone">
<strong>Cost:</strong> Free<br/>
<strong>Requirements:</strong>
iPhone, iPod Touch, <br/>
iPad with iOS 4.3 or later
</div>

</div>






<div id="dotted_line3_iphone"></div>

<div id="detail_text_iphone">



<span style="font-size:11px;"><strong>Description:</strong></span>

<p>The goal of this prototype has been to collaborate with CDC's STD team to design a mobile app for the iPhone
containing the 2010 STD Treatment Guidelines.  This prototype, v2, builds on the first prototype version to have more of a "portal" feel. The application is to serve as a reference for doctors and related parties on the identification of and treatment regimen for STDs.</p>

<p>These guidelines for the treatment of persons who have or are at risk for sexually transmitted diseases (STDs) were updated by CDC after consultation with a group of professionals knowledgeable in the field of STDs who met in Atlanta on April 18–30, 2009. The information in this report updates the 2006 Guidelines for Treatment of Sexually Transmitted Diseases (MMWR 2006;55[No. RR–11]).</p> 

<br/>

<strong>Screenshots:</strong> 
<div id="screen_row_iphone"><img src="images_iphone/std2_screen1.png" alt="screenshot of Home screen" title="screenshot of Home screen"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/std2_screen2.png" alt="screenshot of guideline categories" title="screenshot of guideline categories"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/std2_screen3.png" alt="screenshot of Recommended Regimens" title="screenshot of Recommended Regimens"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/std2_screen4.png" alt="screenshot of photo associated with disease" title="screenshot of photo associated with disease"/></div> 







<div id="dotted_line4_iphone"></div>
<br/>
<div id="feedback_iphone">
<?php

$page_id = "std2";
$reference = "STD Guide, Version 2";
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
