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

$ordering = ($this->lists['order'] == 'ordering');

?>
<form action="index.php?option=com_suggestvotecommentbribe&view=suggs"
	method="post" name="adminForm">
<div id="tablecell">
<table class="adminlist">
	<thead>
		<tr>
			<th width="20px" style="text-align: left;"><input type="checkbox"
				name="toggle" value=""
				onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
			<th width="1%" nowrap="nowrap" style="text-align: left;"><?php echo JHTML::_('grid.sort',   'id', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th class="title" style="text-align: left;"><?php echo JHTML::_('grid.sort',   'Title', 'title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'description', 'description', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', '# of votes', 'noofVotes', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', '# of comments', 'noofComs', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'Amount Bribed', 'amountDonated', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>

			<th width="5%" style="text-align: left;"><?php echo JHTML::_('grid.sort', 'published', 'published', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'By', 'UID', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
			<th style="text-align: left;"><?php echo JHTML::_('grid.sort', 'State', 'state', $this->lists['order_Dir'], $this->lists['order']);?>
			</th>
		</tr>
	</thead>

	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$link       = JRoute::_( 'index.php?option=com_suggestvotecommentbribe&controller=sugg&task=edit&cid[]='. $row->id);

		$checked = JHTML::_('grid.id',  $i, $row->id );
		$published  = JHTML::_('grid.published', $row, $i );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td width="20px"><?php echo $checked; ?></td>
			<td align="center"><?php echo $row->id; ?></td>
			<td><span class="editlinktip hasTip"
				title="<?php echo JText::_( 'Edit sugg' );?>::<?php echo $row->title; ?>">
			<a href="<?php echo $link  ?>"> <?php $row->title=html_entity_decode($row->title,ENT_NOQUOTES); if(strlen($row->title)>25) $row->title=substr($row->title, 0,25).'...'; echo htmlentities($row->title,ENT_NOQUOTES); ?></a>
			</span></td>
			<td><?php $row->description=html_entity_decode(str_replace('<br />',' ',$row->description),ENT_NOQUOTES); if(strlen($row->description)>50) $row->description=substr($row->description, 0,50).'...'; echo htmlentities($row->description,ENT_NOQUOTES); ?>
			</td>
			<td align="center"><?php echo $row->noofVotes; ?></td>
			<td align="center"><?php echo $row->noofComs; ?></td>
			<td align="center"><?php echo $row->amountDonated; ?></td>

			<td align="center"><?php echo $published;?></td>
			<td><?php
			if($row->UID)
			{
				$user =& JFactory::getUser($row->UID);
				echo $user->get('name');
			}
			else echo 'Anonymous';
			?></td>
			<td><?php if ($row->state == "1") {
				$img = 'publish_g.png';
				$alt = JText::_( 'Open' );
			} else {
				$img = "publish_x.png";
				$alt = JText::_( 'Close' );
			}
			?> <a href="javascript:void(0);"
				onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? "Open" : "Close";?>');">
			<img src="images/<?php echo $img;?>" border="0"
				alt="<?php echo $alt; ?>" /> </a></td>
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
	type="hidden" name="controller" value="sugg" /> <input type="hidden"
	name="view" value="suggs" /> <?php echo JHTML::_( 'form.token' ); ?></form>
