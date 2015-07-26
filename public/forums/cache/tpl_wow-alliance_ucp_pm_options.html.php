<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('ucp_header.html'); if ($this->_rootref['ERROR_MESSAGE'] || $this->_rootref['NOTIFICATION_MESSAGE']) {  ?>

	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="row3" align="center">
			<?php if ($this->_rootref['ERROR_MESSAGE']) {  ?><span class="genmed error"><?php echo (isset($this->_rootref['ERROR_MESSAGE'])) ? $this->_rootref['ERROR_MESSAGE'] : ''; ?></span><?php } if ($this->_rootref['NOTIFICATION_MESSAGE']) {  ?><span class="genmed error"><?php echo (isset($this->_rootref['NOTIFICATION_MESSAGE'])) ? $this->_rootref['NOTIFICATION_MESSAGE'] : ''; ?></span><?php } ?>

		</td>
	</tr>
	</table>
	<div style="padding: 2px;"></div>
<?php } ?>


<form name="ucp" method="post" action="<?php echo (isset($this->_rootref['S_UCP_ACTION'])) ? $this->_rootref['S_UCP_ACTION'] : ''; ?>">

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_ADD_NEW_RULE'])) ? $this->_rootref['L_ADD_NEW_RULE'] : ((isset($user->lang['ADD_NEW_RULE'])) ? $user->lang['ADD_NEW_RULE'] : '{ ADD_NEW_RULE }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<?php if ($this->_rootref['S_CHECK_DEFINED']) {  ?>

	<tr>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="top"><b class="gen"><?php echo ((isset($this->_rootref['L_IF'])) ? $this->_rootref['L_IF'] : ((isset($user->lang['IF'])) ? $user->lang['IF'] : '{ IF }')); ?>:</b></td>
		<td class="row2" align="center" valign="top"><?php if ($this->_rootref['S_CHECK_SELECT']) {  ?><select name="check_option"><?php echo (isset($this->_rootref['S_CHECK_OPTIONS'])) ? $this->_rootref['S_CHECK_OPTIONS'] : ''; ?></select><?php } else { ?><b class="gen"><?php echo (isset($this->_rootref['CHECK_CURRENT'])) ? $this->_rootref['CHECK_CURRENT'] : ''; ?></b><input type="hidden" name="check_option" value="<?php echo (isset($this->_rootref['CHECK_OPTION'])) ? $this->_rootref['CHECK_OPTION'] : ''; ?>" /><?php } ?></td>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_CHECK_SELECT']) {  ?><input type="submit" name="next" value="<?php echo ((isset($this->_rootref['L_NEXT_STEP'])) ? $this->_rootref['L_NEXT_STEP'] : ((isset($user->lang['NEXT_STEP'])) ? $user->lang['NEXT_STEP'] : '{ NEXT_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
	</tr>
<?php } if ($this->_rootref['S_RULE_DEFINED']) {  ?>

	<tr>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_RULE_SELECT']) {  ?><input type="submit" name="back[rule]" value="<?php echo ((isset($this->_rootref['L_PREVIOUS_STEP'])) ? $this->_rootref['L_PREVIOUS_STEP'] : ((isset($user->lang['PREVIOUS_STEP'])) ? $user->lang['PREVIOUS_STEP'] : '{ PREVIOUS_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
		<td class="row2" align="center" valign="top"><?php if ($this->_rootref['S_RULE_SELECT']) {  ?><select name="rule_option"><?php echo (isset($this->_rootref['S_RULE_OPTIONS'])) ? $this->_rootref['S_RULE_OPTIONS'] : ''; ?></select><?php } else { ?><b class="gen"><?php echo (isset($this->_rootref['RULE_CURRENT'])) ? $this->_rootref['RULE_CURRENT'] : ''; ?></b><input type="hidden" name="rule_option" value="<?php echo (isset($this->_rootref['RULE_OPTION'])) ? $this->_rootref['RULE_OPTION'] : ''; ?>" /><?php } ?></td>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_RULE_SELECT']) {  ?><input type="submit" name="next" value="<?php echo ((isset($this->_rootref['L_NEXT_STEP'])) ? $this->_rootref['L_NEXT_STEP'] : ((isset($user->lang['NEXT_STEP'])) ? $user->lang['NEXT_STEP'] : '{ NEXT_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
	</tr>
<?php } if ($this->_rootref['S_COND_DEFINED']) {  if ($this->_rootref['S_COND_SELECT'] || $this->_rootref['COND_CURRENT']) {  ?>

		<tr>
			<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_COND_SELECT']) {  ?><input type="submit" name="back[cond]" value="<?php echo ((isset($this->_rootref['L_PREVIOUS_STEP'])) ? $this->_rootref['L_PREVIOUS_STEP'] : ((isset($user->lang['PREVIOUS_STEP'])) ? $user->lang['PREVIOUS_STEP'] : '{ PREVIOUS_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
			<td class="row2" align="center" valign="top">
				<?php if ($this->_rootref['S_COND_SELECT']) {  if ($this->_rootref['S_TEXT_CONDITION']) {  ?>

						<input type="text" name="rule_string" value="<?php echo (isset($this->_rootref['CURRENT_STRING'])) ? $this->_rootref['CURRENT_STRING'] : ''; ?>" size="30" maxlength="250" class="post" />
					<?php } else if ($this->_rootref['S_USER_CONDITION']) {  ?>

						<input type="text" class="post" name="rule_string" value="<?php echo (isset($this->_rootref['CURRENT_STRING'])) ? $this->_rootref['CURRENT_STRING'] : ''; ?>" size="20" />&nbsp;<span class="gensmall">[ <a href="<?php echo (isset($this->_rootref['U_FIND_USERNAME'])) ? $this->_rootref['U_FIND_USERNAME'] : ''; ?>" onclick="find_username(this.href); return false;"><?php echo ((isset($this->_rootref['L_FIND_USERNAME'])) ? $this->_rootref['L_FIND_USERNAME'] : ((isset($user->lang['FIND_USERNAME'])) ? $user->lang['FIND_USERNAME'] : '{ FIND_USERNAME }')); ?></a> ]</span>
					<?php } else if ($this->_rootref['S_GROUP_CONDITION']) {  ?>

						<input type="hidden" name="rule_string" value="<?php echo (isset($this->_rootref['CURRENT_STRING'])) ? $this->_rootref['CURRENT_STRING'] : ''; ?>" /><?php if ($this->_rootref['S_GROUP_OPTIONS']) {  ?><select name="rule_group_id"><?php echo (isset($this->_rootref['S_GROUP_OPTIONS'])) ? $this->_rootref['S_GROUP_OPTIONS'] : ''; ?></select><?php } else { echo ((isset($this->_rootref['L_NO_GROUPS'])) ? $this->_rootref['L_NO_GROUPS'] : ((isset($user->lang['NO_GROUPS'])) ? $user->lang['NO_GROUPS'] : '{ NO_GROUPS }')); } } } else { ?>

					<b class="gen"><?php echo (isset($this->_rootref['COND_CURRENT'])) ? $this->_rootref['COND_CURRENT'] : ''; ?></b>
						<input type="hidden" name="rule_string" value="<?php echo (isset($this->_rootref['CURRENT_STRING'])) ? $this->_rootref['CURRENT_STRING'] : ''; ?>" /><input type="hidden" name="rule_user_id" value="<?php echo (isset($this->_rootref['CURRENT_USER_ID'])) ? $this->_rootref['CURRENT_USER_ID'] : ''; ?>" /><input type="hidden" name="rule_group_id" value="<?php echo (isset($this->_rootref['CURRENT_GROUP_ID'])) ? $this->_rootref['CURRENT_GROUP_ID'] : ''; ?>" />
				<?php } ?>

			</td>
			<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_COND_SELECT']) {  ?><input type="submit" name="next" value="<?php echo ((isset($this->_rootref['L_NEXT_STEP'])) ? $this->_rootref['L_NEXT_STEP'] : ((isset($user->lang['NEXT_STEP'])) ? $user->lang['NEXT_STEP'] : '{ NEXT_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
		</tr>
	<?php } ?>

	<input type="hidden" name="cond_option" value="<?php echo (isset($this->_rootref['COND_OPTION'])) ? $this->_rootref['COND_OPTION'] : ''; ?>" />
<?php } if ($this->_rootref['NONE_CONDITION']) {  ?><input type="hidden" name="cond_option" value="none" /><?php } if ($this->_rootref['S_ACTION_DEFINED']) {  ?>

	<tr>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_ACTION_SELECT']) {  ?><input type="submit" name="back[action]" value="<?php echo ((isset($this->_rootref['L_PREVIOUS_STEP'])) ? $this->_rootref['L_PREVIOUS_STEP'] : ((isset($user->lang['PREVIOUS_STEP'])) ? $user->lang['PREVIOUS_STEP'] : '{ PREVIOUS_STEP }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
		<td class="row2" align="center" valign="top"><?php if ($this->_rootref['S_ACTION_SELECT']) {  ?><select name="action_option"><?php echo (isset($this->_rootref['S_ACTION_OPTIONS'])) ? $this->_rootref['S_ACTION_OPTIONS'] : ''; ?></select><?php } else { ?><b class="gen"><?php echo (isset($this->_rootref['ACTION_CURRENT'])) ? $this->_rootref['ACTION_CURRENT'] : ''; ?></b><input type="hidden" name="action_option" value="<?php echo (isset($this->_rootref['ACTION_OPTION'])) ? $this->_rootref['ACTION_OPTION'] : ''; ?>" /><?php } ?></td>
		<td class="row1" width="50" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top"><?php if ($this->_rootref['S_ACTION_SELECT']) {  ?><input type="submit" name="add_rule" value="<?php echo ((isset($this->_rootref['L_ADD_RULE'])) ? $this->_rootref['L_ADD_RULE'] : ((isset($user->lang['ADD_RULE'])) ? $user->lang['ADD_RULE'] : '{ ADD_RULE }')); ?>" class="btnlite" /><?php } else { ?>&nbsp;<?php } ?></td>
	</tr>
<?php } ?>

</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<div style="padding: 2px;"></div>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_DEFINED_RULES'])) ? $this->_rootref['L_DEFINED_RULES'] : ((isset($user->lang['DEFINED_RULES'])) ? $user->lang['DEFINED_RULES'] : '{ DEFINED_RULES }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<?php $_rule_count = (isset($this->_tpldata['rule'])) ? sizeof($this->_tpldata['rule']) : 0;if ($_rule_count) {for ($_rule_i = 0; $_rule_i < $_rule_count; ++$_rule_i){$_rule_val = &$this->_tpldata['rule'][$_rule_i]; ?>

	<tr>
		<td class="row1" width="25" align="center"><span class="gen">#<?php echo $_rule_val['COUNT']; ?></span></td>
		<td class="row2" width="120"><span class="gen"><strong><?php echo ((isset($this->_rootref['L_IF'])) ? $this->_rootref['L_IF'] : ((isset($user->lang['IF'])) ? $user->lang['IF'] : '{ IF }')); ?></strong> <?php echo $_rule_val['CHECK']; ?></span></td>
		<td class="row1" width="120"><span class="gen"><?php echo $_rule_val['RULE']; ?></span></td>
		<td class="row2" width="120"><span class="gen"><?php if ($_rule_val['STRING']) {  echo $_rule_val['STRING']; } ?></span></td>
		<td class="row1"><span class="gen"><?php echo $_rule_val['ACTION']; if ($_rule_val['FOLDER']) {  ?> -&gt; <?php echo $_rule_val['FOLDER']; } ?></span></td>
		<td class="row2" width="25"><input type="submit" name="delete_rule[<?php echo $_rule_val['RULE_ID']; ?>]" value="<?php echo ((isset($this->_rootref['L_DELETE_RULE'])) ? $this->_rootref['L_DELETE_RULE'] : ((isset($user->lang['DELETE_RULE'])) ? $user->lang['DELETE_RULE'] : '{ DELETE_RULE }')); ?>" class="btnlite" /></td>
	</tr>
<?php }} else { ?>

	<tr>
		<td colspan="6" class="row3" align="center"><span class="gen"><?php echo ((isset($this->_rootref['L_NO_RULES_DEFINED'])) ? $this->_rootref['L_NO_RULES_DEFINED'] : ((isset($user->lang['NO_RULES_DEFINED'])) ? $user->lang['NO_RULES_DEFINED'] : '{ NO_RULES_DEFINED }')); ?></span></td>
	</tr>
<?php } ?>

</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<div style="padding: 2px;"></div>

<?php if ($this->_rootref['S_FOLDER_OPTIONS']) {  ?>

    <?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_RENAME_FOLDER'])) ? $this->_rootref['L_RENAME_FOLDER'] : ((isset($user->lang['RENAME_FOLDER'])) ? $user->lang['RENAME_FOLDER'] : '{ RENAME_FOLDER }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
	<tr>
		<td class="row1" width="200"><b class="gen"><?php echo ((isset($this->_rootref['L_RENAME_FOLDER'])) ? $this->_rootref['L_RENAME_FOLDER'] : ((isset($user->lang['RENAME_FOLDER'])) ? $user->lang['RENAME_FOLDER'] : '{ RENAME_FOLDER }')); ?>: </b></td>
		<td class="row1"><select name="rename_folder_id"><?php echo (isset($this->_rootref['S_FOLDER_OPTIONS'])) ? $this->_rootref['S_FOLDER_OPTIONS'] : ''; ?></select></td>
	</tr>
	<tr>
		<td class="row1" width="200"><b class="gen"><?php echo ((isset($this->_rootref['L_NEW_FOLDER_NAME'])) ? $this->_rootref['L_NEW_FOLDER_NAME'] : ((isset($user->lang['NEW_FOLDER_NAME'])) ? $user->lang['NEW_FOLDER_NAME'] : '{ NEW_FOLDER_NAME }')); ?>: </b></td>
		<td class="row1"><input type="text" class="post" name="new_folder_name" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td class="row1" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" colspan="2"><input class="btnlite" style="width:150px" type="submit" name="rename_folder" value="<?php echo ((isset($this->_rootref['L_RENAME'])) ? $this->_rootref['L_RENAME'] : ((isset($user->lang['RENAME'])) ? $user->lang['RENAME'] : '{ RENAME }')); ?>" /></td>
	</tr>
	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


	<div style="padding: 2px;"></div>
<?php } if (! $this->_rootref['S_MAX_FOLDER_ZERO']) {  ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_ADD_FOLDER'])) ? $this->_rootref['L_ADD_FOLDER'] : ((isset($user->lang['ADD_FOLDER'])) ? $user->lang['ADD_FOLDER'] : '{ ADD_FOLDER }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<?php if ($this->_rootref['S_MAX_FOLDER_REACHED']) {  ?>

	<tr>
		<td colspan="2"><?php echo ((isset($this->_rootref['L_MAX_FOLDER_REACHED'])) ? $this->_rootref['L_MAX_FOLDER_REACHED'] : ((isset($user->lang['MAX_FOLDER_REACHED'])) ? $user->lang['MAX_FOLDER_REACHED'] : '{ MAX_FOLDER_REACHED }')); ?></td>
	</tr>
<?php } else { ?>

	<tr>
		<td class="row1" width="200"><b class="gen"><?php echo ((isset($this->_rootref['L_ADD_FOLDER'])) ? $this->_rootref['L_ADD_FOLDER'] : ((isset($user->lang['ADD_FOLDER'])) ? $user->lang['ADD_FOLDER'] : '{ ADD_FOLDER }')); ?>: </b></td>
		<td class="row1"><input type="text" class="post" name="foldername" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td class="row1" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" colspan="2"><input class="btnlite" style="width:150px" type="submit" name="addfolder" value="<?php echo ((isset($this->_rootref['L_ADD'])) ? $this->_rootref['L_ADD'] : ((isset($user->lang['ADD'])) ? $user->lang['ADD'] : '{ ADD }')); ?>" /></td>
	</tr>
<?php } ?>

</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

<?php } ?>


<div style="padding: 2px;"></div>

<?php if ($this->_rootref['S_FOLDER_OPTIONS']) {  ?>

    <?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_REMOVE_FOLDER'])) ? $this->_rootref['L_REMOVE_FOLDER'] : ((isset($user->lang['REMOVE_FOLDER'])) ? $user->lang['REMOVE_FOLDER'] : '{ REMOVE_FOLDER }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
	<tr>
		<td class="row1" width="200"><b class="gen"><?php echo ((isset($this->_rootref['L_REMOVE_FOLDER'])) ? $this->_rootref['L_REMOVE_FOLDER'] : ((isset($user->lang['REMOVE_FOLDER'])) ? $user->lang['REMOVE_FOLDER'] : '{ REMOVE_FOLDER }')); ?>: </b></td>
		<td class="row1"><select name="remove_folder_id"><?php echo (isset($this->_rootref['S_FOLDER_OPTIONS'])) ? $this->_rootref['S_FOLDER_OPTIONS'] : ''; ?></select></td>
		<td class="row1"><b class="genmed"><?php echo ((isset($this->_rootref['L_AND'])) ? $this->_rootref['L_AND'] : ((isset($user->lang['AND'])) ? $user->lang['AND'] : '{ AND }')); ?></b></td>
	</tr>
	<tr>
		<td class="row2" width="200">&nbsp;</td>
		<td class="row2" colspan="2"><input type="radio" class="radio" name="remove_action" value="1" checked="checked" />&nbsp;<span class="genmed"><?php echo ((isset($this->_rootref['L_MOVE_DELETED_MESSAGES_TO'])) ? $this->_rootref['L_MOVE_DELETED_MESSAGES_TO'] : ((isset($user->lang['MOVE_DELETED_MESSAGES_TO'])) ? $user->lang['MOVE_DELETED_MESSAGES_TO'] : '{ MOVE_DELETED_MESSAGES_TO }')); ?> </span>&nbsp;<select name="move_to"><?php echo (isset($this->_rootref['S_TO_FOLDER_OPTIONS'])) ? $this->_rootref['S_TO_FOLDER_OPTIONS'] : ''; ?></select></td>
	</tr>
	<tr>
		<td class="row2" width="200">&nbsp;</td>
		<td class="row2" colspan="2"><input type="radio" class="radio" name="remove_action" value="2" />&nbsp;<span class="genmed"><?php echo ((isset($this->_rootref['L_DELETE_MESSAGES_IN_FOLDER'])) ? $this->_rootref['L_DELETE_MESSAGES_IN_FOLDER'] : ((isset($user->lang['DELETE_MESSAGES_IN_FOLDER'])) ? $user->lang['DELETE_MESSAGES_IN_FOLDER'] : '{ DELETE_MESSAGES_IN_FOLDER }')); ?></span></td>
	</tr>
	<tr>
		<td class="row2" width="200">&nbsp;</td>
		<td class="row2" colspan="2" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><input class="btnlite" style="width:150px" type="submit" name="remove_folder" value="<?php echo ((isset($this->_rootref['L_REMOVE'])) ? $this->_rootref['L_REMOVE'] : ((isset($user->lang['REMOVE'])) ? $user->lang['REMOVE'] : '{ REMOVE }')); ?>" /></td>
	</tr>
	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


	<div style="padding: 2px;"></div>
<?php } ?>


<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_FOLDER_OPTIONS'])) ? $this->_rootref['L_FOLDER_OPTIONS'] : ((isset($user->lang['FOLDER_OPTIONS'])) ? $user->lang['FOLDER_OPTIONS'] : '{ FOLDER_OPTIONS }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<tr>
	<td class="row1" width="200"><span><b class="genmed"><?php echo ((isset($this->_rootref['L_IF_FOLDER_FULL'])) ? $this->_rootref['L_IF_FOLDER_FULL'] : ((isset($user->lang['IF_FOLDER_FULL'])) ? $user->lang['IF_FOLDER_FULL'] : '{ IF_FOLDER_FULL }')); ?>: </b></span></td>
	<td class="row1"><input type="radio" class="radio" name="full_action" value="1"<?php echo (isset($this->_rootref['S_DELETE_CHECKED'])) ? $this->_rootref['S_DELETE_CHECKED'] : ''; ?> />&nbsp;<span class="genmed"><?php echo ((isset($this->_rootref['L_DELETE_OLDEST_MESSAGES'])) ? $this->_rootref['L_DELETE_OLDEST_MESSAGES'] : ((isset($user->lang['DELETE_OLDEST_MESSAGES'])) ? $user->lang['DELETE_OLDEST_MESSAGES'] : '{ DELETE_OLDEST_MESSAGES }')); ?></span></td>
</tr>
<tr>
	<td class="row1" width="200">&nbsp;</td>
	<td class="row1"><input type="radio" class="radio" name="full_action" value="2"<?php echo (isset($this->_rootref['S_MOVE_CHECKED'])) ? $this->_rootref['S_MOVE_CHECKED'] : ''; ?> />&nbsp;<span class="genmed"><?php echo ((isset($this->_rootref['L_MOVE_TO_FOLDER'])) ? $this->_rootref['L_MOVE_TO_FOLDER'] : ((isset($user->lang['MOVE_TO_FOLDER'])) ? $user->lang['MOVE_TO_FOLDER'] : '{ MOVE_TO_FOLDER }')); ?>: </span><select name="full_move_to"><?php echo (isset($this->_rootref['S_FULL_FOLDER_OPTIONS'])) ? $this->_rootref['S_FULL_FOLDER_OPTIONS'] : ''; ?></select></td>
</tr>
<tr>
	<td class="row1" width="200">&nbsp;</td>
	<td class="row1"><input type="radio" class="radio" name="full_action" value="3"<?php echo (isset($this->_rootref['S_HOLD_CHECKED'])) ? $this->_rootref['S_HOLD_CHECKED'] : ''; ?> />&nbsp;<span class="genmed"><?php echo ((isset($this->_rootref['L_HOLD_NEW_MESSAGES'])) ? $this->_rootref['L_HOLD_NEW_MESSAGES'] : ((isset($user->lang['HOLD_NEW_MESSAGES'])) ? $user->lang['HOLD_NEW_MESSAGES'] : '{ HOLD_NEW_MESSAGES }')); ?></span></td>
</tr>
<tr>
	<td class="row2" width="200"><b class="genmed"><?php echo ((isset($this->_rootref['L_DEFAULT_ACTION'])) ? $this->_rootref['L_DEFAULT_ACTION'] : ((isset($user->lang['DEFAULT_ACTION'])) ? $user->lang['DEFAULT_ACTION'] : '{ DEFAULT_ACTION }')); ?>: </b><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_DEFAULT_ACTION_EXPLAIN'])) ? $this->_rootref['L_DEFAULT_ACTION_EXPLAIN'] : ((isset($user->lang['DEFAULT_ACTION_EXPLAIN'])) ? $user->lang['DEFAULT_ACTION_EXPLAIN'] : '{ DEFAULT_ACTION_EXPLAIN }')); ?></span></td>
	<td class="row2"><span class="genmed"><?php echo (isset($this->_rootref['DEFAULT_ACTION'])) ? $this->_rootref['DEFAULT_ACTION'] : ''; ?></span></td>
</tr>
<tr>
	<td class="row1" colspan="2" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><input class="btnlite" style="width:150px" type="submit" name="fullfolder" value="<?php echo ((isset($this->_rootref['L_CHANGE'])) ? $this->_rootref['L_CHANGE'] : ((isset($user->lang['CHANGE'])) ? $user->lang['CHANGE'] : '{ CHANGE }')); ?>" /></td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

</form>
<?php $this->_tpl_include('ucp_footer.html'); ?>