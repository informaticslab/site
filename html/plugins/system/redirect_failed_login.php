<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

/**
 * Joomla! Redirect Failed Login
 * Version 1.51
 * @author		Roger Noar
 * @package		Joomla
 * @subpackage	System
 */
class  plgSystemRedirect_Failed_Login extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemRedirect_Failed_Login(& $subject, $config)
	{
		parent::__construct($subject, $config);
		     // load plugin parameters
            $this->_plugin = & JPluginHelper::getPlugin( 'system', 'Redirect_Failed_Login' );
            $this->_params = new JParameter( $this->_plugin->params );
	}

	function onLoginFailure()
	{
		global $mainframe;

		$redirect_destination	=	$this->params->get('redirect_destination', 1);
		$redirect_message = $this->params->get('redirect_message', '');
		$time_delay = $this->params->get('time_delay', '');
		$clear_cache = $this->params->get('clear_cache', '');
		
		// Get current URL, if current URL matches the redirect URL, then no need to redirect
		// Prevents multiple redirections caused by onLoginFailure
		$uri =& JFactory::getURI();
		//$mainframe->enqueueMessage( 'URI is =' . $uri->toString() ) ;		
		if ( $time_delay != "0" ) {sleep ( (int)$time_delay ); }  // If a time delay is set, wait before proceeding
		if ( ($uri != $redirect_destination) && ($redirect_destination !='') ) {
			if ($clear_cache == "1") {			
			$cache = & JFactory::getCache();    // Reference the cache
			$cache->clean();// Clean the cache so you don't get stale page after redirection			
			}
			$mainframe->redirect( $redirect_destination, $redirect_message );
		}
			return true;	
	}
}
?>