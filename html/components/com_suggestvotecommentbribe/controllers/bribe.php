<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Controllers
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.controller');

class SuggestionControllerbribe extends JController
{
	var $cid;

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  ,    'edit' );
		$this->registerTask( 'unpublish',   'publish');

		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}
	function edit()
	{
		$model = $this->getModel( 'security' );
		$can=$model->canBribe(JRequest::getVar('SID'));
		if($can!==true)
		{
			$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs', $can );
		 return;
		}
		JRequest::setVar( 'view', 'bribe' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=bribes', $msg );
	}
	function save()
	{
		$db = &JFactory::getDBO();
		$params 	= &JComponentHelper::getParams('com_suggestvotecommentbribe');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
		$settings->max_title 	= $params->get('max_title',100);
		$settings->pubk 		= $params->get('pubk');
		$settings->prvk 		= $params->get('prvk');
		$settings->max_desc 	= $params->get('max_desc');
		$settings->email 		= $params->get('email');
		$settings->URL 			= $params->get('URL');
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';

		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

		// assign posted variables to local variables
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		if($_POST['mc_gross'])
		{
		$payment_amount = $_POST['mc_gross'];
		}
		else
		{
		$payment_amount = $_POST['mc_gross_1'];
		}
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		$UID=$_GET['UID'];
		if (!$fp) {
			// HTTP ERROR
		} else {
			fputs ($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
			}
			fclose ($fp);
			if (strcmp ($res, "VERIFIED") == 0)
			{
				if($payment_status=='Completed')
				{
					$user=JFactory::getUser($UID);
					$post['SID']=$_GET['SID'];
					$post['id']='0';
					$post['amount']=$payment_amount;
					$model = $this->getModel( 'bribe' );
					if ($model->store($post))
					{
						$model1 = $this->getModel( 'sugg' );
						JRequest::setVar('cid',array($post['SID']));
						$sugg=$model1->getData();
						$model1 = $this->getModel( 'log' );
						$post1['title']=$post['SID'];
						if($user->id)   $post1['description']=$user->name;
						else $post1['description']='Anonymous';
						$post1['description'].=' has bribed $'.$payment_amount.' to '.$sugg->title.' at '.date(DATE_RFC822);
						$model1->store($post1);
						$db = &JFactory::getDBO();
						$db->setQuery('update #__suggestvotecommentbribe_sugg set amountDonated=(select sum(amount) from #__suggestvotecommentbribe_bribe where SID='.$post['SID'].') where id='.$post['SID']);
						$db->query();
					}
				}
			}
		}
	}
}
