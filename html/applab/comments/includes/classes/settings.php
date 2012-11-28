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

class Settings {

  private $settings;

  public function __get($name) {
	global $mysql_table_prefix;
    if (!$this->settings) {
      $result = mysql_query("SELECT * FROM `".$mysql_table_prefix."settings`");
      $this->settings = array();
      while ($row = mysql_fetch_assoc($result)) {
        $this->settings[$row['title']] = $row['value'];
      }
    }
    return $this->settings[$name];
  }
  
}

?>