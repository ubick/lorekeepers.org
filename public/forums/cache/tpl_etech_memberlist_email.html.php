<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('overall_header.html'); ?>


<div id="pagecontent">

	<form action="<?php echo (isset($this->_rootref['S_POST_ACTION'])) ? $this->_rootref['S_POST_ACTION'] : ''; ?>" method="post" name="postform">
	
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_SEND_EMAIL_USER'])) ? $this->_rootref['L_SEND_EMAIL_USER'] : ((isset($user->lang['SEND_EMAIL_USER'])) ? $user->lang['SEND_EMAIL_USER'] : '{ SEND_EMAIL_USER }')); ?> <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
	<?php if ($this->_rootref['ERROR_MESSAGE']) {  ?>

		<tr>
			<td class="row3" colspan="2" align="center"><span class="error"><?php echo (isset($this->_rootref['ERROR_MESSAGE'])) ? $this->_rootref['ERROR_MESSAGE'] : ''; ?></span></td>
		</tr>
	<?php } if ($this->_rootref['S_SEND_USER']) {  ?>

		<tr> 
			<td class="row1" width="35%"><b class="genmed"><?php echo ((isset($this->_rootref['L_RECIPIENT'])) ? $this->_rootref['L_RECIPIENT'] : ((isset($user->lang['RECIPIENT'])) ? $user->lang['RECIPIENT'] : '{ RECIPIENT }')); ?></b></td>
			<td class="row2" width="65%"><b class="genmed"><?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?></b></td>
		</tr>
		<tr> 
			<td class="row1" width="35%"><b class="genmed"><?php echo ((isset($this->_rootref['L_SUBJECT'])) ? $this->_rootref['L_SUBJECT'] : ((isset($user->lang['SUBJECT'])) ? $user->lang['SUBJECT'] : '{ SUBJECT }')); ?></b></td>
			<td class="row2"><input class="post" type="text" name="subject" size="50" tabindex="2" value="<?php echo (isset($this->_rootref['SUBJECT'])) ? $this->_rootref['SUBJECT'] : ''; ?>" /></td>
		</tr>
	<?php } else { ?>

		<tr>
			<td class="row1" width="35%"><b class="genmed"><?php echo ((isset($this->_rootref['L_EMAIL_ADDRESS'])) ? $this->_rootref['L_EMAIL_ADDRESS'] : ((isset($user->lang['EMAIL_ADDRESS'])) ? $user->lang['EMAIL_ADDRESS'] : '{ EMAIL_ADDRESS }')); ?></b></td>
			<td class="row2"><input class="post" type="text" name="email" size="50" maxlength="100" value="<?php echo (isset($this->_rootref['EMAIL'])) ? $this->_rootref['EMAIL'] : ''; ?>" /></td>
		</tr>
		<tr> 
			<td class="row1" width="35%"><b class="genmed"><?php echo ((isset($this->_rootref['L_REAL_NAME'])) ? $this->_rootref['L_REAL_NAME'] : ((isset($user->lang['REAL_NAME'])) ? $user->lang['REAL_NAME'] : '{ REAL_NAME }')); ?></b></td>
			<td class="row2"><input class="post" type="text" name="name" size="50" value="<?php echo (isset($this->_rootref['NAME'])) ? $this->_rootref['NAME'] : ''; ?>" /></td>
		</tr>
		<tr> 
			<td class="row1" width="35%"><b class="genmed"><?php echo ((isset($this->_rootref['L_DEST_LANG'])) ? $this->_rootref['L_DEST_LANG'] : ((isset($user->lang['DEST_LANG'])) ? $user->lang['DEST_LANG'] : '{ DEST_LANG }')); ?></b><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_DEST_LANG_EXPLAIN'])) ? $this->_rootref['L_DEST_LANG_EXPLAIN'] : ((isset($user->lang['DEST_LANG_EXPLAIN'])) ? $user->lang['DEST_LANG_EXPLAIN'] : '{ DEST_LANG_EXPLAIN }')); ?></span></td>
			<td class="row2"><select name="lang"><?php echo (isset($this->_rootref['S_LANG_OPTIONS'])) ? $this->_rootref['S_LANG_OPTIONS'] : ''; ?></select></td>
		</tr>
	<?php } ?>

	<tr> 
		<td class="row1" valign="top"><b class="genmed"><?php echo ((isset($this->_rootref['L_MESSAGE_BODY'])) ? $this->_rootref['L_MESSAGE_BODY'] : ((isset($user->lang['MESSAGE_BODY'])) ? $user->lang['MESSAGE_BODY'] : '{ MESSAGE_BODY }')); ?></b><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_EMAIL_BODY_EXPLAIN'])) ? $this->_rootref['L_EMAIL_BODY_EXPLAIN'] : ((isset($user->lang['EMAIL_BODY_EXPLAIN'])) ? $user->lang['EMAIL_BODY_EXPLAIN'] : '{ EMAIL_BODY_EXPLAIN }')); ?></span></td>
		<td class="row2"><textarea class="post" name="message" rows="15" cols="76" tabindex="3"><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></textarea></td>
	</tr>
	<tr> 
		<td class="row1" valign="top"><span class="gen"><b><?php echo ((isset($this->_rootref['L_OPTIONS'])) ? $this->_rootref['L_OPTIONS'] : ((isset($user->lang['OPTIONS'])) ? $user->lang['OPTIONS'] : '{ OPTIONS }')); ?></b></span></td>
		<td class="row2">
			<table cellspacing="0" cellpadding="1" border="0">
			<tr> 
				<td><input type="checkbox" class="radio" name="cc_email" value="1" checked="checked" /></td>
				<td class="gen"><?php echo ((isset($this->_rootref['L_CC_EMAIL'])) ? $this->_rootref['L_CC_EMAIL'] : ((isset($user->lang['CC_EMAIL'])) ? $user->lang['CC_EMAIL'] : '{ CC_EMAIL }')); ?></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="center"><input type="submit" tabindex="6" name="submit" class="btnmain" value="<?php echo ((isset($this->_rootref['L_SEND_EMAIL'])) ? $this->_rootref['L_SEND_EMAIL'] : ((isset($user->lang['SEND_EMAIL'])) ? $user->lang['SEND_EMAIL'] : '{ SEND_EMAIL }')); ?>" /></td>
	</tr>
	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

	<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

	</form>

</div>

<br clear="all" />

<?php $this->_tpl_include('breadcrumbs.html'); ?>


<br clear="all" />

<div style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>;"><?php $this->_tpl_include('jumpbox.html'); ?></div>

<?php $this->_tpl_include('overall_footer.html'); ?>