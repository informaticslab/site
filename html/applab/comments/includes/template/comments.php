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
?>

<?php if (!defined("IN_COMMENTICS")) { die("Access Denied."); } ?>

<?php if ($settings->show_reply && $settings->scroll_reply) { ?>
<script type="text/javascript">
// <![CDATA[
var ss = {
  fixAllLinks: function() {
    // Get a list of all links in the page
    var allLinks = document.getElementsByTagName('a');
    // Walk through the list
    for (var i=0;i<allLinks.length;i++) {
      var lnk = allLinks[i];
	  if (lnk.href.indexOf('<?php echo CMTX_ANCHOR_FORM ?>') != -1) { //Commentics adjustment (1/2)
		 if ((lnk.href && lnk.href.indexOf('#') != -1) && 
			  ( (lnk.pathname == location.pathname) ||
			('/'+lnk.pathname == location.pathname) ) && 
			  (lnk.search == location.search)) {
			// If the link is internal to the page (begins in #)
			// then attach the smoothScroll function as an onclick
			// event handler
			ss.addEvent(lnk,'click',ss.smoothScroll);
		 }
	  } //Commentics adjustment (2/2)
    }
  },

  smoothScroll: function(e) {
    // This is an event handler; get the clicked on element,
    // in a cross-browser fashion
    if (window.event) {
      target = window.event.srcElement;
    } else if (e) {
      target = e.target;
    } else return;

    // Make sure that the target is an element, not a text node
    // within an element
    if (target.nodeType == 3) {
      target = target.parentNode;
    }

    // Paranoia; check this is an A tag
    if (target.nodeName.toLowerCase() != 'a') return;

    // Find the <a name> tag corresponding to this href
    // First strip off the hash (first character)
    anchor = target.hash.substr(1);
    // Now loop all A tags until we find one with that name
    var allLinks = document.getElementsByTagName('a');
    var allDivs = document.getElementsByTagName('div');
    var all = [allLinks, allDivs];
    var destinationLink = null;
    for (var j=0; j<all.length; j++) {
      for (var i=0;i<all[j].length;i++) {
        var lnk = all[j][i];
        if (lnk.name && (lnk.name == anchor)) {
          destinationLink = lnk;
          break;
        } else if (lnk.id && (lnk.id == anchor)){
	  destinationLink = lnk;
          break;
	}
      }
    }

    var allLinks = document.getElementsByTagName('a');
    var destinationLink = null;
    for (var i=0;i<allLinks.length;i++) {
      var lnk = allLinks[i];
      if (lnk.name && (lnk.name == anchor)) {
        destinationLink = lnk;
        break;
      }
    }

    // If we didn't find a destination, give up and let the browser do
    // its thing
    if (!destinationLink) return true;

    // Find the destination's position
    var destx = destinationLink.offsetLeft; 
    var desty = destinationLink.offsetTop;
    var thisNode = destinationLink;
    while (thisNode.offsetParent && 
          (thisNode.offsetParent != document.body)) {
      thisNode = thisNode.offsetParent;
      destx += thisNode.offsetLeft;
      desty += thisNode.offsetTop;
    }

    // Stop any current scrolling
    clearInterval(ss.INTERVAL);

    cypos = ss.getCurrentYPos();

    ss_stepsize = parseInt((desty-cypos)/ss.STEPS);
    ss.INTERVAL =
setInterval('ss.scrollWindow('+ss_stepsize+','+desty+',"'+anchor+'")',10);

    // And stop the actual click happening
    if (window.event) {
      window.event.cancelBubble = true;
      window.event.returnValue = false;
    }
    if (e && e.preventDefault && e.stopPropagation) {
      e.preventDefault();
      e.stopPropagation();
    }
  },

  scrollWindow: function(scramount,dest,anchor) {
    wascypos = ss.getCurrentYPos();
    isAbove = (wascypos < dest);
    window.scrollTo(0,wascypos + scramount);
    iscypos = ss.getCurrentYPos();
    isAboveNow = (iscypos < dest);
    if ((isAbove != isAboveNow) || (wascypos == iscypos)) {
      // if we've just scrolled past the destination, or
      // we haven't moved from the last scroll (i.e., we're at the
      // bottom of the page) then scroll exactly to the link
      window.scrollTo(0,dest);
      // cancel the repeating timer
      clearInterval(ss.INTERVAL);
      // and jump to the link directly so the URL's right
      location.hash = anchor;
    }
  },

  getCurrentYPos: function() {
    if (document.body && document.body.scrollTop)
      return document.body.scrollTop;
    if (document.documentElement && document.documentElement.scrollTop)
      return document.documentElement.scrollTop;
    if (window.pageYOffset)
      return window.pageYOffset;
    return 0;
  },

  addEvent: function(elm, evType, fn, useCapture) {
    // addEvent and removeEvent
    // cross-browser event handling for IE5+, NS6 and Mozilla
    // By Scott Andrew
    if (elm.addEventListener){
      elm.addEventListener(evType, fn, useCapture);
      return true;
    } else if (elm.attachEvent){
      var r = elm.attachEvent("on"+evType, fn);
      return r;
    } else {
      alert("Handler could not be removed");
    }
  } 
}

ss.STEPS = 25;

ss.addEvent(window,"load",ss.fixAllLinks);
// ]]>
</script>
<?php } ?>

<?php if ($settings->show_like || $settings->show_dislike || $settings->show_flag) { ?>
<script type="text/javascript">
// <![CDATA[
if (typeof jQuery == "undefined") {
document.write("<scr" + "ipt type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js\"></scr" + "ipt>");
}
// ]]>
</script>
<?php } ?>

<?php if ($settings->show_like || $settings->show_dislike) { ?>
<script type="text/javascript">
// <![CDATA[
$(function() {
$(".vote").click(function()
{
var id = $(this).attr("id");
var name = $(this).attr("name");
var dataString = 'id='+ id ;
var parent = $(this);

if (name == 'up') {
$.ajax({
type: "POST",
url: "<?php echo $path_to_comments_folder . "vote.php?type=up"?>",
data: dataString,
cache: false,

success: function(html) {
parent.html(html);
}
});
} else {
$.ajax({
type: "POST",
url: "<?php echo $path_to_comments_folder . "vote.php?type=down"?>",
data: dataString,
cache: false,

success: function(html) {
parent.html(html);
}
});
}
return false;
});
});
// ]]>
</script>
<?php } ?>

<?php if ($settings->show_flag) { ?>
<script type="text/javascript">
// <![CDATA[
$(function() {
$(".flag").click(function()
{
var id = $(this).attr("id");
var name = $(this).attr("name");
var dataString = 'id='+ id ;
var parent = $(this);
var proceed = true;

var answer = confirm("<?php echo CMTX_FLAG_CONFIRM; ?>");
if (!answer) { proceed = false; }

if (proceed) {
var text = prompt("<?php echo CMTX_FLAG_REASON; ?>","");
if (text == null) {
proceed = false;
}
}

if (name == 'flag' && proceed) {
$.ajax({
type: "POST",
url: "<?php echo $path_to_comments_folder . "flag.php?reason="?>" + text,
data: dataString,
cache: false,

success: function(html) {
parent.html(html);
}
});
}
return false;
});
});
// ]]>
</script>
<?php } ?>

<h3 class="comments_heading">
<a id="<?php echo str_ireplace("#", "", CMTX_ANCHOR_COMMENTS); ?>" name="<?php echo str_ireplace("#", "", CMTX_ANCHOR_COMMENTS); ?>">
<?php echo CMTX_COMMENTS_HEADING; ?>
</a>
</h3>

<div class="height_below_comments_heading"></div>

<?php
//comments order
if ($settings->newest_first) {
$list_order = "DESC";
} else {
$list_order = "ASC";
}

//get number of approved comments for current page
$number_of_comments = cmtx_number_of_comments();

//if no comments
if ($number_of_comments == 0) {
echo "<span class='no_comments_text'>";
echo CMTX_NO_COMMENTS;
echo "</span>";
if ($settings->rich_snippets) {
	echo " <span class=\"rating\"><span class=\"average\"></span></span><span class=\"votes\"></span></div>";
}
} else { //if there are comments

$total_pages = ceil($number_of_comments/$settings->comments_per_page);

//get the current page or set a default
if (isset($_GET['cmtx_page']) && ctype_digit($_GET['cmtx_page'])) {
	$current_page = (int) $_GET['cmtx_page'];
} else {
	$current_page = 1;
}

if ($current_page > $total_pages) { //if current page is greater than total pages
   $current_page = $total_pages; //set current page to last page
}

if ($current_page < 1) { //if current page is less than first page
   $current_page = 1; //set current page to first page
}

$offset = ($current_page - 1) * $settings->comments_per_page; //the offset of the list, based on current page

if (isset($_GET['cmtx_sort'])) {
	switch ($_GET['cmtx_sort']) {
		case "1":
		$sort = "is_sticky DESC, dated DESC"; //newest
		break;
		case "2":
		$sort = "is_sticky DESC, dated ASC"; //oldest
		break;
		case "3":
		$sort = "is_sticky DESC, vote_up DESC"; //helpful
		break;
		case "4":
		$sort = "is_sticky DESC, vote_down DESC"; //useless
		break;
		case "5":
		$sort = "is_sticky DESC, rating DESC"; //positive
		break;
		case "6":
		$sort = "is_sticky DESC, rating = 0, rating ASC"; //critical
		break;
		default:
		if ($settings->newest_first == "1") {
			$sort = "is_sticky DESC, dated DESC"; //newest
		} else {
			$sort = "is_sticky DESC, dated ASC"; //oldest
		}
	}
} else {
		if ($settings->newest_first == "1") {
			$sort = "is_sticky DESC, dated DESC"; //newest
		} else {
			$sort = "is_sticky DESC, dated ASC"; //oldest
		}
}

//get all comments from database
$comments_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '0' AND is_approved = '1' AND page_id = '$page_id' ORDER BY $sort;");



//sort
if ($settings->enabled_sort_by) {

echo "<div class='sort_block'>";

if ($settings->enabled_sort_by_1 && $settings->show_date) {
	if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "1") || (!isset($_GET['cmtx_sort']) && $settings->newest_first == "1") ) {
	echo CMTX_SORT_1;
	} else {
	echo "<a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=1" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_1 . "' rel='nofollow'>" . CMTX_SORT_1 . "</a>";
	}
}

if ($settings->enabled_sort_by_2 && $settings->show_date) {
	if ( (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "2") || (!isset($_GET['cmtx_sort']) && $settings->newest_first == "0") ) {
	echo " | " . CMTX_SORT_2;
	} else {
	echo " | <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=2" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_2 . "' rel='nofollow'>" . CMTX_SORT_2 . "</a>";
	}
}

if ($settings->enabled_sort_by_3 && $settings->show_like) {
	if (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "3") {
	echo " &nbsp; " . CMTX_SORT_3;
	} else {
	echo " &nbsp; <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=3" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_3 . "' rel='nofollow'>" . CMTX_SORT_3 . "</a>";
	}
}

if ($settings->enabled_sort_by_4 && $settings->show_dislike) {
	if (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "4") {
	echo " | " . CMTX_SORT_4;
	} else {
	echo " | <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=4" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_4 . "' rel='nofollow'>" . CMTX_SORT_4 . "</a>";
	}
}

if ($settings->enabled_sort_by_5 && $settings->show_rating) {
	if (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "5") {
	echo " &nbsp; " . CMTX_SORT_5;
	} else {
	echo " &nbsp; <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=5" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_5 . "' rel='nofollow'>" . CMTX_SORT_5 . "</a>";
	}
}

if ($settings->enabled_sort_by_6 && $settings->show_rating) {
	if (isset($_GET['cmtx_sort']) && $_GET['cmtx_sort'] == "6") {
	echo " | " . CMTX_SORT_6;
	} else {
	echo " | <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_sort=6" . cmtx_get_query("sort") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_SORT_6 . "' rel='nofollow'>" . CMTX_SORT_6 . "</a>";
	}
}

echo "</div>";

echo "<div class='height_below_sort'></div>";
}



//average rating
echo "<div class='average_rating_block'>";
if ($settings->show_average_rating) {

$average_rating = cmtx_average_rating();

$output_average_rating = '';

switch ($average_rating) {
case 1:
$output_average_rating .= cmtx_star_full_avg(1);
$output_average_rating .= cmtx_star_empty_avg(4);
break;
case 1.5:
$output_average_rating .= cmtx_star_full_avg(1);
$output_average_rating .= cmtx_star_half_avg(1);
$output_average_rating .= cmtx_star_empty_avg(3);
break;
case 2:
$output_average_rating .= cmtx_star_full_avg(2);
$output_average_rating .= cmtx_star_empty_avg(3);
break;
case 2.5:
$output_average_rating .= cmtx_star_full_avg(2);
$output_average_rating .= cmtx_star_half_avg(1);
$output_average_rating .= cmtx_star_empty_avg(2);
break;
case 3:
$output_average_rating .= cmtx_star_full_avg(3);
$output_average_rating .= cmtx_star_empty_avg(2);
break;
case 3.5:
$output_average_rating .= cmtx_star_full_avg(3);
$output_average_rating .= cmtx_star_half_avg(1);
$output_average_rating .= cmtx_star_empty_avg(1);
break;
case 4:
$output_average_rating .= cmtx_star_full_avg(4);
$output_average_rating .= cmtx_star_empty_avg(1);
break;
case 4.5:
$output_average_rating .= cmtx_star_full_avg(4);
$output_average_rating .= cmtx_star_half_avg(1);
break;
case 5:
$output_average_rating .= cmtx_star_full_avg(5);
break;
}

if ($average_rating != 0) {
	echo $output_average_rating;
	echo "<span class='average_rating_text'>";
	if ($settings->rich_snippets) {
		echo " <span class=\"rating\"><span class=\"average\">" . $average_rating . "</span></span> (<span class=\"votes\">" . cmtx_number_of_ratings() . "</span>)";
	} else {
		echo " " . $average_rating . " (" . cmtx_number_of_ratings() . ")";
	}
	echo "</span>";
	if ($settings->rich_snippets) {
		echo "</div>";
	}
} else {
	if ($settings->rich_snippets) {
		echo " <span class=\"rating\"><span class=\"average\"></span></span><span class=\"votes\"></span></div>";
	}
}

} else {
	if ($settings->rich_snippets) {
		echo " <span class=\"rating\"><span class=\"average\"></span></span><span class=\"votes\"></span></div>";
	}
}
echo "</div>";


//pagination (top)
echo "<div class='pagination_block_top'>";
if ($settings->enabled_pagination && $settings->show_pagination_top && $total_pages > 1) {
cmtx_paginate($current_page, $settings->range_of_pages, $total_pages);
}
echo "</div>";


//social
echo "<div class='social_block'>";
if ($settings->enabled_social) {
$url = urlencode(cmtx_get_page_url());
$title = urlencode(cmtx_get_page_reference());

$attribute = ""; //initialize variable

if ($settings->social_new_window) {
$attribute = " target='_blank'";
}

echo "<div class='social_images'>";

if ($settings->enabled_social_facebook) {
	echo "<a href='http://www.facebook.com/share.php?u=" . $url . "&amp;t=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/facebook.png' class='social_image' title='Facebook' alt='Facebook'/></a>";
}
if ($settings->enabled_social_delicious) {
	echo "<a href='http://delicious.com/post?url=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/delicious.png' class='social_image' title='del.icio.us' alt='del.icio.us'/></a>";
}
if ($settings->enabled_social_stumbleupon) {
	echo "<a href='http://www.stumbleupon.com/submit?url=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/stumbleupon.png' class='social_image' title='StumbleUpon' alt='StumbleUpon'/></a>";
}
if ($settings->enabled_social_digg) {
	echo "<a href='http://digg.com/submit?phase=2&amp;url=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/digg.png' class='social_image' title='Digg' alt='Digg'/></a>";
}
if ($settings->enabled_social_technorati) {
	echo "<a href='http://technorati.com/faves?add=" . $url . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/technorati.png' class='social_image' title='Technorati' alt='Technorati'/></a>";
}
if ($settings->enabled_social_google) {
	echo "<a href='http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/google.png' class='social_image' title='Google' alt='Google'/></a>";
}
if ($settings->enabled_social_reddit) {
	echo "<a href='http://reddit.com/submit?url=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/reddit.png' class='social_image' title='Reddit' alt='Reddit'/></a>";
}
if ($settings->enabled_social_myspace) {
	echo "<a href='http://www.myspace.com/Modules/PostTo/Pages/?u=" . $url . "&amp;t=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/myspace.png' class='social_image' title='MySpace' alt='MySpace'/></a>";
}
if ($settings->enabled_social_twitter) {
	echo "<a href='http://twitter.com/home?status=" . $title . " - " . $url . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/twitter.png' class='social_image' title='Twitter' alt='Twitter'/></a>";
}
if ($settings->enabled_social_linkedin) {
	echo "<a href='http://www.linkedin.com/shareArticle?mini=true&amp;url=" . $url . "&amp;title=" . $title . "' rel='nofollow'$attribute><img src='" . $settings->url_to_comments_folder . "images/social/linkedin.png' class='social_image' title='LinkedIn' alt='LinkedIn'/></a>";
}

echo "</div>";
}
echo "</div>";


echo "<div style='clear: both;'></div>";


echo "<div class='height_above_comment_boxes'></div>";

$loop_counter = 0;
$comment_counter = 0;

while ($comments = mysql_fetch_assoc($comments_query)) { //while there are comments

	cmtx_get_comment_and_replies($comments["id"]);

}

echo "<div class='height_below_comment_boxes'></div>";


//RSS
echo "<div class='rss_block'>";
if ($settings->rss_enabled) {
if ($settings->show_rss_this_page || $settings->show_rss_all_pages) {
if ($settings->show_rss_this_page) { ?>
<a href="<?php echo $settings->url_to_comments_folder . "rss.php?id=" . $page_id;?>" rel="nofollow"><img src="<?php echo $settings->url_to_comments_folder . "images/misc/rss.jpg";?>" class="rss_image" title="<?php echo CMTX_TITLE_RSS_THIS; ?>" alt="RSS"/></a>
<a href="<?php echo $settings->url_to_comments_folder . "rss.php?id=" . $page_id;?>" title="<?php echo CMTX_TITLE_RSS_THIS; ?>" rel="nofollow"><?php echo CMTX_RSS_THIS_PAGE ?></a>
&nbsp;
<?php }
if ($settings->show_rss_all_pages) { ?>
<a href="<?php echo $settings->url_to_comments_folder . "rss.php";?>" rel="nofollow"><img src="<?php echo $settings->url_to_comments_folder . "images/misc/rss.jpg";?>" class="rss_image" title="<?php echo CMTX_TITLE_RSS_ALL; ?>" alt="RSS"/></a>
<a href="<?php echo $settings->url_to_comments_folder . "rss.php";?>" title="<?php echo CMTX_TITLE_RSS_ALL; ?>" rel="nofollow"><?php echo CMTX_RSS_ALL_PAGES ?></a>
<?php }
}
}
echo "</div>";


//pagination (bottom)
echo "<div class='pagination_block_bottom'>";
if ($settings->enabled_pagination && $settings->show_pagination_bottom && $total_pages > 1) {
cmtx_paginate($current_page, $settings->range_of_pages, $total_pages);
}
echo "</div>";


//Comments Info
echo "<div class='info_block'>";
if ($settings->show_comments_info) { //if enabled
echo "<span class='info_text'>";
if ($settings->enabled_pagination && ($settings->show_pagination_top || $settings->show_pagination_bottom)) { //if pagination enabled
	echo CMTX_INFO_PAGE . " " . $current_page . " " . CMTX_INFO_OF . " " . $total_pages; //display pagination information
	if ($number_of_comments == 1) { //if only 1 comment
		echo " &nbsp;(" . $number_of_comments . " " . CMTX_INFO_COMMENT . ")"; //display that there is 1 comment
	} else {
		echo " &nbsp;(" . $number_of_comments . " " . CMTX_INFO_COMMENTS . ")"; //display number of comments
	}
} else { //if pagination disabled
	if ($number_of_comments == 1) {
		echo "(" . $number_of_comments . " " . CMTX_INFO_COMMENT . ")"; //display that there is 1 comment
	} else {
		echo "(" . $number_of_comments . " " . CMTX_INFO_COMMENTS . ")"; //display number of comments
	}
}
echo "</span>";
}
echo "</div>";

}

echo "<div style='clear: left;'></div>";