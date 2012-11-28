<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<h3><?php echo CMTX_TITLE_FORM_SORT_ORDER ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {
$sort_order_buttons = $_POST['sort_order_buttons'];
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$sort_order_buttons' WHERE title = 'sort_order_buttons'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_SORT_ORDER_BUTTONS ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_sort_order_buttons" id="layout_form_sort_order_buttons" action="index.php?page=layout_form_sort_order_buttons" method="post">

<ul id="buttons" class="buttons">

	<?php
	$elements = explode(",", $settings->sort_order_buttons);
	foreach ($elements as $element) {
		switch ($element) {
			case "1":
			output_submit();
			break;
			case "2":
			output_preview();
			break;
		}
	}
	?>
	
	<?php function output_submit() { ?> <li id="item_1"><?php echo CMTX_FIELD_VALUE_SUBMIT ?></li> <?php } ?>
    <?php function output_preview() { ?> <li id="item_2"><?php echo rtrim(CMTX_FIELD_LABEL_PREVIEW, ':') ?></li> <?php } ?>
	
</ul>

<script type="text/javascript">
  Sortable.create('buttons',{ghosting:false,constraint:true,hoverclass:'over',
    onChange:function(element){
		var totElement = 2;
		var newOrder = Sortable.serialize(element.parentNode);
		for(i=1; i<=totElement; i++){
			newOrder = newOrder.replace("buttons[]=","");
			newOrder = newOrder.replace("&",",");
		}
		$('sort_order_buttons').value = newOrder;
	}
  });
</script>

<input type="hidden" name="sort_order_buttons" id="sort_order_buttons" value="<?php echo $settings->sort_order_buttons; ?>"/>

<p />

<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>

</form>