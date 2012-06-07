<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: view.html.php 303 2010-11-17 12:24:26Z nikosdion $
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.view');

/**
 * Akeeba Backup Configuration Wizard view class for AJAX operations
 * 
 * Since Joomla!'s MVC doesn't allow for the controller to easily attach a single instance of the
 * model to the view, this View file acts as a controller :(
 *
 */
class AkeebaViewConfwiz extends JView
{
	function display()
	{
		$act = JRequest::getCmd('act','ping');
		
		if(method_exists($this, $act)) {
			$result = $this->$act();
		} else {
			$result = false;
		}
		
		$this->assign('result', $result);
		$this->setLayout('ajax');

		parent::display();
	}
	
	private function ping()
	{
		return true;
	}
	
	/**
	 * Try different values of minimum execution time
	 */
	private function minexec()
	{
		$seconds = JRequest::getFloat('seconds','0.5');

		if ($seconds < 1) { 
			usleep($seconds*1000000); 
		} else { 
			sleep($seconds);
		} 

		return true;
	}
	
	/**
	 * Saves the AJAX preference and the minimum execution time
	 * @return bool
	 */
	private function applyminexec()
	{
		// Get the user parameters
		$iframes = JRequest::getInt('iframes',0);
		$minexec = JRequest::getFloat('minecxec',2.0);
		
		// Save the settings
		$profile_id = AEPlatform::get_active_profile();
		$config = AEFactory::getConfiguration();
		$config->set('akeeba.basic.useiframe', $iframes);
		$config->set('akeeba.tuning.min_exec_time', $minexec * 1000);
		AEPlatform::save_configuration($profile_id);
		
		// Enforce the min exec time
		$timer = AEFactory::getTimer();
		$timer->enforce_min_exec_time(false);
		
		// Done!
		return true;
	}
	
	/**
	 * Try to make the directories writable or provide a set of writable directories
	 * @return bool
	 */
	private function directories()
	{
		$timer = AEFactory::getTimer();
		$model = JModel::getInstance('Confwiz','AkeebaModel');
		$result = $model->autofixDirectories();
		$timer->enforce_min_exec_time(false);
		return $result;
	}
	
	/**
	 * Analyze the database and apply optimized database dump settings
	 * @return bool
	 */
	private function database()
	{
		$timer = AEFactory::getTimer();
		$model = JModel::getInstance('Confwiz','AkeebaModel');
		$model->analyzeDatabase();
		$timer->enforce_min_exec_time(false);
		return true;
	}
	
	/**
	 * Try to apply a specific maximum execution time setting
	 * @return bool
	 */
	private function maxexec()
	{
		$seconds = JRequest::getInt('seconds', 30);
		$timer = AEFactory::getTimer();
		$model = JModel::getInstance('Confwiz','AkeebaModel');
		$result = $model->doNothing($seconds);
		$timer->enforce_min_exec_time(false);
		return $result;
	}
	
	/**
	 * Save a specific maximum execution time preference to the database
	 * @return bool
	 */
	private function applymaxexec()
	{
		// Get the user parameters
		$maxexec = JRequest::getInt('seconds',2);
		
		// Save the settings
		$timer = AEFactory::getTimer();
		$profile_id = AEPlatform::get_active_profile();
		$config = AEFactory::getConfiguration();
		$config->set('akeeba.tuning.max_exec_time', $maxexec);
		$config->set('akeeba.tuning.run_time_bias','75');
		$config->set('akeeba.advanced.scan_engine', 'smart');
		// @todo This should be an option (choose format, zip/jpa)
		$config->set('akeeba.advanced.archiver_engine', 'jpa');
		AEPlatform::save_configuration($profile_id);
		
		// Enforce the min exec time
		$timer->enforce_min_exec_time(false);
		
		// Done!
		return true;
	}

	/**
	 * Creates a dummy file of a given size. Remember to give the filesize
	 * query parameter in bytes!
	 */
	public function partsize()
	{
		$timer = AEFactory::getTimer();
		$blocks = JRequest::getInt('blocks', 1);
		
		$model = JModel::getInstance('Confwiz','AkeebaModel');
		$result = $model->createTempFile($blocks);

		if($result) {
			// Save the setting
			if($blocks > 80) $blocks = 16383; // Over 10Mb = 2Gb minus 128Kb limit (safe setting for PHP not running on 64-bit Linux)
			$profile_id = AEPlatform::get_active_profile();
			$config = AEFactory::getConfiguration();
			$config->set('engine.archiver.common.part_size', $blocks * 128 * 1024);
			AEPlatform::save_configuration($profile_id);
		}
		// Enforce the min exec time
		$timer->enforce_min_exec_time(false);
		
		return $result;
	}
	
}