<?xml version="1.0" encoding="iso-8859-1"?>
<mosinstall type="mambot" group="content" version="1.0.0">
	<name>Content - JComments</name>
	<creationDate>02/01/2010</creationDate>
	<author>smart</author>
	<copyright>Copyright 2006-2010 JoomlaTune.ru All rights reserved!</copyright>
	<authorEmail>smart@joomlatune.ru</authorEmail>
	<authorUrl>http://www.joomlatune.ru</authorUrl>
	<license>http://www.gnu.org/copyleft/gpl.html GNU/GPL</license>
	<version>1.0</version>
	<description>Mambot for attaching comments list and form to content item</description>
	<files>
		<filename mambot="jcomments">jcomments.php</filename>
	</files>
	<params>
		<param name="show_frontpage" type="radio" default="1" label="Show on Frontpage" description="Show links Add comment on Frontpage">
			<option value="0">No</option>
			<option value="1">Yes</option>
		</param>
		<param name="show_blogs" type="radio" default="1" label="Show on Blogs" description="Show links Add comment on Blog-Section or Blog-Categoruy pages">
			<option value="0">No</option>
			<option value="1">Yes</option>
		</param>
	</params>
</mosinstall>