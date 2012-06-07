<?php
$uri = JURI::getInstance();
IonCubeLicenseHandler::$current_url = $uri->toString();
IonCubeLicenseHandler::$get_demo_url = IonCubeLicenseHandler::$current_url.'&action=gdl';
IonCubeLicenseHandler::$get_full_url = IonCubeLicenseHandler::$current_url.'&action=gfl';

IonCubeLicenseHandler::$license_params = parse_ini_file(dirname(__FILE__).DS.'ioncube'.DS.'ioncube.settings.ini');

$GLOBALS['es_license_error'] = true;

?>

<style>
	.proc_title {
		font-size: 13px;
		font-weight: bold;
		line-height: 20px;
		
	}
</style>

<script type="text/javascript">
	var current_url = '';
	function getFullLicense() {
		document.location.href = '<?php echo IonCubeLicenseHandler::$get_full_url; ?>&pkey='+document.lform.pkey.value;
	}
	function getDemoLicense() {
		document.location.href = '<?php echo IonCubeLicenseHandler::$get_demo_url; ?>';
	}

	function license_key_changed(kelm) {
		var btn = document.getElementById('btnGetFull');
		btn.disabled = !(kelm.value.length == 32);
	}
	
	function showInfoDiv() {
		var div = document.getElementById('server_info_div');
		div.style.display = 'block';
	}
</script>
<?php

function ioncube_event_handler($err_code, $params) {
	$current_url = IonCubeLicenseHandler::$current_url;
	$get_demo_url = IonCubeLicenseHandler::$get_demo_url;
	$get_full_url = IonCubeLicenseHandler::$get_full_url;
	$enless_url = IonCubeLicenseHandler::enless_url;
	
	$action = JRequest::getVar('action', '');
	
	//If the license file is a problem, check if the used license is inside the Joomla root. If not - FILE NOT FOUND
	if ($err_code == 7 || $err_code == 8 || $err_code == 9 || $err_code == 10 || $err_code == 11) {
		$file = $params['license_file'];
		if (strpos($file, JPATH_SITE) === false) {
			$err_code = 6;
		}
	}
	
	if ($action == 'show_info') {
		
	} else if ($action == 'gdl') {
		IonCubeLicenseHandler::getDemoLicense();
	} else if ($action == 'gfl') {
		IonCubeLicenseHandler::getFullLicense();
	} else {
		?>
		<div style="width: 600px;">
		<form name="lform" id="lform">
		<?php
		switch($err_code) { 
			case 1:
				?>
				<h1>Corrupt file was encountered.</h1>
				The file "<strong><?php echo $params['current_file']; ?></strong>" appears to be corrupt.
				<br/><br/>
				This may happen if you or someone else have edited the file.
				You need to replace the file with the original file from the product installation or reinstall the product.
				<br/><br/>
				<?php
				break;
			case 2:
				?>
				<h1>A file has expired.</h1>
				The file "<strong><?php echo $params['current_file']; ?></strong>" has expired.
				<br/><br/>
				<?php
				break;
			case 3:
				?>
				<h1>Permission denied.</h1>
				You don't have permissions to use the product on this server.
				<br/><br/>
				File: <strong><?php echo $params['current_file']; ?></strong>
				<br/><br/>
				<?php
				break;
			case 4:
				?>
				<h1>Date/time error.</h1>
				The date/time settings on this server seems incorrect.
				<br/><br/>
				Current date/time settings: <?php echo  date(DATE_RFC822, time()) ; ?>
				<br/><br/>
				<?php
				break;
			case 5: //Untrusted extension
			case 12: //Unauthorized including file
			case 13: //Unauthorized included file
			case 14: //Unauthorized append/prepend
				?>
				<h1>An error occured.</h1>
				A security-related error has occured.
				<br/><br/>
				Error code: <?php echo $err_code ; ?><br/>
				File: <strong><?php echo $params['current_file'] ; ?></strong>
				<br/><br/>
				<?php
				break;
			case 8: //License expired
			case 6: //No license file
	//			require 'error_ui.php';
				if (function_exists('ioncube_server_data')) {
					$sd = ioncube_server_data();
				}
				
				$err_msg = $err_code == 6 ? 'No license found.' : 'License expired.';
				
				?>
				<h1><?php echo $err_msg ; ?></h1>
				<?php if ($err_code == 6) { ?>
				The required license file "<?php echo JPATH_SITE.DS.IonCubeLicenseHandler::getLicenseParam('LICENSE_FILE_NAME') ; ?>" was not found.
				<br/>
				<?php } else { ?>
				The license for this product has expired.
				<br/><br/>
				License file: <strong><?php echo $params['license_file'] ; ?></strong>
				<br/>
				<?php } ?>
				<br/>
				
				<?php getLicenseAquirePage($err_code, $action); ?>
				
				<?php
				break; 
			case 7: 
				?>
				<h1>The license file is corrupt.</h1>
				The license file "<strong><?php echo $params['license_file']; ?></strong>" appears to be corrupt.
				<br/><br/>
				You must delete it and get an uncorrupted one. After you delete the file, refresh the page and you will be taken to the license acquire page.
				<br/><br/>
				If you think the file is not corrupt you may send us a copy for investigation.
				<br/><br/>
				<?php
				break;
			case 9: 
				?>
				<h1>Invalid license version.</h1>
				The license file "<strong><?php echo $params['license_file']; ?></strong>" is for another version of the product.
				<br/><br/>
				This usually happens when you upgrade the product you are using.
				<br/><br/>
				You must delete the existing license file and get one that is meant for the new version. After you delete the file, refresh the page and you will be taken to the license acquire page.
				If you use the full license of the product on this website you will need to specify the purchase key for the product. Note that upgrading a license is not considered as issuing a new license, 
				although a new license file is created.
				<br/><br/>
				If you think the license file should be valid and this error message is incorrect, you may send us a copy of the file for investigation. Don't forget to mention the product and version you are using and the domain and IP address of the server you are trying to use the product on.
				<br/><br/>
				<?php
				break;
			case 10: 
			case 11: 
				?>
				<h1>Invalid license file.</h1>
				The license file "<strong><?php echo $params['license_file']; ?></strong>" is invalid.
				<br/>
				Error code: <?php echo $err_code; ?>
				<br/><br/>
				This may happen if you unintentionally copied files from one server to another.
				<br/><br/>
				You must delete the invalid license file and get a valid one. After you delete the file, refresh the page and you will be taken to the license acquire page.
				<br/><br/>
				If you think the license file should be valid and this error message is incorrect, you may send us a copy of the file for investigation. Don't forget to mention the product and version you are using and the domain and IP address of the server you are trying to use the product on.
				<br/><br/>
				<?php
				break;
		}
		
		?>
		<hr/>
		<br/>
		If you have problems installing the product or have any other questions, please <a href="http://enless-soft.com/contactus" target="_blank">contact us</a>. To be able to help you, we will need some <a href="javascript:showInfoDiv();">info about your system</a>.
		<div id="server_info_div" style="display: none;">
			<h3>System info</h3>
			<?php echo IonCubeLicenseHandler::getServerInfo(); ?>
		</div>
		</form>
		</div>
		<?php
	}
}
function getLicenseAquirePage($err_code, $action) {
	$uri = JURI::getInstance();
	?>
	<?php if (!$action) {
	$auto_url = $uri->toString().'&action=gl_auto';
	$manual_url = $uri->toString().'&action=gl_manual';
	?>
		If this is the first time you try to use the extension on this domain, you can acquire a free evaluation license. Please, read further to understand how.
		<br/><br/>
		<hr /><br/>
		This page contains instructions on how to acquire/re-acquire both demo and full licenses for the product.
		<br/>
		<h4><a href="<?php echo $auto_url; ?>">Automated procedure</a></h4>
		The automated procedure is the recommended way to get a license. To use it your server needs to be connected to the internet.
		The license file is downloaded automatically in the necessary location.
		<br/>
		<br/>
		<h4><a href="<?php echo $manual_url; ?>">Manual procedure</a></h4>
		If your server is not connected to the Internet or there is a problem with the automated procedure, you can always get a license file manually.
		This is done through our website, so you still need Internet connection, but your server doesn't.
		<br/><br/>
	<?php } else if ($action == 'gl_auto') { ?>
		<hr />
		<h2>Get a license(automated procedure)</h2>
		<span class="proc_title">Evaluation license</span><br/>
		<?php if ($err_code == 6) { ?>
			You can obtain a free evaluation license for the product. An evaluation license is a fully functional license for a limited time period.
			It is meant only for evaluating the product and will stop working after that period has passed. After that you can always purchase the product
			and continue using it without loosing any data or settings.
			<br/><br/>
			<strong>Important: </strong> only one evaluation license could be issued for a domain/IP address pair. If you need additional time for evaluation, please contact us.
			<br/><br/>
			<input type="button" value="Get evaluation license" onClick="javascript:getDemoLicense();" <?php echo $err_code == 6 ? '' : 'disabled="disabled"'; ?> />
		<?php } else { ?>
			Your demo license has expired. A demo license is issued only once per domain/IP address. If you need additional time for evaluation, please contact us.
		<?php } ?>
		<br/>
		<br/>
		<span class="proc_title">Full license</span><br/>
		If you have purchased the product, you can get a full license from here.
		You need to enter in the text box below the product key you have recieved with the "Successful purchase" e-mail.
		If you have already acquired a full license for this domain, you don't need to enter the product key.
		<br/><br/>
		Purchase key: <input type="text" name="pkey" id="pkey" value="" size="40" maxlength="32" onchange="javascript:license_key_changed(this);" onkeyup="javascript:license_key_changed(this);" />&nbsp;<input id="btnGetFull" name="btnGetFull" type="button" value="Get license" onClick="javascript:getFullLicense();" disabled="disabled" />
		<br/><br/>
		<strong>Important: </strong> you may only request a limited number of full license files with your key. Be sure to use the key only from the real website(hosting server), not from test installations.
		<br/>
		<br/>
	<?php } else if ($action == 'gl_manual') { ?>
		<hr />
		<h2>Get a license(manual procedure)</h2>
		To get a license manually, follow this simple steps:
		<br/>
		<ol>
			<li>
				Copy the following text. You will be asked for it later.
				<br/><br/>
				<textarea readonly="readonly" cols="45" rows="10"><?php echo IonCubeLicenseHandler::getIonCubeServerData(); ?></textarea>
				<br/><br/>
			</li>
			<li>
				Go to our <a href="http://enless-soft.com/phplic" target="_blank">license creation web page</a> and follow the instructions. You must be able to acquire a license file.
				<br/><br/>
			</li>
			<li>
				Upload the license file in the following folder: <?php echo JPATH_SITE.DS.IonCubeLicenseHandler::getLicenseParam('LICENSE_FILE_NAME'); ?>
				<br/><br/>
			</li>
			<li>
				After all is done, refresh this page. You should be able to use the product.
			</li>
		</ol>
	<?php } ?>	
	<?php
}

class IonCubeLicenseHandler {
	const enless_url = 'https://enless-soft.com/index.php';
	static $get_demo_url;
	static $get_full_url;
	static $current_url;
	static $license_params = array();
	
	function getLicenseParam($param_name) {
		return self::$license_params[$param_name];
	}
	
	function getDemoLicense() {
		self::getLicense('gdl');
	}
	function getFullLicense() {
		self::getLicense('gfl');
	}
	function reacquireLicense() {
		self::getLicense('gel');
	}
	function getLicense($task) {
		$sd_part = self::getServerDataQueryPart();
		
		$function_part = 'option=com_user&task='.$task;
		if ($task == 'gfl') {
			$key = JRequest::getVar('pkey');
			$function_part .= '&pkey='.urlencode($key);
		}
		
		$product_part = self::getProductSpecificQueryPart();
		
		$query = $function_part.'&'.$product_part.'&'.$sd_part;
		
		self::executeQueryAndGetResult(self::enless_url, $query);
	}
	function getProductSpecificQueryPart() {
		$product_key = self::getLicenseParam('PRODUCT_LICENSE_STRING');
		$dist_key = self::getLicenseParam('DISTRIBUTION_LICENSE_STRING');
		$version_major = self::getLicenseParam('MAJOR_VERSION');
		$version_minor = self::getLicenseParam('MINOR_VERSION');
		
		$params = 'pstr='.urlencode($product_key).'&dstr='.urlencode($dist_key).'&major='.$version_major.'&minor='.$version_minor;
		
		return $params;
	}
	function getServerDataQueryPart() {
		$sd = self::getIonCubeServerData();
		if ($sd) {
			return 'sd='.urlencode($sd);
		} else {
			return null;
		}
	}
	function getIonCubeServerData() {
		$sd = null;
		if (function_exists('ioncube_server_data')) {
			$sd = ioncube_server_data();
		}
		return $sd;
	}
	function executeQueryAndGetResult($url, $query) {
		$output_file = JPATH_SITE.DS.self::getLicenseParam('LICENSE_FILE_NAME');
		
//		echo '<br/>url: '.$url;
//		echo '<br/>query: '.$query;
		
//		$fp = fopen($output_file, "w+");
		$ch = curl_init($url);
	
	//	curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_POST, 1);
		$res = curl_exec($ch);
		if ($res === false) {
			echo '<br/>error: ('.curl_errno($ch).')'.curl_error($ch);
		} else {
			$separator = '-l-i-c-e-n-s-e--f-i-l-e-';
			$ind = strpos($res, $separator);
			if ($ind !== false) {
				$msg = substr($res, 0, $ind);
				$license_string = substr($res, $ind+strlen($separator));
			} else {
				$msg = $res;
				$license_string = null;
			}
			
			echo $msg;
			
			if ($license_string) {
				$file_written = true;
				
				$fp = fopen($output_file, "w");
				if ($fp) {
					fwrite($fp, $license_string);
					fclose($fp);
				}
				if (file_exists($output_file) == false) $file_written = false;
				
				echo '<br/><br/>';
				if ($file_written) {
					echo 'License file was returned for your request. Please, refresh this page to use the product.';
				} else {
					$info = pathinfo($output_file);
					$folder = $info['dirname'];
					$file = $info['basename'];
					
					echo '<strong>WARNING:</strong> License file was successfully returned for your request but an error occured while saving it to the appropriate location. You will have to do it manually.<br/><br/>';
					echo '<strong><u>Instructons</u>:</strong> <br/>';
					echo '<strong>Step 1.</strong> Create a file named "<strong>'.$file.'</strong>" in folder "<strong>'.$folder.'</strong>"(this should be the Joomla root folder) on your server.<br/>';
					echo '<strong>Step 2.</strong> Copy the following to the file(including the bottom dashes): <pre>'.$license_string.'</pre><br/>';
					echo '<strong>Step 3.</strong> Refresh this page. The extension should work.<br/>';
					echo '<br/><br/>We are sorry for the inconvenience. This error is most often caused by some security permissions on your server.
					This doesn\'t mean that the security settings are not correct, it just does not allow us to write the file automatically for you.
					If you still have problems, please contact us, specifying your exact actions and the exact error message you get.';
				}
			}
			
//			echo '<br/><br/>result: '.$res;
			
		}
		curl_close($ch);
	
//		fclose($fp);
	}
	
	function getServerInfo() {
		$html = '';
		
		$product_key = self::getLicenseParam('PRODUCT_LICENSE_STRING');
		$dist_key = self::getLicenseParam('DISTRIBUTION_LICENSE_STRING');
		$version_major = self::getLicenseParam('MAJOR_VERSION');
		$version_minor = self::getLicenseParam('MINOR_VERSION');
		
		$html .= 'PHP version: '.PHP_VERSION.'<br/>';
		$html .= 'Joomla version: '.JVERSION.'<br/>';
		if (function_exists('ioncube_loader_version')) $html .= 'ionCube loader version: '.ioncube_loader_version().'<br/>';
		$html .= 'Product: '.$product_key.'<br/>';
		$html .= 'Edition: '.$dist_key.'<br/>';
		$html .= 'Version: '.$version_major.'.'.$version_minor.'<br/>';
		$html .= 'Server info:<br/>';
		$sd = self::getIonCubeServerData();
		if ($sd) {
			$html .= $sd;
		} else {
			$html .= 'Unable to get server info. This is probably caused by ionCube loader not being installed.';
		}
		
		return $html;
	}
	
}

?>