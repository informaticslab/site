<?php
/********************************************************************
Copyright 2009-2010 Chris Gaebler
Version :	3.xx
Date    :	11 October 2010
Description:  A flexible contact component with configurable fields
Please see the pdf documentation at http://extensions.lesarbresdesign.info
*********************************************************************
This file is part of FlexiContact
FlexiContact is free software. You can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation.
*********************************************************************/

defined('_JEXEC') or die('Restricted Access'); 

require_once(JApplicationHelper::getPath('front_html'));

if (file_exists(JPATH_ROOT.DS.'LA.php'))
	require_once JPATH_ROOT.DS.'LA.php';

// try to get parameters from the active menu item

$menus	= &JSite::getMenu();
$item	= $menus->getActive();
if ($item != null)			// is there an active menu item ?
	{
	$itemid = $item->id;
	$params = new JParameter($item->params);
	}
else
	if ($itemid != null)	// if not, was a menu item id passed in?
		$params = getParams($id);

if ($params == null)
	{
	echo "Unable to get menu parameters";
	return;
	}

define ("LOG_DATE_FORMAT", "d/m/y H:i:s");
define ("LOG_FILENAME", "flexicontact_log.txt");

$myuri =& JFactory::getURI(); // Get our actual URI, to be able to come back here...	

// Get the parameters that were specified on the menu item

$configData = array();			// array of config data

$configData['page_title'] = $params->get('page_hdr'); // can't have a parameter called page_title for some reason
$configData['page_text'] = $params->get('page_text');
$configData['image'] = $params->get('image');
$configData['imgpath'] = JURI::base().'images/'.$configData['image'];
$configData['image_align'] = $params->get('image_align');
$configData['num_images'] = $params->get('num_images');
$configData['magic_word'] = $params->get('magic_word');
$configData['subject'] = $params->get('subject');
$configData['default_subject'] = $params->get('default_subject');
$configData['toPrimary'] = $params->get('toPrimary');
$configData['cc'] = $params->get('ccAddress');
$configData['bcc'] = $params->get('bccAddress');
$configData['autofill'] = $params->get('autofill');
$configData['list_opt'] = $params->get('list_opt');
$configData['list_prompt'] = $params->get('list_prompt');
$list_list = $params->get('list_list');
$list_list = str_replace("\r","",$list_list);			// remove any CR's
$list_list = str_replace("\n","",$list_list);			// remove any LF's
$configData['list_array'] = explode(",",$list_list);	// make it an aray
$configData['list_count'] = count($configData['list_array']);
$configData['line1_opt'] 		= $params->get('opt1');
$configData['line1_prompt'] 	= $params->get('prompt1');
$configData['line2_opt'] 		= $params->get('opt2');
$configData['line2_prompt'] 	= $params->get('prompt2');
$configData['line3_opt'] 		= $params->get('opt3');
$configData['line3_prompt'] 	= $params->get('prompt3');
$configData['line4_opt'] 		= $params->get('opt4');
$configData['line4_prompt'] 	= $params->get('prompt4');
$configData['line5_opt'] 		= $params->get('opt5');
$configData['line5_prompt'] 	= $params->get('prompt5');
$configData['area_opt'] = $params->get('area-opt');
$configData['area_prompt'] = $params->get('area-prompt');
$configData['area_width'] = $params->get('area-width');
$configData['area_height'] = $params->get('area-height');
$configData['bottom_text'] = $params->get('bottom_text');

// get data from form or initialise it

$formData = array();							// initialise the array of form data

// if a user is logged in, pre-fill the username and frem address

$user_name = '';
$user_email = '';
$user =& JFactory::getUser();
if ($user)
	{
	switch ($configData['autofill'])
		{
		case 'username':
			$user_name = $user->username;
			$user_email = $user->email;
			break;
		case 'name':
			$user_name = $user->name;
			$user_email = $user->email;
			break;
		}
	}

$formData['fromName'] = JRequest::getVar('fromName',$user_name);
$formData['fromAddress'] = JRequest::getVar('fromAddress',$user_email);
$formData['subject'] = JRequest::getVar('subject',$configData['default_subject']);
$formData['copyMe'] = JRequest::getVar('copyMe','');
$formData['list1'] = JRequest::getVar('list1','');
$formData['line1'] = JRequest::getVar('line1','');
$formData['line2'] = JRequest::getVar('line2','');
$formData['line3'] = JRequest::getVar('line3','');
$formData['line4'] = JRequest::getVar('line4','');
$formData['line5'] = JRequest::getVar('line5','');
$formData['area_data'] = JRequest::getVar('area_data','');
$formData['magic_word'] = JRequest::getVar('magic_word','');
$formData['pic_selected'] = JRequest::getVar('picselected','');
$formData['pic_requested'] = JRequest::getVar('picrequested','');

// initialise error message array

$errorMessages = array();						// initialise the array of error messages
$errorMessages['imageTest'] = '';
$errorMessages['fromName'] = '';
$errorMessages['fromAddress'] = '';
$errorMessages['subject'] = '';
$errorMessages['list'] = '';
$errorMessages['line1'] = '';
$errorMessages['line2'] = '';
$errorMessages['line3'] = '';
$errorMessages['line4'] = '';
$errorMessages['line5'] = '';
$errorMessages['area_data'] = '';
$errorMessages['magic_word'] = '';
$validation_result = true;

// if $task is 'send', we have come back here with data from the form

if ($task == 'send')
	{
	$validation_result = HTML_flexicontact::validateInput($configData,$formData,$errorMessages);
	if ($validation_result)
		{
		$status = sendEmail($configData,$formData);						// it's ok so send the email
		HTML_flexicontact::displayConfirmation($configData,$status);	// and display confirmation
		$task = '';
		return;
		}
	}
		
// if we got here, either we just came in here, or we failed validation.

HTML_flexicontact::displayForm($configData,$formData,$errorMessages,$itemid,$validation_result,$myuri);

return;

//-----------------------------------------
// Get client's IP address
//
function getIPaddress()
{
	if (isset($_SERVER["REMOTE_ADDR"]))
		return $_SERVER["REMOTE_ADDR"];
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	if (isset($_SERVER["HTTP_CLIENT_IP"]))
		return $_SERVER["HTTP_CLIENT_IP"];
	return "unknown";
} 

//-------------------------------------------------------------------------------
// Get client's browser
//
function getBrowser() 
{
	$known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
//	$pattern = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
	$pattern = '#(?P<browser>' . join('|', $known).')[/ ]+(?P<version>[0-9]+(?:\.[0-9]+)?)#';
	if (!preg_match_all($pattern, $agent, $matches)) 
		return array();
	$i = count($matches['browser'])-1;		// use the last match
	return $matches['browser'][$i].' '.$matches['version'][$i];
}

// -------------------------------------------------------------------------------
// Send the email - returns true on success
//
function sendEmail($configData,$formData)
{
// build the message body from the configured fields

	$body = "From ".$formData['fromName']." at ".$formData['fromAddress']."\r\n";
	if (!empty($formData['list1']))
		$body .= $configData['list_prompt'].": ".$configData['list_array'][$formData['list1']]."\r\n";
	if (!empty($formData['line1']))
		$body .= $configData['line1_prompt'].": ".$formData['line1']."\r\n";
	if (!empty($formData['line2']))
		$body .= $configData['line2_prompt'].": ".$formData['line2']."\r\n";
	if (!empty($formData['line3']))
		$body .= $configData['line3_prompt'].": ".$formData['line3']."\r\n";
	if (!empty($formData['line4']))
		$body .= $configData['line4_prompt'].": ".$formData['line4']."\r\n";
	if (!empty($formData['line5']))
		$body .= $configData['line5_prompt'].": ".$formData['line5']."\r\n";
	if (!empty($formData['area_data']))
		$body .= $configData['area_prompt'].": ".$formData['area_data']."\r\n";

// make sure the body and subject don't contain anything they shouldn't

	jimport('joomla.mail.helper');
	$body = JMailHelper::cleanBody($body);
	$subject = JMailHelper::cleanSubject($formData['subject']);

// get the client information

	$ip = getIPaddress();
	$ipmsg = "[".$ip.", ".getBrowser()."]\r\n";

// from version 2.11 we now send the mail using the Joomla sendMail function (instead of php mail)
// which uses the mail settings configured in Joomla Global Configuration

	$app = &JFactory::getApplication();
	$from = $app->getCfg('mailfrom');
	$fromname = $app->getCfg('fromname');
	$recipient = $configData['toPrimary'];
	$cc = $configData['cc'];
	$bcc = $configData['bcc'];
	$replyto = $formData['fromAddress'];
	$replytoname = $formData['fromName'];
	
// from version 2.15 we build the mail object ourselves so that we can get at the ErrorInfo

	$mail =& JFactory::getMailer();
	$mail->setSender(array($from, $fromname));
	$mail->setSubject($subject);
	$mail->setBody($body.$ipmsg);
	$mail->addRecipient($recipient);
	if ($cc != '')
		$mail->addCC($cc);
	if ($bcc != '')
		$mail->addBCC($bcc);
	$mail->addReplyTo(array($replyto, $replytoname));
	$ret_main = $mail->Send();
	if ($ret_main === true)
		$status = "Sent OK\r\n";
	else
		$status = "Mail was NOT accepted for delivery (".$mail->ErrorInfo.")\r\n";
	
	logText(JText::_('SUBJECT').": $subject\r\n".
		"To: $recipient\r\n".
		"From: $fromname at $from\r\n".
		"Cc: $cc\r\n".
		"Bcc: $bcc\r\n".
		"ReplyTo: $replytoname at $replyto\r\n".
		$ipmsg.
		$body.
		$status.
		"-------------------------\r\n");
	
// if the user wanted a copy, send that separately

	if ($formData['copyMe'] == 1)
		{
		$mail =& JFactory::getMailer();
		$mail->setSender(array($from, $fromname));
		$mail->setSubject($subject);
		$mail->setBody($body);
		$mail->addRecipient($formData['fromAddress']);
		$ret_copy = $mail->Send();
		if ($ret_copy === true)
			$status = "Sent OK\r\n";
		else
			$status = "Mail was NOT accepted for delivery (".$mail->ErrorInfo.")\r\n";
		logText("Copy to: $recipient\r\n".
			$status.
			"-------------------------\r\n");
		}
	return $ret_main;
}

//-----------------------------------------
// log to a text file
//
function logText($text)
{
	$basePath = dirname( __FILE__ );
	$logPath = $basePath.'/'.LOG_FILENAME;
	$handle = @fopen($logPath, 'a+');
	if ($handle === false)
		return;						// we don't have permission to create the file
	fwrite($handle, date(LOG_DATE_FORMAT)."\r\n".$text);
	fclose($handle);
}

