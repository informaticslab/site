<?php
session_start();
ob_start();
?>

<?php require("login/login3_iphone_retina.php"); ?> 
<?php require("bsniff.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WISQARS Mobile |Public Health Prototypes | App Lab | Informatics R&D Lab</title>
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

</div>


<div id="iphone_detail_icons"><img src="images/ptt_icon.png" alt="PTT Advisor"/>
</div>



<div id="app_name_iphone">WISQARS Mobile</div>

<div id="stats_iphone">
<strong>Category:</strong> Medical<br/>
<strong>Released:</strong> 7/1/13<br/>
<strong>Version:</strong> 0.2.5001<br/>
<strong>Size:</strong> 17.9MB<br/>
<strong>Cost:</strong> Free

</div><!--end of stats-->


<div id="download_detail_iphone"><a id="ptt-applab-download" href="http://itunes.apple.com/us/app/ptt-advisor/id537989131?mt=8&ls=1"><img src="images_iphone/download_iphone.png" alt="Download app" title="Download app" name="Image4" width="65" height="20" border="0" id="Image4" /></a></div>

<div id="wrap_requirements">
<div id="requirements_iphone">
<strong>Cost:</strong> Free<br/>
<strong>Requirements:</strong><br/>
iPad with iOS 5.0  <br/>
or later<br/>


</div>






<div id="dotted_line3_iphone"></div>

<div id="detail_text_iphone">



<span style="font-size:11px;"><strong>Description:</strong></span>

<p>Assists clinical providers in their evaluation of patients with an abnormal clinical laboratory blood test, specifically an abnormal PTT (Partial Thromboplastin Time). The application has been created to easily navigate through the detailed laboratory testing algorithms. The algorithms may help to reduce inappropriate coagulation testing as well as possible adverse patient outcomes from, for example, a delay in diagnosis.</p>

<p>This application leverages coagulation testing algorithms, which were developed by a group of volunteer laboratory experts working together on a CDC-sponsored team as part of the Clinical Laboratory Integration into Healthcare Collaborative (CLIHC)™ project. The prototype leverages the algorithms as documented in flow charts and turns them into electronic, interactive, decision support tools for clinical provider use.</p>

<p>The algorithms are organized digitally to allow the user to easily walk through a complicated flow diagram by answering one question at a time in an interactive format. The prototype also includes the ability to obtain real-time information about the effectiveness and use of the application.</p> 

<br/>

<strong>Screenshots:</strong> 
<div id="screen_row_iphone"><img src="images_iphone/ptt_screen1.png" alt="screenshot of beginning questions" title="screenshot of beginning questions"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/ptt_screen2.png" alt="screenshot of Evaluation Review" title="screenshot of Evaluation Review"/></div> 
<div id="screen_row_iphone"><img src="images_iphone/ptt_screen3.png" alt="screenshot Recommendation screen" title="screenshot of Recommendation screen"/></div>
<div id="screen_row_iphone"><img src="images_iphone/ptt_screen4.png" alt="screenshot of Help screen" title="screenshot of Help screen"/></div>





<div id="dotted_line4_iphone"></div>
<br/>

<div id="feedback_iphone">


<?php

$page_id = "pttadvisor";
$reference = "PTT Advisor";
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
