<?php require("login/login3.php"); ?> 
<?php require("bsniff.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php 
/*
if(strstr($_SER['HTTP_USER_AGENT'],'iPad'))
{
	header('Location: index_ipad.html');
	exit();
}
?>

<?php 
if(strstr($_SER['HTTP_USER_AGENT'],'iPhone'))
{
	header('Location: index_iphone.html');
	exit();
}
*/
?>


<title>Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script type="text/javascript" src="common.js"></script>

</head>

<body onload="MM_preloadImages('images/view_itunes_both_ho.png','images/view_itunes_ho.png','images/view_itunes_smaller_ho.png','images/view_apps_ho.png')">

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
<div id="disclaimer">
<span class="disclaimer_link">
<a href="disclaimer.php">Disclaimer</a>
</span>
</div><!--end of disclaimer-->
<div id="iphone_apps">
<span class="iphone_icon">
<img src="images/iphone_header.png" alt="iPhone Prototypes" title="iPhone Prototypes" /></span>
</div><!--end of iphone apps header-->

<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="ptt.php"><img src="images/ptt_icon.png" title="PTT Advisor" alt="PTT Advisor" border="0" /></a></span>
<div id="app_title"><a href="ptt.php">PTT Advisor</a></div><br/>
<div id="text">Assists clinical providers in their evaluation of patients with an abnormal clinical laboratory blood test, specifically an abnormal PTT (Partial Thromboplastin Time). 
</div>

<div id="download"><a id="ptt-applab-download" href="http://itunes.apple.com/us/app/ptt-advisor/id537989131?mt=8&ls=1" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image32','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image32" width="91" height="20" border="0" id="Image32" /></a></div>
<div id="early"><img src="images/graduation_cap.png" alt="Graduation cap icon" title="Graduation cap icon" /> <span class="early_text">Graduated to the Apple App Store: 7/6/12</span></div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->

<div class="block_border_right">
<div class="NIOSH_facepiece">

<span class="icons"><a href="facepiece.php"><img src="images/niosh_face_icon.png" title="NIOSH Facepiece Respirator Guide" alt="NIOSH Facepiece Respirator Guide" border="0" /></a></span>
<div id="app_title"><a href="facepiece.php">NIOSH Facepiece Respirator Guide</a></div><br/>
<div id="text">Built in collaboration with The National Institute for 
Occupational Safety and Health (NIOSH). For quickly exploring the database of NIOSH-approved 
particulate filtering facepiece respirators.
</div>

<div id="download"><a id="niosh-face-applab-download" href="../applab/downloads/respguide/1.2.8.001/Respirator%20Guide.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image33','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image33" width="91" height="20" border="0" id="Image33" title="View in iTunes" /></a></div>
<div id="released">Released: 6/4/12</div>

</div><!--end of NIOSH_facepiece-->
</div>

</div><!--end of first_row-->


<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="toxguide.php"><img src="images/tox_icon.png" title="ATSDR ToxGuide" alt="ATSDR ToxGuide" border="0" /></a></span>
<div id="app_title"><a href="toxguide.php">ATSDR ToxGuide</a></div><br/>
<div id="text">Quick reference guide provides information such as 
chemical and physical properties, sources of exposure, 
minimal risk levels, children's health, and health 
effects.
</div>

<div id="download"><a id="tox-applab-download" href="../applab/downloads/toxguide/0.6.2.001/mToxGuide.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image34','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image34" width="91" height="20" border="0" id="Image34" title="View in iTunes" /></a></div>
<div id="released">Released: 6/4/12</div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->

<div class="block_border_right">
<div class="NIOSH_facepiece">

<span class="icons"><a href="std_guide1.php"><img src="images/std1_icon.png" title="STD Guide, Version 1" alt="STD Guide, Version 1" border="0" /></a></span>
<div id="app_title"><a href="std_guide1.php">STD Guide, Version 1</a></div><br/>
<div id="text">Early mobile application prototype for CDC's 2010 STD Treatment Guidelines. 
A Reference for clinicians on the identification of and treatment regimen for STDs. 

</div>

<div id="download"><a id="std1-applab-download" href="../applab/downloads/stdguide/0.4.4.001/Std-Guide.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image36','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image36" width="91" height="20" border="0" id="Image36" title="View in iTunes" /></a></div>
<div id="early"><img src="images/early.png" alt="Early-stage prototype icon" title="Early-stage prototype icon" /> <span class="early_text">Early-stage prototype</span></div>

</div><!--end of NIOSH_facepiece-->




</div><!--end of block_border_right-->

</div><!--end of first(2)_row-->


<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="std_guide2.php"><img src="images/std2_icon.png" title="STD Guide, Version 2" alt="STD Guide, Version 2" border="0" /></a></span>
<div id="app_title"><a href="std_guide2.php">STD Guide, Version 2</a></div><br/>
<div id="text">Enhanced prototype for CDC's 2010 STD Treatment Guidelines. 
A Reference for clinicians on the identification of and treatment regimen for STDs. Version 2 has a more "portal" feel than v1.

</div>

<div id="download"><a id="std2-applab-download" href="../applab/downloads/std2/0.9.3.001/STD%20Guide%202.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image35','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image35" width="91" height="20" border="0" id="Image35" title="View in iTunes" /></a></div>
<div id="early"><img src="images/early.png" alt="Early-stage prototype icon" title="Early-stage prototype icon" /> <span class="early_text">Early-stage prototype</span></div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->
<!--start limited prototypes-->



<div class="block_border_right">
<div class="PTT_advisor">
<span class="icons"><a href="limited_prototypes.php"><img src="images/limited_prototype_icon.png" title="Limited Prototypes" alt="Limited Prototypes" border="0" /></a></span>
<div id="app_title"><a href="limited_prototypes.php">Mobile Prototype Testing Apps</a></div><br/>
<div id="text">These limited prototype apps demonstrate the feature functionality of specific cross-platform mobile development tools. Although we tested 4 tools, we are able to provide links to 3 tools.

</div>

<div id="download"><a href="limited_prototypes.php" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image37','','images/view_apps_ho.png',1)"><img src="images/view_apps.png" alt="View apps" name="Image37" width="91" height="20" border="0" id="Image37" /></a></div>
<div id="early"><img src="images/wrench_icon.png" alt="Tool-testing prototype icon" title="Tool-testing prototype icon" /> <span class="early_text">Tool-testing prototypes</span></div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_right-->
<!--end limited prototypes-->
</div><!--end of first(3)_row-->

<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="std_guide3.php"><img src="images/std3_icon.png" title="STD Guide, Version 3" alt="STD Guide, Version 3" border="0" /></a></span>
<div id="app_title"><a href="std_guide3.php">STD Guide, Version 3</a></div><br/>
<div id="text">The goal of this unique prototype has been to collaborate with CDC's STD team to design mobile apps for the iOS and Android operating systems based on the 2010 STD Treatment Guidelines.

</div>

<div id="download"><a id="std3-applab-download" href="https://itunes.apple.com/us/app/std-tx-guide/id655206856?mt=8" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image32','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image32" width="91" height="20" border="0" id="Image32" /></a></div>
<div id="early"><img src="images/graduation_cap.png" alt="Graduation cap icon" title="Graduation cap icon" /> <span class="early_text">Graduated to Apple App Store and Google Play</span></div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->

<!-- <div id="note"><img src="images/note.png" title="the plus symbol indicates an app is designed for both iPhone and iPad" alt="the plus symbol indicates an app is designed for both iPhone and iPad"/></div> -->

<div class="block_border_right">
<div class="PTT_advisor">
<span class="icons"><a href="stat_calc.php"><img src="images/epi_icon.png" title="Epi Info iPhone app" alt="Epi Info iPhone app" border="0" /></a></span>
<div id="app_title"><a href="stat_calc.php">StatCalc by Epi Info<sup style="font-size:9px;">TM</sup></a></div><br/>
<div id="text">Created by CDC's Epi Info<sup style="font-size:7px;">TM</sup> team, this app adapts the StatCalc statistical calculators, a feature of Epi Info desktop software, for the iPad and iPhone. <br/><br/>

</div>

<div id="download"><a id="epi-applab-download" href="../applab/downloads/epi/0.9/EpiInfo.ipa" onmouseout="MM_swapImgRestore()" onmouseo=
"MM_swapImage('Image35','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image35" width="91" height="20" border="0" id="Image35" title="View in iTunes" /></a></div>
<div id="early"><img src="images/hosted_by.png" alt="Hosted by Informatics R&D Lab" title="Hosted by Informatics R&D Lab" /> </div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_right-->
</div><!--end of row-->

<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a id="mmwrexpress-applab-download" href="../applab/downloads/photon/0.6.4.4/photon.ipa"><img src="images/mmwr_express_icon.png" title="MMWR Express" alt="MMWR Express" border="0" /></a></span>
<div id="app_title"><a id="mmwrexpress-applab-download" href="../applab/downloads/photon/0.6.4.4/photon.ipa">MMWR Express</a></div><br/>
<div id="text">Provides fast access to the blue summary boxes in MMWR's weekly report. Summaries are searchable by specific article, or by specific subject (e.g., salmonella). For iOS devices.

</div>

<div id="download"><a id="mmwrexpress-applab-download" href="../applab/downloads/photon/0.6.4.4/photon.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image32','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image32" width="91" height="20" border="0" id="Image32" /></a></div>

<div id="early"><img src="images/early.png" alt="Early-stage prototype icon" title="Early-stage prototype icon" /> <span class="early_text">Early-stage prototype</span></div>



</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->


<div class="block_border_right">
<div class="PTT_advisor">
<span class="icons"><a id="familyhx-applab-download" href="../applab/downloads/pedigree/0.4.3.1/#.ipa"><img src="images/family_hx_icon.png" title="Family History iPhone app" alt="Family History iPhone app" border="0" /></a></span>
<div id="app_title"><a id="familyhx-applab-download" href="../applab/downloads/pedigree/0.4.3.1/#.ipa">Family Heath History</a></div><br/>
<div id="text">Allows users to record their family health history in one easy-to-reference, centralized place. This app makes it easy to share one's family health history with a clinician. For iPhone. <br/>

</div>

<div id="download"><a id="familyhx-applab-download" href="../applab/downloads/pedigree/0.4.3.1/#.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image32','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image32" width="91" height="20" border="0" id="Image32" /></a></div>

<div id="early"><img src="images/early.png" alt="Early-stage prototype icon" title="Early-stage prototype icon" /> <span class="early_text">Early-stage prototype</span></div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_right-->






</div><!--end of row-->




<!--<div id="note"><img src="images/note.png" title="the plus symbol indicates an app is designed for both iPhone and iPad" alt="the plus symbol indicates an app is designed for both iPhone and iPad"/></div>-->

<div id="dotted_line"></div>

<div id="ipad_apps">
<span class="ipad_icon">
<img src="images/ipad_header.png" alt="iPad Prototypes" title="iPad Prototypes" /></span>
</div><!--end of ipad apps header-->

<div id="first_row">


<div class="block_border_left">
<div class="PTT_advisor">

<span class="icons"><a href="clip.php"><img src="images/clip_icon.png" title="NHSN CLIP" alt="NHSN CLIP" border="0" /></a></span>
<div id="app_title"><a href="clip.php">NHSN CLIP</a></div><br/>
<div id="text">Created in collaboration with National Healthcare 
Safety Network (NHSN), this app brings the Central 
Line Insertion Practices Adherence Monitoring form to 
the iPad. 
</div>

<div id="download"><a id="clip-applab-download" href="../applab/downloads/clip/0.5.12.001/clipam.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image28','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image28" width="91" height="20" border="0" id="Image28" /></a></div>
<div id="released">Released: 6/4/12</div>

</div><!--end of NIOSH_facepiece-->
</div>



<div class="block_border_right">
<div class="NIOSH_facepiece">
<span class="icons"><a href="mine_safety.php"><img src="images/mine_safety_icon.png" title="NIOSH Mine Safety Training" alt="NIOSH Mine Safety Training" border="0" /></a></span>
<div id="app_title"><a href="mine_safety.php">NIOSH Mine Safety Training</a></div><br/>
<div id="text">Designed in collaboration with NIOSH (CDC's National 
Institute for Occupational Safety and Health), this 
proof-of-concept prototype trains mine workers on 
safety issues.

</div>

<div id="download"><a id="niosh-mine-applab-download" href="../applab/downloads/minesim/0.7301.276/mine_sim.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image29','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image29" width="91" height="20" border="0" id="Image29" /></a></div>
<div id="early"><img src="images/early.png" alt="Early-stage prototype icon" /> <span class="early_text">Early-stage prototype</span></div>


</div><!--end of NIOSH facepiece-->
</div><!--end of block_border_right-->
</div><!--end of first_row-->


<div id="first_row">

<div class="block_border_left">
<div class="PTT_advisor">

<span class="icons"><a href="mmwr_nav.php"><img src="images/mmwr_nav_icon.png" title="MMWR Navigator" alt="MMWR Navigator" border="0" /></a></span>
<div id="app_title"><a href="mmwr_nav.php">MMWR Navigator</a></div><br/>
<div id="text">Utilizes the iPad's split screen interface to display 
MMWR content in a user-friendly way. Articles are 
organized into intuitive categories, making them easy 
to find. 

</div>

<div id="download"><a id="mmwr-nav-applab-download" href="../applab/downloads/mmwr-navigator/0.8.9.001/mmwr-navigator.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image30','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image30" width="91" height="20" border="0" id="Image30" /></a></div>
<div id="released">Released: 6/4/12</div>

</div><!--end of PTT_advisor-->
</div>





<div class="block_border_right">
<div class="NIOSH_facepiece">
<span class="icons"><a href="mmwr_map.php"><img src="images/mmwr_map_icon.png" title="MMWR Map Navigator" alt="MMWR Map Navigator" border="0" /></a></span>
<div id="app_title"><a href="mmwr_map.php">MMWR Map Navigator</a></div><br/>
<div id="text">The MMWR brought to the iPad via a map-based navigation interface. The geographic areas relating to MMWR articles are indicated. There are a variety of filtering options.

</div>

<div id="download"><a id="mmwr-map-applab-download" href="../applab/downloads/mapapp/1.3.2.001/MapApp.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image31','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image31" width="91" height="20" border="0" id="Image31" /></a></div>
<div id="released">Released: 6/4/12</div>

</div><!--end of NIOSH facepiece-->
</div><!--end of block_border_right-->



</div><!--end of row-->
<!-- <div id="note"><img src="images/note.png" title="the plus symbol indicates an app is designed for both iPhone and iPad" alt="the plus symbol indicates an app is designed for both iPhone and iPad"/></div> -->

<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="stat_calc.php"><img src="images/epi_icon.png" title="Epi Info iPad app" alt="Epi Info iPad app" border="0" /></a></span>
<div id="app_title"><a href="stat_calc.php">StatCalc by Epi Info<sup style="font-size:9px;">TM</sup></a></div><br/>
<div id="text">Created by CDC's Epi Info<sup style="font-size:7px;">TM</sup> team, this app adapts the StatCalc statistical calculators, a feature of Epi Info desktop software, for the iPad and iPhone.<br/><br/>

</div>

<div id="download"><a id="epi-applab-download" href="../applab/downloads/epi/0.9/EpiInfo.ipa" onmouseout="MM_swapImgRestore()" onmouseo=
"MM_swapImage('Image35','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image35" width="91" height="20" border="0" id="Image35" title="View in iTunes" /></a></div>
<div id="early"><img src="images/hosted_by.png" alt="Hosted by Informatics R&D Lab" title="Hosted by Informatics R&D Lab" /> </div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->



<div class="block_border_right">
<div class="NIOSH_facepiece">
<span class="icons"><a href="wisqars.php"><img src="images/WISQARSMobileApp72.png" title="WISQARS Mobile" alt="WISQARS Mobile" border="0" /></a></span>
<div id="app_title"><a href="wisqars.php">WISQARS Mobile</a></div><br/>
<div id="text">Allows for sharing injury-related information on a tablet. It dynamically displays selected leading causes of injury death data using maps and charts of national and state-level death counts and rates.

</div>

<div id="download"><a id="wisqars-applab-download" href="../applab/downloads/wisqars/WisqarsMobile.ipa" onmouseout="MM_swapImgRestore()" onmouseo="MM_swapImage('Image31','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image31" width="91" height="20" border="0" id="Image31" /></a></div>
<div id="released">Released: 9/13/13</div>

</div><!--end of NIOSH facepiece-->
</div><!--end of block_border_right-->


</div><!--end of row-->

<div id="first_row">
<div class="block_border_left">
<div class="PTT_advisor">
<span class="icons"><a href="retro.php"><img src="images/retro_icon.png" title="HIV Risk Assessment" alt="HIV Risk Assessment Tool" border="0" /></a></span>
<div id="app_title"><a href="retro.php">ARCH-Couples</a></div><br/>
<div id="text">Focuses on HIV Risk Assessment &#8212; specifically, Assessing your Risk of Contracting HIV (ARCH). This tool is the first in the ARCH suite to be delied on a mobile platform.<br/>

</div>

<div id="download"><a id="retro-applab-download" href="../applab/downloads/betas/retro/retro.ipa" onmouseout="MM_swapImgRestore()" onmouseo=
"MM_swapImage('Image35','','images/view_itunes_smaller_ho.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" name="Image35" width="91" height="20" border="0" id="Image35" title="View in iTunes" /></a></div>
<div id="released">Released: 9/17/13</div>

</div><!--end of PTT advisor-->
</div><!--end of block_border_left-->




</div><!--end of row-->

<div id="footer"><span class="footer_text"><img src="images/footer.png" border="0" alt="Informatics R&D Lab | An initiative for the public health community, supported by: Center for Surveillance, Epidemiology, and Laboratory Services -- Office of Public Health Scientific Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" title="Informatics R&D Lab | An initiative for the public health community, supported by: Center for Surveillance, Epidemiology, and Laboratory Services -- Office of Public Health Scientific Services -- Centers for Disease Control and Prevention -- Department of Health and Human Services" /></span></div>
<div id="bottom_line"></div>


</div><!--end of wrap-->

</body>
</html>
