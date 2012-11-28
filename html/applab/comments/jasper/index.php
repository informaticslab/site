
<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

define ('IN_COMMENTICS', 'true');

if (!isset($_GET['page']) && !isset($_GET['action'])) { header("Location: index.php?page=dashboard"); }
require_once "includes/auth.php";
if ($_GET['page'] == "log_out") {
	session_destroy();
	header("Location: index.php?action=logout");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Commentics: Admin Panel</title>

<meta name="robots" content="noindex"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel="stylesheet" type="text/css" href="css/panel.css"/>
<link rel="stylesheet" type="text/css" href="css/general.css"/>

<link rel="stylesheet" type="text/css" href="menu/ddlevelsmenu-base.css"/>
<link rel="stylesheet" type="text/css" href="menu/ddlevelsmenu-topbar.css"/>
<script type="text/javascript" src="menu/ddlevelsmenu.js"></script>

<script type="text/javascript" src="js/tooltip.js"></script>

<?php if ($_GET['page'] == "layout_order" || $_GET['page'] == "layout_form_sort_order_fields" || $_GET['page'] == "layout_form_sort_order_buttons") { ?>
<script type="text/javascript" src="js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous/src/scriptaculous.js"></script>
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="table/css/demo_page.css"/>
<link rel="stylesheet" type="text/css" href="table/css/demo_table.css"/>
<script type="text/javascript" language="javascript" src="table/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="table/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#data').dataTable( {
"aaSorting": [ ]
<?php switch ($_GET['page']) { ?>
<?php case "manage_comments":?>,"aoColumns": [null,null,null,null,<?php if ($settings->enabled_notify) { echo "null,"; } if ($settings->show_flag) { echo "null,null,"; } ?>null,{ "bSearchable": false }] <?php break; ?>
<?php case "manage_pages": ?>,"aoColumns": [null,null,null,null,null,null,{ "bSearchable": false }] <?php break; ?>
<?php case "manage_administrators": ?>,"aoColumns": [null,null,null,null,null,null,null,{ "bSearchable": false }] <?php break; ?>
<?php case "manage_bans": ?>,"aoColumns": [null,null,null,{ "bSearchable": false }] <?php break; ?>
<?php case "manage_subscribers": ?>,"aoColumns": [null,null,null,null,null,null,{ "bSearchable": false }] <?php break; ?>
<?php case "layout_form_questions": ?>,"aoColumns": [null,null,{ "bSearchable": false }] <?php break; ?>
<?php case "tool_db_backup": ?>,"aoColumns": [null,null,null,{ "bSearchable": false }] <?php break; ?>
<?php } ?>
} );
} );
</script>
<?php } ?>

<?php if ($_GET['page'] == "edit_comment" && $settings->enabled_wysiwyg) { ?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "inlinepopups,preview,searchreplace,paste,fullscreen",

	// Editing options
	forced_root_block : false,
	force_p_newlines : false,
	remove_linebreaks : false,
	force_br_newlines : true, 
	verify_html : false,
	relative_urls : false,
	convert_urls : false,

	// Layout options
	height : "225",

	// Style formats
	style_formats : [
		{title : 'Bold text', inline : 'b'},
		{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
		{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
		{title : 'Example 1', inline : 'span', classes : 'example1'},
		{title : 'Example 2', inline : 'span', classes : 'example2'},
		{title : 'Table styles'},
		{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
	],
	
	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,undo,redo,|,link,unlink,image,|,forecolor,backcolor,sub,sup,hr,|,charmap,search,|,preview,help,code,fullscreen",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_resizing : true
		
});
</script>
<?php } ?>

<script type="text/javascript">
function check_passwords() {
if (document.administrator.password_1.value == document.administrator.password_2.value) {
return true;
} else {
alert("<?php echo CMTX_PROMPT_PASSWORDS ?>");
return false;
}
}
</script>

<script type="text/javascript">
function delete_confirmation() {
var answer = confirm("<?php echo CMTX_PROMPT_DELETE ?>")
if (answer) {
return true;
} else {
return false;
}
}
</script>

<script type="text/javascript">
function delete_comment_confirmation() {
var answer = confirm("<?php echo CMTX_PROMPT_DELETE_COMMENT ?>")
if (answer) {
return true;
} else {
return false;
}
}
</script>

<script type="text/javascript">
function delete_page_confirmation() {
var answer = confirm("<?php echo CMTX_PROMPT_DELETE_PAGE ?>")
if (answer) {
return true;
} else {
return false;
}
}
</script>

<script type="text/javascript">
function show_hide(id) {
if (id == "php") {
document.getElementById('smtp').style.display = "none";
document.getElementById('sendmail').style.display = "none";
} else if (id == "smtp") {
document.getElementById('smtp').style.display = "inline";
document.getElementById('sendmail').style.display = "none";
} else if (id == "sendmail") {
document.getElementById('smtp').style.display = "none";
document.getElementById('sendmail').style.display = "inline";
}
}
</script>

<?php if ($_GET['page'] == "tool_viewers" && $settings->viewers_refresh_enabled) { ?>
<meta http-equiv="refresh" content="<?php echo $settings->viewers_refresh_time; ?>">
<?php } ?>

</head>
<body>

<a href="index.php?page=dashboard"><img src="images/commentics/logo.png" class="logo" title="Commentics" alt="Commentics"/></a>

<?php
require "menu/menu.php";

echo "<p />";

if (file_exists("../admin/")) {
?>
<span class='negative'>The admin folder has not been renamed.</span>
<p />
This is an important security step.
<p />
To rename the admin folder, load your FTP software (e.g. FileZilla) and rename the folder below:
<br />
<i>http://www.domain.com/comments<b>/admin/</b></i>
<p />
Then, in your web browser, navigate to your renamed admin folder:
<br />
<i>http://www.domain.com/comments<b>/renamed_admin_folder/</b></i>
<p />
Enter the name of your renamed admin folder in Settings -> System.
<?php
die();
}

if (file_exists("../installer/")) {
?>
<span class='negative'>The installer folder has not been deleted.</span>
<p />
This is an important security step.
<p />
To delete the installer folder, load your FTP software (e.g. FileZilla) and delete the folder below:
<br />
<i>http://www.domain.com/comments<b>/installer/</b></i>
<p />
Then refresh this page.
<p />
<input type="button" class="button" name="refresh" title="<?php echo CMTX_BUTTON_REFRESH ?>" value="<?php echo CMTX_BUTTON_REFRESH ?>" onclick="window.location.reload()"/>
<?php
die();
}

if (isset($_POST['chmod'])) {
@chmod("../includes/db/details.php", 0444);
}
if (isset($_POST['check'])) {
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '0' WHERE title = 'check_db_file'");
}
if ($settings->check_db_file && !isset($_POST['check']) && is_writable("../includes/db/details.php")) {
?>
<span class='negative'>The database file is writable.</span>
<p />
This is an important security step.
<p />
To protect this file, please click the 'Set Permission' button below.
<p />
If that fails then you may have to disable the check.
<p />
<form name="db_file" id="db_file" action="index.php?page=dashboard" method="post">
<input type="submit" class="button" name="chmod" title="<?php echo CMTX_BUTTON_CHMOD ?>" value="<?php echo CMTX_BUTTON_CHMOD ?>"/>
<input type="submit" class="button" name="check" title="<?php echo CMTX_BUTTON_CHECK ?>" value="<?php echo CMTX_BUTTON_CHECK ?>"/>
</form>
<?php
die();
}

$access_log = mysql_query("SELECT * FROM `".$mysql_table_prefix."access`");
$total = mysql_num_rows($access_log);
if ($total >= 100) {
mysql_query("DELETE FROM `".$mysql_table_prefix."access` ORDER BY dated ASC LIMIT 1");
}

if (file_exists("includes/pages/".$_GET['page'].".php")) {

	$admin_id = sanitize(get_admin_id());
	$username = sanitize($_SESSION['username']);
	$page = sanitize($_GET['page']);
	$ip_address = get_ip_address();
	mysql_query("INSERT INTO `".$mysql_table_prefix."access` (admin_id, username, ip_address, page, dated) VALUES ('$admin_id', '$username', '$ip_address','$page', NOW());");

	require "includes/pages/".$_GET['page'].".php";
	
} else {

	require "includes/pages/dashboard.php";

}

?>
</body>
</html>