<?php
session_start();
ob_start();
?>


<?php require("login/login3.php"); ?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mobile Prototype Testing Apps | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
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
<img src="images/limited_prototypes_large_icon.png" alt="Limited Prototypes" title="Limited Prototypes" />

</div><!--end of large_icon-->
</div><!--end of top_right_links-->

<div id="text_block"><br/><br/>
<div id="app_name">Mobile Prototype Testing Apps</div>
<div id="subtitle">Description</div> 
<p>These limited prototype apps demonstrate the feature functionality of specific cross-platform mobile development tools. Although we tested 4 tools, we are able to provide links to 3 tools. The iOS versions are currently available below. The Android versions will be available in the near future.<br /><br />
  <ol>
  <li> <strong>jQueryMobile</strong>: uses the jQueryMobile JavaScript library created using Adobe Dreamweaver tools, and deployed for iOS and Android using PhoneGap.<br/>
  <span style="position:relative; top:5px;"><a id="jQuery-test-applab-sourcecode" href="https://github.com/informaticslab/mobile-framework-testing-apps/tree/master/jQueryMobilePhoneGap">Get source code</a> | <a id="jQuery-test-applab-download" href="../applab/downloads/jQueryMobilePhoneGap/DwJmPg.ipa">iOS Download</a></span></li><br/><br/>
  <li> <strong>Sencha</strong>: developed using the Sencha JavaScript library created using the Sencha Architect IDE, and deployed for iOS and Android using PhoneGap.<br/>
 <span style="position:relative; top:5px;"> <a id="Sencha-test-applab-sourcecode" href="https://github.com/informaticslab/mobile-framework-testing-apps/tree/master/Sencha">Get source code</a> | <a id="Sencha-test-applab-download" href="../applab/downloads/Sencha/IrdaEval.ipa">iOS Download</a></span></li><br/><br/>
  <li> <strong>Appcelerator</strong>: developed and created using the Appcelerator Titanium SDK, and deployed for iOS using xCode and the Android SDK.<br/>
  <span style="position:relative; top:5px;"><a id="Appcelerator-test-applab-sourcecode" href="https://github.com/informaticslab/mobile-framework-testing-apps/tree/master/Appcelerator">Get source code</a> | <a id="Appcelerator-test-applab-download" href="../applab/downloads/Appcelerator/KitchenSink.ipa">iOS Download</a></span></li></ol><br/>
<br/>Please send any feedback to <a href="mailto:informaticslab@cdc.gov">InformaticsLab@cdc.gov</a>

</div><!--end of text_block-->
<!--
<div id="screenshots">
<div id="subtitle">Screenshots</div> 
<div id="screen_row"><img src="images/std2_screens_row1.png" alt="screenshots of Home screen and guideline categories" title="screenshots of Home screen and guideline categories"/></div> 
<div id="screen_row2"><img src="images/std2_screens_row2.png" alt="screenshots of Recommended Regimens and photo associated with disease" title="screenshots of Recommended Regimens and photo associated with disease"/></div> 
</div><!--end of screenshots-->


<div id="section_divider">
</div><!--end of section_divider-->

<div id="feedback">
<?php

$page_id = "limited_prototypes";
$reference = "Limited Prototypes";
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
