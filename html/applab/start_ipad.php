<?php require("bsniff.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles.css" type="text/css" />


<style type="text/css" media="all">
 <!--
#wrap {
min-width:960px;
max-width:960px;
width:auto !important; /*IE6 hack*/
width:960px; /*IE6 hack*/
margin:0 auto; /*center hack*/
text-align:left; /*center hack*/
border:1px solid #000000;
} 


#yes_no_buttons {
	margin-top:0px;}



-->
 </style>





</head>

<body class="begin">

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

<div id="agree_text">

<img src="images/ack.png" title="Acknowledgement" alt="Acknowledgement" />
<br/><br/>
<span style="position:relative; top:3px;">To use the Informatics R&D Lab's app lab, you must agree with the following statements:</span> <br/>
<br/><ul style="list-style-image: url(images/arrow_bullet.png)">
<li>I acknowledge that I am a member of the <strong>CDC developer and/or testing community</strong>.</li><br/> 

<li>I understand that this app lab is meant for CDC staff, authorized agents of CDC (e.g., contractors), or CDC's community partners <strong>only</strong>.</li><br />
<li>I understand that this app lab does NOT contain production apps, but only <strong>prototype and/or proof-of-concept apps</strong> for collaboration and/or testing purposes.
</li></ul>
<span style="text-align:center;"><br/>
<p>If you agree with these statements, you may proceed by entering your passcode:</p></span>


<?php
if(isset($_GET["wrong"])){
echo("<div class=\"echo_text\">Your passcode is incorrect. Please try again.</div>");





}
#session_start();
#echo "Original:".$_SESSION['original_location'];
?>
<div id="form_controls">
<form action="login/login2_ipad.php" method="post">
<br />
Passcode: 
<input type="password" class="passfield" name="password" size="41" /> 

<!--<input type="image" name="Login" alt="Login" value="Login" class="login_button" src="images/go_button.png">-->


<input class="login" type="submit" name="login" value="" />


</form>

</div><!--end of form_controls-->

<div id="get_code">
To request a passcode, please e-mail: <a href="mailto:informaticslab@cdc.gov">informaticslab@cdc.gov</a>
</div><!--end of get_code-->


<p></p>
<p></p>
<p></p>
<p></p>
<br/>
<br/>
<br/>
<br/>


</div><!--end of agree_text-->
<div id="site_mention"><img src="images/small_symbol.png" /> Visit us at: <a href="http://www.phiresearchlab.org">phiresearchlab.org</a>

</div>


<div id="bottom_orange">
</div>
<div id="bottom_black">
</div>
</div><!--end of wrap-->

</body>
</html>
