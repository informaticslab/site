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


function cmtx_get_comment_and_replies($id) {

	global $mysql_table_prefix, $settings, $page_id, $loop_counter, $comment_counter, $offset; //globalise variables

	$loop_counter++; //increase loop counter by 1
	
	//switch box number each time
	if ($comment_counter%2 == 0) {
		$alternate = 1;
	} else {
		$alternate = 2;
	}
		
	if ($comment_counter != 0) { echo "<div class='height_between_comments'></div>"; } //don't display on first run
	
	//get the details of the comment
	$comments_q = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	$comments = mysql_fetch_assoc($comments_q);

	if (!$settings->enabled_pagination) { //if pagination is disabled
	
			//display comment
			echo cmtx_generate_comment (FALSE, $alternate, $comments["id"], $comments["name"], $comments["email"], $comments["website"], $comments["town"], $comments["country"], $comments["rating"], $comments["reply_to"], $comments["comment"], $comments["reply"], $comments["is_admin"], $comments["vote_up"], $comments["vote_down"], $comments["is_sticky"], $comments["is_locked"], $comments["dated"]);
			$comment_counter++; //increase comment counter by 1
	
	} else { //apply pagination
	
		if ($loop_counter > $offset && $loop_counter < $offset + ($settings->comments_per_page + 1)) { //skip unwanted comments
	
			//display comment
			echo cmtx_generate_comment (FALSE, $alternate, $comments["id"], $comments["name"], $comments["email"], $comments["website"], $comments["town"], $comments["country"], $comments["rating"], $comments["reply_to"], $comments["comment"], $comments["reply"], $comments["is_admin"], $comments["vote_up"], $comments["vote_down"], $comments["is_sticky"], $comments["is_locked"], $comments["dated"]);
			$comment_counter++; //increase counter by 1
	
		}
		
	}
	
    if (cmtx_comment_has_reply($id)) { //if the comment has a reply
	
		//get all of its replies
		$reply_q = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '$id' AND is_approved = '1' AND page_id = '$page_id' ORDER BY dated ASC");
		
		while ($replies = mysql_fetch_assoc($reply_q)) { //while there are replies
		
			cmtx_get_comment_and_replies($replies["id"]); //re-call this function to display the reply AND any replies it may have
				
		}
		
    }

} //end of get-comment-and-replies function


function cmtx_comment_has_reply($id) {

	global $mysql_table_prefix, $page_id; //globalise variables

	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE reply_to = '$id' AND is_approved = '1'"))) {
		return true;
	} else {
		return false;
	}
	
} //end of comment-has-reply function


function cmtx_get_reply_to($id) {

	global $mysql_table_prefix; //globalise variables

	$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$id'");
	$result = mysql_fetch_assoc($query);
	
	return $result["reply_to"];
	
} //end of get-reply-to function


function cmtx_get_reply_depth($id) {

	global $mysql_table_prefix; //globalise variables

	$reply_depth = 0;
	$reply_to = cmtx_get_reply_to($id);
	
	if ($reply_to != 0) {
		$reply_depth++;
	}
	
	while ($reply_to != 0) {
	
		$query = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE id = '$reply_to' AND is_approved = '1'");
		$result = mysql_fetch_assoc($query);
		
		if (mysql_num_rows($query)) {
			
			$reply_to = $result["reply_to"];
			
			if ($reply_to != 0) {
				$reply_depth++;
			}
			
		}
	
	}
	
	return $reply_depth;
	
} //end of get-reply-depth function


function cmtx_generate_comment ($is_preview, $alternate, $id, $name, $email, $website, $town, $country, $rating, $reply_to, $comment, $reply, $is_admin, $vote_up, $vote_down, $is_sticky, $is_locked, $dated) { //generate comment

global $settings; //globalise settings

$box = ""; //initialise box

for ($i = 1; $i <= cmtx_get_reply_depth($id); $i++) {
	if ($settings->reply_arrow && $i == cmtx_get_reply_depth($id)) {
		$box .= "<div class='reply_arrow'>"; //add the reply arrow
	}
	$box .= '<div class="reply_indent">'; //indent the reply
}

if ($alternate == 1) { //if it's the first box

	if (!$reply_to && !$is_admin) {
        $box .= "<div class='comment_box_1'>"; //comment and not admin
    } else if ($reply_to && !$is_admin) {
        $box .= "<div class='reply_box_1'>"; //reply and not admin
    } else if (!$reply_to && $is_admin) {
        $box .= "<div class='admin_comment_box_1'>"; //comment and is admin
    } else if ($reply_to && $is_admin) {
        $box .= "<div class='admin_reply_box_1'>"; //reply and is admin
    }

} else { //if it's the second box
	
	if (!$reply_to && !$is_admin) {
        $box .= "<div class='comment_box_2'>"; //comment and not admin
    } else if ($reply_to && !$is_admin) {
        $box .= "<div class='reply_box_2'>"; //reply and not admin
    } else if (!$reply_to && $is_admin) {
        $box .= "<div class='admin_comment_box_2'>"; //comment and is admin
    } else if ($reply_to && $is_admin) {
        $box .= "<div class='admin_reply_box_2'>"; //reply and is admin
    }
	
}

//Sticky (1/2)
if ($is_sticky) {
$box .= "<div class='sticky_image'>";
}

//Gravatar (1/2)
if ($settings->enabled_gravatar) {
$box .= "<div class='gravatar_block'>";
$gravatar_parameter = "&amp;r=" . $settings->gravatar_rating;
if ($settings->gravatar_default != "") {
$gravatar_parameter .= "&amp;d=" . $settings->gravatar_default;
}
$box .= "<img src='http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . ".png?s=71" . $gravatar_parameter . "' alt='Gravatar' title='Gravatar'/>";
$box .= "</div>";
$box .= "<div style='clear: right;'></div>";
$box .= "<div class='non_gravatar_block'>";
}

//Rating
if ($settings->show_rating && $rating != 0) {
$box .= "<div class='rating_block'>";
if ($rating == 1) {
$box .= cmtx_star_full(1);
$box .= cmtx_star_empty(4);
} else if ($rating == 2) {
$box .= cmtx_star_full(2);
$box .= cmtx_star_empty(3);
} else if ($rating == 3) {
$box .= cmtx_star_full(3);
$box .= cmtx_star_empty(2);
} else if ($rating == 4) {
$box .= cmtx_star_full(4);
$box .= cmtx_star_empty(1);
} else if ($rating == 5) {
$box .= cmtx_star_full(5);
}
$box .= "</div>";
}

//Name and Website
if ($settings->show_website && !empty($website) && $website != "http://") {
$attribute = ""; //initialize variable
if ($settings->website_new_window) { $attribute = " target='_blank'"; } //if website should open in new window
if ($settings->website_nofollow) { $attribute .= " rel='nofollow'";	} //if website should contain nofollow tag
$box .= "<a class='name_with_website_text' href='" . $website . "'$attribute>" . $name . "</a>";
} else {
$box .= "<span class='name_without_website_text'>";
$box .= $name;
$box .= "</span>";
}

//Town and Country
if ($settings->show_town && !empty($town) && $settings->show_country && !empty($country)) {
$box .= "<span class='town_country_text'>";
$box .= " (" . $town . ", " . $country . ")";
$box .= "</span>";
} else if ($settings->show_town && !empty($town)) {
$box .= "<span class='town_country_text'>";
$box .= " (" . $town . ")";
$box .= "</span>";
} else if ($settings->show_country && !empty($country)) {
$box .= "<span class='town_country_text'>";
$box .= " (" . $country . ")";
$box .= "</span>";
}

//Says...
if ($settings->show_says) {
$box .= "<span class='says_text'>";
$box .= " " . CMTX_SAYS;
$box .= "</span>";
}

$box .= "<div class='height_above_comment_text'></div>";

//Comment
$box .= "<div class='comment_text'>";
$box .= $comment;
$box .= "</div>";

//Admin Reply
if (!empty($reply)) {
$box .= "<div class='height_above_reply_text'></div>";
$box .= "<div class='reply_intro'>";
$box .= CMTX_REPLY_INTRO;
$box .= "</div>";
$box .= " ";
$box .= "<div class='reply_text'>";
$box .= $reply;
$box .= "</div>";
}

$box .= "<div class='height_below_comment_text'></div>";

//Preview Message
if ($is_preview) {
$box .= "<div class='preview_block'>";
$box .= "<span class='preview_text'>";
$box .= CMTX_PREVIEW_TEXT;
$box .= "</span>";
$box .= "</div>";
}

$box .= "<div class='buttons_block'>";

//Reply
if ($settings->show_reply && !$is_preview) {
$box .= "<div class='reply_block'>";
$box .= "<div class='buttons'>";
if (cmtx_get_reply_depth($id) < $settings->reply_depth && !$is_locked) {
$box .= "<a class='reply_enabled' href='" . CMTX_ANCHOR_FORM . "' title='" . CMTX_TITLE_REPLY . "' rel='nofollow' onclick='";
$box .= "document.getElementById(\"hide_reply\").style.display=\"inline\";";
$box .= "document.getElementById(\"cmtx_reply_id\").value=\"" . $id . "\";";
$box .= "document.getElementById(\"reply_message\").innerHTML=\"" . CMTX_REPLY_MESSAGE . " " . $name . '. ' . "\";";
$box .= "document.getElementById(\"reset_reply\").style.display=\"inline\"'>";
$box .= "<img src='" . $settings->url_to_comments_folder . "images/buttons/reply.png' alt='Reply' title='" . CMTX_TITLE_REPLY . "'/>" . CMTX_REPLY . "</a>";
} else {
$box .= "<a class='reply_disabled' href='#' title='' rel='nofollow'>";
$box .= "<img src='" . $settings->url_to_comments_folder . "images/buttons/reply.png' alt='Reply' title=''/>" . CMTX_REPLY . "</a>";
}
$box .= "</div>";
$box .= "</div>";
}

//Flag
if ($settings->show_flag && !$is_preview) {
$box .= "<div class='flag_block'>";
$box .= "<div class='buttons'>";
$box .= "<a class='flag' href='' id='flag_" . $id . "' name='flag' title='" . CMTX_TITLE_FLAG . "' rel='nofollow'><img src='" . $settings->url_to_comments_folder . "images/buttons/flag.png' alt='Flag' title='" . CMTX_TITLE_FLAG . "'/>" . CMTX_FLAG . "</a>";
$box .= "</div>";
$box .= "</div>";
}

//Like/Dislike
if (($settings->show_like || $settings->show_dislike) && !$is_preview) {
$box .= "<div class='like_block'>";
$box .= "<div class='buttons'>";
if ($settings->show_like) {
$box .= "<a class='vote vote_up' href='' id='vote_up_" . $id . "' name='up' title='" . CMTX_TITLE_VOTE_UP . "' rel='nofollow'><img src='" . $settings->url_to_comments_folder . "images/buttons/up.png' alt='Up' title='" . CMTX_TITLE_VOTE_UP . "'/>" . $vote_up . "</a>";
}
if ($settings->show_dislike) {
$box .= "<a class='vote vote_down' href='' id='vote_down_" . $id . "' name='down' title='" . CMTX_TITLE_VOTE_DOWN . "' rel='nofollow'><img src='" . $settings->url_to_comments_folder . "images/buttons/down.png' alt='Down' title='" . CMTX_TITLE_VOTE_DOWN . "'/>" . $vote_down . "</a>";
}
$box .= "</div>";
$box .= "</div>";
}

$box .= "</div>";

//Date
if ($settings->show_date) {
$box .= "<span class='date_text'>";
if (date("Y-m-d", strtotime($dated)) == date("Y-m-d")) { //if comment's date is today
$box .= CMTX_TODAY . " " . date($settings->time_format, strtotime($dated));
} else if (date("Y-m-d", strtotime($dated)) == date("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y")))) { //if comment's date is yesterday
$box .= CMTX_YESTERDAY . " " . date($settings->time_format, strtotime($dated));
} else {
$box .= date($settings->date_time_format, strtotime($dated));
}
$box .= "</span>";
}

//Sticky (2/2)
if ($is_sticky) {
$box .= "</div>";
}

//Gravatar (2/2)
if ($settings->enabled_gravatar) {
$box .= "</div>";
}

$box .= "</div>"; //end div

for ($i = 1; $i <= cmtx_get_reply_depth($id); $i++) {
	if ($settings->reply_arrow && $i == cmtx_get_reply_depth($id)) {
		$box .= "</div>";
	}
	$box .= "</div>";
}

return $box;

} //end of generate-comment function


function cmtx_paginate ($current_page, $range_of_pages, $total_pages) { //display pagination

global $settings; //globalise settings

if ($current_page > 1) { //if not on page 1
   echo " <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_page=1" . cmtx_get_query("pagination") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_PAG_FIRST . "'>" . CMTX_PAGINATION_FIRST . "</a> "; // show link to go back to page 1
   $previous_page = $current_page - 1; //get previous page number
   echo " <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_page=$previous_page" . cmtx_get_query("pagination") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_PAG_PREVIOUS . "'>" . CMTX_PAGINATION_PREVIOUS . "</a> "; //show link to go back 1 page
}

for ($x = ($current_page - $range_of_pages); $x < (($current_page + $range_of_pages) + 1); $x++) { //loop to show links to range of pages around current page
	if (($x > 0) && ($x <= $total_pages)) { //if it's a valid page number
      if ($x == $current_page) { //if we're on current page
        echo " $x "; //show it but don't make it a link
      } else { //if not current page
		echo " <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_page=$x" . cmtx_get_query("pagination") . CMTX_ANCHOR_COMMENTS . "' title='$x'>$x</a> "; //make it a link
      }
   }
}
		 
if ($current_page != $total_pages) { //if not on last page, show forward and last page links
   $next_page = $current_page + 1; //get next page
   echo " <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_page=$next_page" . cmtx_get_query("pagination") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_PAG_NEXT . "'>" . CMTX_PAGINATION_NEXT . "</a> "; //display forward link for next page 
   echo " <a href='" . htmlentities(strtok($_SERVER['REQUEST_URI'], "?")) . "?cmtx_page=$total_pages" . cmtx_get_query("pagination") . CMTX_ANCHOR_COMMENTS . "' title='" . CMTX_TITLE_PAG_LAST . "'>" . CMTX_PAGINATION_LAST . "</a> "; //display forward link for last page
}

} //end of paginate function


function cmtx_star_full ($amount) { //star full

global $settings; //globalise settings

$star_full = '';

for ($counter=1; $counter<=$amount; $counter++) {
	$star_full .= "<img src='" . $settings->url_to_comments_folder . "images/stars/star_full.png' title='" . CMTX_TITLE_FULL_STAR . "' alt='Full Star' class='star_image'/>";
}

return $star_full;

} //end of star-full function


function cmtx_star_empty ($amount) { //star empty

global $settings; //globalise settings

$star_empty = '';

for ($counter=1; $counter<=$amount; $counter++) {
	$star_empty .= "<img src='" . $settings->url_to_comments_folder . "images/stars/star_empty.png' title='" . CMTX_TITLE_EMPTY_STAR . "' alt='Empty Star' class='star_image'/>";
}

return $star_empty;

} //end of star-empty function


function cmtx_star_full_avg ($amount) { //star full for average rating

global $settings; //globalise settings

$star_full = '';

for ($counter=1; $counter<=$amount; $counter++) {
	$star_full .= "<img src='" . $settings->url_to_comments_folder . "images/stars/star_full.png' title='" . CMTX_TITLE_FULL_STAR . "' alt='Full Star' class='star_image_avg'/>";
}

return $star_full;

} //end of star-full-avg function


function cmtx_star_half_avg ($amount) { //star half for average rating

global $settings; //globalise settings

$star_half = '';

for ($counter=1; $counter<=$amount; $counter++) {
	$star_half .= "<img src='" . $settings->url_to_comments_folder . "images/stars/star_half.png' title='" . CMTX_TITLE_HALF_STAR . "' alt='Half Star' class='star_image_avg'/>";
}

return $star_half;

} //end of star-half-avg function


function cmtx_star_empty_avg ($amount) { //star empty for average rating

global $settings; //globalise settings

$star_empty = '';

for ($counter=1; $counter<=$amount; $counter++) {
	$star_empty .= "<img src='" . $settings->url_to_comments_folder . "images/stars/star_empty.png' title='" . CMTX_TITLE_EMPTY_STAR . "' alt='Empty Star' class='star_image_avg'/>";
}

return $star_empty;

} //end of star-empty-avg function


function cmtx_number_of_comments() { //get total number of comments

global $mysql_table_prefix, $page_id; //globalise variables

$result = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE is_approved = '1' AND page_id = '$page_id'");

$total = mysql_num_rows($result);

return $total;

} //end of number_of_comments function


function cmtx_number_of_ratings() { //get total number of ratings

global $mysql_table_prefix, $page_id; //globalise variables

$result = mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE page_id = '$page_id' AND rating != '0' AND is_approved = '1'");

$total = mysql_num_rows($result);

return $total;

} //end of number_of_ratings function


function cmtx_average_rating() { //get average rating

global $mysql_table_prefix, $page_id; //globalise variables

$result = mysql_query("SELECT AVG(rating) FROM `".$mysql_table_prefix."comments` WHERE is_approved = '1' AND rating != '0' AND page_id = '$page_id'");

$average = mysql_fetch_assoc($result);

$average = round($average["AVG(rating)"]/0.5)*0.5;

return $average;

} //end of average-rating function
?>