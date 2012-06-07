<?php
/**
 * ReReplacer Item View Template
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

// Import modal
JHTML::_( 'behavior.modal' );
// Import html tooltips
JHTML::_( 'behavior.tooltip' );

jimport( 'joomla.html.pane' );
$pane =& JPane::getInstance( 'sliders', array( 'allowAllClose' => true, 'startOffset' => 0, 'startTransition' => true ) );

JPlugin::loadLanguage( 'com_content' );

$has_k2 = JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'admin.k2.php' );
$has_mr = JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_resource'.DS.'resource.php' );
$has_zoo = JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zoo'.DS.'zoo.php' );

$view_state = $this->detail->view_state;
if ( $view_state == -1 ) {
	$config =& JComponentHelper::getParams( 'com_rereplacer' );
	$view_state = $config->get( 'view_state', 1 );
}

$script = "
	function changeView( val ) {
		document.getElementById('paramsview_state'+val).click();
		document.getElementById('view_state_div').removeClass('view_state_0').removeClass('view_state_1').removeClass('view_state_2').addClass('view_state_'+val);
	}
";
$doc =& JFactory::getDocument();
$doc->addScriptDeclaration( $script );
?>

<form action="<?php echo JRoute::_( $this->request_url ) ?>" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="item" />
	<input type="hidden" name="has_k2" value="<?php echo $has_k2; ?>" />
	<input type="hidden" name="has_mr" value="<?php echo $has_mr; ?>" />
	<input type="hidden" name="has_zoo" value="<?php echo $has_zoo; ?>" />

	<div style="display:none;">
		<?php echo str_replace( 'value="'.$view_state.'"', 'value="'.$view_state.'" checked="checked"', str_replace( 'checked="checked"', '', $this->detail->_xml->render( 'params', 'view_state' ) ) ); ?>
	</div>

	<div class="view_state_<?php echo $view_state; ?>" id="view_state_div">
		<div class="button1 button_view_state simple"><div><a onclick="changeView( 0 );" class="hasTip" title="<?php echo JText::_( 'RR_SIMPLE' ).'::'.JText::_( 'RR_SIMPLE_DESC' ); ?>"><?php echo JText::_( 'RR_SIMPLE' ); ?></a></div></div>
		<div class="button1 button_view_state normal"><div><a onclick="changeView( 1 );" class="hasTip" title="<?php echo JText::_( 'RR_NORMAL' ).'::'.JText::_( 'RR_NORMAL_DESC' ); ?>"><?php echo JText::_( 'RR_NORMAL' ); ?></a></div></div>
		<div class="button1 button_view_state advanced"><div><a onclick="changeView( 2 );" class="hasTip" title="<?php echo JText::_( 'RR_ADVANCED' ).'::'.JText::_( 'RR_ADVANCED_DESC' ); ?>"><?php echo JText::_( 'RR_ADVANCED' ); ?></a></div></div>
	</div>

	<div class="clr"></div>

	<p><?php echo JText::_( 'RR_ITEM_INFORMATION' ); ?></p>

	<div class="clr"></div>

	<table width="100%">

		<tr>
			<td valign="top">
				<div class="col" style="width:100%;">
					<fieldset class="adminform">
						<legend><?php echo JText::_( 'RR_DETAILS' ); ?></legend>
						<?php echo $this->detail->_xml->render(); ?>
					</fieldset>
					<fieldset class="adminform">
						<legend><?php echo JText::_( 'RR_SEARCH_REPLACE' ); ?></legend>
						<?php echo $this->detail->_xml->render( 'params', 'search' ); ?>
					</fieldset>
					<fieldset class="adminform">
						<legend><?php echo JText::_( 'RR_SYNTAX_HELP' ); ?></legend>
						<?php
							$user =& JFactory::getUser();
							$_tick = '<img src="components/com_rereplacer/images/tick.png" border="0" alt="'.JText::_( 'Yes' ).'" title="'.JText::_( 'Yes' ).'" />';
							$_cross = '<img src="components/com_rereplacer/images/publish_x.png" border="0" alt="'.JText::_( 'No' ).'" title="'.JText::_( 'No' ).'" />';
						?>
						<p><?php echo JText::_( 'RR_OVERVIEW_OF_EXTRA_CODES' ); ?></p>

						<table class="adminlist" style="width:auto;">
							<thead>
								<tr>
									<th><label><?php echo JText::_( 'RR_SYNTAX' ); ?></label></th>
									<th style="text-align:left"><label><?php echo JText::_( 'Description' ); ?></label></th>
									<th style="text-align:left"><label><?php echo JText::_( 'RR_INPUT_EXAMPLE' ); ?></label></th>
									<th style="text-align:left"><label><?php echo JText::_( 'RR_OUTPUT_EXAMPLE' ); ?></label></th>
									<th><label class="hasTip" title="<?php echo JText::_( 'RR_NORMAL' ); ?>::<?php echo JText::_( 'RR_USE_IN_NORMAL' ); ?>"><?php echo JText::_( 'RR_NORMAL' ); ?></label></th>
									<th><label class="hasTip" title="<?php echo JText::_( 'RR_REGEX' ); ?>::<?php echo JText::_( 'RR_USE_IN_REGEX' ); ?>"><?php echo JText::_( 'RR_REGEX' ); ?></label></th>
									<th><label class="hasTip" title="<?php echo JText::_( 'RR_SEARCH' ); ?>::<?php echo JText::_( 'RR_USE_IN_SEARCH' ); ?>"><?php echo JText::_( 'RR_SEARCH' ); ?></label></th>
									<th><label class="hasTip" title="<?php echo JText::_( 'RR_REPLACE' ); ?>::<?php echo JText::_( 'RR_USE_IN_REPLACE' ); ?>"><?php echo JText::_( 'RR_REPLACE' ); ?></label></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="font-family:monospace">[[comma]]</td>
									<td><?php echo JText::_( 'RR_USE_INSTEAD_OF_A_COMMA' ); ?></td>
									<td style="font-family:monospace">[[comma]]</td>
									<td style="font-family:monospace">,</td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[space]]</td>
									<td><?php echo JText::_( 'RR_USE_FOR_LEADING_OR_TRAILING_SPACES' ); ?></td>
									<td style="font-family:monospace">[[space]]</td>
									<td> </td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[counter]]</td>
									<td><?php echo JText::_( 'RR_THIS_PLACES_THE_NUMBER_OF_THE_OCCURRENCE' ); ?></td>
									<td style="font-family:monospace">[[counter]]</td>
									<td>1</td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[random:...-...]]</td>
									<td><?php echo JText::_( 'RR_THIS_PLACES_A_RANDOM_NUMBER' ); ?></td>
									<td style="font-family:monospace">[[random:0-100]]</td>
									<td><?php echo rand( 0, 100 ); ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[date:...]]</td>
									<td><?php echo JText::sprintf( 'RR_DATE_USING_PHP_STRFTIME_FORMAT', '<a rel="{handler: \'iframe\', size:{x:window.getSize().scrollSize.x-100, y: window.getSize().size.y-100}}" href="http://www.php.net/manual/function.strftime.php" class="modal">', '</a>' ); ?></td>
									<td style="font-family:monospace">[[date:%A, %d %B %Y]]</td>
									<td><?php echo JHTML::_( 'date', time(), '%A, %d %B %Y' ); ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:id]]</td>
									<td><?php echo JText::_( 'RR_THE_ID_NUMBER_OF_THE_USER' ); ?></td>
									<td style="font-family:monospace">[[user:id]]</td>
									<td><?php echo $user->id; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:username]]</td>
									<td><?php echo JText::_( 'RR_THE_LOGIN_NAME_OF_THE_USER' ); ?></td>
									<td style="font-family:monospace">[[user:username]]</td>
									<td><?php echo $user->username; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:name]]</td>
									<td><?php echo JText::_( 'RR_THE_NAME_OF_THE_USER' ); ?></td>
									<td style="font-family:monospace">[[user:name]]</td>
									<td><?php echo $user->name; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
							</tbody>
						</table>

						<p><?php echo JText::sprintf( 'RR_HELP_ON_REGULAR_EXPRESSIONS', '<a rel="{handler: \'iframe\', size: {x: 800, y: window.getSize().size.y-100}}" href="index.php?NN_QP=1&folder=administrator.components.com_rereplacer.images&file=image.inc.php" class="modal">', '</a>' ); ?></p>

					</fieldset>
				</div>

				<div class="clr"></div>
			</td>
			<td valign="top" width="1%">
				<div class="col">
					<div id="<?php echo rand( 1000000, 9999999 ); ?>___view_state.1___view_state.2" class="nntoggler nntoggler_horizontal nntoggler_overlay" style="visibility: hidden;">
					<div id="<?php echo rand( 1000000, 9999999 ); ?>___view_state.1___view_state.2" class="nntoggler nntoggler_nofx" style="visibility: hidden;">
						<div style="width:500px;">
								<?php
									echo $pane->startPane( 'rereplacer_pane' );

										echo $pane->startPanel( JText::_( 'RR_SEARCH_OPTIONS' ), 'search-page' );
										echo $this->detail->_xml->render( 'params', 'options' );
										echo $pane->endPanel();

										echo $pane->startPanel( JText::_( 'RR_SEARCH_AREAS' ), 'areas-page' );
										echo $this->detail->_xml->render( 'params', 'areas' );
										echo $pane->endPanel();
								?>
								<div id="<?php echo rand( 1000000, 9999999 ); ?>___view_state.2" class="nntoggler" style="visibility: hidden;">
								<?php
										echo $pane->startPanel( JText::_( 'NN_PUBLISHING_ASSIGNMENTS' ), 'assignments-page' );
										echo $this->detail->_xml->render( 'params', 'assignments' );
										echo $this->detail->_xml->render( 'params', 'assignments_else' );
										echo $pane->endPanel();
								?>
								</div>
								<?php
									echo $pane->endPane();
								?>
						</div>
					</div></div>
				</div>

				<div class="clr"></div>
			</td>
		</tr>
	</table>

	<div class="clr"></div>
</form>

<script language="javascript" type="text/javascript">
	function submitbutton( pressbutton )
	{
		if ( pressbutton == 'cancel' ) {
			submitform( pressbutton );
			return;
		}

		// do field validation
		passCheck = checkFields();
		if ( passCheck ) {
			submitform( pressbutton );
		}
	}

	function checkFields()
	{
		var form = document.adminForm;
		msg = '';
		// do field validation
		if ( form['params[name]'].value == '' ) {
			msg = '<?php echo JText::_( 'RR_THE_ITEM_MUST_HAVE_A_NAME', true ); ?>';
		} else {
			if ( form['params[view_state]'][2].checked && form['params[use_xml]'][1].checked ) {
				if ( form['params[xml]'].value == '' ) {
					msg = '<?php echo JText::_( 'RR_THE_ITEM_MUST_HAVE_AN_XML_FILE', true ); ?>';
				}
			} else {
				if ( form['params[search]'].value == '' ) {
					msg = '<?php echo JText::_( 'RR_THE_ITEM_MUST_HAVE_SOMETHING_TO_SEARCH_FOR', true ); ?>';
				}
			}
		}
		if ( msg != '' ) {
			alert( msg );
			return 0;
		} else {
			return checkFields_2();
		}
	}
	function checkFields_2()
	{
		var form = document.adminForm;
		msg = '';
		// do field validation
		if ( !( form['params[view_state]'][2].checked && form['params[use_xml]'][1].checked ) && form['params[search]'].value.trim() != '' && form['params[search]'].value.trim().length < 3 ) {
			msg = '<?php echo sprintf( JText::_( 'RR_THE_SEARCH_STRING_SHOULD_BE_LONGER', true ), 2 ); ?>';
		} else if (
			( form['params[between_start]'].value.trim() != '' && form['params[between_start]'].value.trim().length < 3 ) ||
			( form['params[between_end]'].value.trim() != '' && form['params[between_end]'].value.trim().length < 3 )
		) {
			msg = '<?php echo sprintf( JText::_( 'RR_THE_SEARCH_BETWEEN_STRINGS_SHOULD_BE_LONGER', true ), 2 ); ?>';
		}
		if ( msg != '' ) {
			alert( msg );
			return 0;
		} else {
			return 1;
		}
	}
	checkFields_2();
</script>