<?php
// no direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');
/*
 *
 * Template for links (Readmore and Add comment) attached to content items on frontpage and blogs
 *
 */
class jtt_tpl_links extends JoomlaTuneTemplate
{
	function render() 
	{
		$readmoreLink = $this->getReadmoreLink();
		$commentsLink = $this->getCommentsLink();

		$hitsCount = '';
		
		if ($this->getVar('show_hits', 0) == 1) {
			$content = $this->getVar('content-item');


			if (!isset($content->hits)) {
				$dbo = & JCommentsFactory::getDBO();
				$dbo->setQuery('SELECT hits FROM #__content WHERE id = ' . intval($content->id));
				$cnt = (int) $dbo->loadResult();
			} else {
				$cnt = (int) $content->hits;
			}

			$hitsCount = JText::_('Hits') . ': ' . $cnt;
		}

		if ($readmoreLink != '' || $commentsLink != '') {
?>
<div class="jcomments-links"><?php echo $readmoreLink; ?> <?php echo $commentsLink; ?> <?php echo $hitsCount; ?></div>
<?php
        	}
	}

	/*
	 *
	 * Display Readmore link
	 *
	 */
	function getReadmoreLink() 
	{
		if ($this->getVar('readmore_link_hidden', 0) == 1) {
			return '';
		}

		$link  = $this->getVar('link-readmore');
		$text  = $this->getVar('link-readmore-text');
		$title = $this->getVar('link-readmore-title');
		$css   = $this->getVar('link-readmore-class');

		return '<a class="' . $css . '" href="'. $link .'" title="' . $title . '">' . $text . '</a>';
	}

	/*
	 *
	 * Display Comments or Add comments link
	 *
	 */
	function getCommentsLink()
	{
		if ($this->getVar('comments_link_hidden') == 1) {
			return '';
		}

		$style = $this->getVar('comments_link_style');
		$count = $this->getVar('comments-count');
		$link  = $this->getVar('link-comment');
		$css   = $this->getVar('link-comments-class');

		if ($count == 0) {
			return '<a href="' . $link . '#addcomments" class="' . $css . '">' . JText::_('Add comment') . '</a>';
		} else {
			$text = JText::sprintf('Read comments', $count);

			if ($this->getVar('use-plural-forms', 0)) {
				$comments_pf = JText::_('comments_pf');

				if ($comments_pf != '') {
					global $mainframe;
					$pf = JoomlaTuneLanguageTools::getPlural($mainframe->getCfg('lang'), $count, $comments_pf);
					if ($pf != '') {
						$text = JText::sprintf('COMMENTS2', $count, $pf);
					}
				}
			}

			switch($style) {
				case -1:
					return '<span class="' . $css . '">' . $text . '</span>';
					break;
				default:

					return '<a href="' . $link . '#comments" class="' . $css . '">' . $text . '</a>';
					break;
			}
		}
	}
}
?>