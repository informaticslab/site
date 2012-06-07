<?xml version="1.0" encoding="utf-8"?>
<jomsocial>
	<component>com_jcomments</component>
	<rules>
		<rule>
			<name>Add Comment</name>
			<description>Give points when registered user add new comment.</description>
			<action_string>com_jcomments.comment.add</action_string>
			<publish>true</publish>
			<points>1</points>
			<access_level>1</access_level>       
		</rule>
		<rule>
			<name>Update Comment</name>
			<description>Give points when registered user or admininstator/moderator update comment.</description>
			<action_string>com_jcomments.comment.update</action_string>
			<publish>true</publish>
			<points>1</points>
			<access_level>1</access_level>
		</rule>		
		<rule>
			<name>Remove Comment</name>
			<description>Deduct points when registered user or admininstator/moderator remove comment.</description>
			<action_string>com_jcomments.comment.remove</action_string>
			<publish>true</publish>
			<points>-1</points>
			<access_level>1</access_level>
		</rule>
	</rules>
</jomsocial>