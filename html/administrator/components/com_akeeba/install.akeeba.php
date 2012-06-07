<?php
/**
 * @package Akeeba
 * @copyright Copyright (C) 2009 Nicholas K. Dionysopoulos. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Joomla! 1.6 Beta 13+ hack
if( version_compare( JVERSION, '1.6.0', 'ge' ) && !defined('_AKEEBA_HACK') ) {
	return;
} else {
	global $akeeba_installation_has_run;
	if($akeeba_installation_has_run) return;
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

// Schema modification -- BEGIN

$db =& JFactory::getDBO();
$errors = array();

// Version 3.0 to 3.1 updates (performs autodection before running the commands)
$sql = 'SHOW CREATE TABLE `#__ak_stats`';
$db->setQuery($sql);
$ctableAssoc = $db->loadResultArray(1);
$ctable = empty($ctableAssoc) ? '' : $ctableAssoc[0];
if(!strstr($ctable, '`tag`'))
{
	// Smart schema update - NEW IN 3.1.b3

	if($db->hasUTF())
	{
		$charset = 'CHARSET=utf8';
	}
	else
	{
		$charset = '';
	}

	$sql = <<<ENDSQL
DROP TABLE IF EXISTS `#__ak_stats_bak`;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
CREATE TABLE `#__ak_stats_bak` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `comment` longtext,
  `backupstart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backupend` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('run','fail','complete') NOT NULL DEFAULT 'run',
  `origin` varchar(30) NOT NULL DEFAULT 'backend',
  `type` varchar(30) NOT NULL DEFAULT 'full',
  `profile_id` bigint(20) NOT NULL DEFAULT '1',
  `archivename` longtext,
  `absolute_path` longtext,
  `multipart` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `filesexist` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fullstatus` (`filesexist`,`status`),
  KEY `idx_stale` (`status`,`origin`)
) ENGINE=MyISAM DEFAULT $charset;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
INSERT IGNORE INTO `#__ak_stats_bak`
	(`id`,`description`,`comment`,`backupstart`,`backupend`,`status`,`origin`,`type`,`profile_id`,`archivename`,`absolute_path`,`multipart`)
SELECT
  `id`,`description`,`comment`,`backupstart`,`backupend`,`status`,`origin`,`type`,`profile_id`,`archivename`,`absolute_path`,`multipart`
FROM
  `#__ak_stats`;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
DROP TABLE IF EXISTS `#__ak_stats`;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
CREATE TABLE `#__ak_stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `comment` longtext,
  `backupstart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `backupend` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('run','fail','complete') NOT NULL DEFAULT 'run',
  `origin` varchar(30) NOT NULL DEFAULT 'backend',
  `type` varchar(30) NOT NULL DEFAULT 'full',
  `profile_id` bigint(20) NOT NULL DEFAULT '1',
  `archivename` longtext,
  `absolute_path` longtext,
  `multipart` int(11) NOT NULL DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `filesexist` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fullstatus` (`filesexist`,`status`),
  KEY `idx_stale` (`status`,`origin`)
) ENGINE=MyISAM DEFAULT $charset;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
INSERT IGNORE INTO `#__ak_stats` SELECT * FROM `#__ak_stats_bak`;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

	$sql = <<<ENDSQL
DROP TABLE IF EXISTS `#__ak_stats_bak`;
ENDSQL;
	$db->setQuery($sql);
	$status = $db->query();
	if(!$status && ($db->getErrorNum() != 1060)) {
		$errors[] = $db->getErrorMsg(true);
	}

}

// Schema modification -- END

// Install modules and plugins -- BEGIN

// -- General settings
jimport('joomla.installer.installer');
$db = & JFactory::getDBO();
$status = new JObject();
$status->modules = array();
$status->plugins = array();
if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
	// Thank you for removing installer features in Joomla! 1.6 Beta 13 and
	// forcing me to write ugly code, Joomla!...
	$src = dirname(__FILE__);
} else {
	$src = $this->parent->getPath('source');
}

// -- Icon module
$installer = new JInstaller;
$result = $installer->install($src.'/mod_akadmin');
$status->modules[] = array('name'=>'mod_akadmin','client'=>'administrator', 'result'=>$result);

$query = "UPDATE #__modules SET position='icon', ordering=97, published=1 WHERE `module`='mod_akadmin'";
$db->setQuery($query);
$db->query();

// -- Lazy scheduling plugin (do not enable automatically!)
$installer = new JInstaller;
$result = $installer->install($src.DS.'aklazy');
$status->plugins[] = array('name'=>'plg_aklazy','group'=>'system', 'result'=>$result);

// Install modules and plugins -- END

// Load the translation strings (Joomla! 1.5 and 1.6 compatible)
if( version_compare( JVERSION, '1.6.0', 'lt' ) ) {
	global $j15;
	// Joomla! 1.5 will have to load the translation strings
	$j15 = true;
	$jlang =& JFactory::getLanguage();
	$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_akeeba';
	$jlang->load('com_akeeba.sys', $path, 'en-GB', true);
	$jlang->load('com_akeeba.sys', $path, $jlang->getDefault(), true);
	$jlang->load('com_akeeba.sys', $path, null, true);
} else {
	$j15 = false;
}

if(!function_exists('pitext'))
{
	function pitext($key)
	{
		global $j15;
		$string = JText::_($key);
		if($j15)
		{
			$string = str_replace('"_QQ_"', '"', $string);
		}
		echo $string;
	}
}

if(!function_exists('pisprint'))
{
	function pisprint($key, $param)
	{
		global $j15;
		$string = JText::sprintf($key, $param);
		if($j15)
		{
			$string = str_replace('"_QQ_"', '"', $string);
		}
		echo $string;
	}
}

// Finally, show the installation results form
?>
<?php if(!empty($errors)): ?>
<div style="background-color: #900; color: #fff; font-size: large;">
	<h1><?php pitext('COM_AKEEBA_PIMYSQLERR_HEAD'); ?></h1>
	<p><?php pitext('COM_AKEEBA_PIMYSQLERR_BODY1'); ?></p>
	<p><?php pitext('COM_AKEEBA_PIMYSQLERR_BODY2'); ?></p>
	<p style="font-size: normal;">
<?php echo implode("<br/>", $errors); ?>
	</p>
</div>
<?php endif; ?>

<h1><?php pitext('COM_AKEEBA_PIHEADER'); ?></h1>

<?php $rows = 0;?>
<img src="components/com_akeeba/assets/images/logo-48.png" width="48" height="48" alt="Akeeba Backup" align="right" />

<h2><?php pitext('COM_AKEEBA_PIWELCOME') ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'Akeeba Backup '.JText::_('Component'); ?></td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<fieldset>
	<p>
		<?php pisprint('COM_AKEEBA_PITEXT1','http://www.akeebabackup.com/akeeba-backup-documentation/index.html') ?>
		<?php pisprint('COM_AKEEBA_PITEXT2','http://www.akeebabackup.com/support/forum.html') ?>
	</p>
	<p>
		<?php pisprint('COM_AKEEBA_PITEXT3',JURI::base().'index.php?option=com_akeeba&view=config') ?>
		<?php pisprint('COM_AKEEBA_PITEXT4',JURI::base().'index.php?option=com_akeeba&view=cpanel') ?>
		<?php pisprint('COM_AKEEBA_PITEXT5',JURI::base().'index.php?option=com_akeeba&view=backup') ?>
		<?php pitext('COM_AKEEBA_PITEXT6') ?>
	</p>
</fieldset>
<?php global $akeeba_installation_has_run; $akeeba_installation_has_run = 1; ?>