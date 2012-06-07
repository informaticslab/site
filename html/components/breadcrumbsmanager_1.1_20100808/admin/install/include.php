<?php

class EnlessSoftCustomInstaller {
	const EXISTING_FILES_OVERWRITE = 'overwrite';
	const EXISTING_FILES_REPLACE = 'replace';
	const EXISTING_FILES_SKIP = 'skip';
	
	const SEPARATOR = '----------------------------------------------------------------------------------------------------';
	
	function processInstallationFile($install_file = null, $uninstall = false) {
		//Note: $install_file must be given in the argument when more than one components with custom installation scripts are installed at once
		if (!$install_file) $install_file = dirname(__FILE__).DS.'install.settings.txt';
		
		ob_start();
		
		$res = true;
		if (file_exists($install_file)) {
			$fh = fopen($install_file, 'r');
			if ($fh) {
			    while (!feof($fh)) {
			        $line = fgets($fh);
			        $props = explode(',', $line);
			        $params = array();
			        foreach ($props as $prop) {
			        	$kvp = explode('=', $prop);
			        	$params[trim($kvp[0])] = trim($kvp[1]);
			        }
			        
			        $result = self::processInstallAction($params, $uninstall, dirname($install_file));
			        
			        if ($result) {
			        	self::showMessage('Error: '.$result);
			        }
			        $res = $res && (bool)$result;
			    }
			    fclose($fh);
			}
			
		} else {
			self::showMessage('Installation settings file not found: '.$install_file);
		}
		
		$output = ob_get_clean();
		if ($output) {
			self::showMessage('Performing additional installation actions...');
			self::showMessage('');
			self::showMessage(self::SEPARATOR);
			echo $output;
		}
		
		
		global $mainframe;
//		$v = $mainframe->getMessageQueue();
//		print_r($v);
		
        self::showMessage('');
        self::showMessage('');
		self::showMessage('Product ' .($uninstall ? 'uninstalled' : 'installed'). ' successfully.');
		
		return false;
	}
	private function processInstallAction(array $params, $uninstall = false, $base_folder = '') {
		$action = $params['action'];
		
		if ($action == 'install-archive') {
			if ($uninstall) {
				$do_uninstall = ($params['uninstall'] == 'true');
				if (!$do_uninstall) return '';
				
				$type = $params['type'];
				$name = $params['name'];
				
				self::showMessage('Uninstalling extension: '.$type.' "'.$name.'"...');
				
				$db	= & JFactory::getDBO();
				$query = 'SELECT id FROM '.self::$ext_type_tables[$type].' WHERE '.self::$ext_type_fields[$type].' = '.$db->Quote($name);
		        $db->setQuery($query);
		        $id = $db->loadResult();
				
		        if (!$id) {
					self::showMessage('Unable to uninstall extension: '.$type.'" '.$name.'"');
		        } else {
					$result = self::uninstallExtension($type, array($id => 0));
					if ($result) {
						self::showMessage('Extension uninstalled successfully: '.$type.'" '.$name.'"');
					} else {
						self::showMessage('Unable to uninstall extension: '.$type.'" '.$name.'"');
					}
		        }
			} else {
				$file = $params['file'];
				self::showMessage('Installing extension from package: '.$file.'...');
				$path = $base_folder.DS.$file;
				if (file_exists($path) == false) {
					return 'Package installation failed. The file "'.$path.'" was not found.';
				}
				$res = self::installPackage($path);
//				self::showMessage('Result: '.($res ? 'successful' : 'failed'));
			}
			self::showMessage(self::SEPARATOR);
		} else if ($action == 'move') {
			$src = $params['src'];
			$src = self::parsePath($src, $base_folder);
			$dest = $params['dest'];
			$dest = self::parsePath($dest, $base_folder);
			
			$type = $params['type'];
			if ($uninstall) {
				return '';
			} else {
				$existing_action = $params['existing'] == 'overwrite';
//				self::showMessage('Moving '.($type == 'folder' ? 'folder' : 'file').': "'.$src.'" -&gt; "'.$dest.'"');
				if ($type == 'folder') {
					jimport('joomla.filesystem.folder');
					if (file_exists($src)) {
						if (file_exists($dest)) {
							if ($existing_action == self::EXISTING_FILES_REPLACE) {
								unlink($dest);
							} else if ($existing_action == self::EXISTING_FILES_SKIP) {
								return '';
							}
						}
						if (file_exists($dest) == false) mkdir($dest);
						$res = JFolder::copy($src, $dest, '', true);
						JFolder::delete($src);
					}
				} else {
					jimport('joomla.filesystem.file');
					if (file_exists($src)) {
						if (file_exists($dest) && $existing_action == self::EXISTING_FILES_SKIP) {
							$res = '';
						} else {
							$res = JFile::move($src, $dest);
						}
					}
				}
//				self::showMessage('Result: '.($res ? $res : 'successful'));
			}
		} else if ($action == 'remove-site-link') {
			if ($uninstall) {
				return '';
			}
			
			$component_name = $params['name'];
			$db	= & JFactory::getDBO();
			$query = 'UPDATE #__components AS c SET link = '.$db->Quote('').' WHERE c.option = '.$db->Quote($component_name);
	        $db->setQuery($query);
	        $db->query();
		} else if ($action == 'remove-admin-link') {
			if ($uninstall) {
				return '';
			}
			
			$component_name = $params['name'];
			$db	= & JFactory::getDBO();
			$query = 'UPDATE #__components AS c SET admin_menu_link = '.$db->Quote('').' WHERE c.option = '.$db->Quote($component_name);
	        $db->setQuery($query);
	        $db->query();
		} else if ($action == 'enable-plugin') {
			if ($uninstall) {
				return '';
			}
			
			$plugin_name = $params['name'];
	        self::enqueueMessage('Trying to enable plugin: '.$plugin_name.'...');
			$db	= & JFactory::getDBO();
			$query = 'UPDATE #__plugins AS p SET published = 1 WHERE p.element = '.$db->Quote($plugin_name);
	        $db->setQuery($query);
	        $db->query();
	        self::enqueueMessage('Plugin enabled: '.$plugin_name);
			self::showMessage(self::SEPARATOR);
		} else {
			return 'Unknown install action: '.$action.'';
		}
		
		return '';
	}
	private function showMessage($message) {
		echo '<br/>'.$message;
	}
	private function parsePath($path, $current_folder = null) {
		if ($current_folder === null) $current_folder = dirname(__FILE__);
		$path = str_replace('JPATH_ADMINISTRATOR', JPATH_ADMINISTRATOR, $path);
		$path = str_replace('JPATH_SITE', JPATH_SITE, $path);
		$path = str_replace('JPATH_ROOT', JPATH_ROOT, $path);
		$path = str_replace('JPATH_BASE', JPATH_BASE, $path);
		$path = str_replace('{CURRENT}', $current_folder, $path);
		return $path;
	}
	
	const EXT_TYPE_COMPONENT = 'component';
	const EXT_TYPE_PLUGIN = 'plugin';
	const EXT_TYPE_MODULE = 'module';
	static $ext_type_tables = array (
		self::EXT_TYPE_COMPONENT => '#__components',
		self::EXT_TYPE_PLUGIN => '#__plugins',
		self::EXT_TYPE_MODULE => '#__modules',
	);
	static $ext_type_fields = array (
		self::EXT_TYPE_COMPONENT => 'option',
		self::EXT_TYPE_PLUGIN => 'element',
		self::EXT_TYPE_MODULE => 'module',
	);
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $type
	 * @param array $eid - an associative array: key=extension_id, value=clientID(o=site,1=admin)
	 * @return unknown
	 */
	function uninstallExtension($type, $eid) {
		global $mainframe;

		// Initialize variables
		$failed = array();

		/*
		 * Ensure eid is an array of extension ids in the form id => client_id
		 */
		if (!is_array($eid)) {
			$eid = array($eid => 0);
		}

		// Get a database connector
		$db =& JFactory::getDBO();

		// Get an installer object for the extension type
		jimport('joomla.installer.installer');
		$installer = new JInstaller();
		$installer->setAdapter($type, null);

		// Uninstall the chosen extensions
		foreach ($eid as $id => $clientId) {
			$id = trim( $id );
			$result	= $installer->uninstall($type, $id, $clientId);

			// Build an array of extensions that failed to uninstall
			if ($result === false) {
				$failed[] = $id;
			}
		}

		if (count($failed)) {
			// There was an error in uninstalling the package
			$msg = JText::sprintf('UNINSTALLEXT', JText::_($type), JText::_('Error'));
			$result = false;
		} else {
			// Package uninstalled sucessfully
			$msg = JText::sprintf('UNINSTALLEXT', JText::_($type), JText::_('Success'));
			$result = true;
		}

		$mainframe->enqueueMessage($msg);

		return $result;
	}
	function installPackage($archive_path) {
		global $mainframe;
	
//		$this->setState('action', 'install');
	
		$package = self::getPackageFromArchive($archive_path);
	
		// Was the package unpacked?
		if (!$package) {
//			$this->setState('message', 'Unable to find install package.');
			return false;
		}
	
		// Get an installer instance
//		$installer =& JInstaller::getInstance();
		$installer = new JInstaller();
	
		// Install the package
		if (!$installer->install($package['dir'])) {
			// There was an error installing the package
			$msg = JText::sprintf('INSTALLEXT', JText::_($package['type']), JText::_('Error'));
			$result = false;
		} else {
			// Package installed sucessfully
			$msg = JText::sprintf('INSTALLEXT', JText::_($package['type']), JText::_('Success'));
			$result = true;
		}
		
		$xml = $installer->getManifest();
		$root = $xml->document;
		$ext_type = $root->attributes('type');
		foreach($root->children() as $child) {
			if ($child->name() == 'name') {
				$ext_name = $child->data();
			}
		}
		if ($ext_type == 'component') {
			$ext_name = $installer->message;
		}
		
		if ($ext_name) {
			if ($result == true) {
				self::enqueueMessage("Extension installed successfully: <strong>$ext_name ($ext_type)</strong>");
//				echo "<h3>$ext_name ($ext_type)</h3>";
//				echo '<p>'.$installer->message.'</p>';
			} else {
				self::enqueueMessage("Error installing extension: <strong>$ext_name ($ext_type)</strong>");
			}
		}
	
		// Set some model state values
//		$mainframe->enqueueMessage($msg);
//		$this->setState('name', $installer->get('name'));
//		$this->setState('result', $result);
//		$this->setState('message', $installer->message);
//		$this->setState('extension.message', $installer->get('extension.message'));
	
		// Cleanup the install files
		if (!is_file($package['packagefile'])) {
			$config =& JFactory::getConfig();
			$package['packagefile'] = $config->getValue('config.tmp_path').DS.$package['packagefile'];
		}
	
		//Da se pregleda - kato e otkomentirano ne raboti, kato e zakomentirane no iztriva failovete ot vremennata papka
		//JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);
	
		return $result;
	}
	function getPackageFromArchive($archive_path) {
		if (file_exists($archive_path) == false) return false;
		
		// Build the appropriate paths
		$config =& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.basename($archive_path);
		$tmp_src	= $archive_path;
//		self::showMessage('source: '.$tmp_src);
//		self::showMessage('dest: '.$tmp_dest);
	
		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::move($tmp_src, $tmp_dest);
	
//		self::showMessage('Unpacking extension package...');
		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest);
	
		return $package;
	}
	
	
	function enqueueMessage($msg) {
		self::showMessage($msg);
	}
	
}

?>