<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2006-2010 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @version $Id: ftpbrowser.php 304 2010-11-17 12:34:57Z nikosdion $
 * @since 3.0
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.model');

class AkeebaModelFtpbrowser extends JModel
{
	/** @var string The FTP server hostname */
	public $host = '';
	/** @var int The FTP server port number (default: 21) */
	public $port = 21;
	/** @var bool Should I use passive mode (default: yes) */
	public $passive = true;
	/** @var bool Should I use FTP over SSL (default: no) */
	public $ssl = false;
	/** @var string Username for logging in */
	public $username = '';
	/** @var string Password for logging in */
	public $password = '';
	/** @var string The directory to browse */
	public $directory = '';

	/** @var array Breadcrumbs to the current directory */
	public $parts = array();
	/** @var string Path to the parent directory */
	public $parent_directory = null;

	public function getListing()
	{
		$dir = $this->directory;

		// Parse directory to parts
		$parsed_dir = trim($dir,'/');
		$this->parts = empty($parsed_dir) ? array() : explode('/', $parsed_dir);
		
		// Find the path to the parent directory
		if(!empty($parts)) {
			$copy_of_parts = $parts;
			array_pop($copy_of_parts);
			if(!empty($copy_of_parts)) {
				$this->parent_directory = '/' . implode('/', $copy_of_parts);
			} else {
				$this->parent_directory = '/';
			}
		} else {
			$this->parent_directory = '';
		}

		// Connect to the server
		if($this->ssl) {
			$con = @ftp_ssl_connect($this->host, $this->port);
		} else {
			$con = @ftp_connect($this->host, $this->port);
		}
		if($con === false) {
			$this->setError(JText::_('FTPBROWSER_ERROR_HOSTNAME'));
			return false;
		}

		// Login
		$result = @ftp_login($con,$this->username,$this->password);
		if($result === false) {
			$this->setError(JText::_('FTPBROWSER_ERROR_USERPASS'));
			return false;
		}

		// Set the passive mode -- don't care if it fails, though!
		@ftp_pasv($con, $this->passive);

		// Try to chdir to the specified directory
		if(!empty($dir)) {
			$result = @ftp_chdir($con, $dir);
			if($result === false) {
				$this->setError(JText::_('FTPBROWSER_ERROR_NOACCESS'));
				return false;
			}
		}

		// Get a raw directory listing (hoping it's a UNIX server!)
		$list = @ftp_rawlist($con,'.');
		ftp_close($con);

		if($list === false) {
			$this->setError(JText::_('FTPBROWSER_ERROR_UNSUPPORTED'));
			return false;
		}

		// Parse the raw listing into an array
		$items = array();
		if(!empty($list)) foreach($list as $_)
			@preg_replace('`^(.{10}+)(\s*)(\d{1})(\s*)(\d*|\w*)(\s*)(\d*|\w*)(\s*)(\d*)\s([a-zA-Z]{3}+)(\s*)([0-9]{1,2}+)(\s*)([0-9]{2}+):([0-9]{2}+)(\s*)(.*)$`Ue','$items[]=array("rights"=>"$1","number"=>"$3","owner"=>"$5","group"=>"$7","file_size"=>"$9","mod_time"=>"$10 $12 $14:$15","file"=>"$17","type"=>(preg_match("/^d/","$1"))?"dir":"file");',$_);

		// Clean up the leading spaces
		$list = array();
		if(!empty($items)) foreach($items as $i) {
			if($i['type'] != 'dir') continue;
			$i['file'] = trim($i['file']);
			$list[] = $i;
		}

		return $list;
	}
}