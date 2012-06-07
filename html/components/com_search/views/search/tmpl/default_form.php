<?php defined('_JEXEC') or die('Restricted access'); ?>

<!--Hide advanced search
<form id="searchForm" action="<?php echo JRoute::_( 'index.php?option=com_search' );?>" method="post" name="searchForm">
	<table class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<tr>
			<td nowrap="nowrap" class="searchlabel">
				<label for="search_searchword">
					<?php echo JText::_( 'Search keyword(s)' ); ?>:
				</label>
			</td>
			<td nowrap="nowrap">
				<input type="text" name="searchword" id="search_searchword" size="30" maxlength="20" value="<?php echo $this->escape($this->searchword); ?>" class="inputbox" />
			</td>
			<td width="100%" nowrap="nowrap">
				<button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_( 'Search' );?></button>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="radiobut">
				<?php echo $this->lists['searchphrase']; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="orderlist">
				<label for="ordering">
					<?php echo JText::_( 'Ordering' );?>:
				</label>
				<?php echo $this->lists['ordering'];?>
			</td>
		</tr>
	
</table>

-->	
    
 
    <table class="searchintro<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<tr>
		<td colspan="3" >
			<br />
			<?php echo JText::_( 'Search keyword(s):' ) .' <b>'. $this->escape($this->searchword) .'</b>'; ?>
	
        <br/>
        </td>
	</tr>
	<tr>
		<td class="resultText">
			
			<?php echo $this->result; ?>
		</td>
	</tr>
</table>






<br />
<!--# box
<?php if($this->total > 0) : ?>
<div align="center">
	<div style="float: right; padding-bottom:3px;">
		<label for="limit">
			<?php echo JText::_( 'Display Num' ); ?>
		</label>
		<?php echo $this->pagination->getLimitBox( ); ?>
	</div>
	<div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
</div>
<?php endif; ?>

<input type="hidden" name="task"   value="search" />
</form>
-->	