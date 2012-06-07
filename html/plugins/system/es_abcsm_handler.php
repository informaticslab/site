<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemEs_Abcsm_Handler extends JPlugin {
	static $is_active = false;

	function __construct(&$subject, $config) {
		parent::__construct( $subject, $config );
		
		//Require ionCube utilities
        $path_helper = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_es_joomla_common'.DS.'ioncube_helper.php';
        if (file_exists($path_helper) == false) {
        	return;
        }
        include_once $path_helper;
		
//        $ini_file = JPATH_ADMINISTRATOR.DS.'components'.DS.EsJoomlaHelper::COMPONENT_ADV_BREADCRUMBS_MANAGER.DS.'ioncube'.DS.'ioncube.settings.ini';
//        unlink($ini_file);
        
		//Require Joomla common utilities
        $path_common = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_es_joomla_common'.DS.'helper.php';
        $continue = EsIoncubeHelper::requireOnceEncryptedFile($path_common);
        if (!$continue) return;
        
        $path_comp = JPATH_ADMINISTRATOR.DS.'components'.DS.EsJoomlaHelper::COMPONENT_ADV_BREADCRUMBS_MANAGER.DS.'helper.php';
        //echo '<br/>helper path: '.$path_comp;
        self::$is_active = EsIoncubeHelper::initializePlugin(array($path_comp), false);
		//echo '<br/>is active: '.self::$is_active;
	}
	
	function onAfterDispatch() {
		global $mainframe;
		
		$er_level = error_reporting(E_ALL & ~E_NOTICE);
		
		if (self::$is_active == false) return;
		
		if ($mainframe->isAdmin() == true) return;
		
		try {
			$db	= & JFactory::getDBO();
			$document =& JFactory::getDocument();
//			echo '<br/>Evaluateing breadcrumbs...';
			if (is_a($document, 'JDocumentHTML')) {
				if (EsJoomlaHelper::isComponentInstalled(EsJoomlaHelper::COMPONENT_ADV_SECTIONS, true)) {
					$active_sections = ComEsAdvSectionsHelper::getCurrentlyActiveContexts();
				}
				if (!$active_sections) $active_sections = array();
				
				$new_bcs = ComEsBcsMgrHelper::getCurrentBreadcrumbs($active_sections);
				
//				echo '<br/>Current breadcrumbs: '.print_r($new_bcs, true);
				if ($new_bcs !== null && is_array($new_bcs)) {
					$new_items = array();
					$pathway =& $mainframe->getPathway();
					foreach ($new_bcs as $bc) {
						if (!$bc->label) continue;
						$item = new stdClass();
				        $item->name = html_entity_decode($bc->label);
				        $item->link = $bc->link;
				        $new_items[] = $item;
					}
					$pathway->setPathway($new_items);
				}
			} else {
//				echo '<br/>Document is not JDocumentHTML!';
			}
		} catch(Exception $ex) {
			
		}
		
		error_reporting($er_level);
	}
}


?>