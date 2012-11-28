<?php
/*
I apologize for my terrible PHP skills. This is a quick hack to allow to allow pages to browser sniff
for the proper version of the page. We make 4 versions: regular, ipad, iphone, iphone_retina.
#TODO - fix this at some point in the future, contributions welcome
*/
$slashPos = strrpos($_SERVER['PHP_SELF'],'/');
$fileNameFull = substr($_SERVER['PHP_SELF'],$slashPos+1);
$fileNameClean = str_replace("_iphone_retina","",$fileNameFull);
$fileNameClean = str_replace("_iphone","",$fileNameClean);
$fileNameClean = str_replace("_ipad","",$fileNameClean);
//if the user has an ipad and isn't already an ipad page, redirect to the ipad page
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')){
	if(!strpos($_SERVER['PHP_SELF'],'_ipad.php')){
        	$fileNameSuffixed = str_replace(".php","_ipad.php",$fileNameClean);
        	header('Location: '.$fileNameSuffixed);
        	exit();
	}
}
//if the user has an iphone and isn't already an iphone page, redirect to the iphone page
//Note, if user has an iphone retina they will get 2 redirects the first time, first to iphone, then to iphone_retina. I need to be smarter and fix this eventually.
elseif(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone')){
        if(!strpos($_SERVER['PHP_SELF'],'_iphone.php') and !strpos($_SERVER['PHP_SELF'],'_retina.php')){
                $fileNameSuffixed = str_replace(".php","_iphone.php",$fileNameClean);
                header('Location: '.$fileNameSuffixed);
                exit();
        }
        $fileNameSuffixed = str_replace(".php","_iphone_retina.php",$fileNameClean);
?>
<script type="text/javascript">
if(window.location.href.indexOf("_iphone_retina.php") == -1
	&&  window.devicePixelRatio >= 2 ){window.location.replace("<?php echo $fileNameSuffixed;?>");
}
</script>
<?php
//if they aren't on an iphone or ipad, and they aren't aready on regular  then direct to regular
}elseif (strcmp($fileNameFull,$fileNameClean) != 0){
	header('Location: '.$fileNameClean);
	exit();
}
?>
