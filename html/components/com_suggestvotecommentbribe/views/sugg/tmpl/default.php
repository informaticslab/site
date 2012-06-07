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

function force_sp($string,$charcount)
{
	$count=0;
	$spl=preg_split('[\s]',$string);
	foreach($spl as $str)
	{
		if(strlen($str)>$charcount)
		{
			$str1=substr($string,0,$count+$charcount);
			$str2=substr($string,$count+$charcount);
			$string=$str1.' '.$str2;
			$string=force_sp($string,$charcount);
			break;
		}
		$count+=strlen($str)+1;
	}
	return $string;
}
?>

<div>
<?php
if( $this->showtitle )
{
?>
<h1><?php echo force_sp(str_replace('&nbsp;','&nbsp; ',$this->item->title),30); ?></h1>
<?php
}
?>
<?php
if( $this->showauthor )
{
	if($this->item->UID)
	{
		$user2 =& JFactory::getUser($this->item->UID);
		echo 'This suggestion was submitted by ' . $user2->get('name') . '.';
	}
} ?>

<h2><?php echo JText::_('DESCRIPTION') ?></h2>
<p><?php echo force_sp(str_replace('&nbsp;','&nbsp; ',$this->item->description),50); ?></p>
</div>

<div>
<?php
// if the current User made this Suggestion
// then allow them to publish/unpublish it
if( ($this->item->UID!=0 && $this->item->UID==$this->user_id) || isset($_COOKIE['suggest'.$this->item->id]) )
{
	echo "<form name=\"sugg\">
	<input type=\"hidden\" name=\"cid\" value=\"".$this->item->id."\">
	<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
	<input type=\"hidden\" name=\"controller\" value=\"sugg\">
	<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">";
	if($this->item->published){
		echo "<input type=\"hidden\" name=\"task\" value=\"unpublish\">
		<a href='javascript:void(0)' onclick='sugg.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."icon-32-unpublish.png\" alt=\"".JText::_('UNPUBLISH')."\"><br /></a>";
	}else{
		echo "<input type=\"hidden\" name=\"task\" value=\"publish\">
		<a href='javascript:void(0)' onclick='sugg.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."icon-32-publish.png\" alt=\"".JText::_('PUBLISH')."\"><br /></a>";
	}
	echo "</form>";
}
?>
</div>

<h2><?php echo JText::_('FEEDBACK') ?></h2>
<table>
<?php
if( $this->showbribes )
{
?>
	<tr>
		<td><?php echo JText::_('SUGGAMOUNTBRIBED')?>:</td>
		<td><?php echo $this->item->amountDonated; ?></td>
		<td>
<?php
	if($this->item->state && $this->item->published)
	{
		echo "<form name=\"bribe\" method=\"post\">
		<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\">
		<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
		<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">
		<input type=\"hidden\" name=\"controller\" value=\"bribe\">
		<input type=\"hidden\" name=\"task\" value=\"edit\"><a href='javascript:void(0)' onclick='bribe.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS.'bribe-32.jpg'."\" alt=\"".JText::_('LEAVEBRIBE')."\"><br /></a>
		</form>";
	}
?></td>
	</tr>
<?php
}	// end showbribes
?>

<?php
if( $this->showcomments )
{
?>
	<tr>
		<td><?php echo JText::_('SUGGNOOFCOMMENTS')?>:</td>
		<td><?php echo $this->item->noofComs; ?></td>
		<td><?php if($this->item->state&&$this->item->published)
		{
			echo "<form name=\"comment\" method=\"post\">
			<input type=\"hidden\" name=\"cid\" value=\"0\">
			<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\">
			<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
			<input type=\"hidden\" name=\"controller\" value=\"comment\">
			<input type=\"hidden\" name=\"task\" value=\"edit\">
			<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">
			<a href='javascript:void(0)' onclick='comment.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."icon-32-article-add.png\" alt=\"".JText::_('LEAVECOMMENT')."\"><br /></a></form>";
		}
?></td>
	</tr>
<?php
}	// end showcomments
?>

<?php
if( $this->showvotes )
{
	?>
	<tr>
		<td><?php echo JText::_('SUGGNOOFVOTES')?>:</td>
		<td><?php echo $this->item->noofVotes; ?></td>
		<td><?php if( $this->item->state && $this->item->published )
		{
			// for each vote on this Suggestion
			for($i=0; $i<count($this->votes); $i++)
			{
				$vote=$this->votes[$i];
				// if this vote was cast by the current User
				// then allow the current User to remove their Vote on this Suggestion
				if( $vote->UID && $vote->UID==$this->user_id || isset($_COOKIE['vote'.$vote->SID]) )
				{
					$del= "<form name=\"vote".$vote->id."\" method=\"post\">
					<input type=\"hidden\" name=\"cid\" value=\"".$vote->id."\">
					<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
					<input type=\"hidden\" name=\"controller\" value=\"vote\">
					<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\">
					<input type=\"hidden\" name=\"task\" value=\"remove\">
					<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">
					<a href='javascript:void(0)' onclick='vote".$vote->id.".submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS.'thumbs-down.png'."\" alt=\"".JText::_('REMOVEVOTE')."\"><br /></a></form>";
					break;
				}
				// or, if the user is logged in OR captcha && login are not required
				// then allow the current User to Vote on this Suggestion
				elseif($this->user_id || (!$this->requiresCaptcha && !$this->requireslogin))
				{
					$del= "<form name=\"vote\" method=\"post\">
					<input type=\"hidden\" name=\"cid\" value=\"0\">
					<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\" />
					<input type=\"hidden\" name=\"controller\" value=\"vote\" />
					<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\" />
					<input type=\"hidden\" name=\"task\" value=\"save\" />
					<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\" />
					<input type=\"hidden\" name=\"value\" value=\"1\" />
					<a href='javascript:void(0)' onclick='vote.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS.'thumbs-up.png'."\" alt=\"".JText::_('LEAVEVOTE')."\"><br />	</a></form>";
				}
				// the current User is not associated with a Vote AND the current User is not logged in AND to Vote requires CAPTCHA
				// so allow the current User to Vote on this Suggestion
				else
				{
					$del= "<form name=\"vote\" method=\"post\">
					<input type=\"hidden\" name=\"cid\" value=\"0\">
					<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
					<input type=\"hidden\" name=\"controller\" value=\"vote\" >
					<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\" >
 					<input type=\"hidden\" name=\"task\" value=\"edit\">
 					<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">
 					<a href='javascript:void(0)' onclick='vote.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS.'thumbs-up.png'."\" alt=\"".JText::_('LEAVEVOTE')."\"><br /></a></form>";
				}
			}

			if(!isset($del))
			{
				if($this->user_id||(!$this->requiresCaptcha&&!$this->requireslogin))
				{
					$del= "<form name=\"vote\" method=\"post\">
				   <input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\" />
				   <input type=\"hidden\" name=\"task\" value=\"save\" />
				   <input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\" />
				   <input type=\"hidden\" name=\"controller\" value=\"vote\" />
				   <input type=\"hidden\" name=\"cid\" value=\"0\">
				   <input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">
				   <input type=\"hidden\" name=\"value\" value=\"1\" />
				   <a href='javascript:void(0)' onclick='vote.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS.'thumbs-up.png'."\" alt=\"".JText::_('LEAVEVOTE')."\"><br /></a></form>";
				}
				else
				{
					$del= "<form name=\"vote\" method=\"post\">
					<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\" />
 					<input type=\"hidden\" name=\"task\" value=\"edit\" />
					<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\" />
					<input type=\"hidden\" name=\"controller\" value=\"vote\" />
					<input type=\"hidden\" name=\"cid\" value=\"0\" />
					<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\" />
 					<a href='javascript:void(0)' onclick='vote.submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."thumbs-up.png\" alt=\"".JText::_('LEAVEVOTE')."\"><br /></a></form>";
				}
			}
			echo $del;
		}	// end state && published
?></td>
	</tr>
	<?php
}	// end showvotes
?>
</table>

<?php
if( $this->showcomments )
{
	?>
<h2><?php echo JText::_('SUGGCOMMENTSTITLE')?>:</h2>
<p>
	<?php
	for($i=0;$i<count($this->comments);$i++)
	{
		$comment=$this->comments[$i];
		if(($comment->UID&&$comment->UID==$this->user_id)|| isset($_COOKIE['comment'.$comment->id]) )
		{   $disable="<form name='comment".$comment->id."'>
			<input type=\"hidden\" name=\"cid\" value=\"".$comment->id."\">
			<input type=\"hidden\" name=\"option\" value=\"com_suggestvotecommentbribe\">
			<input type=\"hidden\" name=\"controller\" value=\"comment\">
			<input type=\"hidden\" name=\"SID\" value=\"".$this->item->id."\">
			<input type=\"hidden\" name=\"Itemid\" value=\"".$this->Itemid."\">";
			if($comment->published)
			{
				$disable.=" <input type=\"hidden\" name=\"task\" value=\"unpublish\">
				<a href='javascript:void(0)' onclick='comment".$comment->id.".submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."icon-32-unpublish.png\" alt=\"".JText::_('UNPUBLISH')."\"><br /></a></form>";
			}
			else
			{
				$disable.=" <input type=\"hidden\" name=\"task\" value=\"publish\">
				<a href='javascript:void(0)' onclick='comment".$comment->id.".submit()'><img src=\"".'components'.DS.'com_suggestvotecommentbribe'.DS.'assets'.DS.'images'.DS."icon-32-publish.png\" alt=\"".JText::_('PUBLISH')."\"><br /></a></form>";
			}
		}
		else
		{
			$disable='';
		}
		if( $this->showauthor )
		{
			if($comment->UID==0)
			{
				$username=JText::_('ANONYMOUS');
			}
			else
			{
				$user = JFactory::getUser($comment->UID);
				$username=$user->name;
			}
		}
		?>
<h3><?php echo force_sp(str_replace('&nbsp;','&nbsp; ',$comment->title),30);?></h3>
		<?php echo $this->showauthor? JText::_('By').": ".$username:""; ?>
<p><?php echo force_sp(str_replace('&nbsp;','&nbsp; ',$comment->description),50);?></p>
<h4><?php echo $disable;?></h4>
		<?php
	}
	?>
	<?php
}
?>
<?php
if( $this->showvotes )
{
	?>
<h2><?php echo JText::_('SUGGVOTESTITLE')?>:</h2>
<ul>
<?php
	for($i=0; $i<count($this->votes); $i++)
	{
		$vote=$this->votes[$i];
		if($vote->UID==0)
		{
			$username=JText::_('ANONYMOUS');
		}
		else
		{
			$user = JFactory::getUser($vote->UID);
			$username=$user->name;
		}
		?>
		<li><?php echo $username;?> <?php
	}
?>

</ul>
<?php
}
?>