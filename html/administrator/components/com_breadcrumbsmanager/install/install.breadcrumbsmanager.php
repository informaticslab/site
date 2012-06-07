<?php

	if (class_exists('EnlessSoftCustomInstaller') == false) {
		require_once dirname(__FILE__).DS.'include.php';
	}

	EnlessSoftCustomInstaller::processInstallationFile(dirname(__FILE__).DS.'install.settings.txt', false);
	
	
?>