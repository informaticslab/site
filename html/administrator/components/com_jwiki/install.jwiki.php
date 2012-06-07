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


function com_install() 
{
    $mosConfig_absolute_path = dirname(JPATH_BASE);

    // db operations
    $database = JFactory::getDBO();

	$content = "";

	if (_JEXEC==1)
	{	$database->setQuery("SELECT id FROM #__components WHERE name='JWiki'");	}
	else
	{	$database->setQuery("SELECT id FROM #__components WHERE name='MamboWiki'");	}

    $id = $database -> loadResult();

	if (!$id)
	{
		$content .= "Unable to find the JWiki component in the components table";

	} else
	{
		$database->setQuery("SELECT count(*) as ctr FROM #__menu WHERE menutype='wikioptions'");
		$ctr = $database->loadResult();

	    $database->setQuery("UPDATE #__menu SET componentid = $id WHERE menutype='wikioptions'");
		$database->query();

		if (_JEXEC==1) 
		{ 
			$database->setQuery("UPDATE #__menu SET `type` = 'component' WHERE menutype='wikioptions'"); 
			$database->query();
		}

		$content .= "<p>Table update successful.</p>";
	}
?>

<center>
<table width="100%" border="0">
  <tr>
<?php if (_JEXEC==1) { ?>
    <td><img src="components/com_jwiki/images/lyquidity_wiki.jpg"></td>
    <td>
      <strong>MediaWiki for Joomla Component</strong><br/>
<?php } else { ?>
    <td><img src="components/com_mambowiki/images/lyquidity_wiki.jpg"></td>
    <td>
      <strong>MediaWiki for Mambo Component</strong><br/>
<?php } ?>
<?php echo "$content<br/>"; ?>
	  <font class="small">Copyright &copy; 2005...2008 by Lyquidity Solutions and &copy; by 2009 Hallo Welt! - Medienwerkstatt GmbH</font>
      <p>This component is released under the terms and conditions of the GNU General Public License.</p>
	  <p>This licence does not extend or cover the underlying MediaWiki that is released under its own licence.</p>
    </td>
  </tr>
</table>
</center>
<br/>

<?php
	return $content;
}
?>

