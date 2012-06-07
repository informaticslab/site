<?php
/**
 * NoNumber! Elements Helper File: VersionCheck
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

class NNVersions
{
	function &instance()
	{
		static $instance;
		if ( !is_object( $instance ) ) {
			$instance = new NoNumberVersions;
		}
		return $instance;
	}
}
class NoNumberVersions
{
	function getMessage( $extension = '', $xml = '', $version = '', $addmargin = 0 )
	{
		if ( !$extension || ( !$xml && !$version ) ) {
			return;
		}

		$alias = preg_replace( '#[^a-z\-]#', '', str_replace( '?', '-', strtolower( $extension ) ) );

		if ( $xml ) {
			$xml = JApplicationHelper::parseXMLInstallFile( JPATH_SITE.DS.( str_replace( '/', DS, $xml ) ) );
			if ( $xml && isset( $xml['version'] ) ) {
				$version = $xml['version'];
			}
		}

		if ( !$version ) {
			return;
		}

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'functions.php';
		$this->functions =& NNFunctions::getFunctions();
		$mt_version = $this->functions->getJSVersion();

		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/js/script'.$mt_version.'.js' );
		$url = 'http://www.nonumber.nl/scripts/version.php?ext='.$alias.'&version='.$version;
		$script = "
			window.addEvent( 'domready', function() {
				nnScripts.loadajax(
					'".$url."',
					'nnScripts.displayVersion( \'".$alias."\', data )',
					'nnScripts.displayVersion( \'".$alias."\', \'\' )'
				);
			});
		";
		$document->addScriptDeclaration( $script );

		$msg = JText::sprintf( 'NN_A_NEWER_VERSION_IS_AVAILABLE', 'http://www.nonumber.nl/'.$alias.'/download', '<span id="nonumber_newversionnumber_'.$alias.'"></span>', $version  );

		$margin = $addmargin ? '10px;' : '3px;';
		$msg = '<div style="border:3px solid #F0DC7E;color:#CC0000;margin-bottom:'.$margin.'"><div style="padding: 2px 5px;background-color:#EFE7B8">'.$msg.'</div></div>';
		$msg = '<div id="nonumber_version_'.$alias.'" style="display: none;">'.$msg.'</div>';

		return $msg;
	}

	function getVersion( $extension, $xml )
	{
		if ( !$extension || !$xml ) {
			return;
		}

		$alias = preg_replace( '#[^a-z\-]#', '', str_replace( '?', '-', strtolower( $extension ) ) );

		$version = '';
		if ( $xml ) {
			$xml = JApplicationHelper::parseXMLInstallFile( JPATH_SITE.DS.( str_replace( '/', DS, $xml ) ) );
			if ( $xml && isset( $xml['version'] ) ) {
				$version = $xml['version'];
			}
		}
		return $version;
	}

	function setMessage( $current_version = '0', $version_file = '', $version_url = '', $download_url = '' )
	{
		echo $this->getMessage( str_replace( 'version_', '', $version_file ), '', $current_version, 1 );
	}
}