<?php
/**
 * NoNumber! Elements Helper File: Licenses
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

class NNLicenses
{
	function &instance()
	{
		static $instance;
		if ( !is_object( $instance ) ) {
			$instance = new NoNumberLicenses;
		}
		return $instance;
	}
}
class NoNumberLicenses
{
	function getMessage( $extension = '', $addmargin = 0 )
	{
		if ( !$extension ) {
			return;
		}

		$alias = preg_replace( '#[^a-z\-]#', '', str_replace( '?', '-', strtolower( $extension ) ) );

		$host = parse_url( JURI::root( false ) );
		$host = strtolower( $host['host'] );

		if ( !$host || $host == 'localhost' || $host == '127.0.0.1' ) {
			return $this->blockHTML( $extension, $alias, 'local', '', $addmargin );
		}

		$db =& JFactory::getDBO();
		$sql = 'show tables like "'.$db->getPrefix().'nonumber_licenses"';
		$db->setQuery( $sql );
		$exists = $db->loadResult();

		$code = '';
		if ( $exists ) {
			$sql = 'SELECT code FROM #__nonumber_licenses'
				.' WHERE extension = \'all\''
				.' LIMIT 1';
			$db->setQuery( $sql );
			$code = $db->loadResult();
			if ( !$code ) {
				$sql = 'SELECT code FROM #__nonumber_licenses'
					.' WHERE extension = \''.$alias.'\''
					.' LIMIT 1';
				$db->setQuery( $sql );
				$code = $db->loadResult();
			}
		}

		if ( !( strpos( $host, '.' ) === false ) ) {
			$host_array = explode( '.', $host );
			if ( count( $host_array ) > 1 ) {
				$slds = 'ac au city co com edu gov gv law ltd me med mil mod net nhs nic nom org parliament plc police pub sch school';
				$host = array();
				$host[] = array_pop( $host_array );
				$host[] = array_pop( $host_array );
				if ( in_array( $host['1'], explode( ' ', $slds ) ) ) {
					$host[] = array_pop( $host_array );
				}
				$host = implode( '.', array_reverse( $host ) );
			}
		}

		if ( !$code ) {
			return $this->blockHTML( $extension, $alias, 'none', $host, $addmargin );
		}

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'functions.php';
		$this->functions =& NNFunctions::getFunctions();
		$mt_version = $this->functions->getJSVersion();

		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/js/script'.$mt_version.'.js' );
		// url to the license checker on the nonumber.nl server
		// returns the state (valid, invalid, fail)
		$url = 'http://www.nonumber.nl/scripts/license.php?host='.$host.'&code='.$code.'&ext='.$alias;
		$script = "
			window.addEvent( 'domready', function() {
				nnScripts.loadajax(
					'".$url."',
					'nnScripts.displayLicense( \'".$alias."\', data )',
					'nnScripts.displayLicense( \'".$alias."\', \'\' )'
				);
			});
		";
		$document->addScriptDeclaration( $script );

		$html = array();

		$html[] = '<div id="nonumber_license_'.$alias.'_valid" style="display: none">';
			$html[] = $this->blockHTML( $extension, $alias, 'valid', $host, $addmargin );
		$html[] = '</div>';

		$html[] = '<div id="nonumber_license_'.$alias.'_invalid" style="display: none;">';
			$html[] = $this->blockHTML( $extension, $alias, 'invalid', $host, $addmargin );
		$html[] = '</div>';

		$html[] = '<div id="nonumber_license_'.$alias.'_fail" style="display: none;">';
			$html[] = $this->blockHTML( $extension, $alias, 'fail', $host, $addmargin );
		$html[] = '</div>';

		return implode( '', $html );
	}

	function blockHTML( $extension = '', $alias = '', $state = '', $host = '', $addmargin = 0 )
	{
		$bgcolor = '#FFCCCC';
		$color = '#000000';
		$formcolor = '#996666';
		$bordercolor = '#EEBBBB';

		switch ( $state ) {
			case 'valid':
				$text = JText::sprintf( 'NN_THIS_IS_A_COMMERCIAL_VERSION', $extension, $host );
				$bgcolor = '#F6F6F6';
				$color = '#009900';
				$formcolor = '#999999';
				$bordercolor = '#EEEEEE';
				break;
			case 'invalid':
				$text = JText::sprintf( 'NN_THE_LICENSE_CODE_IS_NOT_VALID', $extension, $host );
				break;
			case 'local':
				$text = JText::sprintf( 'NN_CANNOT_CHECK_IF_LICENSE_CODE_IS_VALID_BECAUSE_YOU_ARE_WORKING_ON_A_LOCAL_SERVER',  $extension );
				break;
			case 'fail':
				$text = JText::sprintf( 'NN_CANNOT_CHECK_IF_LICENSE_CODE_IS_VALID', $extension );
				break;
			default:
				$text = JText::sprintf( 'NN_THIS_IS_A_NONCOMMERCIAL_VERSION', $extension );
				break;
		}

		$margin = $addmargin ? '10px;' : '3px;';

		$html = array();

		$html[] = '<div style="border:1px solid #CCCCCC;margin-bottom:'.$margin.'"><div style="padding: 2px 5px;background-color:'.$bgcolor.';">';
			$html[] = '<strong style="color:'.$color.';">'.$text.'</strong>';
			if ( $state != 'valid' ) {
				$html[] = '<br />'.JText::_( 'NN_THERE_ARE_NO_LIMITATIONS_IN_FUNCTIONALITY' );
				$html[] = '<span style="white-space:nowrap;"><em>';
					$html[] = '(<a href="http://www.nonumber.nl/'.$alias.'/license" target="_blank">'.JText::_( 'NN_PURCHASE_LICENSE_CODE' ).'</a>';
					$html[] = ( $host ? ' '.JText::sprintf( 'NN_FOR_YOUR_DOMAIN', $host ) : '' ).')';
				$html[] = '</em></span>';
			}
		$html[] = '</div></div>';

		return implode( '', $html );
	}

	/* Used by older extensions: for backward compatibility... */
	function getState( $extension )
	{
		if ( is_object( $extension ) ) {
			$alias = $extension->alias;
		} else {
			$alias = preg_replace( '#[^a-z\-]#', '', str_replace( '?', '-', strtolower( $extension ) ) );
		}

		$host = parse_url( JURI::root( false ) );
		$host = strtolower( $host['host'] );

		if ( !$host || $host == 'localhost' || $host == '127.0.0.1' ) {
			return 2;
		}

		$db =& JFactory::getDBO();
		$sql = 'show tables like "'.$db->getPrefix().'nonumber_licenses"';
		$db->setQuery( $sql );
		$exists = $db->loadResult();

		$code = '';
		if ( $exists ) {
			$sql = 'SELECT code FROM #__nonumber_licenses'
				.' WHERE extension = \'all\''
				.' LIMIT 1';
			$db->setQuery( $sql );
			$code = $db->loadResult();
			if ( !$code ) {
				$sql = 'SELECT code FROM #__nonumber_licenses'
					.' WHERE extension = \''.$alias.'\''
					.' LIMIT 1';
				$db->setQuery( $sql );
				$code = $db->loadResult();
			}
		}

		if ( !$code ) {
			return 0;
		}

		$url = 'http://www.nonumber.nl/scripts/license.php?host='.$host.'&code='.$code.'&ext='.$alias;

		$data = '';
		if ( function_exists( 'curl_init' ) ) {
			$curl_handle = curl_init();

			$options = array
			(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_TIMEOUT => 3,
				CURLOPT_USERAGENT => "some crazy browser"
			);
			curl_setopt_array( $curl_handle,$options );

			$data = curl_exec( $curl_handle );
			curl_close( $curl_handle );
		} else {
			$file = @fopen( $url, 'r' );
			if ( $file ) {
				$data = array();
				while ( !feof( $file ) ) {
					$data[] = fgets( $file, 1024 );
				}
				$data = implode( '', $data );
			}
		}

		$state = 0;
		switch ( $data ) {
			case 'invalid':
			// commercial but not valid
				$state = 1;
				break;
			case 'local':
			// commercial
				$state = 2;
				break;
			case 'valid':
			// commercial
				$state = 3;
				break;
			default:
			// non-commercial
				$state = 0;
				break;
		}

		return $state;
	}
}
