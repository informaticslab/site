<?php
session_start();
ob_start();
?>


<?php require("login/login3_ipad.php"); ?> 
<?php require("bsniff.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HIV Risk Assessment Tool | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" href="comments/css/stylesheet.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>


</head>

<body onload="MM_preloadImages('images/all_prototypes_hover.png','images/download_largest_hover.png')">

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
<div id="back_button"><a href="index_ipad.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('all_prototypes','','images/all_prototypes_hover.png',1)"><img src="images/all_prototypes.png" alt="All prototypes" title="All prototypes" name="all_prototypes" width="130" height="27" border="0" id="all_prototypes" /></a></div><!--end of back_button-->

<div id="first_column">
<div id="large_icon">
<img src="images/retro_large_icon.png" alt="HIV Risk Assessment Tool" title="HIV Risk Assessment Tool" />

</div><!--end of large_icon-->
<div id="download_detail_largest"><a id="retro-applab-download" href="itms-services://?action=download-manifest&url=http://www.phiresearchlab.org/applab/downloads/betas/retro/manifest.plist" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','images/download_largest_hover.png',1)"><img src="images/download_largest.png" alt="Download app" name="Image10" width="119" height="27" border="0" id="Image10" title="Download app" /></a></div><!--end of download_detail-->
<div id="stats">
<strong>Category:</strong> Medical<br/>
<strong>Released:</strong> 9/17/13<br/>
<strong>Version:</strong> 0.1.6.1<br/>
<strong>Size:</strong> 957KB<br/>
<strong>Cost:</strong> Free

</div><!--end of stats-->

<div id="small_line">

</div>

<div id="requirements">
<strong>Requirements:</strong><br/>
iPad with iOS 6.1 <br/>or later<br/>

</div>


</div><!--end of first_column-->



<div id="second_column">
<div id="top_right_links">
<a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href=" https://github.com/informaticslab/retro">Get source code ></a>
</div><!--end of top_right_links-->

<div id="text_block">
<div id="app_name">ARCH-Couples</div>
<div id="subtitle">Description</div> 
<p>This mobile app focuses on the area of HIV Risk Assessment &#8212; or specifically, Assessing your Risk of Contracting HIV (ARCH). This tool, ARCH-Couples, is the first in the ARCH suite to be delivered on a mobile platform.  </p> 
<p>Among HIV-discordant couples, where one partner is infected with HIV while the other is not, long-term HIV transmission risk to the negative partner can be high. Those at risk for HIV may have difficulty personalizing and quantifying their HIV risk.</p> 
<p>Also, HIV risk reduction strategies now include antiretroviral therapy for prevention, pre-exposure prophylaxis, and male circumcision; and those in HIV-discordant relationships may wonder if and how to best use these new HIV risk reduction strategies individually or along with condom use and other existing measures in order to get their HIV risk down to a level that is acceptable to them. </p>
<p>The ARCH-Couples iPad app assists persons in HIV-discordant relationships with their choice of HIV risk reduction strategies by generating a number that represents their personalized risk of contracting HIV over time given their choices related to condom usage, type of sex act, and various preventative measures. </p>




</div><!--end of text_block-->

<div id="screenshots">
<div id="subtitle">Screenshots</div> 
<div id="screen_row"><img src="images/retro_screen1.png" alt="screenshot of HIV Risk Assessment Tool, quesion about sexual activity" title="screenshot of HIV Risk Assessment Tool, quesion about sexual activity"/></div> 
<div id="screen_row2"><img src="images/retro_screen2.png" alt="screenshot of HIV Risk Assessment Tool" title="screenshot of HIV Risk Assessment Tool"/></div>
 
</div><!--end of screenshots-->


<div id="section_divider">
</div><!--end of section_divider-->

<div id="feedback">


<?php

$page_id = "retro";
$reference = "RETRO";
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
