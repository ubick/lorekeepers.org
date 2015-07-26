<?php if (!defined('IN_PHPBB')) exit; echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_POST_REVIEW'])) ? $this->_rootref['L_POST_REVIEW'] : ((isset($user->lang['POST_REVIEW'])) ? $user->lang['POST_REVIEW'] : '{ POST_REVIEW }')); echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<tr>
	<td class="row1" align="center"><span class="gen"><?php echo ((isset($this->_rootref['L_POST_REVIEW_EXPLAIN'])) ? $this->_rootref['L_POST_REVIEW_EXPLAIN'] : ((isset($user->lang['POST_REVIEW_EXPLAIN'])) ? $user->lang['POST_REVIEW_EXPLAIN'] : '{ POST_REVIEW_EXPLAIN }')); ?></span></td>
</tr>
<tr>
	<td class="spacer"><img src="images/spacer.gif" alt="" width="1" height="1" /></td>
</tr>
<tr>
	<td class="row1">
		<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
		<tr>
			<th width="22%"><?php echo ((isset($this->_rootref['L_AUTHOR'])) ? $this->_rootref['L_AUTHOR'] : ((isset($user->lang['AUTHOR'])) ? $user->lang['AUTHOR'] : '{ AUTHOR }')); ?></th>
			<th><?php echo ((isset($this->_rootref['L_MESSAGE'])) ? $this->_rootref['L_MESSAGE'] : ((isset($user->lang['MESSAGE'])) ? $user->lang['MESSAGE'] : '{ MESSAGE }')); ?></th>
		</tr>
		<?php $_post_review_row_count = (isset($this->_tpldata['post_review_row'])) ? sizeof($this->_tpldata['post_review_row']) : 0;if ($_post_review_row_count) {for ($_post_review_row_i = 0; $_post_review_row_i < $_post_review_row_count; ++$_post_review_row_i){$_post_review_row_val = &$this->_tpldata['post_review_row'][$_post_review_row_i]; if (!($_post_review_row_val['S_ROW_COUNT'] & 1)  ) {  ?>	<tr class="row1"><?php } else { ?><tr class="row2"><?php } if ($_post_review_row_val['S_IGNORE_POST']) {  ?>

				<td colspan="2"><?php echo $_post_review_row_val['L_IGNORE_POST']; ?></td>
            <?php } else { ?>


				<td class="row" rowspan="2" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="top"><a id="pr<?php echo $_post_review_row_val['U_POST_ID']; ?>"></a>
					<table width="150" cellspacing="0" cellpadding="4" border="0">
					<tr>
						<td align="center"><b class="postauthor"><?php echo $_post_review_row_val['POST_AUTHOR_FULL']; ?></b></td>
					</tr>
					</table>
				</td>
				<td class="row" width="100%">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td>&nbsp;</td>
						<td class="gensmall" valign="middle" nowrap="nowrap"><b><?php echo ((isset($this->_rootref['L_POST_SUBJECT'])) ? $this->_rootref['L_POST_SUBJECT'] : ((isset($user->lang['POST_SUBJECT'])) ? $user->lang['POST_SUBJECT'] : '{ POST_SUBJECT }')); ?>:</b>&nbsp;</td>
						<td class="gensmall" width="100%" valign="middle"><?php echo $_post_review_row_val['POST_SUBJECT']; ?></td>
						<td>&nbsp;</td>
					</tr>
					</table>
				</td>
			</tr>

			<?php if (!($_post_review_row_val['S_ROW_COUNT'] & 1)  ) {  ?><tr class="row1"><?php } else { ?><tr class="row2"><?php } ?>


				<td valign="top">
					<table width="100%" cellspacing="0">
					<tr>
						<td valign="top">
							<table width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td><div class="postbody"><?php echo $_post_review_row_val['MESSAGE']; ?></div>

								<?php if ($_post_review_row_val['S_HAS_ATTACHMENTS']) {  ?>

									<br clear="all" /><br />

									<div class="attachwrapper"><div class="attachtitle"><?php echo ((isset($this->_rootref['L_ATTACHMENTS'])) ? $this->_rootref['L_ATTACHMENTS'] : ((isset($user->lang['ATTACHMENTS'])) ? $user->lang['ATTACHMENTS'] : '{ ATTACHMENTS }')); ?>:</div>
									<?php $_attachment_count = (isset($_post_review_row_val['attachment'])) ? sizeof($_post_review_row_val['attachment']) : 0;if ($_attachment_count) {for ($_attachment_i = 0; $_attachment_i < $_attachment_count; ++$_attachment_i){$_attachment_val = &$_post_review_row_val['attachment'][$_attachment_i]; ?>

									<div class="attachcontent"><?php echo $_attachment_val['DISPLAY_ATTACHMENT']; ?></div>
									<?php }} ?>

									</div>
								<?php } ?>

								
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr valign="middle">
								<td width="100%">&nbsp;</td>
								<td width="10" nowrap="nowrap"><?php if ($this->_rootref['S_IS_BOT']) {  echo $_post_review_row_val['MINI_POST_IMG']; } else { ?><a href="<?php echo $_post_review_row_val['U_MINI_POST']; ?>"><?php echo $_post_review_row_val['MINI_POST_IMG']; ?></a><?php } ?></td>
								<td class="gensmall" nowrap="nowrap"><b><?php echo ((isset($this->_rootref['L_POSTED'])) ? $this->_rootref['L_POSTED'] : ((isset($user->lang['POSTED'])) ? $user->lang['POSTED'] : '{ POSTED }')); ?>:</b> <?php echo $_post_review_row_val['POST_DATE']; ?></td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</td>
            <?php } ?>

			</tr>
			<tr>
				<td class="spacer" colspan="2" height="1"><img src="images/spacer.gif" alt="" width="1" height="1" /></td>
			</tr>
		<?php }} ?>

		</table>
	</td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<br clear="all" />