<?php
/**
 * JComments - Joomla Comment System
 *
 * Backend uninstall handler
 *
 * @version 2.1
 * @package JComments
 * @subpackage Installer
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JComments someplace in your code
 * and provide a link to http://www.joomlatune.ru
 **/

// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

// define directory separator short constant
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// include legacy class
if (defined('JPATH_ROOT')) {
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
	include_once (JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.class.php');
} else {
	global $mainframe;
	include_once ($mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php');
	include_once ($mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments'.DS.'jcomments.class.php');
}

include_once (dirname(__FILE__).DS.'install'.DS.'helpers'.DS.'installer.php');

function com_uninstall()
{
	global $mainframe;

	$versionInfo = JCommentsInstallerHelper::getVersionInfo('jcomments');
?>
<style type="text/css">
div#jc {width: 600px;margin: 0 auto;}
span.copyright {color: #777;display: block;margin-top: 12px;}
div#element-box span.componentname {color: #FF9900;font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;}
div#element-box span.componentdate {color: #FF9900;font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: normal;}
div#element-box span.installheader {color: #FF9900;font-family: Arial, Helvetica, sans-serif;font-size: 16px;font-weight: bold;}
</style>

<div id="jc">

<div id="element-box">
<div class="t">
<div class="t">
<div class="t"></div>
</div>
</div>
<div class="m">

<table width="95%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top" align="left">
		<td width="50px"><img src="http://www.joomlatune.com//images/banners/jcomments_logo.png" width="48" height="48" border="0" alt="" /></td>
		<td><span class="componentname">JComments <?php echo $versionInfo->releaseVersion; ?></span>
		<span class="componentdate">[<?php echo $versionInfo->releaseDate; ?>]</span><br />
		<span class="copyright">&copy; 2006-2010 smart (<a href="http://www.joomlatune.ru" target="_blank">JoomlaTune.ru</a> | <a href="http://www.joomlatune.com" target="_blank">JoomlaTune.com</a>). <?php echo JText::_('All rights reserved!');?><br /></span></td>
	</tr>
	<tr valign="top" align="left">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

		<tr valign="top" align="left">
			<td>&nbsp;</td>
			<td><span class="installheader"><?php echo JText::_('Uninstall log'); ?></span></td>
		</tr>
		<tr valign="top" align="left">
			<td>&nbsp;</td>
			<td>
			<ul style="padding: 0 0 0 20px; margin: 0;">
<?php
	JCommentsInstallerHelper::uninstallPlugin('jcomments', 'content');
?>
			<li><?php echo JText::_('Uninstall content plugin'); ?>: <span style="color: green">OK</span></li>
<?php
	JCommentsInstallerHelper::uninstallPlugin('jcomments', 'search');
?>
			<li><?php echo JText::_('Uninstall search plugin'); ?>: <span style="color: green">OK</span></li>
<?php
	JCommentsInstallerHelper::uninstallPlugin('jcomments', 'system');
?>
			<li><?php echo JText::_('Uninstall system plugin'); ?>: <span style="color: green">OK</span></li>
<?php
	JCommentsInstallerHelper::uninstallPlugin(
		'jcommentson', 
		'editors-xtd', 
		array('jcommentson.gif')
	);

	JCommentsInstallerHelper::uninstallPlugin(
		'jcommentsoff', 
		'editors-xtd', 
		array('jcommentsoff.gif')
	);

	JCommentsInstallerHelper::uninstallPlugin('jcomments', 'k2');
?>
			<li><?php echo JText::_('Uninstall editors-xtd plugins'); ?>: <span style="color: green">OK</span></li>
<?php
	if (defined('JPATH_ROOT')) {
		JCommentsInstallerHelper::uninstallPlugin('jcomments', 'user');

		if(!isset($mainframe)) {
			$mainframe = &JFactory::getApplication('administrator');
		}
	}

	// Clean all caches for components with comments
	if ($mainframe->getCfg('caching') == 1) {
		$db =& JCommentsFactory::getDBO();
		$db->setQuery("SELECT DISTINCT(object_group) AS name FROM #__jcomments");
		$rows = $db->loadObjectList();

		foreach ($rows as $row) {
			JCommentsCache::cleanCache($row->name);
		}
		unset($rows);
?>
			<li><?php echo JText::_('Clean components cache'); ?>: <span style="color: green">OK</span></li>
<?php
	}
?>
			<li><span style="color: green"><strong><?php echo JText::_('JComments uninstalled'); ?></strong></span></li>
			</ul>
			</td>
		</tr>
	</table>

	</div>
	<div class="b">
	<div class="b">
	<div class="b"></div>
	</div>
	</div>
	</div>

	</div>
<?php
	if (JCOMMENTS_JVERSION == '1.0') {
		$componentPath = $mainframe->getCfg('absolute_path').DS.'components'.DS.'com_jcomments';

		require_once ($componentPath.DS.'libraries'.DS.'joomlatune'.DS.'filesystem.php');
		
		$path = $componentPath.DS.'languages';
		$filter = '\.ini';

		$files = JoomlaTuneFS::readDirectory($path, $filter, false, true);
		foreach($files as $file) {
			if (!preg_match('/[a-z]{2}-[A-Z]{2}\.com_jcomments/', (string) $file)) {
				@unlink((string) $file);
			}
		}
	}
}
?>