<?php

class EsIoncubeHelper {
	
	static $ioncube_installed = null;
	function isIoncubeInstalled() {
		if (self::$ioncube_installed === null) {
			self::$ioncube_installed = function_exists('ioncube_read_file');
		}
		
		return self::$ioncube_installed;
	}
	
	function normalize_path($path){
		//TODO: da maha ../../ vuv puti6tata na failovete za da raboti ke6iraneto
	 
	    return $path;
	}
	
	static $required_files = array();
	/**
	 * Proveriava dali podadenia kriptiran fail e vuzmojen za include-vane - dali ima ionCube, dali faila su6testvuva, dali licenza e OK.
	 * Ne raboti ako metoda se izvika i licenza su6testvuva, exposed porpertitata mu sa OK, no e corrupted. Moje bi i pri drugi slu4ai kogato se izvikva
	 * custom handler-a. Ako samo edin fail ne e OK togava raboti - na vtoria put ionCube izvikvat exit() - stranni hora.
	 *
	 * @param string $file
	 * @return boolean - true ako scripta e include-nat uspe6no, false ako ne e
	 */
	function requireOnceEncryptedFile($file) {
		$res = true;
		$file = self::normalize_path($file);
		if (array_key_exists($file, self::$required_files) == false) {
			if (file_exists($file) == false) {
	        	self::showMessage("A required file is missing: '$file'. You should either reinstall the extension or deactivate/uninstall the plugin.");
	        	$res = false;
	        } else {
	        	$component_folder = self::getComponentPath($file);
//		        	echo '<br/>Component folder: '.$file;
	        	$ini_file = $component_folder.DS.'ioncube'.DS.'ioncube.settings.ini';
//		        echo '<br/>INI file: '.$ini_file;
		        //Check for license file only if the component is protected with a license file(the license settings file exists)
	        	if (file_exists($ini_file)) {
	        		
					if (self::isIoncubeInstalled() == false) {
						self::showMessage("The required ionCube loader is not installed.");
						$res = false;
					} else {
			        	$license_params = parse_ini_file($ini_file);
			        	$license_file_name = $license_params['LICENSE_FILE_NAME'];
			        	$license_file = self::getLicenseFile($license_file_name);
	//		        		echo '<br/>License file: '.$license_file;
			        	
			        	if (file_exists($license_file)) {
							$res = self::isLicenseFileValid($license_file, $license_params);
			        	} else {
			        		$res = false;
			        	}
					}
	        	}
	        	
	        	if ($res) {
			        $GLOBALS['es_license_error'] = false;
//	//			        echo '<br/>Including encrypted file: '.$file;
//				        
//	//			        register_shutdown_function(array('EsIoncubeHelper', 'sutdown_handler'));
			        ob_start();
			        include_once $file;
			        ob_end_clean();
			        
				    $has_error = $GLOBALS['es_license_error'];
//	//			        echo '<br/>Error: '.($has_error ? 'true' : 'false');
				    $res = ($has_error == false);
	        	}
	        }
			
			self::$required_files[$file] = $res;
		}
		
		return self::$required_files[$file];
	}
	function isLicenseFileValid($license_file, $license_params) {
		$res = false;
		
		$handle = fopen($license_file, 'r');
		if ($handle) {
		    $res = true;
		    while (!feof($handle)) {
		        $line = fgets($handle);
		        $rt = self::validateLine($line, $license_params);
		        $res = $res && $rt;
		        if (!$res) {
//		        	echo '<br/>Invalid line: '.$line;
		        	break;
		        }
		    }
		    fclose($handle);
		}
		
		return $res;
	}
	private function validateLine($line, $license_params) {
		$ind = strpos($line, ':');
		if ($ind !== false) {
			$prop_name = trim(substr($line, 0, $ind));
			$prop_value = trim(substr($line, $ind+1));
			
			if ($prop_name == 'esoftdomain') {
				$real_domain = $_SERVER['HTTP_HOST'];
				return (strpos($real_domain, $prop_value) !== false);
			} else if ($prop_name == 'esoftexpiration') {
				$current_time = time();
				return ($current_time < $prop_value);
			} else if ($prop_name == 'esoftedition') {
				$edition_str = $license_params['DISTRIBUTION_LICENSE_STRING'];
				return ($edition_str == $prop_value);
			} else if ($prop_name == 'esoftproduct') {
				$product_str = $license_params['PRODUCT_LICENSE_STRING'];
				return ($product_str == $prop_value);
			} else if ($prop_name == 'major') {
				$major_version = $license_params['MAJOR_VERSION'];
				return ($major_version == $prop_value);
			} else if ($prop_name == 'minor') {
				$minor_version = $license_params['MINOR_VERSION'];
				return ($minor_version == $prop_value);
			}
		}
		
		return true;
	}
	
	
	private function getComponentPath($component_file) {
		$components_path = JPATH_ADMINISTRATOR.DS.'components'.DS;
		$ind = strlen($components_path);
		$str = substr($component_file, $ind);
		$ind = strpos($str, '/');
		return $components_path.substr($str, 0, $ind);
	}
	private function getLicenseFile($license_file_name) {
		return JPATH_SITE.DS.$license_file_name;
	}
//	function sutdown_handler() {
//		echo '<br/>Including encrypted file: '.$file;
//	}
	
	
	function requireOnceEncryptedFiles(array $required_files) {
		$res = true;
		
		foreach ($required_files as $required_file) {
			$res = $res && self::requireOnceEncryptedFile($required_file);
			if ($res == false) return $res;
		}
		
		return $res;
	}

	function initializePlugin(array $required_files, $active_in_admin = false) {
		global $mainframe;
		
		if ($mainframe->isAdmin()) {
			if ($active_in_admin == false) return false;
		}
		
		$res = self::requireOnceEncryptedFiles($required_files);
		
		return $res;
	}
	
	function requireCommonUtilities() {
		$path_common = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_es_joomla_common'.DS.'helper.php';
		return self::requireOnceEncryptedFile($path_common);
	}
	
	
	function showMessage($msg, $admin_only = true, $msg_type = 'message') {
		global $mainframe;
		
		if ($admin_only && $mainframe->isAdmin() == false) {
			return;
		}
		
		$mainframe->enqueueMessage($msg, $msg_type);
	}
}
?>