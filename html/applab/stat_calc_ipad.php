<?php
session_start();
ob_start();
?>


<?php require("login/login3_ipad.php"); ?> 
<?php require("bsniff.php"); ?>
<?php require("mobile_apps.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>StatCalc by Epi Info | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
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
<img src="images/epi_large_icon.png" alt="Epi Info" title="Epi Info" />

</div><!--end of large_icon-->
<div id="download_detail_largest"><a id="epi-applab-download" href="<?php echo $epi_info_manifest_link?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','images/download_largest_hover.png',1)"><img src="images/download_largest.png" alt="Download app" name="Image10" width="119" height="27" border="0" id="Image10" title="Download app" /></a></div><!--end of download_detail-->
<div id="stats">
<strong>Category:</strong> Epidemiology<br/>

    <strong>Released:</strong> <?php echo $epi_info_release_date ?><br/>
    <strong>Version:</strong> <?php echo $epi_info_version ?><br/>
    <strong>Size:</strong> <?php echo $epi_info_size ?><br/>

<strong>Cost:</strong> Free
<br/><br/>
</div><!--end of stats-->

<div id="small_line">

</div>

<div id="requirements">
<br/>
<br/> <br/>

</div>


</div><!--end of first_column-->



<div id="second_column">
<div id="top_right_links">
<a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="http://epiinfoios.codeplex.com">Get source code ></a>
</div><!--end of top_right_links-->

<div id="text_block">
<div id="app_name">Epi Info</div>
<div id="subtitle">Description</div>


    <p>The Epi Info app has two main features: Data Entry and StatCalc.</p>

    <div id="subtitle2">Data Entry</div>

    <p>Allows the user to collect data on the mobile device using a form created with Epi Info 7 on a desktop PC.  Features include:</p>

    <ul><li>Importing a collection form via the device’s native email app</li>
        <li>Opening saved forms</li>
        <li>Entering new records to be stored on the device</li>
        <li>Recalling and updating or deleting existing records</li>
        <li>Packaging and encrypting local datasets for import to PC Epi Info 7 projects</li>
    </ul>


    <div id="subtitle2">StatCalc</div>



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



</div><!--end of text_block-->

<div id="screenshots">
<div id="subtitle">Screenshots</div>
    <div id="screen_row"><img src="images/epi-ipad-large-5.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
    <div id="screen_row"><img src="images/epi-ipad-large-6.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
    <div id="screen_row"><img src="images/epi-ipad-large-7.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
    <div id="screen_row"><img src="images/epi-iphone-large-5.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
    <div id="screen_row"><img src="images/epi-iphone-large-6.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
    <div id="screen_row"><img src="images/epi-iphone-large-7.png" alt="screenshot of Epi Info statistical calculators" title="screenshot of Epi Info statistical calculators"/></div>
</div><!--end of screenshots-->


<div id="section_divider">
</div><!--end of section_divider-->

<div id="feedback">


<?php

$page_id = "epi";
$reference = "EPI INFO";
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
