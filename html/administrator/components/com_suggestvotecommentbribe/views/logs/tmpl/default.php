<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Views
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

JHTML::_('behavior.tooltip');


?>
<form action="index.php?option=com_suggestvotecommentbribe&view=logs"
	method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%"><?php echo JText::_( 'FILTER' ); ?>: <input
			type="text" name="search" id="search"
			value="<?php echo $this->lists['search'];?>" class="text_area"
			onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'GO' ); ?></button>
		<button
			onclick="document.getElementById('search').value='';this.form.getElementById('filter_item').value='';this.form.submit();"><?php echo JText::_( 'RESET' ); ?></button>
		</td>
	</tr>
</table>
<div id="tablecell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="1%" nowrap="nowrap" style="text-align: left;"><?php echo JHTML::_('grid.sort',   'id', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'description', 'description', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'Suggestion', 'title', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
		</tr>
	</thead>

	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$link       = JRoute::_( 'index.php?option=com_suggestvotecommentbribe&controller=log&task=edit&cid[]='. $row->id);

		$checked = JHTML::_('grid.id',  $i, $row->id );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center"><?php echo $row->id; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->title; ?></td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="13"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>
</div>
<input type="hidden" name="option" value="com_suggestvotecommentbribe" />
<input type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /> <input
	type="hidden" name="controller" value="log" /> <input type="hidden"
	name="view" value="logs" /> <?php echo JHTML::_( 'form.token' ); ?></form>
