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

if (isset($_POST['cmtx_submit']) || isset($_POST['cmtx_sub']) || isset($_POST['cmtx_preview']) || isset($_POST['cmtx_prev'])) { //if data submitted
	
	if (!cmtx_is_form_enabled(false)) { //if form is disabled
		return; //exit file
	}
	
	$ip_address = cmtx_get_ip_address(); //get user's ip address
	
	cmtx_check_if_banned(); //check if user is banned
	
	//initialise a few variables
	$approve = false;
	$approve_reason = "";
	$approve_total = 0;
	$error = false;
	$error_message = "";
	$error_total = 0;
	
	/* Security Key */
	if (!isset($_POST['cmtx_security_key'])) { //no security key submitted
		cmtx_ban(CMTX_BAN_REASON_NO_SECURITY_KEY); //ban user for no security key
	} else { //if security key submitted
		if ($settings->security_key != $_POST['cmtx_security_key']) { //security key incorrect
			cmtx_ban(CMTX_BAN_REASON_INCORRECT_SECURITY_KEY); //ban user for incorrect security key
		}
	}
	
	/* Check Referrer */
	if ($settings->check_referrer) {
		if (isset($_SERVER['HTTP_REFERER'])) { //if referrer available
			$referrer = parse_url(cmtx_clean_url($_SERVER['HTTP_REFERER']), PHP_URL_HOST); //get and clean referrer
			$page_url = cmtx_clean_url(cmtx_get_page_url()); //get and clean page URL
			if (!preg_match('/\.[0-9]+\./i', $page_url)) { //if URL is not an IP address
				if (!stristr($page_url, $referrer)) { //if page URL does not contain host of referrer
					cmtx_ban(CMTX_BAN_REASON_INCORRECT_REFERRER); //ban user for incorrect referrer
				}
			}
		} else {
			cmtx_error(CMTX_ERROR_MESSAGE_NO_REFERRER); //reject user for no referrer
		}
	}
	
	/* Flood Control Delay */
	if ($settings->flood_control_delay_enabled && !$is_admin) { //if 'flood control delay' enabled and user is not admin
		cmtx_flood_control_delay();
	}
	
	/* Flood Control Maximum */
	if ($settings->flood_control_maximum_enabled && !$is_admin) { //if 'flood control maximum' enabled and user is not admin
		cmtx_flood_control_maximum();
	}
	
	/* Name */
	if (!isset($_POST['cmtx_name'])) { //if name is not submitted
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}
	$name = trim($_POST['cmtx_name']); //remove any space at beginning and end
	if (empty($name)) { //if name is empty
		cmtx_error(CMTX_ERROR_MESSAGE_NO_NAME); //reject user for entering no name
	} else {
		cmtx_is_injected($name); //check for injection attempt
		cmtx_validate_name($name); //validate name
		if ($settings->reserved_names_enabled && !$is_admin) {
			$name = cmtx_check_for_word("reserved_names", 1, $name, $settings->reserved_names_action, CMTX_APPROVE_REASON_RESERVED_NAME, CMTX_ERROR_MESSAGE_RESERVED_NAME, CMTX_BAN_REASON_RESERVED_NAME);
		}
		if ($settings->dummy_names_enabled) {
			$name = cmtx_check_for_word("dummy_names", 1, $name, $settings->dummy_names_action, CMTX_APPROVE_REASON_DUMMY_NAME, CMTX_ERROR_MESSAGE_DUMMY_NAME, CMTX_BAN_REASON_DUMMY_NAME);
		}
		if ($settings->banned_names_enabled) {
			$name = cmtx_check_for_word("banned_names", 1, $name, $settings->banned_names_action, CMTX_APPROVE_REASON_BANNED_NAME, CMTX_ERROR_MESSAGE_BANNED_NAME, CMTX_BAN_REASON_BANNED_NAME);
		}
		if ($settings->one_name_enabled) {
			cmtx_check_for_one_name($name); //check only one word is entered for name
		}
		if ($settings->fix_name_enabled) {
			$name = cmtx_fix_entry($name); //makes first letter uppercase and the rest lowercase
		}
		if ($settings->detect_link_in_name_enabled) {
			cmtx_check_for_link($name, $settings->link_in_name_action, CMTX_APPROVE_REASON_LINK_IN_NAME, CMTX_ERROR_MESSAGE_LINK_IN_NAME, CMTX_BAN_REASON_LINK_IN_NAME); //detect link
		}
		$name = cmtx_sanitize($name, true, true, true);
	}

	/* Email */
	if ( (isset($_POST['cmtx_email']) && !$settings->enabled_email) || (!isset($_POST['cmtx_email']) && $settings->enabled_email) ) {
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}
	if ($settings->enabled_email) { //if email field is enabled
		$email = trim($_POST['cmtx_email']); //remove any space at beginning and end
		if ($settings->required_email && empty($email)) { //if field is required but value is empty
			cmtx_error(CMTX_ERROR_MESSAGE_NO_EMAIL); //reject user for entering no email address
		}
		if (!empty($email)) { //if email value is not empty
			cmtx_is_injected($email); //check for injection attempt
			cmtx_validate_email($email); //validate email address
			if ($settings->reserved_emails_enabled && !$is_admin) {
				$email = cmtx_check_for_word("reserved_emails", 0, $email, $settings->reserved_emails_action, CMTX_APPROVE_REASON_RESERVED_EMAIL, CMTX_ERROR_MESSAGE_RESERVED_EMAIL, CMTX_BAN_REASON_RESERVED_EMAIL);
			}
			if ($settings->dummy_emails_enabled) {
				$email = cmtx_check_for_word("dummy_emails", 0, $email, $settings->dummy_emails_action, CMTX_APPROVE_REASON_DUMMY_EMAIL, CMTX_ERROR_MESSAGE_DUMMY_EMAIL, CMTX_BAN_REASON_DUMMY_EMAIL);
			}
			if ($settings->banned_emails_enabled) {
				$email = cmtx_check_for_word("banned_emails", 0, $email, $settings->banned_emails_action, CMTX_APPROVE_REASON_BANNED_EMAIL, CMTX_ERROR_MESSAGE_BANNED_EMAIL, CMTX_BAN_REASON_BANNED_EMAIL);
			}
			$email = cmtx_sanitize($email, true, true, true);
		} else {
			$email = "";
		}
	} else {
		$email = "";
	}

	/* Website */
	if ( (isset($_POST['cmtx_website']) && !$settings->enabled_website) || (!isset($_POST['cmtx_website']) && $settings->enabled_website) ) {
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}	
	if ($settings->enabled_website) { //if website field is enabled
		$website = trim($_POST['cmtx_website']); //remove any space at beginning and end
		if ($settings->required_website && empty($website)) { //if field is required but value is empty
			cmtx_error(CMTX_ERROR_MESSAGE_NO_WEBSITE); //reject user for entering no website address
		} else if ($settings->required_website && $website == "http://") { //if field is required but value is http://
			cmtx_error(CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE); //reject user for entering default website address
		} else if (!empty($website) && $website != "http://") { //if a website address is entered
			cmtx_is_injected($website); //check for injection attempt
			cmtx_validate_website($website); //validate website
			if ($settings->approve_websites) { //if entering a website address requires approval
				cmtx_approve(CMTX_APPROVE_REASON_WEBSITE_ENTERED); //approve user for entering website
			}
			if ($settings->reserved_websites_enabled && !$is_admin) {
				$website = cmtx_check_for_word("reserved_websites", 0, $website, $settings->reserved_websites_action, CMTX_APPROVE_REASON_RESERVED_WEBSITE, CMTX_ERROR_MESSAGE_RESERVED_WEBSITE, CMTX_BAN_REASON_RESERVED_WEBSITE);
			}
			if ($settings->dummy_websites_enabled) {
				$website = cmtx_check_for_word("dummy_websites", 0, $website, $settings->dummy_websites_action, CMTX_APPROVE_REASON_DUMMY_WEBSITE, CMTX_ERROR_MESSAGE_DUMMY_WEBSITE, CMTX_BAN_REASON_DUMMY_WEBSITE);
			}			
			if ($settings->banned_websites_as_website_enabled) {
				$website = cmtx_check_for_word("banned_websites", 0, $website, $settings->banned_websites_as_website_action, CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE, CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE, CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE);
			}
			$website = strtolower($website); //convert to lowercase
			$website = cmtx_sanitize($website, true, true, true); //sanitize website address
		} else {
			$website = "http://";
		}
	} else {
		$website = "http://";
	}

	/* Town */
	if ( (isset($_POST['cmtx_town']) && !$settings->enabled_town) || (!isset($_POST['cmtx_town']) && $settings->enabled_town) ) {
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}
	if ($settings->enabled_town) { //if town field is enabled
		$town = trim($_POST['cmtx_town']); //remove any space at beginning and end
		if ($settings->required_town && empty($town)) { //if field is required but value is empty
			cmtx_error(CMTX_ERROR_MESSAGE_NO_TOWN); //reject user for entering no town
		}
		if (!empty($town)) { //if town value is not empty
			cmtx_is_injected($town); //check for injection attempt
			cmtx_validate_town($town); //validate town
			if ($settings->reserved_towns_enabled && !$is_admin) {
				$town = cmtx_check_for_word("reserved_towns", 1, $town, $settings->reserved_towns_action, CMTX_APPROVE_REASON_RESERVED_TOWN, CMTX_ERROR_MESSAGE_RESERVED_TOWN, CMTX_BAN_REASON_RESERVED_TOWN);
			}
			if ($settings->dummy_towns_enabled) {
				$town = cmtx_check_for_word("dummy_towns", 1, $town, $settings->dummy_towns_action, CMTX_APPROVE_REASON_DUMMY_TOWN, CMTX_ERROR_MESSAGE_DUMMY_TOWN, CMTX_BAN_REASON_DUMMY_TOWN);
			}
			if ($settings->banned_towns_enabled) {
				$town = cmtx_check_for_word("banned_towns", 1, $town, $settings->banned_towns_action, CMTX_APPROVE_REASON_BANNED_TOWN, CMTX_ERROR_MESSAGE_BANNED_TOWN, CMTX_BAN_REASON_BANNED_TOWN);
			}
			if ($settings->fix_town_enabled) {
				$town = cmtx_fix_entry($town); //makes first letter uppercase and the rest lowercase
			}
			if ($settings->detect_link_in_town_enabled) {
				cmtx_check_for_link($town, $settings->link_in_town_action, CMTX_APPROVE_REASON_LINK_IN_TOWN, CMTX_ERROR_MESSAGE_LINK_IN_TOWN, CMTX_BAN_REASON_LINK_IN_TOWN); //detect link
			}
			$town = cmtx_sanitize($town, true, true, true); //sanitize town
		} else {
			$town = "";
		}
	} else {
		$town = "";
	}

	/* Country */
	if ( (isset($_POST['cmtx_country']) && !$settings->enabled_country) || (!isset($_POST['cmtx_country']) && $settings->enabled_country) ) {
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}
	if ($settings->enabled_country) { //if country field is enabled
		$country = trim($_POST['cmtx_country']); //remove any space at beginning and end
		if ($settings->required_country && $country == "blank") { //if field is required but value is empty
			cmtx_error(CMTX_ERROR_MESSAGE_NO_COUNTRY); //reject user for selecting no country
		}
		if ($country != "blank") { //if country value is selected
			cmtx_is_injected($country); //check for injection attempt
			cmtx_validate_country($country); //validate country
			$country = cmtx_sanitize($country, true, true, true); //sanitize country
		} else {
			$country = "";
		}
	} else {
		$country = "";
	}

	/* Rating */
	if ($settings->repeat_ratings != "allow" && cmtx_has_rated()) { $rating = 0; } else {
		if (isset($_POST['cmtx_rating']) && !$settings->enabled_rating) {
			cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
		}
		if ($settings->enabled_rating) { //if rating field is enabled
			$rating = trim($_POST['cmtx_rating']); //remove any space at beginning and end
			if ($settings->required_rating && $rating == "blank") { //if field is required but value is empty
				cmtx_error(CMTX_ERROR_MESSAGE_NO_RATING); //reject user for selecting no rating
			}
			if ($rating != "blank") { //if rating value is selected
				cmtx_is_injected($rating); //check for injection attempt
				cmtx_validate_rating($rating); //validate rating
				$rating = cmtx_sanitize($rating, true, true, true); //sanitize rating
			} else {
				$rating = 0;
			}
		} else {
			$rating = 0;
		}
	}

	/* Reply To */
	if ( (isset($_POST['cmtx_reply_id']) && !$settings->show_reply) || (!isset($_POST['cmtx_reply_id']) && $settings->show_reply) ) {
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA);//ban user for mismatching data
	}
	if ($settings->show_reply) { //if reply field is enabled
		$reply_id = trim($_POST['cmtx_reply_id']); //remove any space at beginning and end
		cmtx_is_injected($reply_id); //check for injection attempt
		cmtx_validate_reply($reply_id); //validate reply
		$reply_to = cmtx_sanitize($reply_id, true, true, true); //sanitize reply
	} else {
		$reply_to = 0;
	}

	/* Comment */
	if (!isset($_POST['cmtx_comment'])) { //if comment not submitted
		cmtx_ban(CMTX_BAN_REASON_MISMATCHING_DATA); //ban user for mismatching data
	}
	$comment = trim($_POST['cmtx_comment']); //remove any space at beginning and end
	if (empty($comment)) { //if comment value is empty
		cmtx_error(CMTX_ERROR_MESSAGE_NO_COMMENT); //reject user for entering no comment
	} else { //if comment entered
		if ($settings->check_repeats_enabled) {
			cmtx_check_repeats($comment, $settings->check_repeats_action, CMTX_APPROVE_REASON_REPEATS, CMTX_ERROR_MESSAGE_REPEATS, CMTX_BAN_REASON_REPEATS);
		}
		if ($settings->mild_swear_words_enabled) {
			$comment = cmtx_check_for_word("mild_swear_words", 1, $comment, $settings->mild_swear_words_action, CMTX_APPROVE_REASON_MILD_SWEARING, CMTX_ERROR_MESSAGE_MILD_SWEARING, CMTX_BAN_REASON_MILD_SWEARING);
		}
		if ($settings->strong_swear_words_enabled) {
			$comment = cmtx_check_for_word("strong_swear_words", 1, $comment, $settings->strong_swear_words_action, CMTX_APPROVE_REASON_STRONG_SWEARING, CMTX_ERROR_MESSAGE_STRONG_SWEARING, CMTX_BAN_REASON_STRONG_SWEARING);
		}
		if ($settings->spam_words_enabled) {
			$comment = cmtx_check_for_word("spam_words", 1, $comment, $settings->spam_words_action, CMTX_APPROVE_REASON_SPAMMING, CMTX_ERROR_MESSAGE_SPAMMING, CMTX_BAN_REASON_SPAMMING);
		}
		if ($settings->check_capitals_enabled) {
			cmtx_comment_check_capitals($comment); //check for too many capitals
		}
		if ($settings->detect_link_in_comment_enabled) {
			cmtx_check_for_link($comment, $settings->link_in_comment_action, CMTX_APPROVE_REASON_LINK_IN_COMMENT, CMTX_ERROR_MESSAGE_LINK_IN_COMMENT, CMTX_BAN_REASON_LINK_IN_COMMENT); //detect link
		}
		if ($settings->approve_images) {
			cmtx_comment_detect_image($comment); //detect images in comment
		}
		if ($settings->approve_videos) {
			cmtx_comment_detect_video($comment); //detect videos in comment
		}
		if ($settings->banned_websites_as_comment_enabled) {
			$comment = cmtx_check_for_word("banned_websites", 0, $comment, $settings->banned_websites_as_comment_action, CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT, CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT, CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT);
		}
		$comment = cmtx_sanitize($comment, false, true, false); //converts to html entities
		if ($settings->enabled_bb_code) {
			$comment = cmtx_comment_add_bb_code($comment); //convert BB Code to html
		}
		if ($settings->enabled_smilies) {
			$comment = cmtx_comment_add_smilies($comment); //convert smilies to html
			cmtx_check_maximum_smilies($comment); //check comment meets maximum smilies requirement
		}
		$comment = cmtx_purify($comment); //purify html
		$comment = cmtx_comment_parse_links($comment); //convert links to html
		if ($settings->comment_line_breaks) {
			$comment = cmtx_comment_add_breaks($comment); //add line breaks (<br /> and <p />)
		} else {
			$comment = cmtx_comment_remove_breaks($comment); //remove line breaks
		}
		cmtx_comment_deny_long_words($comment); //check for extremely long words
		cmtx_comment_minimum($comment); //check comment meets minimum requirements
		cmtx_comment_maximum($comment); //check comment meets maximum requirements
		cmtx_comment_max_lines($comment); //check comment for too many lines
		$comment = cmtx_sanitize($comment, false, false, true); //complete sanitization
		cmtx_comment_resubmit($comment); //check comment is new
	}
		
	/* Question */
	if (isset($_SESSION['cmtx_question']) && $_SESSION['cmtx_question'] == $settings->session_key) {} else {
		if ((!isset($_POST['cmtx_supplied_answer']) || !isset($_POST['cmtx_real_answer'])) && $settings->enabled_question) {
			cmtx_error(CMTX_ERROR_MESSAGE_NO_ANSWER); //reject user for entering no answer
		} else {
			if ($settings->enabled_question) { //if question field enabled
				$supplied_answer = trim($_POST['cmtx_supplied_answer']); //get and trim supplied answer
				$real_answer = trim($_POST['cmtx_real_answer']); //get and trim real answer
				if (empty($supplied_answer)) { //if no answer entered
					cmtx_error(CMTX_ERROR_MESSAGE_NO_ANSWER); //reject user for entering no answer
				} else { //if answer entered
					if (strtolower($supplied_answer) != strtolower($real_answer)) { //if answers do not match
						cmtx_error(CMTX_ERROR_MESSAGE_WRONG_ANSWER); //reject user for entering wrong answer
					} else {
						$_SESSION['cmtx_question'] = $settings->session_key; //add question completion to session
					}
				}
			}
		}
	}
	
	/* Captcha */
	if (isset($_SESSION['cmtx_captcha']) && $_SESSION['cmtx_captcha'] == $settings->session_key) {} else {
		if (!isset($_POST['cmtx_captcha']) && $settings->enabled_captcha) {
			cmtx_error(CMTX_ERROR_MESSAGE_NO_CAPTCHA); //reject user for entering no captcha value
		} else {
			if ($settings->enabled_captcha) { //if captcha enabled
				$captcha = trim($_POST['cmtx_captcha']); //get and trim entered captcha value
				if (empty($captcha)) { //if no captcha value entered
					cmtx_error(CMTX_ERROR_MESSAGE_NO_CAPTCHA); //reject user for entering no captcha value
				} else { //if captcha value entered
					require_once $path_to_comments_folder . "captcha/securimage.php"; //load captcha script
					$securimage = new Securimage();
					$captcha_valid = $securimage->check("$captcha");
					if (!$captcha_valid) { //if entered captcha value invalid
						cmtx_error(CMTX_ERROR_MESSAGE_WRONG_CAPTCHA); //reject user for entering wrong captcha value
					} else {
						$_SESSION['cmtx_captcha'] = $settings->session_key; //add captcha completion to session
					}
				}
			}
		}
	}
	
	/* Akismet */
	if ($settings->akismet_enabled) {
		if (cmtx_akismet($name, $email, $website, $comment)) {
			cmtx_approve(CMTX_APPROVE_REASON_AKISMET); //approve user for failing Akismet test
		}
	}
		
	if ($settings->enabled_notify && isset($_POST['cmtx_notify']) && $settings->enabled_email && !empty($email) && cmtx_subscriber_exists($email, $page_id)) {
		cmtx_error(CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS); //reject user for already being subscribed
	}
	
	if ($settings->enabled_notify && isset($_POST['cmtx_notify']) && $settings->enabled_email && !empty($email) && cmtx_subscriber_bad($email)) {
		cmtx_error(CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD); //reject user for having pending subscription(s)
	}

	cmtx_check_maximums(); //check field data does not exceed the maximum lengths
	
	if ($is_admin) { $is_admin = 1;	} else { $is_admin = 0;	} //prepare for database
	
	if ($error) { //if there were any errors
	
		//build the error box
		$box = "<div class='error_box'>";
		if ($error_total == 1) {
			$box .= "<div class='error_message_part_1'>";
			$box .= CMTX_ERROR_NUMBER_PART_1 . $error_total . CMTX_ERROR_NUMBER_PART_2;
			$box .= "</div>";
			$box .= "<div style='margin-bottom: 10px;'></div>";
			$box .= "<div class='error_message_part_2'>";
			$box .= CMTX_ERROR_CORRECTION;
			$box .= "</div>";
		} else {
			$box .= "<div class='error_message_part_1'>";
			$box .= CMTX_ERRORS_NUMBER_PART_1 . $error_total . CMTX_ERRORS_NUMBER_PART_2;
			$box .= "</div>";
			$box .= "<div style='margin-bottom: 10px;'></div>";
			$box .= "<div class='error_message_part_2'>";
			$box .= CMTX_ERRORS_CORRECTION;
			$box .= "</div>";
		}
		$box .= "<div class='error_details'>";
		$box .= "<ul>" . $error_message . "</ul>";
		$box .= "</div>";
		$box .= "</div>";
		$box .= "<div style='clear: left;'></div>";
		
		cmtx_repopulate(); //repopulate the form with submitted values
		
	} else if (isset($_POST['cmtx_preview']) || isset($_POST['cmtx_prev'])) { //if preview was selected
		
		//remove any escapes from data
		$name = cmtx_strip($name);
		$email = cmtx_strip($email);
		$website = cmtx_strip($website);
		$town = cmtx_strip($town);
		$country = cmtx_strip($country);
		$comment = cmtx_strip($comment);
		
		//build the preview box using submitted values
		$box = cmtx_generate_comment (true, 1, 0, $name, $email, $website, $town, $country, $rating, '0', $comment, '', $is_admin, 0, 0, 0, 0, date("Y-m-d H:i:s"));
		
		$box .= "<div style='clear: left;'></div>";
		
		cmtx_repopulate(); //repopulate the form with submitted values
	
	} else if ($approve || $settings->approve_comments) { //if approval needed

		//insert user's comment into 'comments' database table
		mysql_query("INSERT INTO `".$mysql_table_prefix."comments` (name, email, website, town, country, rating, reply_to, comment, reply, ip_address, page_id, is_approved, approval_reasoning, is_admin, is_sent, sent_to, vote_up, vote_down, is_sticky, is_locked, dated) VALUES ('$name', '$email', '$website', '$town', '$country', '$rating', '$reply_to', '$comment', '', '$ip_address', '$page_id', 0, '$approve_reason', $is_admin, 0, 0, 0, 0, 0, 0, NOW())");
		
		//build the approval box
		$box = "<div class='approval_box'>";
		$box .= "<div class='approval_opening_text'>";
		$box .= CMTX_APPROVAL_OPENING;
		$box .= "</div>";
		$box .= "<div style='margin-bottom:10px;'></div>";
		$box .= "<div class='approval_normal_text'>";
		
		$box .= CMTX_APPROVAL_TEXT;
		
		//add new subscriber
		if ($settings->enabled_notify && isset($_POST['cmtx_notify']) && $settings->enabled_email && !empty($email) && !cmtx_subscriber_exists($email, $page_id) && !cmtx_subscriber_bad($email)) {
			cmtx_add_subscriber($name, $email, $page_id);
			$box .= "<div style='margin-bottom:10px;'></div>";
			$box .= CMTX_APPROVAL_SUBSCRIBER;
		}
		
		$box .= "</div>";
		$box .= "</div>";
		$box .= "<div style='clear: left;'></div>";
		
		cmtx_notify_admin_new_comment_approve($name, $comment, $page_id); //notify admin of new comment
		
		cmtx_set_form_cookie($name, $email, $website, $town, $country); //save form inputs
		$default_name = cmtx_strip(cmtx_decode($name));
		$default_email = cmtx_strip(cmtx_decode($email));
		$default_website = cmtx_strip(cmtx_decode($website));
		$default_town = cmtx_strip(cmtx_decode($town));
		$default_country = cmtx_strip(cmtx_decode($country));
		
		$_SESSION['cmtx_comment'] = cmtx_strip(cmtx_decode($comment)); //add comment to session
		
		$reply_id = 0; //reset the reply id
		$reply_message = ""; //reset the reply message
		
		$_SESSION['cmtx_question'] = ""; //reset session
		$_SESSION['cmtx_captcha'] = ""; //reset session
		
	} else { //if comment is a success (no approval required)
		
		//insert user's comment into 'comments' database table
		mysql_query("INSERT INTO `".$mysql_table_prefix."comments` (name, email, website, town, country, rating, reply_to, comment, reply, ip_address, page_id, is_approved, approval_reasoning, is_admin, is_sent, sent_to, vote_up, vote_down, is_sticky, is_locked, dated) VALUES ('$name', '$email', '$website', '$town', '$country', '$rating', '$reply_to', '$comment', '', '$ip_address', '$page_id', 1, '', $is_admin, 0, 0, 0, 0, 0, 0, NOW())"); //insert user's comment into 'comments' db table
		
		//build the success box
		$box = "<div class='success_box'>";
		$box .= "<div class='success_opening_text'>";
		$box .= CMTX_SUCCESS_OPENING;
		$box .= "</div>";
		$box .= "<div style='margin-bottom:10px;'></div>";
		$box .= "<div class='success_normal_text'>";
		
		$box .= CMTX_SUCCESS_TEXT;
		
		//add new subscriber
		if ($settings->enabled_notify && isset($_POST['cmtx_notify']) && $settings->enabled_email && !empty($email) && !cmtx_subscriber_exists($email, $page_id) && !cmtx_subscriber_bad($email) && !$is_admin) {
			cmtx_add_subscriber($name, $email, $page_id);
			$box .= "<div style='margin-bottom:10px;'></div>";
			$box .= CMTX_SUCCESS_SUBSCRIBER;
		}
		
		$box .= "</div>";
		$box .= "</div>";
		$box .= "<div style='clear: left;'></div>";
		
		//notify subscribers of new comment
		if ($settings->enabled_notify) {
			if ($is_admin) {
				cmtx_notify_subscribers($name, $comment, $page_id);
			} else {
				if (!$settings->approve_notifications) {
					cmtx_notify_subscribers($name, $comment, $page_id);
				}
			}
		}
		
		cmtx_notify_admin_new_comment_okay($name, $comment, $page_id); //notify admin of new comment
		
		cmtx_set_form_cookie($name, $email, $website, $town, $country); //save form inputs
		$default_name = cmtx_strip(cmtx_decode($name));
		$default_email = cmtx_strip(cmtx_decode($email));
		$default_website = cmtx_strip(cmtx_decode($website));
		$default_town = cmtx_strip(cmtx_decode($town));
		$default_country = cmtx_strip(cmtx_decode($country));
		
		$_SESSION['cmtx_comment'] = cmtx_strip(cmtx_decode($comment)); //add comment to session
		
		$reply_id = 0; //reset the reply id
		$reply_message = ""; //reset the reply message
		
		$_SESSION['cmtx_question'] = ""; //reset session
		$_SESSION['cmtx_captcha'] = ""; //reset session
		
	}
	
} //end of if-data-submitted
?>