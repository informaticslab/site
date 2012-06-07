<?php
// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');
/*
 *
 * Comment item template. Results of rendering used in tpl_list.php
 *
 */
class jtt_tpl_comment extends JoomlaTuneTemplate
{
        function render()
        {
                $comment = $this->getVar('comment');

                if (isset($comment)) {
                        if ($this->getVar('get_comment_vote', 0) == 1) {
                                // return comment vote
                                $this->getCommentVoteValue( $comment );
                        } else if ($this->getVar('get_comment_body', 0) == 1) {
                                // return only comment body (for example after quick edit)
                                echo $comment->comment;
                        } else {
                                // return all comment item
?>
<div class="rbox"><div class="rbox_tr"><div class="rbox_tl"><div class="rbox_t">&nbsp;</div></div></div><div class="rbox_m">
<?php

                                $comment_number = $this->getVar('comment-number', 1);
                                $thisurl = $this->getVar('thisurl', '');

                                $commentBoxIndentStyle = ($this->getVar('avatar') == 1) ? ' avatar-indent' : '';

                                if (isset($comment->usertype)) {
                                        $commentBoxIndentStyle .= ' usertype-' . $comment->usertype;
                                }

                                if ($this->getVar('avatar') == 1) {
?>
<div class="comment-avatar"><?php echo $comment->avatar; ?></div>
<?php
                                }
?>
<div class="comment-box<?php echo $commentBoxIndentStyle; ?>">
<?php
                                if ($this->getVar('comment-show-vote', 0) == 1) {
                                        $this->getCommentVote( $comment );
                                }
?>
<a class="comment-anchor" href="<?php echo $thisurl; ?>#comment-<?php echo $comment->id; ?>" title="Comment anchor" id="comment-<?php echo $comment->id; ?>">&nbsp;<?php echo $comment_number; ?></a>
<?php
                                if (($this->getVar('comment-show-title') > 0) && ($comment->title != '')) {
?>
<span class="comment-title"><?php echo $comment->title; ?></span> &mdash; 
<?php
                                }
                                if ($this->getVar('comment-show-homepage') == 1) {
?>
<a class="author-homepage" href="<?php echo $comment->homepage; ?>" rel="nofollow" title="<?php echo $comment->author; ?>"><?php echo $comment->author; ?></a>
<?php
                                } else {
?>
<span class="comment-author"><?php echo $comment->author?></span>
<?php
                                }
?>
<span class="comment-date"><?php echo JCommentsText::formatDate($comment->datetime, JText::_('DATETIME_FORMAT')); ?></span>
<div class="comment-body" id="comment-body-<?php echo $comment->id; ?>"><?php echo $comment->comment; ?></div>
<?php
                                if (($this->getVar('button-reply') == 1)
                                || ($this->getVar('button-quote') == 1)
                                || ($this->getVar('button-report') == 1)) {
?>
<span class="comments-buttons">
<?php
                                        if ($this->getVar('button-reply') == 1) {
?>
<a href="#" onclick="jcomments.showReply(<?php echo $comment->id; ?>); return false;"><?php echo JText::_('Reply'); ?></a>
<?php
                                                if ($this->getVar('button-quote') == 1) {
?>
 | <a href="#" onclick="jcomments.showReply(<?php echo $comment->id; ?>,1); return false;"><?php echo JText::_('Reply with quote'); ?></a> | 
<?php
                                                }
                                        }
                                        if ($this->getVar('button-quote') == 1) {
?>
<a href="#" onclick="jcomments.quoteComment(<?php echo $comment->id; ?>); return false;"><?php echo JText::_('Quote'); ?></a>
<?php
                                        }
                                        if ($this->getVar('button-report') == 1) {
                                                if ($this->getVar('button-quote') == 1 || $this->getVar('button-reply') == 1) {
?>
 | 
<?php
                                                }
?>
<a href="#" onclick="jcomments.reportComment(<?php echo $comment->id; ?>); return false;"><?php echo JText::_('Report to administrator'); ?></a>
<?php
                                        }
?>
</span>
<?php
                                }
?>
</div><div class="clear"></div>
<?php
                                // show frontend moderation panel
                                $this->getCommentAdministratorPanel( $comment );
?>
</div><div class="rbox_br"><div class="rbox_bl"><div class="rbox_b">&nbsp;</div></div></div></div>
<?php
                        }
                }
        }

        /*
         *
         * Displays comment's administration panel
         *
         */
        function getCommentAdministratorPanel( &$comment )
        {
                if ($this->getVar('comments-panel-visible', 0) == 1) {
                        $imagesPath = $this->getVar('template_url') . '/images';
?>
<p class="toolbar" id="comment-toolbar-<?php echo $comment->id; ?>">
<?php
                        if ($this->getVar('button-edit') == 1) {
                                $text = JText::_('EDIT');
                                $image = $imagesPath . '/jc_edit.gif';
?>
        <img src="<?php echo $image; ?>" onclick="jcomments.editComment(<?php echo $comment->id; ?>);" alt="<?php echo $text; ?>" title="<?php echo $text; ?>" />
<?php
                        }

                        if ($this->getVar('button-delete') == 1) {
                                $text = JText::_('DELETE');
                                $image = $imagesPath . '/jc_delete.gif';
?>
        <img src="<?php echo $image; ?>" onclick="if (confirm('<?php echo JText::_('CONFIRM_DELETE'); ?>')){jcomments.deleteComment(<?php echo $comment->id; ?>);}" alt="<?php echo $text; ?>" title="<?php echo $text; ?>" />
<?php
                        }

                        if ($this->getVar('button-publish') == 1) {
                                $text = $comment->published ? JText::_('UNPUBLISH') : JText::_('PUBLISH');
                                $image = $comment->published ? $imagesPath . '/jc_publish.gif' : $imagesPath . '/jc_unpublish.gif';

?>
        <img src="<?php echo $image; ?>" onclick="jcomments.publishComment(<?php echo $comment->id; ?>);" alt="<?php echo $text; ?>" title="<?php echo $text; ?>" />
<?php
                        }

                        if ($this->getVar('button-ip') == 1) {
                                $text = JText::_('IP') . ' ' . $comment->ip;
                                $image = $imagesPath . '/jc_ip.gif';
?>
        <img src="<?php echo $image; ?>" onclick="jcomments.go('http://www.ripe.net/perl/whois?searchtext=<?php echo $comment->ip; ?>');" alt="<?php echo $text; ?>" title="<?php echo $text; ?>" />
<?php
                        }
?>
</p>
<div class="clear"></div>
<?php
        }
        }

        function getCommentVote( &$comment )
        {
                $value = intval($comment->isgood) - intval($comment->ispoor);

                if ($value == 0 && $this->getVar('button-vote', 0) == 0) {
                        return;
                }
?>
<span class="comments-vote">
        <span id="comment-vote-holder-<?php echo $comment->id; ?>">
<?php
                if ($this->getVar('button-vote', 0) == 1) {
?>
<a href="#" class="vote-good" title="<?php echo JText::_('VOTE_GOOD'); ?>" onclick="jcomments.voteComment(<?php echo $comment->id;?>, 1);return false;"></a><a href="#" class="vote-poor" title="<?php echo JText::_('VOTE_POOR'); ?>" onclick="jcomments.voteComment(<?php echo $comment->id;?>, -1);return false;"></a>
<?php
                }
                echo $this->getCommentVoteValue( $comment );
?>
        </span>
</span>
<?php
        }

        function getCommentVoteValue( &$comment )
        {
                $value = intval($comment->isgood - $comment->ispoor);

                if ($value == 0 && $this->getVar('button-vote', 0) == 0 && $this->getVar('get_comment_vote', 0) == 0) {
                        // if current value is 0 and user has no rights to vote - hide 0
                        return;
                }

                if ($value < 0) {
                        $class = 'poor';
                } else if ($value > 0) {
                        $class = 'good';
                        $value = '+' . $value;
                } else {
                        $class = 'none';
                }
?>
<span class="vote-<?php echo $class; ?>"><?php echo $value; ?></span>
<?php
        }
}
?>
