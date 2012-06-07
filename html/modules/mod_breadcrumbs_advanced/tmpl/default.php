<?php // no direct access

defined('_JEXEC') or die('Restricted access');

$showLast = $params->get('showLast', 1);
$cutLast = $params->get('cutLast', 0);
$cutAt = $params->get('cutAt', 20);
$cutChar = $params->get('cutChar', JText::_('...'));
$showHome = $params->get('showHome', 1);

?>
<span class="breadcrumbs pathway">
<?php for ($i = 0; $i < $count; $i ++) :

	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {

		if(!empty($list[$i]->link)) {
			echo '<a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a>';
		} else {
			echo $list[$i]->name;
		};
		if ($i < $count -2)
      echo ' '.$separator.' ';

	}  else if ($showLast && $count > 1) { // when $i == $count -1 and 'showLast' is true
	
      echo ' '.$separator.' ';
      if ( ($cutLast) && (strlen($list[$i]->name) > $cutAt) ) { // when cutLast is true and length of breadcrumb is bigger than cutAt
	      echo substr($list[$i]->name, 0 , $cutAt).$cutChar;
      } else {
        echo $list[$i]->name;
      };

	} else if ($count == 1) {
    echo $list[0]->name;
	};
	endfor; ?>
</span>
