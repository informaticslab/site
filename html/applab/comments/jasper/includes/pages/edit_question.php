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
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<h3><?php echo CMTX_TITLE_EDIT_QUESTION ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$id = $_GET['id'];
$question = $_POST['question'];
$answer = $_POST['answer'];

$id = sanitize($id);
$question = sanitize($question);
$answer = sanitize($answer);

mysql_query("UPDATE `".$mysql_table_prefix."questions` SET question = '$question', answer = '$answer' WHERE id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_QUESTION_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
$id = $_GET['id'];
$id = sanitize($id);
$question_query = mysql_query("SELECT * FROM `".$mysql_table_prefix."questions` WHERE id = '$id'");
$question_result = mysql_fetch_assoc($question_query);
$question = $question_result["question"];
$answer = $question_result["answer"];
?>

<p />

<?php $settings = new Settings; ?>

<form name="edit_question" id="edit_question" action="index.php?page=edit_question&id=<?php echo $id ?>" method="post">
<label class='edit_question'><?php echo CMTX_FIELD_LABEL_QUESTION ?></label> <input type="text" name="question" size="50" value="<?php echo $question; ?>" maxlength="250"/>
<p />
<label class='edit_question'><?php echo CMTX_FIELD_LABEL_ANSWER ?></label> <input type="text" name="answer" size="15" value="<?php echo $answer; ?>" maxlength="250"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_confirmation()){window.location='index.php?page=layout_form_questions&action=delete&id=<?php echo $id ?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>

<p />

<a href="index.php?page=layout_form_questions"><?php echo CMTX_LINK_BACK ?></a>