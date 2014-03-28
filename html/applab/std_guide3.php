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
    <title>STD Guide, Version 3 | Public Health Prototypes | App Lab | Informatics R&D Lab</title>
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
            <img src="images/std3_large_icon.png" alt="STD Guide, Version 3" title="STD Guide, Version 3" />

        </div><!--end of large_icon-->
        <div id="download_detail"><a id="std3-applab-download" href="<?php echo $std3_itunes_link ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image10','','images/view_itunes_smaller_hover.png',1)"><img src="images/view_itunes_smaller.png" alt="View in iTunes" title="View in iTunes" name="Image10" width="91" height="20" border="0" id="Image10" /></a><br/><span class="android_inner"><a id="std3-android-applab-download" href="https://play.google.com/store/apps/details?id=gov.cdc.oid.nchhstp.stdguide">View in Google Play</a></span></div><!--end of download_detail-->
        <div id="stats_android">
            <strong>Category:</strong> Reference<br/>
            <strong>Released:</strong> <?php echo $std3_release_date ?><br/>
            <strong>Version:</strong> <?php echo $std3_version ?><br/>
            <strong>Size:</strong> <?php echo $std3_size ?><br/>
            <strong>Cost:</strong> Free

        </div><!--end of stats-->

        <div id="small_line">

        </div>

        <div id="requirements">
            <strong>Requirements:</strong><br/>
            iPhone, iPod Touch, <br/>
            iPad with iOS 4.3  <br/>
            or later<br/>

        </div>


    </div><!--end of first_column-->



    <div id="second_column">
        <div id="top_right_links">
            <a href="mailto:informaticslab@cdc.gov">Contact us ></a><br/>
            <a href="https://github.com/informaticslab/shirly">Get source code ></a>
        </div><!--end of top_right_links-->

        <div id="text_block">
            <div id="app_name">STD Guide, Version 3</div>
            <div id="subtitle">Description</div>
            <p>The goal of this unique prototype has been to collaborate with CDC's STD team to design mobile apps for the iOS and Android operating systems (OS) based on the 2010 STD Treatment Guidelines. The applications serve as a reference for doctors and related parties on the identification of and treatment regimen for STDs.

            <p>These guidelines for the treatment of persons who have or are at risk for sexually transmitted diseases (STDs) were updated by CDC after consultation with a group of professionals knowledgeable in the field of STDs who met in Atlanta on April 18â€“30, 2009. The information in this report updates the 2006 Guidelines for Treatment of Sexually Transmitted Diseases (MMWR 2006;55[No. RRâ€“11]).</p>

            <p>The current features that are functional in this version of the prototype include:</p>
            <ul>
                <li><strong>Condition Quick Pick:</strong> allows doctors and clinicians to quickly look up conditions and their treatments. Easy access to condition descriptions is also provided. </li><br/>
                <li><strong>Full STD Guidelines:</strong> the full STD guidelines presented in an easily navigable format. The user may drill down to any section of the 2010 STD Treatment Guidelines. </li><br/>
                <li><strong>PDF of STD Guidelines:</strong> the user may access the PDF document via his/her mobile Safari browser. </li>
            </ul>
            <p>Please send any feedback to <a href="mailto:informaticslab@cdc.gov">InformaticsLab@cdc.gov</a></p>

        </div><!--end of text_block-->

        <div id="screenshots">
            <div id="subtitle">Screenshots</div>
            <div id="screen_row"><img src="images/std3_row1.png" alt="screenshots of Main Menu and Condition Quick Pick" title="screenshots of Main Menu and Condition Quick Pick"/></div>
            <div id="screen_row2"><img src="images/std3_row2.png" alt="screenshots of condition treatments and more info about condition" title="screenshots of condition treatments and more info about condition"/></div>
        </div><!--end of screenshots-->



        <div id="section_divider">
        </div><!--end of section_divider-->

        <div id="feedback">
            <?php

            $page_id = "std3";
            $reference = "STD Guide, Version 3";
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
