<?php
/**
 * ReReplacer Import View Template
 *
 * @package     ReReplacer
 * @version     2.13.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<form onsubmit="return submitform()" action="<?php echo $this->request_url; ?>" method="post" name="adminForm" enctype="multipart/form-data">
	<input type="hidden" name="controller" value="item" />
	<input type="hidden" name="task" value="import" />

	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
			<td><?php echo JText::_( 'RR_CHOOSE_FILE' ); ?>: &nbsp;<input type="file" name="file"></td>
		</tr>
		<tr>
			<td>
				<?php echo JText::_( 'RR_PUBLISH_ITEMS' ); ?>
				<input type="radio" name="publish_all" id="publish_all0" value="0" />
				<label for="publish_all0"><?php echo JText::_( 'No' ); ?></label>
				<input type="radio" name="publish_all" id="publish_all1" value="1" />
				<label for="publish_all1"><?php echo JText::_( 'Yes' ); ?></label>
				<input type="radio" name="publish_all" id="publish_all2" value="2" checked="checked" />
				<label for="publish_all2"><?php echo JText::_( 'RR_AS_EXPORTED' ); ?></label>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="<?php echo JText::_( 'Upload' ); ?>"></td>
		</tr>
	</table>
</form>

<script language="javascript" type="text/javascript">
	/**
	* Submit the admin form
	*
	* small hack: let task decides where it comes
	*/
	function submitform()
	{
		var form = document.adminForm;
		var file = form.file.value;
		if ( file ) {
			dot = file.lastIndexOf(".");
			if ( dot != -1 ) {
				ext = file.substr( dot, file.length );
				if ( ext == '.rrbak' ) {
					return true;
				}
			}
		}
		alert('<?php echo JText::_( 'RR_PLEASE_CHOOSE_A_VALID_FILE' ); ?>');
		return false;
	}
</script>