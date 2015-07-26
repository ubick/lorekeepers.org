<?php if (!defined('IN_PHPBB')) exit; ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="<?php echo (isset($this->_rootref['S_CONTENT_DIRECTION'])) ? $this->_rootref['S_CONTENT_DIRECTION'] : ''; ?>" lang="<?php echo (isset($this->_rootref['S_USER_LANG'])) ? $this->_rootref['S_USER_LANG'] : ''; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo (isset($this->_rootref['S_CONTENT_ENCODING'])) ? $this->_rootref['S_CONTENT_ENCODING'] : ''; ?>">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Language" content="<?php echo (isset($this->_rootref['S_USER_LANG'])) ? $this->_rootref['S_USER_LANG'] : ''; ?>">
<title><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?> :: <?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?></title>

<style type="text/css">
<!--

body {
	font-family: Verdana,serif;
	font-size: 10pt;
}

td {
	font-family: Verdana,serif;
	font-size: 10pt;
	line-height: 150%;
}

.code,
.quote {
	font-size: smaller;
	border: black solid 1px;
}

.forum {
	font-family: Arial,Helvetica,sans-serif;
	font-weight: bold;
	font-size: 18pt;
}

.topic {
	font-family: Arial,Helvetica,sans-serif;
	font-size: 14pt;
	font-weight: bold;
}

.gensmall {
	font-size: 8pt;
}

hr {
	color: #888;
	height: 3px;
	border-style: solid;
}

hr.sep {
	color: #aaa;
	height: 1px;
	border-style: dashed;
}
//-->
</style>

</head>
<body>

<table width="85%" cellspacing="3" cellpadding="0" border="0" align="center">
<tr>
	<td colspan="2" align="center"><span class="Forum"><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?></span><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_PRIVATE_MESSAGING'])) ? $this->_rootref['L_PRIVATE_MESSAGING'] : ((isset($user->lang['PRIVATE_MESSAGING'])) ? $user->lang['PRIVATE_MESSAGING'] : '{ PRIVATE_MESSAGING }')); ?></a></span></td>
</tr>
<tr>
	<td colspan="2"><br /></td>
</tr>
<tr>
	<td><span class="topic"><?php echo (isset($this->_rootref['SUBJECT'])) ? $this->_rootref['SUBJECT'] : ''; ?></span><br /></td>
	<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="bottom"><span class="gensmall"><?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?></span></td>
</tr>
</table>

<hr width="85%" />

<table width="85%" cellspacing="3" cellpadding="0" border="0" align="center">
<tr>
	<td width="10%" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_PM_FROM'])) ? $this->_rootref['L_PM_FROM'] : ((isset($user->lang['PM_FROM'])) ? $user->lang['PM_FROM'] : '{ PM_FROM }')); ?>:&nbsp;</td>
	<td><b><?php echo (isset($this->_rootref['MESSAGE_AUTHOR'])) ? $this->_rootref['MESSAGE_AUTHOR'] : ''; ?></b> [ <?php echo (isset($this->_rootref['SENT_DATE'])) ? $this->_rootref['SENT_DATE'] : ''; ?> ]</td>
</tr>
	
<?php if ($this->_rootref['S_TO_RECIPIENT']) {  ?>

	<tr>
		<td width="10%" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_TO'])) ? $this->_rootref['L_TO'] : ((isset($user->lang['TO'])) ? $user->lang['TO'] : '{ TO }')); ?>:</td>
		<td>
		<?php $_to_recipient_count = (isset($this->_tpldata['to_recipient'])) ? sizeof($this->_tpldata['to_recipient']) : 0;if ($_to_recipient_count) {for ($_to_recipient_i = 0; $_to_recipient_i < $_to_recipient_count; ++$_to_recipient_i){$_to_recipient_val = &$this->_tpldata['to_recipient'][$_to_recipient_i]; if ($_to_recipient_val['COLOUR']) {  ?><span style="color:<?php echo $_to_recipient_val['COLOUR']; ?>"><?php } else { ?><span<?php if ($_to_recipient_val['IS_GROUP']) {  ?> class="sep"<?php } ?>><?php } echo $_to_recipient_val['NAME']; ?></span>&nbsp;
		<?php }} ?>

		</td>
	</tr>
<?php } if ($this->_rootref['S_BCC_RECIPIENT']) {  ?>

	<tr>
		<td width="10%" nowrap="nowrap"><?php echo ((isset($this->_rootref['L_BCC'])) ? $this->_rootref['L_BCC'] : ((isset($user->lang['BCC'])) ? $user->lang['BCC'] : '{ BCC }')); ?>:</td>
		<td>
		<?php $_bcc_recipient_count = (isset($this->_tpldata['bcc_recipient'])) ? sizeof($this->_tpldata['bcc_recipient']) : 0;if ($_bcc_recipient_count) {for ($_bcc_recipient_i = 0; $_bcc_recipient_i < $_bcc_recipient_count; ++$_bcc_recipient_i){$_bcc_recipient_val = &$this->_tpldata['bcc_recipient'][$_bcc_recipient_i]; if ($_bcc_recipient_val['COLOUR']) {  ?><span style="color:<?php echo $_bcc_recipient_val['COLOUR']; ?>"><?php } else { ?><span<?php if ($_bcc_recipient_val['IS_GROUP']) {  ?> class="sep"<?php } ?>><?php } echo $_bcc_recipient_val['NAME']; ?></span>&nbsp;
		<?php }} ?>

		</td>
	</tr>
<?php } ?>

<tr>
	<td colspan="2"><hr class="sep" /><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></td>
</tr>
</table>

<hr width="85%" />
<!--
	We request you retain the full copyright notice below including the link to www.phpbb.com.
	This not only gives respect to the large amount of time given freely by the developers
	but also helps build interest, traffic and use of phpBB3. If you (honestly) cannot retain
	the full copyright we ask you at least leave in place the "Powered by phpBB" line. If you
	refuse to include even this then support on our forums may be affected.

	The phpBB Group : 2006
// -->

<table width="85%" cellspacing="3" cellpadding="0" border="0" align="center">
<tr>
	<td><span class="gensmall"><?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?></span></td>
	<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><span class="gensmall"><?php echo (isset($this->_rootref['S_TIMEZONE'])) ? $this->_rootref['S_TIMEZONE'] : ''; ?></span></td>
</tr>
<tr>
	<td colspan="2" align="center"><span class="gensmall">Powered by phpBB &copy; 2000, 2002, 2005, 2007 phpBB Group<br />http://www.phpbb.com/</span></td>
</tr>
</table>

</body>
</html>