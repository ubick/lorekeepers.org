<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('mcp_header.html'); ?>


<form method="post" name="mcp" action="<?php echo (isset($this->_rootref['U_POST_ACTION'])) ? $this->_rootref['U_POST_ACTION'] : ''; ?>">

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_SELECT_USER'])) ? $this->_rootref['L_SELECT_USER'] : ((isset($user->lang['SELECT_USER'])) ? $user->lang['SELECT_USER'] : '{ SELECT_USER }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>" border="0" align="center">
<tr>
	<td class="row1" width="40%"><b class="gen"><?php echo ((isset($this->_rootref['L_FIND_USERNAME'])) ? $this->_rootref['L_FIND_USERNAME'] : ((isset($user->lang['FIND_USERNAME'])) ? $user->lang['FIND_USERNAME'] : '{ FIND_USERNAME }')); ?>: </b><br /><span class="gensmall">[ <a href="<?php echo (isset($this->_rootref['U_FIND_USERNAME'])) ? $this->_rootref['U_FIND_USERNAME'] : ''; ?>" onclick="find_username(this.href); return false;"><?php echo ((isset($this->_rootref['L_FIND_USERNAME'])) ? $this->_rootref['L_FIND_USERNAME'] : ((isset($user->lang['FIND_USERNAME'])) ? $user->lang['FIND_USERNAME'] : '{ FIND_USERNAME }')); ?></a> ]</span></td>
	<td class="row2"><input type="text" class="post" name="username" size="20" /></td>
</tr>
<tr>
	<td class="cat" colspan="2" align="center"><input type="submit" name="submituser" value="<?php echo ((isset($this->_rootref['L_SUBMIT'])) ? $this->_rootref['L_SUBMIT'] : ((isset($user->lang['SUBMIT'])) ? $user->lang['SUBMIT'] : '{ SUBMIT }')); ?>" class="btnmain" /></td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

</form>

<br />

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_MOST_WARNINGS'])) ? $this->_rootref['L_MOST_WARNINGS'] : ((isset($user->lang['MOST_WARNINGS'])) ? $user->lang['MOST_WARNINGS'] : '{ MOST_WARNINGS }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<tr>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_USERNAME'])) ? $this->_rootref['L_USERNAME'] : ((isset($user->lang['USERNAME'])) ? $user->lang['USERNAME'] : '{ USERNAME }')); ?>&nbsp;</th>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_WARNINGS'])) ? $this->_rootref['L_WARNINGS'] : ((isset($user->lang['WARNINGS'])) ? $user->lang['WARNINGS'] : '{ WARNINGS }')); ?>&nbsp;</th>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_LATEST_WARNING_TIME'])) ? $this->_rootref['L_LATEST_WARNING_TIME'] : ((isset($user->lang['LATEST_WARNING_TIME'])) ? $user->lang['LATEST_WARNING_TIME'] : '{ LATEST_WARNING_TIME }')); ?>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?php $_highest_count = (isset($this->_tpldata['highest'])) ? sizeof($this->_tpldata['highest']) : 0;if ($_highest_count) {for ($_highest_i = 0; $_highest_i < $_highest_count; ++$_highest_i){$_highest_val = &$this->_tpldata['highest'][$_highest_i]; ?>

	<tr>
		<td class="row1" width="15%" valign="top"><span class="gen"><?php echo $_highest_val['USERNAME_FULL']; ?></span></td>
		<td class="row2" width="15%" valign="top"><span class="gen"><?php echo $_highest_val['WARNINGS']; ?></span></td>
		<td class="row1" width="15%" valign="top"><span class="gen"><?php echo $_highest_val['WARNING_TIME']; ?></span></td>
		<td class="row2" width="15%" valign="top"><span class="gen"><a href="<?php echo $_highest_val['U_NOTES']; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NOTES'])) ? $this->_rootref['L_VIEW_NOTES'] : ((isset($user->lang['VIEW_NOTES'])) ? $user->lang['VIEW_NOTES'] : '{ VIEW_NOTES }')); ?></a></span></td>
	</tr>
<?php }} else { ?>

	<tr>
		<td class="row1" colspan="4" align="center"><span class="gen"><?php echo ((isset($this->_rootref['L_WARNINGS_ZERO_TOTAL'])) ? $this->_rootref['L_WARNINGS_ZERO_TOTAL'] : ((isset($user->lang['WARNINGS_ZERO_TOTAL'])) ? $user->lang['WARNINGS_ZERO_TOTAL'] : '{ WARNINGS_ZERO_TOTAL }')); ?></span></td>
	</tr>
<?php } ?>

</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<br />

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_LATEST_WARNINGS'])) ? $this->_rootref['L_LATEST_WARNINGS'] : ((isset($user->lang['LATEST_WARNINGS'])) ? $user->lang['LATEST_WARNINGS'] : '{ LATEST_WARNINGS }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<tr>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_USERNAME'])) ? $this->_rootref['L_USERNAME'] : ((isset($user->lang['USERNAME'])) ? $user->lang['USERNAME'] : '{ USERNAME }')); ?>&nbsp;</th>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_TIME'])) ? $this->_rootref['L_TIME'] : ((isset($user->lang['TIME'])) ? $user->lang['TIME'] : '{ TIME }')); ?>&nbsp;</th>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_TOTAL_WARNINGS'])) ? $this->_rootref['L_TOTAL_WARNINGS'] : ((isset($user->lang['TOTAL_WARNINGS'])) ? $user->lang['TOTAL_WARNINGS'] : '{ TOTAL_WARNINGS }')); ?>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
<?php $_latest_count = (isset($this->_tpldata['latest'])) ? sizeof($this->_tpldata['latest']) : 0;if ($_latest_count) {for ($_latest_i = 0; $_latest_i < $_latest_count; ++$_latest_i){$_latest_val = &$this->_tpldata['latest'][$_latest_i]; ?>

	<tr>
		<td class="row1" width="15%" valign="top"><span class="gen"><?php echo $_latest_val['USERNAME_FULL']; ?></span></td>
		<td class="row2" width="15%" valign="top"><span class="gen"><?php echo $_latest_val['WARNING_TIME']; ?></span></td>
		<td class="row1" width="15%" valign="top"><span class="gen"><?php echo $_latest_val['WARNINGS']; ?></span></td>
		<td class="row2" width="15%" valign="top"><span class="gen"><a href="<?php echo $_latest_val['U_NOTES']; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NOTES'])) ? $this->_rootref['L_VIEW_NOTES'] : ((isset($user->lang['VIEW_NOTES'])) ? $user->lang['VIEW_NOTES'] : '{ VIEW_NOTES }')); ?></a></span></td>
	</tr>
<?php }} else { ?>

	<tr>
		<td class="row1" colspan="4" align="center"><span class="gen"><?php echo ((isset($this->_rootref['L_WARNINGS_ZERO_TOTAL'])) ? $this->_rootref['L_WARNINGS_ZERO_TOTAL'] : ((isset($user->lang['WARNINGS_ZERO_TOTAL'])) ? $user->lang['WARNINGS_ZERO_TOTAL'] : '{ WARNINGS_ZERO_TOTAL }')); ?></span></td>
	</tr>
<?php } ?>

</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<br />

<?php $this->_tpl_include('mcp_footer.html'); ?>