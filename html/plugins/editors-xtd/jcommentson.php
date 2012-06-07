<?php
/**
 * JComments - Joomla Comment System
 *
 * Provides button to insert {jcomments on} into content edit box
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

// define directory separator short constant
if (!defined( 'DS' )) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if (defined('JPATH_ROOT')) {
	include_once( JPATH_ROOT.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php' );
} else {
	global $mosConfig_absolute_path;
	include_once( $mosConfig_absolute_path.DS.'components'.DS.'com_jcomments'.DS.'jcomments.legacy.php' );
}

// if component doesnt exists (may be already uninstalled) - return
if (!defined( 'JCOMMENTS_JVERSION' )) { return; }

if ( JCOMMENTS_JVERSION == '1.0' ) {
	global $_MAMBOTS;
	$_MAMBOTS->registerFunction( 'onCustomEditorButton', 'botJCommentsOnButton' );

	function botJCommentsOnButton() {
		global $option;

		switch ( $option ) {
			case 'com_sections':
			case 'com_categories':
			case 'com_modules':
				$button = array( '', '' );
				break;
			default:
				$button = array( 'jcommentson.gif', '{jcomments on}' );
				break;
		}
		return $button;
	}
} else {
	jimport('joomla.event.plugin');

	/**
	 * Editor JComments Off button
	 **/
	class plgButtonJCommentsOn extends JPlugin
	{
		function plgButtonJCommentsOn(& $subject, $config)
		{
			parent::__construct($subject, $config);
		}

		function onDisplay($name)
		{
			$getContent = $this->_subject->getContent($name);
			$js = "
				function insertJCommentsOn(editor) {
					var content = $getContent
					if (content.match(/{jcomments on}/)) {
						return false;
					} else {
						jInsertEditorText('{jcomments on}', editor);
					}
				}
				";

			$doc =& JFactory::getDocument();
			$doc->addScriptDeclaration($js);
			
			$button = new JObject();
			$button->set('modal', false);
			$button->set('onclick', 'insertJCommentsOn(\''.$name.'\');return false;');
			$button->set('text', 'JComments ON');
			$button->set('name', 'blank');
			$button->set('link', '#');
	
			return $button;
		}
	}
}
?>