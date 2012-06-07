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
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
define('_JOOMLA15', strpos(strtolower(__FILE__), "jwiki.html.php") === false ? 0 : 1 );

class HTML_mambowiki {

	function adminMamboWiki( $option, $showmediawikiimage, $height, $px, $usescrollbars, $uninstallwikitables, $readaccessrules, $editaccessrules, $mamboLoginComponent, $allowdirectaccess, $versionMajor, $versionMinor, $versionPoint ) 
	{
		// make a standard yes/no list
	    $yesno = array();
	    $yesno[] = JHTML::_('select.option', '0', _NO);
	    $yesno[] = JHTML::_('select.option', '1', _YES);

	    // make a standard px/pct list
	    $pxpct = array();
	    $pxpct[] = JHTML::_('select.option', '0', _PIXELS );
	    $pxpct[] = JHTML::_('select.option', '1', _PERCENT );

	    // make a standard auto/no/yes list
	    $scrollbars = array();
	    $scrollbars[] = JHTML::_('select.option', '0', _AUTO );
	    $scrollbars[] = JHTML::_('select.option', '1', _NO );
	    $scrollbars[] = JHTML::_('select.option', '2', _YES );

	    // make a uninstall options list
	    $uninstalloptions = array();
	    $uninstalloptions[] = JHTML::_('select.option', '0', _UNINSTALLOPTION0 );
	    $uninstalloptions[] = JHTML::_('select.option', '1', _UNINSTALLOPTION1 );
	    $uninstalloptions[] = JHTML::_('select.option', '2', _UNINSTALLOPTION2 );

	    // make a options list for read and edit access
	    $accessoptions = array();
	    $accessoptions[] = JHTML::_('select.option', '0', _ACCESSOPTION0 );
	    $accessoptions[] = JHTML::_('select.option', '1', _ACCESSOPTION1 );
	    $accessoptions[] = JHTML::_('select.option', '2', _ACCESSOPTION2 );

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";

?>

		<script language="javascript" type="text/javascript">
			function submitbutton(pressbutton) {
				var form = document.adminForm;
					if (pressbutton == 'savemambowiki') 
					{
						if (confirm ("<?php echo _CONFIRM; ?>")) 
						{
							submitform( pressbutton );
						}
					} else 
					{
						document.location.href = 'index2.php';
					}
			}

			function Donate()
			{
				
			}
		</script>

	<form action="index2.php" method="POST" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%">
				<td width="200px">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td style="width: 100%" align="center" >
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki" target="_blank">
					 <img border="0" height="94" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
		</table>

		<table class="adminform">
		  <tr>
			<th colspan="2"><?php echo _ADMINISTRATION; ?></th>
		  </tr>

		  <tr>
			<td align="left" height="70px" width="10">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=setup" style="text-decoration:none;" title="<?php echo _INIT_MEDIAWIKI_TITLE; ?>">
			    <img src="images/install.png" width="48px" height="48px" align="middle" border="0"/>
			  </a>
			</td>
			<td align="left" height="70px" width="100%">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=setup" style="text-decoration:none;" title="<?php echo _INIT_MEDIAWIKI_TITLE; ?>">
	 			  <?php echo _INIT_MEDIAWIKI; ?>
			  </a>
			</td>
		  </tr>

		  <tr>
			<td align="left" height="70px" width="10">
			  <a href="http://www.hallowelt.biz/joomlawiki" target="_blank" style="text-decoration:none;" title="<?php echo _HELP_TITLE; ?>">
			    <img src="components/<?php echo $component; ?>/images/help_header.png" width="48px" height="48px" align="middle" border="0"/>
			  </a>
			</td>
			<td align="left" height="70px" width="100%">
			  <a href="http://www.hallowelt.biz/joomlawiki" target="_blank" style="text-decoration:none;" title="<?php echo _HELP_TITLE; ?>">
	 			  <?php echo _HELP; ?>
			  </a>
			</td>
		  </tr>

		  <tr>
			<td align="left" height="70px" width="10">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=configuration" style="text-decoration:none;" title="<?php echo _CONFIG_MEDIAWIKI_TITLE; ?>">
			    <img src="images/systeminfo.png" width="48px" height="48px" align="middle" border="0"/>
			  </a>
			</td>
			<td align="left" height="70px" width="100%">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=configuration" style="text-decoration:none;" title="<?php echo _CONFIG_MEDIAWIKI_TITLE; ?>">
 			    <?php echo _CONFIG_MEDIAWIKI; ?>
			  </a>
			</td>
		  </tr>

		  <tr>
			<td align="left" height="70px" width="10">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=showusers" style="text-decoration:none;" title="<?php echo _CONTRIBS_TITLE; ?>">
			    <img src="images/user.png" width="48px" height="48px" align="middle" border="0"/>
			  </a>
			</td>
			<td align="left" height="70px" width="100%">
			  <a href="index2.php?option=<?php echo $component; ?>&amp;task=showusers" style="text-decoration:none;" title="<?php echo _CONTRIBS_TITLE; ?>">
 			    <?php echo _CONTRIBS; ?>
			  </a>
			</td>
		  </tr>

		  <tr>
			<td valign="top"><img src="images/addedit.png" width="48px" height="48px" align="middle" border="0"/></td>
			<td>
			  <table cellpadding="4" cellspacing="0" border="0">
			    <tr>
				  <td align="left">
				    <?php echo _SHOW_IMAGE; ?>
				  </td>
				  <td align="left" width="150">
				    <?php echo JHTML::_('select.genericlist', $yesno, 'cfg_showmediawikiimage', 'class="inputbox" size="1"', 'value', 'text', $showmediawikiimage ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _COMPONENT_HEIGHT; ?>
				  </td>
				  <td align="left" height="10">
					<input type="text" name="cfg_height" value="<?php echo $height; ?>" class="inputbox" size="4" maxlength="4" />
					<?php echo JHTML::_('select.genericlist', $pxpct, 'cfg_usepx', 'class="inputbox" size="1"', 'value', 'text', $px ); ?>
					&nbsp; <?php echo _COMPONENT_HEIGHT_COMMENT; ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _IFRAME_SCROLLBARS; ?>
				  </td>
				  <td align="left">
				    <?php echo JHTML::_('select.genericlist', $scrollbars, 'cfg_scrollbars', 'class="inputbox" size="1"', 'value', 'text', $usescrollbars ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _UNINSTALLWIKITABLES; ?>
				  </td>
				  <td align="left">
				    <?php echo JHTML::_('select.genericlist', $uninstalloptions, 'cfg_uninstallwikitables', 'class="inputbox" size="1"', 'value', 'text', $uninstallwikitables ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _READACCESSRULES; ?>
				  </td>
				  <td align="left">
				    <?php echo JHTML::_('select.genericlist', $accessoptions, 'cfg_readaccessrules', 'class="inputbox" size="1"', 'value', 'text', $readaccessrules ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _EDITACCESSRULES; ?>
				  </td>
				  <td align="left">
				    <?php echo JHTML::_('select.genericlist', $accessoptions, 'cfg_editaccessrules', 'class="inputbox" size="1"', 'value', 'text', $editaccessrules ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _ALLOWDIRECTACCESS; ?>
				  </td>
				  <td align="left">
				    <?php echo JHTML::_('select.genericlist', $yesno, 'cfg_allowdirectaccess', 'class="inputbox" size="1"', 'value', 'text', $allowdirectaccess ); ?>
				  </td>
			    </tr>

			    <tr>
				  <td align="left">
				    <?php echo _LOGINCOMPONENT; ?>
				  </td>
				  <td align="left">
				    <?php echo "<input name='cfg_logincomponent' class='inputbox' size='70' value='$mamboLoginComponent' />"; ?>
				  </td>
			    </tr>

				<tr>
				  <td align="left" colspan="2">&nbsp;</td>
			    </tr>

			  </table>
		    </td>
		  </tr>

		  <tr>
			<td valign="top"><img src="images/query.png" width="48px" height="48px" align="middle" border="0"/></td>
			<td>
			  <table cellpadding="4" cellspacing="0" border="0">

				<tr>
				  <td align="left">
				    <?php echo _GOTOPAGE; ?>
				  </td>
				  <td align="left" nowrap>
					<input type="text" name="search" value="" class="inputbox" onChange="document.adminForm.submit();" />&nbsp;<input type="button" name="go" value=" -> " onClick="document.adminForm.submit();" />
				  </td>
			    </tr>

			  </table>
		    </td>
		  </tr>

		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr class="row0">
				<td height="100%" width="100%"></td>
			</tr>
			<tr>
				<th align="center"> <?php // echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center"> <?php //echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="showpage">

	</form>

<?php
	}

	function configureMamboWiki( $option ) 
	{
		global $mosConfig_live_site, $my, $database, $mosConfig_secret, $wgScriptPath;

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";

		// Initialise function variables
		$username = '';
		$querystring = '';
		$password = '';
        $config =& JFactory::getConfig();
        $mosConfig_secret = $config->getValue( 'config.secret' );
		$secret = md5($mosConfig_secret);
        $database = JFactory::getDBO();
        $my =& JFactory::getUser();

		// First, check that the Wiki has been configured by the administrator

		// Next check to see if the user is signed in
		if ($my->id == 0)
		{
			if ($show_page == -1) { $show_page = 0; }
		} 
		else
		{
			/*
			* Linking the authentication server and MediaWiki
			* ===============================================
			*
			* NOTE: This should be done only when $show_page == -1
			*       $show_page will be -1 when the user enters the  Wiki for the first time.
			*
			* See http://meta.wikimedia.org/wiki/QISSingleSignOn for more information
			*
			* The authentication server has to create a token for MediaWiki and
			* transmit it as "password":
			*
			* action="/mediawiki/index.php?title=Spezial:Userlogin&action=submitlogin&returnto=Main_Page"
			* wpLoginattempt=Anmelden
			* wpName=username
			* wpPassword=1115814654-d1bf93299de1b68e6d382c893bf1215f
			*
			* You should not put this variables into the URL but use a hidden form
			* instead. This could even be triggerd automaticially by JavaScript:
			* <body onload="document.forms[0].submit();">
			*/

			$row = new mosUser( $database );
			$row->load( $my->id );

			# For MediaWiki the password should be lowercase and *then* utf8_encoded
			$username = strtolower($row->username);
			$username = utf8_encode($username);

			// Make a password
			$currentTime = time();

			// The password is the microtime plus a hash of the microtime, username and secret
			// This should be enough to stop someone casually sending a valid login request.

			# The username that makes up the password should be lowercase because MediaWiki 
			# will lowercase the the wpUser value when before it arrives in the MamboLogin.php 
			# authenticate() function.  Note that MediaWiki replaces the "_" in a usrername with 
			# a space so this has to be done to the comparison password as well or, again, the
			# comparison will fail.

			$password = str_replace('_', ' ', strtolower($username)) . $currentTime . $mosConfig_secret;
			$password = $currentTime . '-' . md5($password);
		}

		$querystring = "components/$component/index.php?title=Special:Userlogin&action=submitlogin&returnto=Special:Specialpages&wpName=$username&wpPassword=$password&wpLoginattempt=userlogin&lock=$secret";

		echo $querystring;

?>

	<form action="index2.php" method="POST" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

		<table class="adminform">
		  <tr>
			<th colspan="2"><?php echo _CONFIG; ?></th>
		  </tr>
		  <tr>
			<td align="center" height="500" width="100%">
			  <iframe frameborder="0" name="configure" src="<?php echo $querystring ?>" width="100%" height="500" scrolling="auto"></iframe>
			</td>
		  </tr>
		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr class="row0">
				<td height="100%" width="100%"></td>
			</tr>
			<tr>
				<th align="center"> <?php // echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center"> <?php // echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="">

	</form>

<?php
	}

	function userContributions( $option, $user ) 
	{
		global $mosConfig_live_site, $my, $database, $mosConfig_secret, $wgScriptPath;

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";

		// Initialise function variables
		$username = '';
		$querystring = '';
		$password = '';
        $config =& JFactory::getConfig();
        $mosConfig_secret = $config->getValue( 'config.secret' );
		$secret = md5($mosConfig_secret);
        $database = JFactory::getDBO();
        $my =& JFactory::getUser();

		// First, check that the Wiki has been configured by the administrator

		$row = new mosUser( $database );
		$row->load( $my->id );

		# For MediaWiki the password should be lowercase and *then* utf8_encoded
		$username = strtolower($row->username);
		$username = utf8_encode($username);

		// Make a password
		$currentTime = microtime();
		$currentTime = substr($currentTime, strpos($currentTime, ' ')+1);

		// The password is the microtime plus a hash of the microtime, username and secret
		// This should be enough to stop someone casually sending a valid login request.

		# The username that makes up the password should be lowercase because MediaWiki 
		# will lowercase the the wpUser value when before it arrives in the MamboLogin.php 
		# authenticate() function.  Note that MediaWiki replaces the "_" in a usrername with 
		# a space so this has to be done to the comparison password as well or, again, the
		# comparison will fail.

		$password = str_replace('_', ' ', strtolower($username)) . $currentTime . $mosConfig_secret;
		$password = $currentTime . '-' . md5($password);

		$querystring = "components/$component/index.php?title=Special:Contributions&target=$user&lock=$secret";

?>

	<form action="index2.php" method="POST" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

		<table class="adminform">
		  <tr>
			<th colspan="2"><?php echo _CONTRIBS; ?></th>
		  </tr>
		  <tr>
			<td align="center" height="500" width="100%">
			  <iframe frameborder="0" name="contribution" src="<?php echo $querystring ?>" width="100%" height="500" scrolling="auto"></iframe>
			</td>
		  </tr>
		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr class="row0">
				<td height="100%" width="100%"></td>
			</tr>
			<tr>
				<th align="center"> <?php // echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center"> <?php // echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="">

	</form>

<?php
	}

	function showPage( $option, $page ) 
	{
		global $mosConfig_live_site, $my, $database, $mosConfig_secret, $wgScriptPath;

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";

		// Initialise function variables
		$username = '';
		$querystring = '';
		$password = '';
        $config =& JFactory::getConfig();
        $mosConfig_secret = $config->getValue( 'config.secret' );
		$secret = md5($mosConfig_secret);
        $database = JFactory::getDBO();
        $my =& JFactory::getUser();

		if ($page=='') $page='Main_Page';

		// First, check that the Wiki has been configured by the administrator

		# For MediaWiki the password should be lowercase and *then* utf8_encoded
		$username = strtolower($my->username);
		$username = utf8_encode($username);

		// Make a password
		$currentTime = microtime();
		$currentTime = substr($currentTime, strpos($currentTime, ' ')+1);

		// The password is the microtime plus a hash of the microtime, username and secret
		// This should be enough to stop someone casually sending a valid login request.

		# The username that makes up the password should be lowercase because MediaWiki 
		# will lowercase the the wpUser value when before it arrives in the MamboLogin.php 
		# authenticate() function.  Note that MediaWiki replaces the "_" in a usrername with 
		# a space so this has to be done to the comparison password as well or, again, the
		# comparison will fail.

		$password = str_replace('_', ' ', strtolower($username)) . $currentTime . $mosConfig_secret;
		$password = $currentTime . '-' . md5($password);

		$querystring = "../components/$component/index.php?title=Special:Userlogin&action=submitlogin&returnto=$page&wpName=$username&wpPassword=$password&wpLoginattempt=userlogin&lock=$secret";

?>

	<form action="index2.php" method="POST" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

		<table class="adminform">

		  <tr>

			<th width="100%"><?php echo _SHOWPAGE . "&nbsp;" . $page; ?></th>
			<th align="right" nowrap>
			  <?php echo _GOTOPAGE . "&nbsp;"; ?><input type="text" name="search" value="" class="inputbox" onChange="document.adminForm.submit();" />&nbsp;<input type="button" name="go" value=" -> " onClick="document.adminForm.submit();" />
			</th>

		  </tr>

		  <tr>
			<td align="center" height="500" width="100%" colspan="2">
			  <iframe frameborder="0" name="contribution" src="<?php echo $querystring ?>" width="100%" height="500" scrolling="auto"></iframe>
			</td>
		  </tr>

		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr class="row0">
				<td height="100%" width="100%"></td>
			</tr>
			<tr>
				<th align="center"> <?php // echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center"> <?php // echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="showpage">

	</form>

<?php
	}

	function setupMamboWiki( $option ) 
	{
		global $mosConfig_live_site, $mosConfig_absolute_path;

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";
?>

	<form action="index2.php" method="POST" name="adminForm">

		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

		<table class="adminform">
		  <tr>
			<th colspan="2"><?php echo _SETUP; ?></th>
		  </tr>
		  <tr>
			<td valign="top" align="center" height="500" width="100%" bgcolor="white">
<?php	if (file_exists("../components/$component/config/index.php"))
		{ 
			if(_JOOMLA15==1)
			{ ?>
			  <iframe frameborder="0" name="setup" src="<?php echo "../components/com_jwiki/config/index.php?joomla15=1"; ?>" width="100%" height="500" scrolling="auto"></iframe>
			<?php } else { ?>
			  <iframe frameborder="0" name="setup" src="../components/com_mambowiki/config/index.php" width="100%" height="500" scrolling="auto"></iframe>
<?php } } else { ?>
			  <h1>MediaWiki is installed</h1><br/>Please use the <?php echo $title; ?> configuration options to make changes to this installation
<?php } ?>
			</td>
		  </tr>
		</table>

		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
			<tr class="row0">
				<td height="100%" width="100%"></td>
			</tr>
			<tr>
				<th align="center"> <?php // echo $pageNav->writePagesLinks(); ?></th>
			</tr>
			<tr>
				<td align="center"> <?php // echo $pageNav->writePagesCounter(); ?></td>
			</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>">
		<input type="hidden" name="task" value="">

	</form>

<?php
	}

	function showUsers( &$rows, $pageNav, $search, $option ) 
	{

		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";

?>

<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo _SHOWUSERS; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="20%" class="title"><?php echo _USER_ID; ?></th>
    </tr>
<?php
    $k = 0;
    for ($i=0, $n=count( $rows ); $i < $n; $i++) {
      $row =& $rows[$i];
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td> <a href="index2.php?option=<?php echo $option; ?>&task=contributions&user=<?php echo $row->user_name; ?>" >
        <?php echo $row->user_name; ?> </a> </td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="9"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="9" nowrap="nowrap">
		<?php echo _DISPLAY; ?>&nbsp;#&nbsp;<?php echo $pageNav->writeLimitBox(); ?>&nbsp;<?php echo $pageNav->writePagesCounter(); ?>&nbsp;
		<?php echo _SEARCH; ?>:&nbsp;<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />

	  </td>
    </tr>
  </table>

  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="showusers" />
  <input type="hidden" name="boxchecked" value="0" />
</form>

<?php
	}

	function notInstalled( $option ) 
	{
		$component	= _JOOMLA15==1 ? "com_jwiki" : "com_mambowiki";
		$title		= _JOOMLA15==1 ? "JWiki" : "MamboWiki";
?>

<form action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
			<tr>	
				<td width="100%">
				   <span class="sectionname"><img src="components/<?php echo $component; ?>/images/wiki.png" align="middle" />&nbsp;<?php echo $title; ?></span>
				</td>
				<td align="right">
				   <span class="sectionname">
				     <a href="http://www.hallowelt.biz/joomlawiki"
					    target="_blank">
					 <img border="0" height="85" width="256" 
					      src="components/<?php echo $component; ?>/images/lyquidity_wiki.jpg" align="right" />
					 </a></span>
				</td>
			</tr>
		</table>

  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="100%" class="title"></td>
    </tr>
	<tr>
	  <td valign="top" align="center" height="500" width="100%" bgcolor="white">
	  <h2>Mambo Wiki installation is not yet complete</h2><p>Please use the <a href="index2.php?option=<?php echo $component; ?>">Setup</a> option to initialise the Wiki.</p>
	  </td>
    </tr>
  </table>

</form>

<?php }

}
?>
