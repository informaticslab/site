<?php
/**
 * JComments - Joomla Comment System
 *
 * Service functions for JComments system plugin
 *
 * @version 2.1
 * @package JComments
 * @subpackage Helpers
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

/**
 * JComments System Plugin Helper
 * 
 * @static
 * @package JComments
 * @subpackage Helpers
 */
class JCommentsSystemPluginHelper
{
	/**
	 *
	 * @access private
	 * @return string
	 */
	function getCoreJS($html=false)
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			global $mainframe;
			$baseUrl = $mainframe->getCfg('live_site');
		} else {
			$baseUrl = JURI::root(true);
		}

		$link = $baseUrl . '/components/com_jcomments/js/jcomments-v2.1.js?v=7';

		if ($html) {
			return  '<script src="' . $link . '" type="text/javascript"></script>';
		} else {
			return $link;
		}
	}

	/**
	 *
	 * @access private
	 * @return string
	 */
	function getCSS($isRTL = false, $template = '')
	{
		global $mainframe;

		if (empty($template)) {
			$config = & JCommentsCfg::getInstance();
			$template = $config->get('template');
		}

		$cssName = $isRTL ? 'style_rtl.css' : 'style.css';
		$cssFile = $cssName . '?v=12';
		
		if (JCOMMENTS_JVERSION == '1.0') {
			global $mosConfig_live_site, $mosConfig_absolute_path;
			$cssUrl = $mosConfig_live_site.'/components/com_jcomments/tpl/'.$template.'/'.$cssFile;
		} else {
			$cssPath = JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jcomments'.DS.$template.DS.$cssName;
			$cssUrl = JURI::root(true).'/templates/'.$mainframe->getTemplate().'/html/com_jcomments/'.$template.'/'.$cssFile;

			if (!is_file($cssPath)) {
				$cssPath = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'tpl'.DS.$template.DS.$cssName;
				$cssUrl = JURI::root(true).'/components/com_jcomments/tpl/'.$template.'/'.$cssFile;
                        	if ($isRTL && !is_file($cssPath)) {
					$cssUrl = '';
				}
	                }
		}
			
		return $cssUrl;
	}

	/**
	 *
	 * @access private
	 * @return string
	 */
	function getAjaxJS($html=false)
	{
		if (JCOMMENTS_JVERSION == '1.0') {
			global $mainframe;
			$baseUrl = $mainframe->getCfg('live_site');
		} else {
			$baseUrl = JURI::root(true);
		}

		$link = $baseUrl . '/components/com_jcomments/libraries/joomlatune/ajax.js?v=3';

		if ($html) {
			return  '<script src="' . $link . '" type="text/javascript"></script>';
		} else {
			return $link;
		}
	}
}
?>