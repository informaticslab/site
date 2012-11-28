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

<h3><?php echo CMTX_TITLE_FORM_QUESTIONS ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$question = $_POST['question'];
$answer = $_POST['answer'];

$question = sanitize($question);
$answer = sanitize($answer);

mysql_query("INSERT INTO `".$mysql_table_prefix."questions` (question, answer) VALUES ('$question', '$answer');");
?>
<div class="success"><?php echo CMTX_MSG_QUESTION_ADDED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php
if ( isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && ctype_digit($_GET['id']) ) {
if ($settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else {
$id = $_GET['id'];
$id = sanitize($id);
mysql_query("DELETE FROM `".$mysql_table_prefix."questions` WHERE id = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_QUESTION_DELETED ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<p />

<?php $settings = new Settings; ?>

<form name="add_question" id="add_question" action="index.php?page=layout_form_questions" method="post">
<?php echo CMTX_FIELD_LABEL_QUESTION ?> <input type="text" name="question" size="50" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_ANSWER ?> <input type="text" name="answer" size="15" maxlength="250"/>&nbsp;
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_ADD_QUESTION ?>" value="<?php echo CMTX_BUTTON_ADD_QUESTION ?>"/>
</form>

<br />

<table id="data" class="display" summary="Questions">
    <thead>
    	<tr>
        	<th><?php echo CMTX_TABLE_QUESTION ?></th>
            <th><?php echo CMTX_TABLE_ANSWER ?></th>
            <th><?php echo CMTX_TABLE_ACTION ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$questions = mysql_query("SELECT * FROM `".$mysql_table_prefix."questions`");
while ($question = mysql_fetch_assoc($questions)) {
?>
    	<tr>
        	<td><?php echo $question["question"]; ?></td>
            <td><?php echo $question["answer"]; ?></td>
			<td>
			<a href="<?php echo "index.php?page=edit_question&id=" . $question["id"];?>"><img src="images/buttons/edit.png" class="button_edit" title="Edit" alt="Edit"></a>
			<a href="<?php echo "index.php?page=layout_form_questions&action=delete&id=" . $question["id"];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_confirmation()" title="Delete" alt="Delete"></a>
			</td>
        </tr>	
<?php } ?>

    </tbody>
</table>