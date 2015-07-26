<?php if (!defined('IN_PHPBB')) exit; if ($this->_rootref['S_RECAPTCHA_AVAILABLE']) {  ?>

	<tr>
		<th colspan="2" valign="middle"><?php echo ((isset($this->_rootref['L_CONFIRM_CODE'])) ? $this->_rootref['L_CONFIRM_CODE'] : ((isset($user->lang['CONFIRM_CODE'])) ? $user->lang['CONFIRM_CODE'] : '{ CONFIRM_CODE }')); ?></th>
	</tr>
	<tr>
		<td class="row1"><b class="genmed"><?php echo ((isset($this->_rootref['L_CONFIRM_CODE'])) ? $this->_rootref['L_CONFIRM_CODE'] : ((isset($user->lang['CONFIRM_CODE'])) ? $user->lang['CONFIRM_CODE'] : '{ CONFIRM_CODE }')); ?>:</b><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_RECAPTCHA_EXPLAIN'])) ? $this->_rootref['L_RECAPTCHA_EXPLAIN'] : ((isset($user->lang['RECAPTCHA_EXPLAIN'])) ? $user->lang['RECAPTCHA_EXPLAIN'] : '{ RECAPTCHA_EXPLAIN }')); ?></span></td>
		<td class="row2">
		<script type="text/javascript">
			//<![CDATA[
			var RecaptchaOptions = {
			lang : '<?php echo ((isset($this->_rootref['L_RECAPTCHA_LANG'])) ? $this->_rootref['L_RECAPTCHA_LANG'] : ((isset($user->lang['RECAPTCHA_LANG'])) ? $user->lang['RECAPTCHA_LANG'] : '{ RECAPTCHA_LANG }')); ?>',
			tabindex : <?php if ($this->_tpldata['DEFINE']['.']['CAPTCHA_TAB_INDEX']) {  echo (isset($this->_tpldata['DEFINE']['.']['CAPTCHA_TAB_INDEX'])) ? $this->_tpldata['DEFINE']['.']['CAPTCHA_TAB_INDEX'] : ''; } else { ?>10<?php } ?>

			};
			// ]]>
			</script>
		<script type="text/javascript" src="<?php echo (isset($this->_rootref['RECAPTCHA_SERVER'])) ? $this->_rootref['RECAPTCHA_SERVER'] : ''; ?>/challenge?k=<?php echo (isset($this->_rootref['RECAPTCHA_PUBKEY'])) ? $this->_rootref['RECAPTCHA_PUBKEY'] : ''; echo (isset($this->_rootref['RECAPTCHA_ERRORGET'])) ? $this->_rootref['RECAPTCHA_ERRORGET'] : ''; ?>" ></script>
		<script type="text/javascript">
		// <![CDATA[
		<?php if ($this->_rootref['S_CONTENT_DIRECTION'] == ('rtl')) {  ?>

			document.getElementById('recaptcha_table').style.direction = 'ltr';
		<?php } ?>

		// ]]>
		</script>

			<noscript>
				<iframe src="<?php echo (isset($this->_rootref['RECAPTCHA_SERVER'])) ? $this->_rootref['RECAPTCHA_SERVER'] : ''; ?>/noscript?k=<?php echo (isset($this->_rootref['RECAPTCHA_PUBKEY'])) ? $this->_rootref['RECAPTCHA_PUBKEY'] : ''; echo (isset($this->_rootref['RECAPTCHA_ERRORGET'])) ? $this->_rootref['RECAPTCHA_ERRORGET'] : ''; ?>" height="300" width="500" frameborder="0"></iframe><br />
				<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
				<input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
			</noscript>
		</td>
	</tr>

<?php } else { ?>

<?php echo ((isset($this->_rootref['L_RECAPTCHA_NOT_AVAILABLE'])) ? $this->_rootref['L_RECAPTCHA_NOT_AVAILABLE'] : ((isset($user->lang['RECAPTCHA_NOT_AVAILABLE'])) ? $user->lang['RECAPTCHA_NOT_AVAILABLE'] : '{ RECAPTCHA_NOT_AVAILABLE }')); ?>

<?php } ?>