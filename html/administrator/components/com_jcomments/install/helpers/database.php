<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments Installer
 *
 * @static
 * @version 2.1
 * @package JComments
 * @subpackage Installer
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2009-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

class JCommentsInstallerDatabaseHelper
{
	function setupCollation()
	{
		$db = & JCommentsFactory::getDBO();
		
		$db->setQuery("SELECT COUNT(*) FROM `#__jcomments`;");
		$cnt = $db->loadResult();
		
		// only if where are no comments
		if ($cnt == 0) {
			$collation = '';
			
			$db->setQuery("SHOW FULL COLUMNS FROM `#__content` LIKE 'title';");
			$rows = $db->loadObjectList();
			
			if (count($rows)) {
				$collation = $rows[0]->Collation;
			}
			
			if ($collation == '') {
				$db->setQuery("SHOW VARIABLES LIKE 'collation_database';");
				$rows = $db->loadObjectList();
				$collation = count($rows) ? $rows[0]->Value : '';
			}
			
			// if collation not determined - skip correction
			if ($collation != '') {
				$db->setQuery("SHOW FULL COLUMNS FROM `#__jcomments`;");
				$columns = $db->loadObjectList();
				
				if (is_array($columns)) {

					$change_text = array();
					
					foreach ($columns as $column) {
						if (strpos($column->Type, 'text') !== false || strpos($column->Type, 'char') !== false) {
							$change_text[] = "CHANGE `" . $column->Field . "` `" . $column->Field . "` " . $column->Type . " COLLATE " . $collation . " NOT NULL DEFAULT ''";
						}
					}
				
					// change collation for #__jcomments
					$db->setQuery("ALTER TABLE `#__jcomments` " . implode(', ', $change_text) . ";");
					@$db->query();
				}
				
				$db->setQuery("ALTER TABLE `#__jcomments` COLLATE " . $collation . ";");
				@$db->query();
				
				// change collation for #__jcomments_settings
				$db->setQuery("ALTER TABLE `#__jcomments_settings` CHANGE `value` `value` TEXT COLLATE " . $collation . " NOT NULL DEFAULT '';");
				@$db->query();
				
				$db->setQuery("ALTER TABLE `#__jcomments_settings` COLLATE " . $collation . ";");
				@$db->query();


				// change collation for #__jcomments_subscriptions
				$db->setQuery("SHOW FULL COLUMNS FROM `#__jcomments_subscriptions`;");
				$columns = $db->loadObjectList();
				
				if (is_array($columns)) {

					$change_text = array();
					
					foreach ($columns as $column) {
						if (strpos($column->Type, 'text') !== false || strpos($column->Type, 'char') !== false) {
							$change_text[] = "CHANGE `" . $column->Field . "` `" . $column->Field . "` " . $column->Type . " COLLATE " . $collation . " NOT NULL DEFAULT ''";
						}
					}
					$db->setQuery("ALTER TABLE `#__jcomments_subscriptions` " . implode(', ', $change_text) . ";");
					@$db->query();
				}
				
				$db->setQuery("ALTER TABLE `#__jcomments_subscriptions` COLLATE " . $collation . ";");
				@$db->query();
			}
		}
	}

	function upgradeStructure()
	{
		global $mainframe;
		
		$db = & JCommentsFactory::getDBO();
		
		// auto upgrade old table structure
		$db->setQuery("SHOW FIELDS FROM `#__jcomments`");
		$rows = $db->loadObjectList();

		if (is_array($rows)) {
			$fields = array();
			
			foreach ($rows as $row) {
				$fields[] = strtolower($row->Field);
			}
		
			$fieldsList = array_values($fields);
		
			if (!in_array('lang', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `lang` varchar(255) default '" . $mainframe->getCfg('lang') . "'; ");
				@$db->query();
			}
			if (!in_array('username', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `username` varchar(255) default NULL; ");
				@$db->query();
			}
			if (!in_array('subscribe', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `subscribe` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'; ");
				@$db->query();
				$db->setQuery("ALTER TABLE `#__jcomments` ADD INDEX `idx_subscribe`(`subscribe`); ");
				@$db->query();
			}
			if (!in_array('parent', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `parent` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`; ");
				@$db->query();
			}
			if (!in_array('isgood', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `isgood` SMALLINT(5) UNSIGNED NOT NULL default '0' AFTER `date`; ");
				@$db->query();
			}
			if (!in_array('ispoor', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `ispoor` SMALLINT(5) UNSIGNED NOT NULL default '0' AFTER `isgood`; ");
				@$db->query();
			}
			unset($fieldsList, $rows);
		}

		// correction settings table structure
		$db->setQuery("SHOW FIELDS FROM `#__jcomments_settings`;");
		$rows = $db->loadObjectList();
	
		if (is_array($rows)) {
			$fields = array();
		
			foreach ($rows as $row) {
				$fields[] = strtolower($row->Field);
			}
		
			$fieldsList = array_values($fields);
		
			if (!in_array('lang', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments_settings` ADD `lang` VARCHAR(20) NOT NULL DEFAULT '' AFTER `component`; ");
				@$db->query();
				
				$db->setQuery("ALTER TABLE `#__jcomments_settings` DROP PRIMARY KEY;");
				@$db->query();

				$db->setQuery("ALTER TABLE `#__jcomments_settings` ADD PRIMARY KEY (`component`, `lang`, `name`);");
				@$db->query();
			}
		}
		unset($fieldsList, $rows);
		
		return true;
	}

	function upgradeStructure2200()
	{
		global $mainframe;
		
		$db = & JCommentsFactory::getDBO();
		
		// auto upgrade old table structure
		$db->setQuery("SHOW FIELDS FROM `#__jcomments`");
		$rows = $db->loadObjectList();

		if (is_array($rows)) {
			$fields = array();
			
			foreach ($rows as $row) {
				$fields[] = strtolower($row->Field);
			}
		
			$fieldsList = array_values($fields);

			if (!in_array('level', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `level` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `parent`; ");
				@$db->query();
				$db->setQuery("ALTER TABLE `#__jcomments` ADD INDEX `idx_level`(`level`); ");
				@$db->query();
			}

			if (!in_array('path', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `path` VARCHAR(255) NOT NULL DEFAULT '' AFTER `parent`; ");
				@$db->query();
				$db->setQuery("ALTER TABLE `#__jcomments` ADD INDEX `idx_path`(`path`,`level`); ");
				@$db->query();
			}

			if (!in_array('source_id', $fieldsList)) {
				$db->setQuery("ALTER TABLE `#__jcomments` ADD `source_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `source`; ");
				@$db->query();
			}

			unset($fieldsList, $rows);
			return true;
		}
	
		return false;
	}

	function updateCommentsLevel()
	{
		$db = & JCommentsFactory::getDBO();
 
		// TODO: add check max_execution_time variable

		$db->setQuery("SELECT COUNT(*) FROM `#__jcomments` WHERE `parent` > 0 AND `level` = 0");
		$recordsToUpdate = $db->loadResult();

		if ($recordsToUpdate > 0) {
	
			$db->setQuery("UPDATE `#__jcomments` SET `level` = CASE WHEN `parent` = 0 THEN 0 ELSE 255 END;");
			$db->query();

			$maxLevel = 15;
			$currentLevel = 1;

			while (true) {
				$query = "UPDATE #__jcomments c1, #__jcomments c2"
					. "\nSET c1.level = c2.level + 1"
					. "\nWHERE c1.parent = c2.id and c2.level = " . ($currentLevel - 1)
					;
				$db->setQuery($query);
				$db->query();

				$currentLevel++;

				$updated = $db->getAffectedRows();

				if ($currentLevel > $maxLevel || $updated == 0) {
					break;
				}
			}
		}
	}

	function updateCommentsPath()
	{
		$db = & JCommentsFactory::getDBO();
 
		// TODO: add check max_execution_time variable

		$db->setQuery("SELECT DISTINCT `level` FROM `#__jcomments` ORDER BY `level`");
		$rows = $db->loadObjectList();


		$db->setQuery("UPDATE #__jcomments SET `path` = CASE WHEN `level` = 0 THEN '0' ELSE NULL END;");
		$db->query();

		if (count($rows) > 1) {
			foreach($rows as $row) {
				$query = "UPDATE `#__jcomments` c1, `#__jcomments` c2"
					. "\n SET c1.`path` = CONCAT_WS(',', c2.`path`, c2.`id`)"
					. "\nWHERE c1.parent = c2.id and c1.level = " . $row->level
					;
				$db->setQuery($query);
				$db->query();

			}
		}
		unset($rows);
	}
}
?>