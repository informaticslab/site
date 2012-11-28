<?php require("bsniff.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Public Health Prototypes | App Lab | Informatics R&D Lab</title>
<link rel="stylesheet" href="styles_iphone.css" type="text/css" />







</head>

<meta name="viewport" content="width=320" />
<body class="begin">

<div id="wrap">

<div id="topper">
</div><!--end of topper-->
<div id="line">
</div><!--end of line-->


<div id="header">
<a href="http://www.phiresearchlab.org"><img src="images_iphone/banner_retina_iphone.png" title="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" alt="Informatics R&D Laboratory, Public Health Prototypes App Lab, A tool for the Lab, CDC, and its community partners to test and collaborate on innovative mobile apps" border="0" width="320px" height"130px" /></a>

</div><!--end of header-->




<div id="agree_text">

<img src="images/ack_retina.png" width="195px" height="26px" title="Acknowledgement" alt="Acknowledgement" />
<br/><br/>
<span style="position:relative; top:10px;">To use the Informatics R&D Lab's app lab, you must agree with the following statements:</span> <br/>
<br/><ul style="list-style-image: url(images/arrow_bullet.png)">
<li>I acknowledge that I am a member of the <strong>CDC developer and/or testing community</strong>.</li><br/> 

<li>I understand that this app lab is meant for CDC staff, authorized agents of CDC (e.g., contractors), or CDC's community partners <strong>only</strong>.</li><br />
<li>I understand that this app lab does NOT contain production apps, but only <strong>prototype and/or proof-of-concept apps</strong> for collaboration and/or testing purposes.
</li></ul>
<span style="text-align:center;"><br/>
<p>If you agree with these statements, you may proceed by entering your passcode:</p></span>


<?php
if(isset($_GET["wrong"])){
echo("<div class=\"echo_text\">Your passcode is incorrect.<br/> Please try again.</div>");





}
#session_start();
#echo "Original:".$_SESSION['original_location'];
?>
<div id="form_controls">
<form action="login/login2_iphone_retina.php" method="post">
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
