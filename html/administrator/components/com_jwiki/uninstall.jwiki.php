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


function com_uninstall()
{
	global $database, $mosConfig_absolute_path;
    $mosConfig_absolute_path = dirname(JPATH_BASE);

    // db operations
    $database = JFactory::getDBO();

	$path = _JEXEC==1 ? "components/com_jwiki" : "components/com_mambowiki";

	// Get the Wiki tables prefix - but check that LocalSettings is there.  If its not, the setup was not performed.
	if (file_exists("$mosConfig_absolute_path/$path/LocalSettings.php")) $bSetup=1; else $bSetup=0;
	$bRemoveTables = $bSetup; // Set a default - no point delete tables that do not exist
	$bRemoveData = true; // Set a default - alway assume the user wants to delete other data

	// Is there a record to recode the preferences?
	$sql = "SELECT id FROM #__mambowiki LIMIT 1";
	$database->setQuery($sql);
	$id = $database -> loadResult();

	// $handle=fopen("$mosConfig_absolute_path\bill.log", "w");

	if ($id) // Only bother to check the user's preference if there is an id
	{
		/* There are three users options

			0 - No deletion, keep all existing data
			1 - Delete everything
			2 - Only mambo data not the wiki tables

		*/
		$sql = "SELECT `uninstallwikitables` FROM #__mambowiki WHERE id=$id";
		$database->setQuery($sql);
		$uninstallwikitables = $database -> loadResult();
		$bRemoveTables = (($uninstallwikitables==1) && ($bSetup==1)) ? 1 : 0;
		$bRemoveData   = ($uninstallwikitables>0) ? 1 : 0;

		//fwrite($handle, "value=$uninstallwikitables\n");
		//fwrite($handle, "bSetup=$bSetup\n");
		//fwrite($handle, "bRemoveTables=$bRemoveTables\n");
		//fwrite($handle, "bRemoveData=$bRemoveData\n");
	}

	if ($bRemoveData)
	{
		//fwrite($handle, "Deleting data\n");

		// Remove wiki menus
		$sql = "DELETE FROM `#__menu` WHERE menutype='wikioptions' OR link = 'index.php?option=com_jwiki'";
		$database->setQuery($sql);
		$database->query();

		$sql = "DELETE FROM `#__menu` WHERE menutype='mainmenu' AND name='Wiki'";
		$database->setQuery($sql);
		$database->query();

		$sql = "DELETE FROM `#__modules` WHERE position='wiki' OR title = 'Wiki Options'";
		$database->setQuery($sql);
		$database->query();

		$sql = "DELETE FROM `#__template_positions` WHERE position='wiki'";
		$database->setQuery($sql);
		$database->query();

	}

	if ($bRemoveTables)
	{
		define( 'MEDIAWIKI', true );
		include_once("$mosConfig_absolute_path/$path/LocalSettings.php");
		$wiki = $wgDBprefix;
        if(!$wiki) {
            $wiki = 'mw_';
        }

		// Optionally remove Wiki Tables

		// fwrite($handle, "Deleting tables\n");

		$sqlStatements = array();
		$sqlStatements[] = "DROP TABLE IF EXISTS `#__mambowiki`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "archive`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "blobs`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "brokenlinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "categorylinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "cur`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "hitcounter`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "image`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "imagelinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "interwiki`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "ipblocks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "links`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "linkscc`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "logging`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "math`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "objectcache`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "old`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "oldimage`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "page`";		//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "pagelinks`";	//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "querycache`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "recentchanges`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "revision`";	//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "searchindex`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "site_stats`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "text`";		//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "trackbacks`";	//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "transcache`";	//added 1.5.6
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "user`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "user_groups`";	//added 1.5.4
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "user_newtalk`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "user_rights`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "validate`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "watchlist`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "category`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "change_tag`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "externallinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "filearchive`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "job`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "langlinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "page_props`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "page_restrictions`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "protected_titles`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "querycachetwo`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "querycache_info`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "redirect`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "tag_summary`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "templatelinks`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "updatelog`";
		$sqlStatements[] = "DROP TABLE IF EXISTS `" . $wiki . "valid_tag`";

		foreach($sqlStatements as $sql)
		{
			$database->setQuery($sql);
			$database->query();
		}

	}

	// fwrite($handle, "Done\n");
	// fclose($handle);

}

?>