<?php
/**
 * NoNumber! Elements Helper File: Parameters
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
* Assignments
* $assignment = no / include / exclude / none
*/

class NNePparameters extends NNParameters
{
	 // for backward compatibility
}

class NNParameters
{
	function &getParameters()
	{
		static $instance;
		if ( !is_object( $instance ) ) {
			$instance = new NoNumberElementsParameters;
		}
		return $instance;
	}
}
class NoNumberElementsParameters
{
	var $_xml = array();

	function getParams( $ini, $path = '' )
	{
		$xml = $this->_getXML( $path );

		if ( !$ini ) {
			return (object) $xml;
		}

		$params = array();

		$key = '';
		$lines = explode( "\n", trim( $ini ) );
		foreach ( $lines as $line ) {
			// lines without '...=' are added to previous value
			if ( !preg_match( '#^[a-z0-9@][a-z0-9@\-_]*=#i', $line ) ) {
				if ( $key != '' ) {
					$params[ $key ] .= "\n".$line;
				}
				continue;
			}

			// ignore comments
			if ( $line && $line{0} == '@' ) {
				continue;
			}

			$key = substr( $line, 0, strpos( $line, '=' ) );
			$val = substr( $line, strpos( $line, '=' )+1 );
			$params[ $key ] = $val;
		}

		unset( $lines );
		unset( $line );

		if ( !empty( $xml ) ) {
			foreach( $xml as $key => $val ) {
				if ( !isset( $params[$key] ) || $params[$key] == '' ) {
					$params[$key] = $val;
				}
			}
		}

		return (object) $params;
	}

	function _getXML( $path )
	{
		if ( !isset( $this->_xml[$path] ) ) {
			$this->_xml[$path] = $this->_loadXML( $path );
		}

		return $this->_xml[$path];
	}

	function _loadXML( $path )
	{
		$xml = array();
		if ( $path ) {
			$xmlparser = & JFactory::getXMLParser('Simple');
			if ( $xmlparser->loadFile( $path ) ) {
				$xml = $this->_getParamValues( $xmlparser );
			}
		}

		return $xml;
	}

	function _getParamValues( &$xml, $keys = array() )
	{
		$params = array();
		if ( isset( $xml->document ) && isset( $xml->document->params ) ) {
			foreach ( $xml->document->params as $xml_group ) {
				foreach ( $xml_group->children() as $xml_child ) {
					$key = $xml_child->attributes('name');
					if ( !empty( $key ) && $key['0'] != '@' ) {
						if ( empty( $keys ) || in_array( $key, $keys ) ) {
							$val = $xml->get( $key );
							if ( !is_array( $val ) && !strlen( $val ) ) {
								$val = $xml_child->attributes('default');
								if ( $xml_child->attributes('type') == 'textarea' ) {
									$val = str_replace( '<br />', "\n", $val );
								}
							}
							$params[$key] = $val;
						}
					}
				}
			}
		}
		return $params;
	}

	function getObjectFromXML( &$xml )
	{
		if ( !is_array( $xml ) ) {
			$xml = array( $xml );
		}
		$class = '';
		foreach ( $xml as $item ) {
			$key = $this->_getKeyFromXML( $item );
			$val = $this->_getValFromXML( $item );

			if ( isset( $class->$key ) ) {
				if ( !is_array( $class->$key ) ) {
					$class->$key = array( $class->$key );
				}
				$class->{$key}[] = $val;
			}
			$class->$key = $val;
		}
		return $class;
	}

	function _getKeyFromXML( &$xml )
	{
		if ( !empty( $xml->_attributes ) && isset( $xml->_attributes['name'] ) ) {
			$key = $xml->_attributes['name'];
		} else {
			$key = $xml->_name;
		}
		return $key;
	}

	function _getValFromXML( &$xml )
	{
		if ( !empty( $xml->_attributes ) && isset( $xml->_attributes['value'] ) ) {
			$val = $xml->_attributes['value'];
		} else if ( empty( $xml->_children ) ) {
			$val = $xml->_data;
		} else {
			$val = '';
			foreach ( $xml->_children as $child ) {
				$k = $this->_getKeyFromXML( $child );
				$v =$this->_getValFromXML( $child );

				if ( isset( $val->$k ) ) {
					if ( !is_array( $val->$k ) ) {
						$val->$k = array( $val->$k );
					}
					$val->{$k}[] = $v;
				} else {
					$val->$k = $v;
				}
			}
		}
		return $val;
	}

	function getPluginParams( $plugin, $folder = 'system' )
	{
		static $instance;
		if ( !is_object( $instance ) ) {
			$xmlfile = JPATH_PLUGINS.DS.$folder.DS.$plugin.'.xml';
			$plug = JPluginHelper::getPlugin( $folder, $plugin );
			$instance = $this->getParams( $plug->params, $xmlfile );
		}
		return $instance;
	}

}
