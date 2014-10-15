/*start mixpanel*/
    (function(d,c){var a,b,g,e;a=d.createElement("script");a.type="text/javascript";
    a.async=!0;a.src=("https:"===d.location.protocol?"https:":"http:")+
    '//api.mixpanel.com/site_media/js/api/mixpanel.2.js';b=d.getElementsByTagName("script")[0];
    b.parentNode.insertBefore(a,b);c._i=[];c.init=function(a,d,f){var b=c;
    "undefined"!==typeof f?b=c[f]=[]:f="mixpanel";g=['disable','track','track_pageview',
    'track_links','track_forms','register','register_once','unregister','identify',
    'name_tag','set_config'];
    for(e=0;e<g.length;e++)(function(a){b[a]=function(){b.push([a].concat(
    Array.prototype.slice.call(arguments,0)))}})(g[e]);c._i.push([a,d,f])};window.mixpanel=c}
    )(document,[]);
mixpanel.init("3ffb32a694c5473084a71bcefae11737");

mixpanel.track_links('#download a', 'downloaded app from applab');
mixpanel.track_links('#ptt-applab-download', 'downloaded ptt app from applab');
mixpanel.track_links('#wisqars-applab-download', 'downloaded wisqars app from applab');
mixpanel.track_links('#retro-applab-download', 'downloaded retro app from applab');
mixpanel.track_links('#niosh-face-applab-download', 'downloaded niosh facepiece app from applab');
mixpanel.track_links('#tox-applab-download', 'downloaded tox guide app from applab');
mixpanel.track_links('#std1-applab-download', 'downloaded std1 app from applab');
mixpanel.track_links('#std2-applab-download', 'downloaded std2 app from applab');
mixpanel.track_links('#std3-applab-download', 'downloaded std3 shirly app from applab');
mixpanel.track_links('#std3-android-applab-download', 'downloaded Android version of std3 shirly app from applab');
mixpanel.track_links('#clip-applab-download', 'downloaded clip ipad app from applab');
mixpanel.track_links('#niosh-mine-applab-download', 'downloaded niosh mine app from applab');
mixpanel.track_links('#mmwr-nav-applab-download', 'downloaded MMWR Navigator ipad app from applab');
mixpanel.track_links('#mmwr-map-applab-download', 'downloaded MMWR Map ipad app from applab');
mixpanel.track_links('#epi-applab-download', 'downloaded StatCalc Epi Info ipad app from applab');
mixpanel.track_links('#jQuery-test-applab-download', 'downloaded jQuery mobile framework iOS app from applab');
mixpanel.track_links('#jQuery-test-applab-sourcecode', 'downloaded jQuery mobile framework sourcecode iOS app from applab');
mixpanel.track_links('#Sencha-test-applab-download', 'downloaded Sencha mobile framework iOS app from applab');
mixpanel.track_links('#Sencha-test-applab-sourcecode', 'downloaded Sencha mobile framework sourcecode iOS app from applab');
mixpanel.track_links('#Appcelerator-test-applab-download', 'downloaded Appcelerator mobile framework iOS app from applab');
mixpanel.track_links('#Appcelerator-test-applab-sourcecode', 'downloaded Appcelerator mobile framework sourcecode iOS app from applab');
mixpanel.track_links('#mmwrexpress-applab-download', 'downloaded MMWR Express iOS app from applab');
mixpanel.track_links('#lydia-android-applab-download', 'downloaded Lydia Android app from applab');
mixpanel.track_links('#lydia-ios-applab-download', 'downloaded Lydia iOS app from applab');
mixpanel.track_links('#bluebird-ios-applab-download', 'downloaded Bluebird iOS app from applab');
mixpanel.track_links('#pedigree-ios-applab-download', 'downloaded Pedigree iOS app from applab');
mixpanel.track_links('#tempmon-applab-download', 'downloaded Temp Monitor iOS app from applab');
mixpanel.track_links('#tempmon-android-applab-download', 'downloaded Temp Monitor Android app from applab');
mixpanel.track_links('#everydose-applab-download', 'downloaded Every Dose iOS app from applab');
mixpanel.track_links('#everydose-android-applab-download', 'downloaded Every Dose Android app from applab');


/*end mixpanel*/

/*start image functions*/
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
/*end image functions*/

/*start google analytics*/

 var _gaq = _gaq || [];
 _gaq.push(['_setAccount', 'UA-23539639-1']);
 _gaq.push(['_trackPageview']);

 (function() {
   var ga = document.createElement('script'); ga.type =
'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
'http://www') + '.google-analytics.com/ga.js';
   var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);
 })();

/*end google analytics*/
