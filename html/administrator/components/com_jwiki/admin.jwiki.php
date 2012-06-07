<?php

/**
 * This file is part of JWiki.
 * JWiki is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * JWiki is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JWiki. If not, see <http://www.gnu.org/licenses/>.
 *
 * @Copyright Copyright (C) 2009 - HalloWelt! - Medienwerkstatt GmbH
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/


// ensure this file is being included by a parent file
defined('_JEXEC') or die('Restricted access');
define('_JOOMLA15', strpos(strtolower(__FILE__), "jwiki.php") === false ? 0 : 1 );
define('_VALID_MOS', true);
define( 'MEDIAWIKI', true );

global $mosConfig_lang, $mosConfig_absolute_path;

$lang =& JFactory::getLanguage();
$mosConfig_lang = $lang->getBackwardLang();
$mosConfig_absolute_path = dirname(JPATH_BASE);

$path = _JOOMLA15==1 ? "administrator/components/com_jwiki" : "administrator/components/com_mambowiki";

// Get the right language if it exists
if (file_exists("$mosConfig_absolute_path/$path/language/$mosConfig_lang.php")) {
	include_once("$mosConfig_absolute_path/$path/language/$mosConfig_lang.php");
} else {
	include_once("$mosConfig_absolute_path/$path/language/english.php");
}

require_once( $mainframe->getPath( 'admin_html' ) );
// require_once( $mainframe->getPath( 'class' ) );

$cid = JRequest::getVar( 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

switch( $task ) {
	case 'setup':
		setup( $option );
		break;
	case 'configuration':
		configuration( $option );
		break;
	case 'contributions':
		contributions( $option );
		break;
	case 'savemambowiki':
		saveConfiguration( $option );
		break;
	case 'cancelmambowiki':
		break;
	case 'showusers':
		showUsers( $option );
		break;
	case 'showpage':
		showPage( $option );
		break;
	default:
		admin( $option );
		break;

} // switch

function saveConfiguration( $option )
{
	global $mosConfig_absolute_path, $database, $mainframe;
    $database = JFactory::getDBO();

	// Get the saved values
	$cfg_height = $_POST['cfg_height'];
	$cfg_px = $_POST['cfg_usepx'];
	$cfg_showmediawikiimage = $_POST['cfg_showmediawikiimage'];
	$cfg_scrollbars = $_POST['cfg_scrollbars'];
	$cfg_uninstallwikitables = $_POST['cfg_uninstallwikitables'];
	$cfg_readaccessrules = $_POST['cfg_readaccessrules'];
	$cfg_editaccessrules = $_POST['cfg_editaccessrules'];
	$cfg_allowdirectaccess = $_POST['cfg_allowdirectaccess'];
	$cfg_logincomponent = $_POST['cfg_logincomponent'];

	// Validate the parameters
	# cfg_height can never be negative
	$bHeightValid = ($cfg_height >= 0);

	# if px is 1 then cfg_height cannot be more than 100
	$bPxValid = ($cfg_px ? ($cfg_height <= 100) : true);

	// There should be only one record so get the id of that record (if it exists yet)
	$database->setQuery("select * from #__mambowiki LIMIT 1");
	$row = $database->loadObjectList();

	// Gather the current parameter values
	$bRecordExists = (count($row) == 0);
	if ($bRecordExists) // No existing record so insert
	{
		$showmediawikiimage=1;
		$height = 500;
		$px = 0; // Px
		$usescrollbars = 0;
		$uninstallwikitables = 1; // Yes
		$readaccessrules = 1; // Users can read
		$editaccessrules = 1; // Users can edit

	} else
	{
		// Get the current values
		$row = $row[0];
		$showmediawikiimage=$row->showmediawikiimage; $errmsg = "found"; 
		$height = $row->height;
		$px = $row->px; $errmsg .= "$px $height";
		$usescrollbars = $row->usescrollbars;
		$id = $row->id;
		$uninstallwikitables = $row->uninstallwikitables;
		$readaccessrules = $row->readaccessrules;
		$editaccessrules = $row->editaccessrules;
	}

	# Replace with new values if new values are valid
	$showmediawikiimage=$cfg_showmediawikiimage;
	$usescrollbars = $cfg_scrollbars;
	$uninstallwikitables = $cfg_uninstallwikitables;
	$readaccessrules = $cfg_readaccessrules;
	$editaccessrules = $cfg_editaccessrules;
	$allowdirectaccess = $cfg_allowdirectaccess ? "true" : "false";
	$logincomponent = $cfg_logincomponent;

	# Only update height and px values if they are a valid combination
	if ($bHeightValid && $bPxValid)
	{
		$height = $cfg_height;
		$px = $cfg_px;
	}

	if ($bRecordExists) // No existing record so insert
	{
		$database->setQuery("INSERT INTO #__mambowiki (showmediawikiimage, height, px, usescrollbars, ordering, uninstallwikitables, readaccessrules, editaccessrules) VALUES($showmediawikiimage, $height, $px, $usescrollbars, 0, $uninstallwikitables, $readaccessrules, $editaccessrules)");
 	} else
	{
		$database->setQuery("UPDATE #__mambowiki SET showmediawikiimage=$showmediawikiimage, height=$height, px=$px, usescrollbars=$usescrollbars, uninstallwikitables=$uninstallwikitables, readaccessrules=$readaccessrules, editaccessrules=$editaccessrules WHERE id=$id");
	}
	$database->query();

	$path = _JOOMLA15==1 ? "components/com_jwiki" : "components/com_mambowiki";

	// Now write out the mambowikivar.php file
	if($f = fopen("$mosConfig_absolute_path/$path/mambowikivars.php", "w"))
	{
		$anonreadfalse = "\t\$wgGroupPermissions['*']['read']\t= false; # Anonymous are not allowed to read your pages.\n";
		$anonreadtrue  = "\t\$wgGroupPermissions['*']['read']\t= true;  # Anonymous are allowed to read your pages.\n";
		$anoneditfalse = "\t\$wgGroupPermissions['*']['edit']\t= false; # Anonymous are not allowed to edit your pages.\n";
		$anonedittrue  = "\t\$wgGroupPermissions['*']['edit']\t= true;  # Anonymous are allowed to edit your pages.\n";
		$userreadfalse = "\t\$wgGroupPermissions['user']['read']\t= false; # Users are not allowed to read your pages.\n";
		$userreadtrue  = "\t\$wgGroupPermissions['user']['read']\t= true;  # Users are allowed to read your pages.\n";
		$usereditfalse = "\t\$wgGroupPermissions['user']['edit']\t= false; # Users are not allowed to edit your pages.\n";
		$useredittrue  = "\t\$wgGroupPermissions['user']['edit']\t= true;  # Users are allowed to edit your pages.\n";
		fwrite($f, "<?php\n");
		if ($readaccessrules == 0) // Nobody can read
			fwrite($f, $anonreadfalse . $userreadfalse);
		if  ($editaccessrules == 0) // Nobody can edit
			fwrite($f, $anoneditfalse . $usereditfalse);
		if ($readaccessrules == 1) // Users can read
			fwrite($f, $anonreadfalse . $userreadtrue);
		if ($editaccessrules == 1) // Users can edit
			fwrite($f, $anoneditfalse . $useredittrue );
// maybe not needed because it is defined in includes/DefaultSettings.php
		if ($readaccessrules == 2) // Both can read
			fwrite($f, $anonreadtrue . $userreadtrue);
// maybe not needed because it is defined in includes/DefaultSettings.php
		if ($editaccessrules == 2) // Both can edit
			fwrite($f, $anonedittrue . $useredittrue);
		fwrite($f, "\t\$wgDisableCookieCheck\t\t\t= false;\n");
		if ($logincomponent == "")
		{
			fwrite($f, "\t\$mamboLoginComponent\t\t\t= \"index.php?option=com_login&task=login\";\n");
		}
		else
		{
			fwrite($f, "\t\$mamboLoginComponent\t\t\t= \"$logincomponent\";\n");
		}
		fwrite($f, "\t\$allowdirectaccess\t\t\t= $allowdirectaccess;\n");
		fwrite($f, "\t\$versionMajor = 0;\n");
		fwrite($f, "\t\$versionMinor = 9;\n");
		fwrite($f, "\t\$versionPoint = 7;\n");
		fwrite($f, "?>\n");
		fclose($f);

	} else
	{
		$readaccessrules = 3;
		$editaccessrules = 3; // use the variable to report a problem
	}

	// Confirm config change to the user
	$imagemsg = _IMAGEMSG0;
	$scrollbarmsg = "";
	$heightmsg = _HEIGHTMSG;
	$heighterrormsg = _HEIGHTERRORMSG;

	if ($showmediawikiimage == 0) $imagemsg = _IMAGEMSG1;
	$imagemsg = str_replace("%imagestate", "", $imagemsg);

	switch($usescrollbars)
	{
		case 0: $scrollbarmsg=_SCROLLBARMSG0; break;
		case 1: $scrollbarmsg=_SCROLLBARMSG1; break;
		case 2: $scrollbarmsg=_SCROLLBARMSG2; break;
		default:
			$scrollbarmsg=_SCROLLBARMSG0;
			$usescrollbars = 0;
	}

	if (!$bHeightValid || !$bPxValid) $heightmsg = $heighterrormsg;
	if ($cfg_px)
		$heightmsg = str_replace("%pxstate", "percent", $heightmsg); else
		$heightmsg = str_replace("%pxstate", "pixels", $heightmsg);
	$heightmsg = str_replace("%height", $cfg_height, $heightmsg);
	
	switch($uninstallwikitables)
	{
		case 0: $uninstallwikitablesmsg=_UNINSTALLWIKITABLES0MSG; break;
		case 1: $uninstallwikitablesmsg=_UNINSTALLWIKITABLES1MSG; break;
		case 2: $uninstallwikitablesmsg=_UNINSTALLWIKITABLES2MSG; break;
		default:
			$uninstallwikitablesmsg=_UNINSTALLWIKITABLES1MSG;
			$uninstallwikitables = 1;
	}

	switch($readaccessrules)
	{
		case 0: $readaccessrulesmsg=_READACCESSRULES0MSG; break;
		case 1: $readaccessrulesmsg=_READACCESSRULES1MSG; break;
		case 2: $readaccessrulesmsg=_READACCESSRULES2MSG; break;
		default:
			$readaccessrulesmsg=_READACCESSRULES1MSG;
			$readaccessrules = 1;
	}

	switch($editaccessrules)
	{
		case 0: $editaccessrulesmsg=_EDITACCESSRULES0MSG; break;
		case 1: $editaccessrulesmsg=_EDITACCESSRULES1MSG; break;
		case 2: $editaccessrulesmsg=_EDITACCESSRULES2MSG; break;
		default:
			$editaccessrulesmsg=_EDITACCESSRULES1MSG;
			$editaccessrules = 1;
	}

	echo "<br/>";
	echo "<font color='green'>$imagemsg</font><br/>";
	echo "<font color='green'>$scrollbarmsg</font><br/>";
	echo "<font color='green'>$uninstallwikitablesmsg</font><br/>";
	if ($readaccessrules==3) echo "<font color='red'>"; else echo "<font color='green'>";
	echo "$readaccessrulesmsg</font><br/>";
	if ($editaccessrules==3) echo "<font color='red'>"; else echo "<font color='green'>";
	echo "$editaccessrulesmsg</font><br/>";

	if ($bHeightValid && $bPxValid) echo "<font color='green'>"; else echo "<font color='red'>";
	echo "$heightmsg</font><br/>&nbsp";
	echo "<font color='green'>Allow direct access = $allowdirectaccess</font><br/>";
	echo "<font color='green'>The login component is '$logincomponent'</font><br/>";

	if ($database->getErrorNum() != 0) echo "<br/>" . $database->getErrorMsg();
}

function setup( $option ) 
{
	HTML_mambowiki::setupMamboWiki( $option );
}

function configuration( $option ) 
{
	HTML_mambowiki::showPage( $option, "Special:Specialpages" );
}

function contributions( $option ) 
{
	$user = $_GET['user'];
	if ($user == '') $user="Admin";
	HTML_mambowiki::userContributions( $option, $user );
}

function admin( $option ) 
{
	global $database, $mosConfig_absolute_path;
    $database = JFactory::getDBO();

	$database->setQuery("select * from #__mambowiki");
	$row = $database->loadObjectList();

	if (count($row) == 0)
	{
		$showmediawikiimage=1;
		$height = 500;
		$px = 0; // Px
		$usescrollbars = 0; // Auto
		$uninstallwikitables = 0; // No
		$readaccessrules = 1; // Users can view
		$editaccessrules = 1; // Users can edit
	} else
	{ 
		$row = $row[0];
		$showmediawikiimage=$row->showmediawikiimage;
		$height = $row->height;
		$px = $row->px;
		$usescrollbars = $row->usescrollbars;
		$uninstallwikitables = $row->uninstallwikitables;
		$readaccessrules = $row->readaccessrules;
		$editaccessrules = $row->editaccessrules;
	}

	$path = _JOOMLA15==1 ? "components/com_jwiki" : "components/com_mambowiki";

	if (file_exists("$mosConfig_absolute_path/$path/mambowikivars.php"))
	{
		require_once("$mosConfig_absolute_path/$path/mambowikivars.php");
	}

	HTML_mambowiki::adminMamboWiki( $option, $showmediawikiimage, $height, $px, $usescrollbars, $uninstallwikitables, $readaccessrules, $editaccessrules, $mamboLoginComponent, $allowdirectaccess, $versionMajor, $versionMinor, $versionPoint );
}

function showUsers( $option )
{
	global $database, $mainframe, $my, $mosConfig_absolute_path;
    $database = JFactory::getDBO();

	$path = _JOOMLA15==1 ? "components/com_jwiki" : "components/com_mambowiki";

	if (!file_exists("$mosConfig_absolute_path/$path/LocalSettings.php"))
	{
		HTML_mambowiki::notInstalled( $option );
		return;
	}

	$curdir = getcwd();
	chdir("$mosConfig_absolute_path/$path/");
	require_once("$mosConfig_absolute_path/$path/LocalSettings.php");
	chdir($curdir);

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( strtolower( $search ) ) );

	$where = "";
	if (isset( $search ) && $search!= "") 
	{
		$where = "(lower(user_name) LIKE '%$search%' OR user_id='$search')";
	}

	$database->setQuery( "SELECT COUNT(*)"
	                   . "\nFROM $wgDBprefix" . "user "
	                   . ($where != "" ? "\nWHERE " . $where : "")
	                   );
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$database->setQuery( "SELECT * "
 					   . "\nFROM $wgDBprefix" . "user"
 					   . ($where != "" ? "\nWHERE " . $where : "" )
					   . "\nLIMIT $pageNav->limitstart, $pageNav->limit"
					   );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) 
	{
		echo $database->stderr();
		return false;
	}

	HTML_mambowiki::showUsers( $rows, $pageNav, $search, $option );
}

function showPage( $option )
{
	global $database, $mainframe, $my, $mosConfig_absolute_path;

	$path = _JOOMLA15==1 ? "components/com_jwiki" : "components/com_mambowiki";

	if (!file_exists("$mosConfig_absolute_path/$path/LocalSettings.php"))
	{
		HTML_mambowiki::notInstalled( $option );
		return;
	}

	$search = $cid = JRequest::getVar( 'search', 'Main_Page' );

	HTML_mambowiki::showPage( $option, $search );
}
?>
