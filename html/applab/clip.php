<?php
session_start();
ob_start();
?>


<?php require("login/login3.php"); ?>
<?php require("bsniff.php"); ?>

 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NHSN Clip | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" href="comments/css/stylesheet.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>




</head>

<body onload="MM_preloadImages('images/all_prototypes_hover.png','images/view_itunes_smaller_hover.png')">

<div id="wrap">
<div id="topper">
</div><!--end of topper-->
<div id="line">
</div><!--end of line-->


<div id="header">
<span class="branding"><a href="http://www.phiresearchlab.org"><img src="images/branding.png" title="Informatics R&D Laboratory" alt="Informatics R&D Laboratory" border="0" width="248px" height"60px" /></a></span>
<span class="prototypes"><img src="images/prototypes.png" title="Public Health Prototypes | App Lab" alt="Public Health Prototypes | App Lab" border="0" width="294px" height"60px" /></span>
<span class="flourish"><img src="images/flourish.png" alt="Decorative illustration of email and internet-related icons" border="0" width="206px" height"77px" /></span>

</div><!--end of header-->


<div id="tagline">
<span class="tagtext">
<img src="images/tagline.png" title="A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" alt="A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" border="0" width="621px" height"17px" />
</span>
</div><!--end of tagline-->
<div id="back_button"><a href="start.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('all_prototypes','','images/all_prototypes_hover.png',1)"><img src="images/all_prototypes.png" alt="All prototypes" title="All prototypes" name="all_prototypes" width="130" height="27" border="0" id="all_prototypes" /></a></div><!--end of back_button-->

<div id="first_column">
<div id="large_icon">
<img src="images/clip_large_icon.png" alt="NHSN Clip" title="NHSN Clip" />

</div><!--end of large_icon-->
<div id="download_detail"><a id="clip-applab-download" href="../applab/downloads/clip/0.5.12.001/clipam.ipa" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','images/view_itunes_smaller_hover.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image10" width="91" height="20" border="0" id="Image10" /></a></div><!--end of download_detail-->
<div id="stats">
<strong>Category:</strong> Medical<br/>
<strong>Released:</strong> 6/1/12<br/>
<strong>Version:</strong> 0.5.12.001<br/>
<strong>Size:</strong> 1.9M<br/>
<strong>Cost:</strong> Free

</div><!--end of stats-->

<div id="small_line">

</div>

<div id="requirements">
<strong>Requirements:</strong><br/>
iPad with iOS 5.0 <br/>or later<br/>

</div>


</div><!--end of first_column-->



<div id="second_column">
<div id="top_right_links">
<a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="https://github.com/informaticslab/clip">Get source code ></a>
</div><!--end of top_right_links-->

<div id="text_block">
<div id="app_name">NHSN Clip</div>
<div id="subtitle">Description</div> 
<p>Created in collaboration with National Healthcare 
Safety Network (NHSN), this app brings the Central 
Line Insertion Practices Adherence Monitoring form to 
the iPad. This app allows for easy collection and submission of data.</p> 


</div><!--end of text_block-->

<div id="screenshots">
<div id="subtitle">Screenshots</div> 
<div id="screen_row"><img src="images/clip_screens_row1.png" alt="screenshot of form, page 1" title="screenshot of form, page 1"/></div> 
<div id="screen_row2"><img src="images/clip_screens_row2.png" alt="screenshots of form, page 2" title="screenshots of form, page 2"/></div> 
</div><!--end of screenshots-->


<div id="section_divider">
</div><!--end of section_divider-->

<div id="feedback">


<?php

$page_id = "clip";
$reference = "NHSN CLIP";
$path_to_comments_folder = "comments/";
define ('IN_COMMENTICS', 'true'); //no need to edit this line
require $path_to_comments_folder . "includes/commentics.php"; //no need to edit this line

?>





</div><!--end of feedback-->

</div><!--end of second_column-->










<div id="footer"><span class="footer_text"><img src="images/footer.png" border="0" alt="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" title="Informatics R&D Lab | An initiative for the public health community, supported by: Public Health Surveillance and Informatics Program Office (proposed) -- Office of Surveillance, Epidemiology, and Laboratory Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" /></span></div>
<div id="bottom_line"></div>


</div><!--end of wrap-->

</body>
</html>
