<?php
// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');
/*
 *
 * Template for report to comment message
 *
 */
class jtt_tpl_email_report extends JoomlaTuneTemplate
{
	function render() 
	{
		$comment = $this->getVar('comment');
		$object_link =  $this->getVar('comment-object_link');
		$name = $this->getVar('report-name');
		$reason = $this->getVar('report-reason');

		// add inline styles for quotes to default comment html layout
		$comment->comment = str_replace('<blockquote>', '<blockquote style="border-left: 2px solid #ccc; padding-left: 5px; margin-left: 10px;">', $comment->comment);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta content="text/html; charset=<?php echo $this->getVar('charset'); ?>" http-equiv="content-type" />
  <meta name="Generator" content="JComments" />
</head>
<body>
<?php echo JText::sprintf('REPORT_MESSAGE', $comment->author, $name); ?>
<br />
<br />
<a href="<?php echo $object_link ?>#comment-<?php echo $comment->id; ?>" target="_blank"><?php echo $object_link; ?>#comment-<?php echo $comment->id; ?></a>
<br />
<br />
<?php
		if ($reason != '') {
?>
<?php echo JText::_('REPORT_REASON'); ?>:
<div style="border: 1px solid #ccc; padding: 10px 5px; margin: 5px 0; font: normal 1em Verdana, Arial, Sans-Serif;"><?php echo $reason; ?></div>
<?php
		}
?>
<br />
<?php echo JText::_('NOTIFICATION_COMMENT_TEXT'); ?>:
<br />
<br />
<a style="color: #777;" href="<?php echo $object_link ?>#comment-<?php echo $comment->id; ?>" target="_blank">#</a>&nbsp;
<?php
		if ($comment->title != '') {
?>
<span style="color: #b01625;font: bold 1em Verdana, Arial, Sans-Serif;"><?php echo $comment->title; ?></span> &mdash; 
<?php
		}
		if ($comment->homepage != '') {
?>
<a style="color: #3c452d;font: bold 1em Verdana, Arial, Sans-Serif;" href="<?php echo $comment->homepage; ?>" target="_blank"><?php echo $comment->name; ?></a>
<?php
		} else {
?>
<span style="color: #3c452d;font: bold 1em Verdana, Arial, Sans-Serif;"><?php echo $comment->name; ?></span>
<?php
		}
?>
 (
<?php
		if ($comment->email != '') {
?>
<a href="mailto: <?php echo $comment->email; ?>" target="_blank"><?php echo $comment->email; ?></a>,
<?php
		}
?>
<span style="font-size: 11px;">IP: <?php echo $comment->ip; ?></span>
) &mdash; <span style="font-size: 11px; color: #999;"><?php echo JCommentsText::formatDate($comment->datetime, JText::_('DATETIME_FORMAT')); ?></span>
<div style="border: 1px solid #ccc; padding: 10px 5px; margin: 5px 0; font: normal 1em Verdana, Arial, Sans-Serif;"><?php echo $comment->comment; ?></div>
<?php

		if ($this->getVar('quick-moderation') == 1) {
			$commands = array();
			if ($comment->published == 0) {
				$commands[] = $this->getCmdLink('publish', JText::_('Publish'), $comment);
			} else {
				$commands[] = $this->getCmdLink('unpublish', JText::_('Unpublish'), $comment);
			}
			$commands[] = $this->getCmdLink('delete', JText::_('Delete'), $comment);

			if (count($commands)) {
				echo JText::_('Quick moderation') . ' ' . implode(' | ', $commands);
			}
		}
?>
</body>
</html>
<?php
	}

	function getCmdLink($cmd, $title, $comment)
	{
		$link = JCommentsFactory::getCmdLink($cmd, $comment->id);
		return '<a href="' . $link . '" title="' . $title . '" target="_blank">' . $title . '</a>';
	}
}
?>