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


function cmtx_is_form_enabled ($display_msg) { //checks whether form is enabled

	global $mysql_table_prefix, $settings, $page_id; //globalise variables

	if (!$settings->enabled_form) {
		if ($display_msg) {
			?><span class="all_forms_disabled_message"><?php echo CMTX_ALL_FORMS_DISABLED ?></span><?php
		}
		return false;
	} else if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."pages` WHERE id = '$page_id' AND is_form_enabled = '0'"))) {
		if ($display_msg) {
			?><span class="this_form_disabled_message"><?php echo CMTX_THIS_FORM_DISABLED ?></span><?php
		}
		return false;
	}
	
	return true;
	
} //end of is-form-enabled function


function cmtx_load_form_defaults() { //load default form field values

	global $settings, $default_name, $default_email, $default_website, $default_town, $default_country, $default_rating, $default_comment, $default_notify, $default_privacy, $default_terms; //globalise variables

	if (!isset($default_name)) { $default_name = $settings->default_name; }
	if (!isset($default_email)) { $default_email = $settings->default_email; }
	if (!isset($default_website)) { $default_website = $settings->default_website; }
	if (!isset($default_town)) { $default_town = $settings->default_town; }
	if (!isset($default_country)) { $default_country = $settings->default_country; }
	if (!isset($default_rating)) { $default_rating = $settings->default_rating; }
	if (!isset($default_comment)) { $default_comment = $settings->default_comment; }
	if (!isset($default_notify)) { $default_notify = $settings->default_notify; }
	if (!isset($default_privacy)) { $default_privacy = $settings->default_privacy; }
	if (!isset($default_terms)) { $default_terms = $settings->default_terms; }
	
} //end of load-form-defaults function


function cmtx_load_form_cookie() { //load cookie form field values

	global $default_name, $default_email, $default_website, $default_town, $default_country; //globalise variables
	
	if (isset($_COOKIE['Commentics-Form']) && $_COOKIE['Commentics-Form'] < 500) {
		
		$values = explode('|', $_COOKIE['Commentics-Form']);
		
		if (count($values) == 5) {
		
			$default_name = $values[0];
			$default_email = $values[1];
			$default_website = $values[2];
			$default_town = $values[3];
			$default_country = $values[4];
		
		}
		
	}
	
} //end of load-form-cookie function


function cmtx_has_rated() { //checks whether user has already rated

	global $mysql_table_prefix, $page_id; //globalise variables
	
	$rated = false; //initialise flag as false

	if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."comments` WHERE page_id = '$page_id' AND ip_address = '" . cmtx_get_ip_address() . "' AND rating != '0'")) != 0) {
		$rated = true;
	}
	
	return $rated;
	
} //end of has-rated function
?>