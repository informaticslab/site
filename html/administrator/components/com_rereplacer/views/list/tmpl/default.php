<?php
/**
 * ReReplacer List View Template
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

// Import html tooltips
JHTML::_( 'behavior.tooltip' );

// Ordering allowed ?
$ordering = ( $this->lists['order'] == 'ordering' );


/**
* Submit the admin form
* small hack: let task decides where it comes
*/
$script = "
	function submitform( pressbutton )
	{
		var form = document.adminForm;
		if ( pressbutton ) {
			form.task.value=pressbutton;
		}

		if (
			( pressbutton=='add' )||( pressbutton=='copy' )||( pressbutton=='edit' )||( pressbutton=='remove' )
			||( pressbutton=='publish' )||( pressbutton=='unpublish' )
			||( pressbutton=='orderdown' )||( pressbutton=='orderup' )||( pressbutton=='saveorder' )
			||( pressbutton=='export' )
		) {
			form.controller.value='item';
		} else {
			form.controller.value='list';
		}
		try {
			form.onsubmit();
			}
		catch( e ) {}

		form.submit();
	}
";
$doc =& JFactory::getDocument();
$doc->addScriptDeclaration( $script );

echo JText::_( 'RR_LIST_INFORMATION' );
?>
<p></p>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" >
	<input type="hidden" name="controller" value="list" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />

	<div style="text-align:right">
		<input type="hidden" name="show_searchreplace" value="<?php echo $this->show_searchreplace; ?>" />
		<input type="checkbox" value="1" <?php if ( $this->show_searchreplace == 1 ) { echo 'checked="checked"'; }?> onclick="if ( this.checked ) { show_searchreplace.value = 1; } else { show_searchreplace.value = 0; } submit();" />
		<?php echo JText::_( 'RR_SHOW_SEARCH_AND_REPLACE_FIELDS' ); ?>

		<input type="hidden" name="show_unpublished" value="<?php echo $this->show_unpublished; ?>" />
		<input type="checkbox" value="1" <?php if ( $this->show_unpublished == 1 ) { echo 'checked="checked"'; }?> onclick="if ( this.checked ) { show_unpublished.value = 1; } else { show_unpublished.value = 0; } submit();" />
		<?php echo JText::_( 'RR_SHOW_UNPUBLISHED_ITEMS' ); ?>
	</div>

	<div id="editcell">
		<table class="adminlist">
		<thead>
			<tr>
				<th width="5">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th class="title">
					<?php echo JHTML::_( 'grid.sort', 'Name', 'name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_( 'grid.sort', 'Description', 'description', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<?php if ( $this->show_searchreplace == 1 ) { ?>
				<th class="title">
					<?php echo JHTML::_( 'grid.sort', 'Search', 'search', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_( 'grid.sort','Replace', 'replace', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<?php } ?>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'RR_CASE' ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'RR_REGEX' ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'RR_ADMIN' ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'Published', 'published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'RR_AREA' ); ?>
				</th>
				<th width="80" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'Order', 'ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th width="1%">
					<?php echo JHTML::_( 'grid.order', $this->items ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'ID', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="<?php echo ( $this->show_searchreplace == 1 ) ? '14' : '12'; ?>">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<?php
		$rownr = 0;
		$item_count = count( $this->items );
		for ( $i=0; $i < $item_count; $i++ )
		{
			$item =& $this->items[$i];
			// todo: Set this to actual editor...
			$item->editor = '';

			$link 	= JRoute::_( 'index.php?option=com_rereplacer&controller=item&task=edit&cid[]='. $item->id );

			$checked = JHTML::_( 'grid.checkedout', $item, $i ,'id' );
			$published = JHTML::_('grid.published', $item, $i );

			if ( $item->casesensitive ) {
				$case 	= '<img src="components/com_rereplacer/images/tick.png" border="0" alt="'.JText::_( 'RR_CASE_SENSITIVE' ).'" title="'.JText::_( 'RR_CASE_SENSITIVE' ).'" />';
			} else {
				$case 	= '<img src="components/com_rereplacer/images/publish_x.png" border="0" alt="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_CASE_SENSITIVE' ).'" title="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_CASE_SENSITIVE' ).'" />';
			}
			if ( $item->regex ) {
				$regex 	= '<img src="components/com_rereplacer/images/tick.png" border="0" alt="'.JText::_( 'RR_REGULAR_EXPRESSIONS' ).'" title="'.JText::_( 'RR_REGULAR_EXPRESSIONS' ).'" />';
			} else {
				$regex 	= '<img src="components/com_rereplacer/images/publish_x.png" border="0" alt="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_REGULAR_EXPRESSIONS' ).'" title="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_REGULAR_EXPRESSIONS' ).'" />';
			}
			if ( $item->enable_in_admin ) {
				$enable_in_admin 	= '<img src="components/com_rereplacer/images/tick.png" border="0" alt="'.JText::_( 'RR_ENABLE_IN_ADMIN' ).'" title="'.JText::_( 'RR_ENABLE_IN_ADMIN' ).'" />';
			} else {
				$enable_in_admin 	= '<img src="components/com_rereplacer/images/publish_x.png" border="0" alt="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_ENABLE_IN_ADMIN' ).'" title="'.JText::_( 'RR_NOT' ).' '.JText::_( 'RR_ENABLE_IN_ADMIN' ).'" />';
			}
			switch( $item->area ) {
				case 'articles':
					$area = JText::_( 'RR_AREA_CONTENT_SHORT' );
					$area_tip = JText::_( 'RR_AREA_CONTENT' );
					break;
				case 'component':
					$area = JText::_( 'RR_AREA_COMPONENT_SHORT' );
					$area_tip = JText::_( 'RR_AREA_COMPONENT' );
					break;
				case 'everywhere':
					$area = JText::_( 'RR_AREA_EVERYWHERE_SHORT' );
					$area_tip = JText::_( 'RR_AREA_EVERYWHERE' );
					break;
				default:
					$area = JText::_( 'RR_AREA_BODY_SHORT' );
					$area_tip = JText::_( 'RR_AREA_BODY' );
					break;
			}

			?>
			<tr class="<?php echo 'row'.$rownr; ?>">
				<td>
					<?php echo $this->pagination->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<?php
					if ( JTable::isCheckedOut( $this->user->get('id' ), $item->checked_out ) ) {
						echo $item->name;
					} else {
					?>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit' ); ?>">
							<?php echo $item->name; ?>
						</a>
					<?php
					}
					?>
				</td>
				<td>
					<?php
						$description = explode( '---', htmlentities( $item->description, ENT_QUOTES, 'UTF-8' ) );
						$descr = trim( $description['0'] );
						if ( isset( $description['1'] ) ) {
							$descr =  '<span class="hasTip" title="'.str_replace( array( "\n", '&' ), array( '<br />', '&amp;' ), $descr.'<hr />'. trim( $description['1'] ) ).'">'.$descr.'</span>';
						}
						
						echo $descr;
					?>
				</td>
				<?php if ( $this->show_searchreplace == 1 ) { ?>
				<td>
					<span class="hasTip" title="<?php echo str_replace( "\n", '<br />', htmlentities( $item->search, ENT_QUOTES, 'UTF-8' ) ); ?>"><?php echo ReReplacerViewList::maxlen( $item->search ); ?></span>
				</td>
				<td>
					<span class="hasTip" title="<?php echo str_replace( array( "\n", '&' ), array( '<br />', '&amp;' ), $item->replace ); ?>"><?php echo ReReplacerViewList::maxlen( $item->replace ); ?></span>
				</td>
				<?php } ?>
				<td align="center">
					<?php echo $case;?>
				</td>
				<td align="center">
					<?php echo $regex;?>
				</td>
				<td align="center">
					<?php echo $enable_in_admin;?>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<td align="center">
					<span class="hasTip" title="<?php echo $area_tip; ?>"><?php echo $area; ?></span>
				</td>
				<td class="order" colspan="2">
					<span><?php echo $this->pagination->orderUpIcon( $i, ( $item->area == @$this->items[$i-1]->area ), $this->lists['order_Dir'] != 'desc' ? 'orderup' : 'orderdown', 'Move Up', $ordering ); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $item_count, ( $item->area == @$this->items[$i+1]->area ), $this->lists['order_Dir'] != 'desc' ? 'orderdown' : 'orderup', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ? '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled; ?> class="text_area" style="text-align: center" />
				</td>
				<td align="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
			<?php
			$rownr = 1 - $rownr;
		}
		?>
		</table>
	</div>
</form>