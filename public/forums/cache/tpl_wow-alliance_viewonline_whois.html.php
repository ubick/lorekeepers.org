<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('simple_header.html'); ?>


<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_WHOIS'])) ? $this->_rootref['L_WHOIS'] : ((isset($user->lang['WHOIS'])) ? $user->lang['WHOIS'] : '{ WHOIS }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<tr>
	<td class="row1"><pre><?php echo (isset($this->_rootref['WHOIS'])) ? $this->_rootref['WHOIS'] : ''; ?></pre><br /><a class="nav" href="#" onclick="window.close(); return false;"><?php echo ((isset($this->_rootref['L_CLOSE_WINDOW'])) ? $this->_rootref['L_CLOSE_WINDOW'] : ((isset($user->lang['CLOSE_WINDOW'])) ? $user->lang['CLOSE_WINDOW'] : '{ CLOSE_WINDOW }')); ?></a></td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<?php $this->_tpl_include('simple_footer.html'); ?>