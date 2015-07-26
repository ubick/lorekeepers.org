<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('overall_header.html'); ?>


<div id="pagecontent">

	<form name="login_forum" method="post" action="<?php echo (isset($this->_rootref['S_LOGIN_ACTION'])) ? $this->_rootref['S_LOGIN_ACTION'] : ''; ?>">
	
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_LOGIN'])) ? $this->_rootref['L_LOGIN'] : ((isset($user->lang['LOGIN'])) ? $user->lang['LOGIN'] : '{ LOGIN }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>" align="center">
	<tr>
		<td class="row3" align="center"><span class="gensmall"><?php echo ((isset($this->_rootref['L_LOGIN_FORUM'])) ? $this->_rootref['L_LOGIN_FORUM'] : ((isset($user->lang['LOGIN_FORUM'])) ? $user->lang['LOGIN_FORUM'] : '{ LOGIN_FORUM }')); ?></span></td>
	</tr>
	<tr> 
		<td class="row1" align="center">
		
			<table cellspacing="1" cellpadding="4" border="0">
			<?php if ($this->_rootref['LOGIN_ERROR']) {  ?>

				<tr>
					<td class="gensmall" colspan="2" align="center"><span class="error"><?php echo (isset($this->_rootref['LOGIN_ERROR'])) ? $this->_rootref['LOGIN_ERROR'] : ''; ?></span></td>
				</tr>
			<?php } ?>

			<tr> 
				<td class="gensmall"><b><?php echo ((isset($this->_rootref['L_PASSWORD'])) ? $this->_rootref['L_PASSWORD'] : ((isset($user->lang['PASSWORD'])) ? $user->lang['PASSWORD'] : '{ PASSWORD }')); ?>:</b></td>
				<td><input class="post" type="password" name="password" size="25" tabindex="2" /></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td class="cat" colspan="2" align="center"><?php echo (isset($this->_rootref['S_HIDDEN_FIELDS'])) ? $this->_rootref['S_HIDDEN_FIELDS'] : ''; ?><input type="submit" name="login" class="btnmain" value="<?php echo ((isset($this->_rootref['L_LOGIN'])) ? $this->_rootref['L_LOGIN'] : ((isset($user->lang['LOGIN'])) ? $user->lang['LOGIN'] : '{ LOGIN }')); ?>" tabindex="3" /></td>
	</tr>
	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

	<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

	</form>

</div>

<br clear="all" />

<?php $this->_tpl_include('breadcrumbs.html'); ?>


<br clear="all" />

<div align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><?php $this->_tpl_include('jumpbox.html'); ?></div>

<?php $this->_tpl_include('overall_footer.html'); ?>