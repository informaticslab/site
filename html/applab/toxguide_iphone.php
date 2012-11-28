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
<a href="http://code.phiresearchlab.org/viewvc/informaticslab/mobiletox/">Get source code ></a>

</div>


<div id="iphone_detail_icons"><img src="images/tox_icon.png" alt="ATSDR ToxGuide"/>
</div>



<div id="app_name_iphone">ATSDR ToxGuide</div>

<div id="stats_iphone">
<strong>Category:</strong> Reference<br/>
<strong>Released:</strong> 6/1/2012<br/>
<strong>Version:</strong> 0.6.2.001<br/>
<strong>Size:</strong> 254KB<br/>
</div><!--end of stats-->


<div id="download_detail_iphone"><a id="tox-applab-download" href="itms-services://?action=download-manifest&url=http://www.phiresearchlab.org/applab/downloads/toxguide/0.6.2.001/manifest.plist"><img src="images_iphone/download_iphone.png" alt="Download app" title="Download app" name="Image4" width="65" height="20" border="0" id="Image4" /></a></div>

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

<p>The ATSDR ToxGuides are quick reference guides providing information such as chemical and physical properties, sources of exposure, routes of exposure, minimal risk levels, children's health, and health effects. The ToxGuides also discuss how the substance might interact in the environment. The ToxGuides were developed by the ATSDR Division of Toxicology and Environmental Medicine. Information is excerpted from the corresponding toxicological profiles.</p>


<p>Currently ToxGuides are available in both the standard HTML or PDF format, and can be found at: <a href="http://www.atsdr.cdc.gov/toxguides/index.asp">http://www.atsdr.cdc.gov/toxguides/index.asp</a>. This project examined the preliminary design and layout of a prototype ToxGuide as an app for the Apple iPhone.</p> 

<br/>

<strong>Screenshots:</strong> 
<div id="screen_row_iphone"><img src="images_iphone/tox_screen1.png" alt="screenshot of substance listings" title="screenshot of substance listings"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/tox_screen2.png" alt="screenshot of substance listings" title="screenshot of substance listings"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/tox_screen3.png" alt="screenshot of chemical and physical information" title="screenshot of chemical and physical information"/></div>






<div id="dotted_line4_iphone"></div>
<br/>
<div id="feedback_iphone">

<?php

$page_id = "toxguide";
$reference = "ATSDR ToxGuide";
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
