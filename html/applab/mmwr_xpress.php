<?php
session_start();
ob_start();
?>

<?php require("login/login3.php"); ?> 
<?php require("bsniff.php"); ?>
<?php require("mobile_apps.php"); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MMWR Express | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="comments/css/stylesheet.css"/>
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
<img src="images/large_mmwr_x_icon.png" alt="MMWR Express" title="MMWR Express" />

</div><!--end of large_icon-->
<div id="download_detail"><a id="mmwrexpress-applab-download" href="<?php echo $photon_itunes_link?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','images/view_itunes_smaller_hover.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image10" width="91" height="20" border="0" id="Image10" /></a></div><!--end of download_detail-->
<div id="stats">

<strong>Category:</strong> Medical<br/>
    <strong>Released:</strong> <?php echo $photon_release_date ?><br/>
    <strong>Version:</strong> <?php echo $photon_version ?><br/>
    <strong>Size:</strong> <?php echo $photon_size ?><br/>
<strong>Cost:</strong> Free

</div><!--end of stats-->

<div id="small_line">

</div>

<div id="requirements">
<strong>Requirements:</strong><br/>
iPhone, iPod Touch, <br/>
iPad with iOS 7.0  <br/>
or later<br/>


</div>


</div><!--end of first_column-->



<div id="second_column">
<div id="top_right_links">
<a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
<a href="https://github.com/informaticslab/photon">Get source code ></a>
</div><!--end of top_right_links-->

<div id="text_block">
<div id="app_name">MMWR Express</div>
<div id="subtitle">Description</div> 
<p>This mobile prototype application, MMWR Express, provides fast access to the blue summary boxes in MMWR's Weekly Report.</p>

<p>The Morbidity and Mortality Weekly Report (MMWR) series is prepared by the Centers for Disease Control and Prevention (CDC). Often called “the voice of CDC,” the MMWR series is the agency’s primary vehicle for scientific publication of timely, reliable, authoritative, accurate, objective, and useful public health information and recommendations.</p>

<p>Summaries are viewable by specific MMWR article, or by searching for a specific subject (e.g., salmonella).</p>

<p>This application is a result of a collaboration between CDC's MMWR staff and the Informatics Innovation Unit staff within the Office of Public Health Scientific Services. </p> 
<br />
<div id="subtitle">Key Features</div>
<ul>
    <li>Allows user to search for summaries by either specific MMWR article or by specific subject (e.g., salmonella).</li><br/>
    <li>Rapidly loads new unread articles when user swipes down on the main list of articles.</li><br/>
    <li>Automatically marks each unread article with a blue dot, which disappears once the summary blue box has been viewed.</li><br/>
    <li>Enables the sharing of articles via email, text message, Facebook, and Twitter.</li><br/>
    <li>Provides easy access to full articles on the main MWWR site, if the user wants more information.</li>
</ul>

</div><!--end of text_block-->

<div id="screenshots">
<div id="subtitle">Screenshots</div> 
<div id="screen_row"><img src="images/mmwr_x_screens_row1.png" alt="screenshots of article list refreshing and search terms" title="screenshots of article list refreshing and search terms"/></div> 
<div id="screen_row2"><img src="images/mmwr_x_screens_row2.png" alt="screenshots of search results and article details" title="screenshots of search results and article details"/></div> 
</div><!--end of screenshots-->


<div id="section_divider">
</div><!--end of section_divider-->

<div id="feedback">


<?php

$page_id = "mmwrxpress";
$reference = "MMWR Express";
$path_to_comments_folder = "comments/";
define ('IN_COMMENTICS', 'true'); //no need to edit this line
require $path_to_comments_folder . "includes/commentics.php"; //no need to edit this line

?>

</div><!--end of feedback-->

</div><!--end of second_column-->



<div id="footer"><span class="footer_text"><img src="images/footer.png" border="0" alt="Informatics R&D Lab | An initiative for the public health community, supported by: Center for Surveillance, Epidemiology, and Laboratory Services -- Office of Public Health Scientific Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" title="Informatics R&D Lab | An initiative for the public health community, supported by: Center for Surveillance, Epidemiology, and Laboratory Services -- Office of Public Health Scientific Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" /></span></div>
<div id="bottom_line"></div>


</div><!--end of wrap-->

</body>
</html>
