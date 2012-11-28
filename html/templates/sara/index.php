<?php
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<php echo $this->language; ?>" >

<head>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23539639-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


  <!-- Mimic Internet Explorer 7 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" >
 



<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />

<link rel="stylesheet" href="templates/system/css/general.css" type="text/css" />

<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

<!--[if lte IE 6]>
<link href="templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->



</head>


<body>

<div id="wrap">

<div id="topper">
<div class="inside">
<br />
</div>
</div><!--end of topper-->

<div id="topline">

</div><!--end of topper-->


<div id="header">
<div class="logo">
<a href="index.php"><img src="images/branding.png" title="Informatics R&D Laboratory, A resource for CDC and its public health partners" alt="Informatics R&D Laboratory, A resource for CDC and its public health partners" border="0" width="488px" height"124px" /></a>
</div>

<div class="search">
<div class="insideArea">
<div class="insidesearch">
<jdoc:include type="modules" name="SearchTop" style="none"  />


</div>
</div>
</div>
</div><!--end of header-->


<!--<form action="#">
  <input type="text" id="text" size="36" />
  &nbsp;
<input type="image" src="templates/sara/images/Search-off.png" alt="Search" title="Search" align="absmiddle" />
</form>-->

<!--<div id="search_stuff">
</div>end of search-->






<br />
<div id="sidebar">

<div class="inside">
<div class="skip"><a href="#whip" class="skip" title="Skip repetitive main navigation (for accessibility concerns)" />Skip main navigation</a></div>
<jdoc:include type="modules" name="left" style="xhtml" />
<br />
<br />
</div>
</div><!--end of sidebar-->




<div id="content">
<div class="inside2"><a name="whip"></a>
<div id="breadcrumbs">
	

	    <jdoc:include type="modules" name="breadcrumbs" />
	   
</div>



<jdoc:include type="component" />
<div id="cloud">
<jdoc:include type="modules" name="mod_joeswordcloud" style="none" />
</div>

<div id="email_form">
<jdoc:include type="modules" name="mod_rapid_contact" style="none" />
</div>


</div>
</div><!--end of mainbody content-->

<div id="abovefooter">
</div>


<div id="footer">
<div class="inside3">
<jdoc:include type="modules" name="bottom" style="xhtml" />



<div class="side_links">
<a href="index.php?option=com_content&view=article&id=26&Itemid=15" class="smaller">Disclaimer</a>&nbsp; |&nbsp; <a href="index.php?option=com_content&view=article&id=27&Itemid=19" class="smaller">Code of Conduct</a>&nbsp; |&nbsp; <a href="index.php?option=com_content&view=article&id=38&Itemid=19" class="smaller">Accessibility</a>

</div>

<br/>
<div class="inside6">
<a href="http://www.facebook.com" target="_blank"><img src="images/stories/fb_icon.png" border="0" alt="Follow us on Facebook" title="Follow us on Facebook" /></a>&nbsp;&nbsp;
<a href="https://twitter.com/CDC_PHIRDL" target="_blank"><img src="images/stories/twitter_icon.png" border="0" alt="Follow us on Twitter" title="Follow us on Twitter" /></a>&nbsp;&nbsp;
<a href="index.php?option=com_content&view=article&id=83&Itemid=19"><img src="images/stories/rss_icon.png" border="0" alt="Subscribe to our RSS feed" title="Subscribe to our RSS feed" /></a>&nbsp;&nbsp;
<a href="http://youtube.com" target="_blank"><img src="images/stories/youtube_icon.png" border="0" alt="Check us out on You Tube" title="Check us out on You Tube" /></a>
&nbsp;&nbsp;
<a href="http://linkedin.com" target="_blank"><img src="images/stories/linked_icon.png" border="0" alt="Connect with us on LinkedIn" title="Connect with us on LinkedIn" /></a>
</div>

<div class="supported">
<img src="images/supported.png" border="0" height="60px" width="694px" alt="An initiative for the public health community, supported by: Public Health Informatics and Technology Program Office, Office of Surveillance, Epidemiology and Laboratory Services, Centers for Disease Control and Prevention, Department of Health and Human Services" title="An initiative for the public health community, supported by: Public Health Informatics and Technology Program Office, Office of Surveillance, Epidemiology and Laboratory Services, Centers for Disease Control and Prevention, Department of Health and Human Services" />
</div>




</div><!--end of inside3-->
</div><!--end of footer-->

<div id="belowfooter">


<div class="inside4">
<a href="index.php" class="txtmenu">Home</a>&nbsp; | &nbsp;<a href="index.php?option=com_content&view=category&layout=blog&id=11&Itemid=2" class="txtmenu">Projects</a>&nbsp; | &nbsp;<a href="index.php?option=com_content&view=category&layout=blog&id=4&Itemid=6" class="txtmenu">News</a>&nbsp; |&nbsp; <a href="index.php?option=com_content&view=category&layout=blog&id=5&Itemid=7" class="txtmenu">Publications</a>&nbsp; | &nbsp;<a href="index.php?option=com_content&view=section&layout=blog&id=4&Itemid=8" class="txtmenu">Tags</a>&nbsp; | &nbsp;<a href="index.php?option=com_content&view=category&layout=blog&id=12&Itemid=9" class="txtmenu">Resources</a>&nbsp; | &nbsp;<a href="index.php?option=com_content&view=section&layout=blog&id=6&Itemid=13" class="txtmenu">FAQS: Our Team & the Lab</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-size: xx-small; color:#9b9b9b">
<?php
$app =& JFactory::getApplication();
echo $app->getCfg('irdu_environment'); //outputs environment
?>
,&nbsp;
</span>
<span style="font-size: xx-small; color:#9b9b9b">
<?php
$app =& JFactory::getApplication();
echo $app->getCfg('irdu_version'); //outputs version
?>
</span>



</div>
</div>
</div><!--end of wrap-->


</body>
</html>