<?php if (!defined('IN_PHPBB')) exit; echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo ((isset($this->_rootref['L_TOPIC_REVIEW'])) ? $this->_rootref['L_TOPIC_REVIEW'] : ((isset($user->lang['TOPIC_REVIEW'])) ? $user->lang['TOPIC_REVIEW'] : '{ TOPIC_REVIEW }')); ?> - <?php echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

<table class="tablebg" width="100%" cellspacing="0" style="border-left-width: 0; border-top-width: 0;">
<tr>
	<td class="row1" style="padding: 0; border-width: 0;"><div style="overflow: auto; width: 100%; height: 300px;">

		<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
		<tr>
			<th width="22%"><?php echo ((isset($this->_rootref['L_AUTHOR'])) ? $this->_rootref['L_AUTHOR'] : ((isset($user->lang['AUTHOR'])) ? $user->lang['AUTHOR'] : '{ AUTHOR }')); ?></th>
			<th><?php echo ((isset($this->_rootref['L_MESSAGE'])) ? $this->_rootref['L_MESSAGE'] : ((isset($user->lang['MESSAGE'])) ? $user->lang['MESSAGE'] : '{ MESSAGE }')); ?></th>
		</tr>
		<?php $_topic_review_row_count = (isset($this->_tpldata['topic_review_row'])) ? sizeof($this->_tpldata['topic_review_row']) : 0;if ($_topic_review_row_count) {for ($_topic_review_row_i = 0; $_topic_review_row_i < $_topic_review_row_count; ++$_topic_review_row_i){$_topic_review_row_val = &$this->_tpldata['topic_review_row'][$_topic_review_row_i]; if (!($_topic_review_row_val['S_ROW_COUNT'] & 1)  ) {  ?><tr class="row1"><?php } else { ?><tr class="row2"><?php } if ($_topic_review_row_val['S_IGNORE_POST']) {  ?>

				<td colspan="2"><?php echo $_topic_review_row_val['L_IGNORE_POST']; ?></td>
            <?php } else { ?>


				<td align="center" valign="top" class="row" width="150"><a id="pr<?php echo $_topic_review_row_val['POST_ID']; ?>"></a>
					<b class="postauthor"<?php if ($_topic_review_row_val['POST_AUTHOR_COLOUR']) {  ?> style="color: <?php echo $_topic_review_row_val['POST_AUTHOR_COLOUR']; ?>"<?php } ?>><?php echo $_topic_review_row_val['POST_AUTHOR']; ?></b><br />
					<?php if ($_topic_review_row_val['U_MCP_DETAILS']) {  ?>[ <a href="<?php echo $_topic_review_row_val['U_MCP_DETAILS']; ?>"><?php echo ((isset($this->_rootref['L_POST_DETAILS'])) ? $this->_rootref['L_POST_DETAILS'] : ((isset($user->lang['POST_DETAILS'])) ? $user->lang['POST_DETAILS'] : '{ POST_DETAILS }')); ?></a> ]<?php } ?>

				</td>
				<td width="100%" class="row" valign="top">
					<?php if ($_topic_review_row_val['POSTER_QUOTE'] && $_topic_review_row_val['DECODED_MESSAGE']) {  ?><a href="#" onclick="addquote(<?php echo $_topic_review_row_val['POST_ID']; ?>,'<?php echo $_topic_review_row_val['POSTER_QUOTE']; ?>'); return false;" style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><?php echo (isset($this->_rootref['QUOTE_IMG'])) ? $this->_rootref['QUOTE_IMG'] : ''; ?></a><?php } ?>

					<a href="<?php echo $_topic_review_row_val['U_MINI_POST']; ?>"><?php echo $_topic_review_row_val['MINI_POST_IMG']; ?></a> <b><?php echo ((isset($this->_rootref['L_POSTED'])) ? $this->_rootref['L_POSTED'] : ((isset($user->lang['POSTED'])) ? $user->lang['POSTED'] : '{ POSTED }')); ?>:</b> <?php echo $_topic_review_row_val['POST_DATE']; ?><br />
					<div class="postsubject"><?php echo $_topic_review_row_val['POST_SUBJECT']; ?></div>
					<div class="postbody"><?php echo $_topic_review_row_val['MESSAGE']; ?></div>
					<?php if ($_topic_review_row_val['POSTER_QUOTE'] && $_topic_review_row_val['DECODED_MESSAGE']) {  ?>

						<div id="message_<?php echo $_topic_review_row_val['POST_ID']; ?>" style="display: none;"><?php echo $_topic_review_row_val['DECODED_MESSAGE']; ?></div>
					<?php } ?>

				</td>
			<?php } ?>	
			</tr>
			<tr>
				<td class="spacer" colspan="2"><img src="images/spacer.gif" alt="" width="1" height="1" /></td>
			</tr>
		<?php }} ?>

		</table>
	</div></td>
</tr>
</table>
<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


<br clear="all" />