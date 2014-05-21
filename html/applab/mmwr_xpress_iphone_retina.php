<?php
session_start();
ob_start();
?>

<?php require("login/login3_iphone_retina.php"); ?> 
<?php require("bsniff.php"); ?>
<?php require("mobile_apps.php"); ?>

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
<a href="http://www.phiresearchlab.org"><img src="images_iphone/banner_retina_iphone.png" title="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" alt="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" border="0" width="320px" height"130px" /></a>

</div><!--end of header-->

<div id="back_to_iphone"><span style="color:#0069ac;"><</span> <a href="index_iphone_retina.php">All prototypes</a>
</div><!--end of disclaimer_iphone-->



<div id="other_links_iphone"><a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="https://github.com/informaticslab/photon">Get source code ></a>

</div>


<div id="iphone_detail_icons"><img src="images_iphone/mmwr_xpress_retina_icon.png" width="69px" height="69px" alt="MMWR Express"/>
</div>



<div id="app_name_iphone">MMWR Express</div>

<div id="stats_iphone">
<strong>Category:</strong> Medical<br/>
    <strong>Released:</strong> <?php echo $photon_release_date ?><br/>
    <strong>Version:</strong> <?php echo $photon_version ?><br/>
    <strong>Size:</strong> <?php echo $photon_size ?><br/>
</div><!--end of stats-->


<div id="download_detail_iphone"><a id="mmwrexpress-applab-download" href="<?php echo $photon_itunes_link?>"><img src="images_iphone/download_iphone.png" alt="Download app" title="Download app" name="Image4" width="65" height="20" border="0" id="Image4" /></a></div>

<div id="wrap_requirements">
<div id="requirements_iphone">
<strong>Cost:</strong> Free<br/>
<strong>Requirements:</strong>
iPhone, iPod Touch, <br/>
iPad with iOS 7.0 or later
</div>

</div>






<div id="dotted_line3_iphone"></div>

<div id="detail_text_iphone">



<span style="font-size:11px;"><strong>Description:</strong></span>

<p>This mobile prototype application, MMWR Express, provides fast access to the blue summary boxes in MMWR's Weekly Report.</p>

<p>The Morbidity and Mortality Weekly Report (MMWR) series is prepared by the Centers for Disease Control and Prevention (CDC). Often called “the voice of CDC,” the MMWR series is the agency’s primary vehicle for scientific publication of timely, reliable, authoritative, accurate, objective, and useful public health information and recommendations.</p>

<p>Summaries are viewable by specific MMWR article, or by searching for a specific subject (e.g., salmonella).</p>

<p>This application is a result of a collaboration between CDC's MMWR staff and the Informatics Innovation Unit staff within the Office of Public Health Scientific Services. </p> 
<br />
<span style="font-size:11px;"><strong>Key Features</strong></span>
<ul>
    <li>Allows user to search for summaries by either specific MMWR article or by specific subject (e.g., salmonella).</li><br/>
    <li>Rapidly loads new unread articles when user swipes down on the main list of articles.</li><br/>
    <li>Automatically marks each unread article with a blue dot, which disappears once the summary blue box has been viewed.</li><br/>
    <li>Enables the sharing of articles via email, text message, Facebook, and Twitter.</li><br/>
    <li>Provides easy access to full articles on the main MWWR site, if the user wants more information.</li>
</ul>
<br/>

<strong>Screenshots:</strong> 
<div id="screen_row_iphone"><img src="images_iphone/screen1_iphone.png" alt="screenshot of refreshing article list" title="screenshot of refreshing article list"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/screen2_iphone.png" alt="screenshot of searching by subject" title="screenshot of searching by subject"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/screen3_iphone.png" alt="screenshot search results" title="screenshot search results"/></div>
<div id="screen_row_iphone"><img src="images_iphone/screen4_iphone.png" alt="screenshot of article details" title="screenshot of article details"/></div>





<div id="dotted_line4_iphone"></div>
<br/>

<div id="feedback_iphone">


<?php

$page_id = "mmwrxpress";
$reference = "MMWR Express";
$path_to_comments_folder = "comments/";
define ('IN_COMMENTICS', 'true'); //no need to edit this line
require $path_to_comments_folder . "includes/commentics.php"; //no need to edit this line

?>

</div><!--end of feedback-->


</div><!--end of second_column-->




</div><!--end of detail_text-->


<div id="footer"><span class="footer_text"><img src="images_iphone/footer_iphone_retina.png" width="302px" height="88px" border="0" alt="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" title="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" /></span></div>
<div id="bottom_line"></div>

</div><!--end of wrap-->

</body>
</html>
