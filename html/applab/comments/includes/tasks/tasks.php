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

if ($settings->task_enabled_delete_bans) {
require $path_to_comments_folder . "includes/tasks/delete_bans.php"; //load task to delete bans
}

if ($settings->task_enabled_delete_reports) {
require $path_to_comments_folder . "includes/tasks/delete_reports.php"; //load task to delete reports
}

if ($settings->task_enabled_delete_voters) {
require $path_to_comments_folder . "includes/tasks/delete_voters.php"; //load task to delete voters
}

if ($settings->task_enabled_delete_comment_ips) {
require $path_to_comments_folder . "includes/tasks/delete_comment_ips.php"; //load task to delete comment ip addresses
}

if ($settings->task_enabled_delete_unconfirmed_subscribers) {
require $path_to_comments_folder . "includes/tasks/delete_unconfirmed_subscribers.php"; //load task to delete unconfirmed subscribers
}

if ($settings->task_enabled_delete_inactive_subscribers) {
require $path_to_comments_folder . "includes/tasks/delete_inactive_subscribers.php"; //load task to delete inactive subscribers
}

?>