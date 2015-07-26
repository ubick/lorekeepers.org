<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('mcp_header.html'); ?>


<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table width="100%" cellpadding="3" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>" border="0" class="tablebg">
<tr> 
	<td class="row1" align="center">
		<table cellspacing="1" cellpadding="2" border="0">
		<tr>
			<td class="gen" align="center"><b><?php echo (isset($this->_rootref['USERNAME_FULL'])) ? $this->_rootref['USERNAME_FULL'] : ''; ?></b></td>
		</tr>
		<?php if ($this->_rootref['RANK_TITLE']) {  ?>

			<tr>
				<td class="postdetails" align="center"><?php echo (isset($this->_rootref['RANK_TITLE'])) ? $this->_rootref['RANK_TITLE'] : ''; ?></td>
			</tr>
		<?php } if ($this->_rootref['RANK_IMG']) {  ?>

			<tr>
				<td align="center"><?php echo (isset($this->_rootref['RANK_IMG'])) ? $this->_rootref['RANK_IMG'] : ''; ?></td>
			</tr>
		<?php } ?>

		<tr>
			<td align="center"><?php if ($this->_rootref['AVATAR_IMG']) {  echo (isset($this->_rootref['AVATAR_IMG'])) ? $this->_rootref['AVATAR_IMG'] : ''; } else { ?><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/no_avatar.gif" alt="" /><?php } ?></td>
		</tr>
		</table>
	</td>
	<td class="row1">
		<table width="100%" cellspacing="1" cellpadding="2" border="0">
		<tr> 
			<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_JOINED'])) ? $this->_rootref['L_JOINED'] : ((isset($user->lang['JOINED'])) ? $user->lang['JOINED'] : '{ JOINED }')); ?>: </td>
			<td width="100%"><b class="gen"><?php echo (isset($this->_rootref['JOINED'])) ? $this->_rootref['JOINED'] : ''; ?></b></td>
		</tr>
		<tr> 
			<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_TOTAL_POSTS'])) ? $this->_rootref['L_TOTAL_POSTS'] : ((isset($user->lang['TOTAL_POSTS'])) ? $user->lang['TOTAL_POSTS'] : '{ TOTAL_POSTS }')); ?>: </td>
			<td><b class="gen"><?php echo (isset($this->_rootref['POSTS'])) ? $this->_rootref['POSTS'] : ''; ?></b></td>
		</tr>
		<tr> 
			<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_WARNINGS'])) ? $this->_rootref['L_WARNINGS'] : ((isset($user->lang['WARNINGS'])) ? $user->lang['WARNINGS'] : '{ WARNINGS }')); ?>: </td>
			<td><b class="gen"><?php echo (isset($this->_rootref['WARNINGS'])) ? $this->_rootref['WARNINGS'] : ''; ?></b></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<br />

<form method="post" name="mcp" action="<?php echo (isset($this->_rootref['U_POST_ACTION'])) ? $this->_rootref['U_POST_ACTION'] : ''; ?>">

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_ADD_WARNING'])) ? $this->_rootref['L_ADD_WARNING'] : ((isset($user->lang['ADD_WARNING'])) ? $user->lang['ADD_WARNING'] : '{ ADD_WARNING }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table width="100%" cellpadding="3" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>" border="0" class="tablebg">
<tr>
	<td class="row3" align="center"><span class="genmed"><?php echo ((isset($this->_rootref['L_ADD_WARNING_EXPLAIN'])) ? $this->_rootref['L_ADD_WARNING_EXPLAIN'] : ((isset($user->lang['ADD_WARNING_EXPLAIN'])) ? $user->lang['ADD_WARNING_EXPLAIN'] : '{ ADD_WARNING_EXPLAIN }')); ?></span></td>
</tr>
<tr>
	<td class="row1" align="center"><textarea name="warning" rows="10" cols="76"></textarea></td>
</tr>
<?php if ($this->_rootref['S_CAN_NOTIFY']) {  ?>

<tr>
	<td class="row1" align="center"><input type="checkbox" class="radio" name="notify_user" checked="checked" /><span class="genmed"><?php echo ((isset($this->_rootref['L_NOTIFY_USER_WARN'])) ? $this->_rootref['L_NOTIFY_USER_WARN'] : ((isset($user->lang['NOTIFY_USER_WARN'])) ? $user->lang['NOTIFY_USER_WARN'] : '{ NOTIFY_USER_WARN }')); ?></span></td>
</tr>
<?php } ?>

<tr>
	<td class="cat" align="center"><input class="btnmain" type="submit" name="action[add_warning]" value="<?php echo ((isset($this->_rootref['L_SUBMIT'])) ? $this->_rootref['L_SUBMIT'] : ((isset($user->lang['SUBMIT'])) ? $user->lang['SUBMIT'] : '{ SUBMIT }')); ?>" />&nbsp;&nbsp;<input class="btnlite" type="reset" value="<?php echo ((isset($this->_rootref['L_RESET'])) ? $this->_rootref['L_RESET'] : ((isset($user->lang['RESET'])) ? $user->lang['RESET'] : '{ RESET }')); ?>" /></td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

</form>

<br />

<?php $this->_tpl_include('mcp_footer.html'); ?>