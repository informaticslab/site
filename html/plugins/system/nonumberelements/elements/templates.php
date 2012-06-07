<?php
/**
 * Element: Templates
 * Displays a select box of templates
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

/**
 * Templates Element
 */
class JElementTemplates extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Templates';

	function fetchElement( $name, $value, &$node, $control_name)
	{
		$size =				$node->attributes( 'size' );
		$multiple =			$node->attributes( 'multiple' );
		$subtemplates =		$this->def( $node->attributes( 'subtemplates' ), 1 );

		$control = $control_name.'['.$name.']';
		$attribs = 'class="inputbox"';
		if ( $multiple ) {
			if( !is_array( $value ) ) { $value = explode( ',', $value ); }
			$attribs .= ' multiple="multiple"';
			$control .= '[]';
		}

		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_templates'.DS.'helpers'.DS.'template.php';
		$rows = array();
		$rows = TemplatesHelper::parseXMLTemplateFiles( JPATH_ROOT.DS.'templates' );
		$options = $this->createList( $rows, JPATH_ROOT.DS.'templates', $subtemplates );

		if( $size ) {
			$attribs .= ' size="'.$size.'"';
		} else {
			$attribs .= ' size="'.( ( count( $options) > 10 ) ? 10 : count( $options) ).'"';
		}

		$list =	JHTML::_( 'select.genericlist', $options, $control, $attribs, 'value', 'text', $value, $control_name.$name );

		return $list;
	}
	function createList( $rows, $templateBaseDir, $subtemplates = 1 )
	{
		$options = array();

		$options[] = JHTML::_( 'select.option', 'system:component', JText::_( 'None' ).' (System - component)' );

		foreach ( $rows as $row ) {
			$options[] = JHTML::_( 'select.option', $row->directory, $row->name );

			if ( $subtemplates ) {
				$options_sub = $this->getSubTemplates( $row, $templateBaseDir );
				$options = array_merge( $options, $options_sub );
			}
		}
		return $options;
	}

	function getSubTemplates( $row, $templateBaseDir )
	{
		$options = array();
		$templateDir = dir( $templateBaseDir.DS.$row->directory );
		while ( false !== ( $file = $templateDir->read() ) ) {
		  	if ( is_file( $templateDir->path.DS.$file ) ) {
				if ( !( strpos( $file, '.php' ) === false ) && $file != 'index.php' ) {
					$file_name = str_replace( '.php', '', $file );
					if ( $file_name != 'index' && $file_name != 'editor' && $file_name != 'error' ) {
						$options[] = JHTML::_( 'select.option', $row->directory.':'.$file_name, $row->name.' - '.$file_name );
					}
				}
			}
		}
		$templateDir->close();

		return $options;
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
	}
}