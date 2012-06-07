<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage _ECR_SUBPACKAGE_
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

jimport('joomla.application.component.controller');

/**
 * Suggestion default Controller
 *
 * @package    Suggest Vote Comment Bribe
 * @subpackage Controllers
 */
class SuggestionsController extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access  public
	 */
	function display()
	{
		global $mainframe;
		$view = &JRequest::getVar('view');
		if(!$view)
		{
			#$this->setRedirect( 'index.php?option=com_suggestvotecommentbribe&view=suggestions','' );
			$mainframe->redirect( 'index.php?option=com_suggestvotecommentbribe&view=suggs','' );
		}

		parent::display();
		?>
<table width="100%">
	<tr>
		<td valign="middle" align="center"><?php JText::_('DONATE')?>
		<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr"
			method="post"><input type="hidden" name="cmd" value="_xclick"> <input
			type="hidden" name="business" value="bursar@Interpreneurial.com"> <input
			type="hidden" name="item_name"
			value="com_suggestvotecommentbribe donation"> <input type="hidden"
			name="currency_code" value="USD"> <input type="image"
			style='border: 0;'
			src="http://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0"
			name="submit"
			alt="Make payments with PayPal - it's fast, free and secure!"></form>
		</td>
	</tr>
</table>
		<?php
	}// function

}// class
?>