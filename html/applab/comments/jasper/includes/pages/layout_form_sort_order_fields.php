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
$sort_order_fields = $_POST['sort_order_fields'];
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$sort_order_fields' WHERE title = 'sort_order_fields'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_SORT_ORDER_FIELDS ?>

<p />

<?php $settings = new Settings; ?>

<form name="layout_form_sort_order_fields" id="layout_form_sort_order_fields" action="index.php?page=layout_form_sort_order_fields" method="post">

<ul id="fields" class="fields">

	<?php
	$elements = explode(",", $settings->sort_order_fields);
	foreach ($elements as $element) {
		switch ($element) {
			case "1":
			output_name();
			break;
			case "2":
			output_email();
			break;
			case "3":
			output_website();
			break;
			case "4":
			output_town();
			break;
			case "5":
			output_country();
			break;
			case "6":
			output_rating();
			break;
		}
	}
	?>
	
	<?php function output_name() { ?> <li id="item_1"><?php echo rtrim(CMTX_FIELD_LABEL_NAME, ':') ?></li> <?php } ?>
    <?php function output_email() { ?> <li id="item_2"><?php echo rtrim(CMTX_FIELD_LABEL_EMAIL, ':') ?></li> <?php } ?>
    <?php function output_website() { ?> <li id="item_3"><?php echo rtrim(CMTX_FIELD_LABEL_WEBSITE, ':') ?></li> <?php } ?>
    <?php function output_town() { ?> <li id="item_4"><?php echo rtrim(CMTX_FIELD_LABEL_TOWN, ':') ?></li> <?php } ?>
    <?php function output_country() { ?> <li id="item_5"><?php echo rtrim(CMTX_FIELD_LABEL_COUNTRY, ':') ?></li> <?php } ?>
    <?php function output_rating() { ?> <li id="item_6"><?php echo rtrim(CMTX_FIELD_LABEL_RATING, ':') ?></li> <?php } ?>
	
</ul>

<script type="text/javascript">
  Sortable.create('fields',{ghosting:false,constraint:true,hoverclass:'over',
    onChange:function(element){
		var totElement = 6;
		var newOrder = Sortable.serialize(element.parentNode);
		for(i=1; i<=totElement; i++){
			newOrder = newOrder.replace("fields[]=","");
			newOrder = newOrder.replace("&",",");
		}
		$('sort_order_fields').value = newOrder;
	}
  });
</script>

<input type="hidden" name="sort_order_fields" id="sort_order_fields" value="<?php echo $settings->sort_order_fields; ?>"/>

<p />

<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>

</form>