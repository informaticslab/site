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
<form action="index.php?option=com_suggestvotecommentbribe&view=votes"
	method="post" name="adminForm">
<div id="tablecell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="1%" nowrap="nowrap" style="text-align: left;"><?php echo JHTML::_('grid.sort',   JText::_('ID'), 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th class="by" style="text-align: left;"><?php echo JHTML::_('grid.sort',   JText::_('BY'), 'UID', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<!-- <th style="text-align:left;">
      <?php echo JHTML::_('grid.sort', JText::_('VALUE'), 'value', $this->lists['order_Dir'], $this->lists['order']);?>
   </th>-->
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', JText::_('SUGGESTION'), 'title', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
		</tr>
	</thead>

	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center"><?php echo $row->id; ?></td>
			<td><?php
			if($row->UID)
			{
				$user =& JFactory::getUser($row->UID);
				echo $user->get('name');
			}
			else echo JText::_('ANONYMOUS');
			?></td>
			<!--            <td>
      <?php echo $row->value; ?>
   </td>-->
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
	type="hidden" name="controller" value="vote" /> <input type="hidden"
	name="view" value="votes" /> <?php echo JHTML::_( 'form.token' ); ?></form>
