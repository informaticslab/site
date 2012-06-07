<?php
/**
 * @version $Id$
 * @package    Suggest Vote Comment Bribe
 * @subpackage Views
 * @copyright Copyright (C) 2010 Interpreneurial LLC. All rights reserved.
 * @license GNU/GPL
 */
// LOCATION: views/suggs/tmpl/default.php
//--No direct access
defined('_JEXEC') or die('=;)');

JHTML::_('behavior.tooltip');
?>


<script type="text/javascript" src="includes/js/joomla.javascript.js"></script>


<form action="index.php?option=com_suggestvotecommentbribe&view=suggs" method="post" name="adminForm">

<div id="tablecell">
<table class="adminlist" cellpadding="5px">
	<thead>
		<tr>
<?php
if( $this->showid ){
?>
			<th><?php echo JHTML::_('grid.sort',   JText::_('ID'), 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<?php } ?>
<?php
if( $this->showtitle ){
?>
			<th nowrap="nowrap"><?php echo JHTML::_('grid.sort',   JText::_('TITLE'), 'title', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
<?php } ?>
<?php
if( $this->showvotes ){
?>
			<th><?php echo JHTML::_('grid.sort', JText::_('SUGGNOOFVOTES'), 'noofVotes', $this->lists['order_Dir'], $this->lists['order']);?></th>
<?php } ?>
<?php
if( $this->showcomments ){
?>
			<th><?php echo JHTML::_('grid.sort', JText::_('SUGGNOOFCOMMENTS'), 'noofComs', $this->lists['order_Dir'], $this->lists['order']);?></th>
<?php } ?>
<?php
if( $this->showbribes ){
?>
			<th nowrap="nowrap"><?php echo JHTML::_('grid.sort', JText::_('SUGGAMOUNTBRIBED'), 'amountDonated', $this->lists['order_Dir'], $this->lists['order']);?></th>
<?php } ?>
<?php
if( $this->showauthor ){
?>
			<th><?php echo JHTML::_('grid.sort', JText::_('AUTHOR'), 'UID', $this->lists['order_Dir'], $this->lists['order']);?></th>
<?php } ?>
<?php
if( $this->showstate ){
?>
			<th><?php echo JHTML::_('grid.sort', JText::_('SUGGSTATE'), 'state', $this->lists['order_Dir'], $this->lists['order']);?></th>
<?php } ?>
		</tr>
	</thead>

	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		if (isset($_COOKIE['suggest'.$row->id])) {
			if($_COOKIE['suggest'.$row->id]!=1)
			{
				if( ($this->user_id==0||$this->user_id!=$row->UID) && $row->published==0 )
				{
					continue;
				}
			}
		}
		$link = JRoute::_( 'index.php?option=com_suggestvotecommentbribe&view=sugg&cid[]='. $row->id.'&Itemid='.$this->Itemid);

		$checked = JHTML::_('grid.id',  $i, $row->id );
	?>





		<tr class="<?php echo "row$k"; ?>">
<?php
	if( $this->showid ){
?>
			<td><?php echo $row->id; ?></td>
<?php } ?>
<?php
	if( $this->showtitle ){
?>
			<td><a href="<?php echo $link  ?>"> <?php $row->title=html_entity_decode($row->title,ENT_NOQUOTES); if(strlen($row->title)>20) $row->title=substr($row->title, 0,20).'...'; echo htmlentities($row->title,ENT_NOQUOTES); ?></a></td>
<?php } ?>
<?php
	if( $this->showvotes ){
?>
			<td><?php echo $row->noofVotes; ?></td>
<?php } ?>
<?php
	if( $this->showcomments ){
?>
			<td><?php echo $row->noofComs; ?></td>
<?php } ?>
<?php
	if( $this->showbribes ){
?>
			<td><?php echo $row->amountDonated; ?></td>
<?php } ?>
<?php
	if( $this->showauthor ){
?>
			<td>
<?php
		if($row->UID)
		{
			$user2 =& JFactory::getUser($row->UID);
			echo $user2->get('name');
		}
		else
		{
			echo JText::_('ANONYMOUS');
		}
?></td>
<?php
	}
?>
<?php
	if( $this->showstate ){
?>
			<td><?php echo ($row->state)?JText::_('OPEN'):JText::_('CLOSED'); ?></td>
<?php
	}
?>
		</tr>
<?php
$k = 1 - $k;
}
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="13"><a href='<?php echo JRoute::_( 'index.php?option=com_suggestvotecommentbribe&controller=sugg&task=edit'.'&Itemid='.$this->Itemid); ?>'><img src="components/com_suggestvotecommentbribe/assets/images/icon-32-article-add.png" alt="<?php echo JText::_('SUGGADDNEW');?>"><br />
				<?php echo JText::_('SUGGADDNEW');?></a></td>
		</tr>
		<tr>
			<td colspan="13"><?php echo $this->pagination->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>
</div>
<input type="hidden" name="option" value="com_suggestvotecommentbribe" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="controller" value="sugg" />
<input type="hidden" name="view" value="suggs" />
<input type="hidden" name="Itemid" value="<?php echo $this->Itemid ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>