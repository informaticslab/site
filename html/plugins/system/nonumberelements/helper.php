<?php
/**
 * Plugin Helper File
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Plugin that replaces Sourcerer code with its HTML / CSS / JavaScript / PHP equivalent
*/
class plgSystemNoNumberElementsHelper
{
	function plgSystemNoNumberElementsHelper()
	{
		$mainframe =& JFactory::getApplication();

		$url = JRequest::getVar( 'url' );

		if ( $url ) {
			echo $this->getByUrl( $url );
			exit;
		}

		$file = JRequest::getVar( 'file' );
		$folder = JRequest::getVar( 'folder' );

		jimport( 'joomla.filesystem.file' );

		// only allow files that have .inc.php in the file name
		if ( !$url && ( !$file || ( strpos( $file, '.inc.php' ) === false ) ) ) {
			echo JText::_( 'Access Denied' );
			exit;
		}

		if ( $mainframe->isSite() && !JRequest::getCmd( 'usetemplate' ) ) {
			$mainframe->setTemplate( 'system' );
		}
		$_REQUEST['tmpl'] = 'component';

		$mainframe->_messageQueue = array();

		$path = JPATH_SITE;
		if ( $folder ) {
			$path .= DS.implode( DS, explode( '.', $folder ) );
		}
		$file = $path.DS.$file;

		$html = '';
		if ( JFile::exists( $file ) ) {
			ob_start();
				include $file;
				$html = ob_get_contents();
			ob_end_clean();
		}

		$document =& JFactory::getDocument();
		$document->setBuffer( $html, 'component' );
		$document->addStyleSheet( JURI::root( true ).'/templates/system/css/system.css' );
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/nonumberelements/css/default.css' );
		$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');

		$mainframe->render();

		echo JResponse::toString( $mainframe->getCfg( 'gzip' ) );

		exit;
	}

	function getByUrl( $url) {
		if ( substr( $url, 0, 4 ) != 'http' ) {
			$url = 'http://'.$url;
		}

		$html = '';
		if ( function_exists( 'curl_init' ) ) {
			$html = $this->curl( $url );
		} else {
			$file = @fopen( $url, 'r' );
			if ( $file ) {
				$html = array();
				while ( !feof( $file ) ) {
					$html[] = fgets( $file, 1024 );
				}
				$html = implode( '', $html );
			}
		}

		return $html;
	}

	function curl( $url )
	{
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 3 );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'some crazy browser' );

		//follow on location problems
		if ( ini_get('open_basedir') == '' && ini_get('safe_mode') != 'On' ) {
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
			$html = curl_exec( $ch );
		}else{
			$html = $this->curl_redir_exec( $ch );
		}
		curl_close( $ch );
		return $html;
	}

	function curl_redir_exec( $ch )
	{
		static $curl_loops = 0;
		static $curl_max_loops = 20;

		if ( $curl_loops++ >= $curl_max_loops ) {
			$curl_loops = 0;
			return false;
		}

		curl_setopt( $ch, CURLOPT_HEADER, true );
		$data = curl_exec( $ch );

		list( $header, $data ) = explode( "\n\n", str_replace( "\r", '', $data ), 2 );
		$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

		if ( $http_code == 301 || $http_code == 302 ) {
			$matches = array();
			preg_match( '/Location:(.*?)\n/', $header, $matches );
			$url = @parse_url( trim( array_pop( $matches ) ) );
			if (!$url) {
				//couldn't process the url to redirect to
				$curl_loops = 0;
				return $data;
			}
			$last_url = parse_url( curl_getinfo( $ch, CURLINFO_EFFECTIVE_URL ) );
			if ( !$url['scheme'] ) {
				$url['scheme'] = $last_url['scheme'];
			}
			if ( !$url['host'] ) {
				$url['host'] = $last_url['host'];
			}
			if ( !$url['path'] ) {
				$url['path'] = $last_url['path'];
			}
			$new_url = $url['scheme'].'://'.$url['host'].$url['path'].( $url['query'] ? '?'.$url['query'] : '' );
			curl_setopt( $ch, CURLOPT_URL, $new_url );
			return $this->curl_redir_exec( $ch );
		} else {
			$curl_loops = 0;
			return $data;
		}
	}
}