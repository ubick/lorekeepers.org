<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('overall_header.html'); if ($this->_rootref['S_FORUM_RULES']) {  ?>

	<div class="forumrules">
		<?php if ($this->_rootref['U_FORUM_RULES']) {  ?>

			<h3><?php echo ((isset($this->_rootref['L_FORUM_RULES'])) ? $this->_rootref['L_FORUM_RULES'] : ((isset($user->lang['FORUM_RULES'])) ? $user->lang['FORUM_RULES'] : '{ FORUM_RULES }')); ?></h3><br />
			<a href="<?php echo (isset($this->_rootref['U_FORUM_RULES'])) ? $this->_rootref['U_FORUM_RULES'] : ''; ?>"><b><?php echo ((isset($this->_rootref['L_FORUM_RULES_LINK'])) ? $this->_rootref['L_FORUM_RULES_LINK'] : ((isset($user->lang['FORUM_RULES_LINK'])) ? $user->lang['FORUM_RULES_LINK'] : '{ FORUM_RULES_LINK }')); ?></b></a>
		<?php } else { ?>

			<h3><?php echo ((isset($this->_rootref['L_FORUM_RULES'])) ? $this->_rootref['L_FORUM_RULES'] : ((isset($user->lang['FORUM_RULES'])) ? $user->lang['FORUM_RULES'] : '{ FORUM_RULES }')); ?></h3><br />
			<?php echo (isset($this->_rootref['FORUM_RULES'])) ? $this->_rootref['FORUM_RULES'] : ''; ?>

		<?php } ?>

	</div>

	<br clear="all" />
<?php } ?>


<div id="pageheader">
	<h2><a class="titles" href="<?php echo (isset($this->_rootref['U_VIEW_TOPIC'])) ? $this->_rootref['U_VIEW_TOPIC'] : ''; ?>"><?php echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; ?></a></h2>

<?php if ($this->_rootref['MODERATORS']) {  ?>

	<p class="moderators"><?php if ($this->_rootref['S_SINGLE_MODERATOR']) {  echo ((isset($this->_rootref['L_MODERATOR'])) ? $this->_rootref['L_MODERATOR'] : ((isset($user->lang['MODERATOR'])) ? $user->lang['MODERATOR'] : '{ MODERATOR }')); } else { echo ((isset($this->_rootref['L_MODERATORS'])) ? $this->_rootref['L_MODERATORS'] : ((isset($user->lang['MODERATORS'])) ? $user->lang['MODERATORS'] : '{ MODERATORS }')); } ?>: <?php echo (isset($this->_rootref['MODERATORS'])) ? $this->_rootref['MODERATORS'] : ''; ?></p>
<?php } if ($this->_rootref['U_MCP']) {  ?>

	<p class="linkmcp">[ <a href="<?php echo (isset($this->_rootref['U_MCP'])) ? $this->_rootref['U_MCP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_MCP'])) ? $this->_rootref['L_MCP'] : ((isset($user->lang['MCP'])) ? $user->lang['MCP'] : '{ MCP }')); ?></a> ]</p>
<?php } ?>

</div>

<br clear="all" /><br />

<div id="pagecontent">

	<table width="100%" cellspacing="1">
	<tr>
		<?php if (! $this->_rootref['S_IS_BOT']) {  ?>

			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="middle" nowrap="nowrap">
				<?php if ($this->_rootref['S_DISPLAY_REPLY_INFO']) {  ?><a href="<?php echo (isset($this->_rootref['U_POST_REPLY_TOPIC'])) ? $this->_rootref['U_POST_REPLY_TOPIC'] : ''; ?>"><?php echo (isset($this->_rootref['REPLY_IMG'])) ? $this->_rootref['REPLY_IMG'] : ''; ?></a><?php } ?>

			</td>
		<?php } if ($this->_rootref['TOTAL_POSTS']) {  ?>

			<td class="nav" valign="middle" nowrap="nowrap">&nbsp;<?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?><br /></td>
			<td class="gensmall" nowrap="nowrap">&nbsp;[ <?php echo (isset($this->_rootref['TOTAL_POSTS'])) ? $this->_rootref['TOTAL_POSTS'] : ''; ?> ]&nbsp;</td>
			<td class="gensmall" width="100%" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" nowrap="nowrap"><?php $this->_tpl_include('pagination.html'); ?></td>
		<?php } ?>

	</tr>
	</table>

			<table width="100%" cellspacing="0">
			<tr>
				<td class="nav" nowrap="nowrap">
				<?php if (! $this->_rootref['S_IS_BOT']) {  if ($this->_rootref['U_WATCH_TOPIC']) {  ?><a href="<?php echo (isset($this->_rootref['U_WATCH_TOPIC'])) ? $this->_rootref['U_WATCH_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_WATCH_TOPIC'])) ? $this->_rootref['L_WATCH_TOPIC'] : ((isset($user->lang['WATCH_TOPIC'])) ? $user->lang['WATCH_TOPIC'] : '{ WATCH_TOPIC }')); ?>"><?php echo ((isset($this->_rootref['L_WATCH_TOPIC'])) ? $this->_rootref['L_WATCH_TOPIC'] : ((isset($user->lang['WATCH_TOPIC'])) ? $user->lang['WATCH_TOPIC'] : '{ WATCH_TOPIC }')); ?></a><?php if ($this->_rootref['U_PRINT_TOPIC'] || $this->_rootref['U_EMAIL_TOPIC'] || $this->_rootref['U_BUMP_TOPIC'] || $this->_rootref['U_BOOKMARK_TOPIC']) {  ?> | <?php } } if ($this->_rootref['U_BOOKMARK_TOPIC']) {  ?><a href="<?php echo (isset($this->_rootref['U_BOOKMARK_TOPIC'])) ? $this->_rootref['U_BOOKMARK_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_BOOKMARK_TOPIC'])) ? $this->_rootref['L_BOOKMARK_TOPIC'] : ((isset($user->lang['BOOKMARK_TOPIC'])) ? $user->lang['BOOKMARK_TOPIC'] : '{ BOOKMARK_TOPIC }')); ?>"><?php echo ((isset($this->_rootref['L_BOOKMARK_TOPIC'])) ? $this->_rootref['L_BOOKMARK_TOPIC'] : ((isset($user->lang['BOOKMARK_TOPIC'])) ? $user->lang['BOOKMARK_TOPIC'] : '{ BOOKMARK_TOPIC }')); ?></a><?php if ($this->_rootref['U_PRINT_TOPIC'] || $this->_rootref['U_EMAIL_TOPIC'] || $this->_rootref['U_BUMP_TOPIC']) {  ?> | <?php } } if ($this->_rootref['U_PRINT_TOPIC']) {  ?><a href="<?php echo (isset($this->_rootref['U_PRINT_TOPIC'])) ? $this->_rootref['U_PRINT_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_PRINT_TOPIC'])) ? $this->_rootref['L_PRINT_TOPIC'] : ((isset($user->lang['PRINT_TOPIC'])) ? $user->lang['PRINT_TOPIC'] : '{ PRINT_TOPIC }')); ?>"><?php echo ((isset($this->_rootref['L_PRINT_TOPIC'])) ? $this->_rootref['L_PRINT_TOPIC'] : ((isset($user->lang['PRINT_TOPIC'])) ? $user->lang['PRINT_TOPIC'] : '{ PRINT_TOPIC }')); ?></a><?php if ($this->_rootref['U_EMAIL_TOPIC'] || $this->_rootref['U_BUMP_TOPIC']) {  ?> | <?php } } if ($this->_rootref['U_EMAIL_TOPIC']) {  ?><a href="<?php echo (isset($this->_rootref['U_EMAIL_TOPIC'])) ? $this->_rootref['U_EMAIL_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_EMAIL_TOPIC'])) ? $this->_rootref['L_EMAIL_TOPIC'] : ((isset($user->lang['EMAIL_TOPIC'])) ? $user->lang['EMAIL_TOPIC'] : '{ EMAIL_TOPIC }')); ?>"><?php echo ((isset($this->_rootref['L_EMAIL_TOPIC'])) ? $this->_rootref['L_EMAIL_TOPIC'] : ((isset($user->lang['EMAIL_TOPIC'])) ? $user->lang['EMAIL_TOPIC'] : '{ EMAIL_TOPIC }')); ?></a><?php if ($this->_rootref['U_BUMP_TOPIC']) {  ?> | <?php } } if ($this->_rootref['U_BUMP_TOPIC']) {  ?><a href="<?php echo (isset($this->_rootref['U_BUMP_TOPIC'])) ? $this->_rootref['U_BUMP_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_BUMP_TOPIC'])) ? $this->_rootref['L_BUMP_TOPIC'] : ((isset($user->lang['BUMP_TOPIC'])) ? $user->lang['BUMP_TOPIC'] : '{ BUMP_TOPIC }')); ?>"><?php echo ((isset($this->_rootref['L_BUMP_TOPIC'])) ? $this->_rootref['L_BUMP_TOPIC'] : ((isset($user->lang['BUMP_TOPIC'])) ? $user->lang['BUMP_TOPIC'] : '{ BUMP_TOPIC }')); ?></a><?php } } ?>

				</td>
				<td class="nav" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" nowrap="nowrap"><a href="<?php echo (isset($this->_rootref['U_VIEW_OLDER_TOPIC'])) ? $this->_rootref['U_VIEW_OLDER_TOPIC'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_PREVIOUS_TOPIC'])) ? $this->_rootref['L_VIEW_PREVIOUS_TOPIC'] : ((isset($user->lang['VIEW_PREVIOUS_TOPIC'])) ? $user->lang['VIEW_PREVIOUS_TOPIC'] : '{ VIEW_PREVIOUS_TOPIC }')); ?></a><?php if ($this->_rootref['U_VIEW_UNREAD_POST'] && ! $this->_rootref['S_IS_BOT']) {  ?> | <a href="<?php echo (isset($this->_rootref['U_VIEW_UNREAD_POST'])) ? $this->_rootref['U_VIEW_UNREAD_POST'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_UNREAD_POST'])) ? $this->_rootref['L_VIEW_UNREAD_POST'] : ((isset($user->lang['VIEW_UNREAD_POST'])) ? $user->lang['VIEW_UNREAD_POST'] : '{ VIEW_UNREAD_POST }')); ?></a><?php } ?> | <a href="<?php echo (isset($this->_rootref['U_VIEW_NEWER_TOPIC'])) ? $this->_rootref['U_VIEW_NEWER_TOPIC'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NEXT_TOPIC'])) ? $this->_rootref['L_VIEW_NEXT_TOPIC'] : ((isset($user->lang['VIEW_NEXT_TOPIC'])) ? $user->lang['VIEW_NEXT_TOPIC'] : '{ VIEW_NEXT_TOPIC }')); ?></a>&nbsp;</td>
			</tr>
			</table>
<?php if ($this->_rootref['S_HAS_POLL']) {  ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
	<tr>
		<td class="row2" colspan="2" align="center"><br clear="all" />

			<form method="post" action="<?php echo (isset($this->_rootref['S_POLL_ACTION'])) ? $this->_rootref['S_POLL_ACTION'] : ''; ?>">

			<table cellspacing="0" cellpadding="4" border="0" align="center" class="poll">
			<tr>
				<td align="center"><span class="gen"><b><?php echo (isset($this->_rootref['POLL_QUESTION'])) ? $this->_rootref['POLL_QUESTION'] : ''; ?></b></span><br /><span class="gensmall"><?php echo ((isset($this->_rootref['L_POLL_LENGTH'])) ? $this->_rootref['L_POLL_LENGTH'] : ((isset($user->lang['POLL_LENGTH'])) ? $user->lang['POLL_LENGTH'] : '{ POLL_LENGTH }')); ?></span></td>
			</tr>
			<tr>
				<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>">
					<table cellspacing="0" cellpadding="2" border="0">
				<?php $_poll_option_count = (isset($this->_tpldata['poll_option'])) ? sizeof($this->_tpldata['poll_option']) : 0;if ($_poll_option_count) {for ($_poll_option_i = 0; $_poll_option_i < $_poll_option_count; ++$_poll_option_i){$_poll_option_val = &$this->_tpldata['poll_option'][$_poll_option_i]; ?>

					<tr>
						<td><span class="gen">
							<?php if ($this->_rootref['S_CAN_VOTE']) {  ?>

								<label>
								<?php if ($this->_rootref['S_IS_MULTI_CHOICE']) {  ?>

									<input type="checkbox" class="radio" name="vote_id[]" value="<?php echo $_poll_option_val['POLL_OPTION_ID']; ?>"<?php if ($_poll_option_val['POLL_OPTION_VOTED']) {  ?> checked="checked"<?php } ?> />
								<?php } else { ?>

									<input type="radio" class="radio" name="vote_id[]" value="<?php echo $_poll_option_val['POLL_OPTION_ID']; ?>"<?php if ($_poll_option_val['POLL_OPTION_VOTED']) {  ?> checked="checked"<?php } ?> />
								<?php } } ?>

							<?php echo $_poll_option_val['POLL_OPTION_CAPTION']; ?>

							<?php if ($this->_rootref['S_CAN_VOTE']) {  ?></label><?php } ?>

						</span></td>
						<?php if ($this->_rootref['S_DISPLAY_RESULTS']) {  ?>

							<td dir="ltr"><?php echo (isset($this->_rootref['POLL_LEFT_CAP_IMG'])) ? $this->_rootref['POLL_LEFT_CAP_IMG'] : ''; echo $_poll_option_val['POLL_OPTION_IMG']; echo (isset($this->_rootref['POLL_RIGHT_CAP_IMG'])) ? $this->_rootref['POLL_RIGHT_CAP_IMG'] : ''; ?></td>
							<td class="gen" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><b>&nbsp;<?php echo $_poll_option_val['POLL_OPTION_PERCENT']; ?>&nbsp;</b></td>
							<td class="gen" align="center">[ <?php echo $_poll_option_val['POLL_OPTION_RESULT']; ?> ]</td>
							<?php if ($_poll_option_val['POLL_OPTION_VOTED']) {  ?>

								<td class="gensmall" valign="top"><b title="<?php echo ((isset($this->_rootref['L_POLL_VOTED_OPTION'])) ? $this->_rootref['L_POLL_VOTED_OPTION'] : ((isset($user->lang['POLL_VOTED_OPTION'])) ? $user->lang['POLL_VOTED_OPTION'] : '{ POLL_VOTED_OPTION }')); ?>">x</b></td>
							<?php } } ?>

					</tr>
				<?php }} ?>

					</table>
				</td>
			</tr>
		<?php if ($this->_rootref['S_CAN_VOTE']) {  ?>

			<tr>
				<td align="center"><span class="gensmall"><?php echo ((isset($this->_rootref['L_MAX_VOTES'])) ? $this->_rootref['L_MAX_VOTES'] : ((isset($user->lang['MAX_VOTES'])) ? $user->lang['MAX_VOTES'] : '{ MAX_VOTES }')); ?></span><br /><br /><input type="submit" name="update" value="<?php echo ((isset($this->_rootref['L_SUBMIT_VOTE'])) ? $this->_rootref['L_SUBMIT_VOTE'] : ((isset($user->lang['SUBMIT_VOTE'])) ? $user->lang['SUBMIT_VOTE'] : '{ SUBMIT_VOTE }')); ?>" class="btnlite" /></td>
			</tr>
		<?php } if ($this->_rootref['S_DISPLAY_RESULTS']) {  ?>

			<tr>
				<td class="gensmall" colspan="4" align="center"><b><?php echo ((isset($this->_rootref['L_TOTAL_VOTES'])) ? $this->_rootref['L_TOTAL_VOTES'] : ((isset($user->lang['TOTAL_VOTES'])) ? $user->lang['TOTAL_VOTES'] : '{ TOTAL_VOTES }')); ?> : <?php echo (isset($this->_rootref['TOTAL_VOTES'])) ? $this->_rootref['TOTAL_VOTES'] : ''; ?></b></td>
			</tr>
		<?php } else { ?>

			<tr>
				<td align="center"><span class="gensmall"><b><a href="<?php echo (isset($this->_rootref['U_VIEW_RESULTS'])) ? $this->_rootref['U_VIEW_RESULTS'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_RESULTS'])) ? $this->_rootref['L_VIEW_RESULTS'] : ((isset($user->lang['VIEW_RESULTS'])) ? $user->lang['VIEW_RESULTS'] : '{ VIEW_RESULTS }')); ?></a></b></span></td>
			</tr>
		<?php } ?>

			</table>
			<?php echo (isset($this->_rootref['S_HIDDEN_FIELDS'])) ? $this->_rootref['S_HIDDEN_FIELDS'] : ''; ?>

			<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

			</form>
			
		</td>
	</tr>
	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

	<br />
<?php } $_postrow_count = (isset($this->_tpldata['postrow'])) ? sizeof($this->_tpldata['postrow']) : 0;if ($_postrow_count) {for ($_postrow_i = 0; $_postrow_i < $_postrow_count; ++$_postrow_i){$_postrow_val = &$this->_tpldata['postrow'][$_postrow_i]; if ($_postrow_val['S_FIRST_ROW'] || $this->_tpldata['DEFINE']['.']['CA_SPLIT_POSTS']) {  ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
        <?php if (! $this->_tpldata['DEFINE']['.']['CA_SPLIT_POSTS']) {  ?>

        <tr>
            <th><?php echo ((isset($this->_rootref['L_AUTHOR'])) ? $this->_rootref['L_AUTHOR'] : ((isset($user->lang['AUTHOR'])) ? $user->lang['AUTHOR'] : '{ AUTHOR }')); ?></th>
            <th width="100%"><?php echo ((isset($this->_rootref['L_MESSAGE'])) ? $this->_rootref['L_MESSAGE'] : ((isset($user->lang['MESSAGE'])) ? $user->lang['MESSAGE'] : '{ MESSAGE }')); ?></th>
        </tr>
        <?php } } if (!($_postrow_val['S_ROW_COUNT'] & 1)  ) {  ?><tr class="row1"><?php } else { ?><tr class="row2"><?php } if ($_postrow_val['S_IGNORE_POST']) {  ?>

			<td class="gensmall row" colspan="2" height="25" align="center"><?php if ($_postrow_val['S_FIRST_UNREAD']) {  ?><a name="unread"></a><?php } ?><a name="p<?php echo $_postrow_val['POST_ID']; ?>"></a><?php echo $_postrow_val['L_IGNORE_POST']; ?></td>
	<?php } else { ?>


			<td align="center" valign="top" class="row">
				<?php if ($_postrow_val['S_FIRST_UNREAD']) {  ?><a name="unread"></a><?php } ?><a name="p<?php echo $_postrow_val['POST_ID']; ?>"></a>
				<div class="postauthor"<?php if ($_postrow_val['POST_AUTHOR_COLOUR']) {  ?> style="color: <?php echo $_postrow_val['POST_AUTHOR_COLOUR']; ?>"<?php } ?>><?php echo $_postrow_val['POST_AUTHOR']; ?></div>
				<?php if ($_postrow_val['ONLINE_IMG'] && $_postrow_val['S_ONLINE']) {  ?><div class="postonline"><?php echo $_postrow_val['ONLINE_IMG']; ?></div><?php } if ($_postrow_val['RANK_TITLE']) {  ?><div class="posterrank"><?php echo $_postrow_val['RANK_TITLE']; ?></div><?php } if ($_postrow_val['RANK_IMG']) {  ?><div class="postrankimg"><?php echo $_postrow_val['RANK_IMG']; ?></div><?php } if ($_postrow_val['POSTER_AVATAR']) {  ?><div class="postavatar"><?php echo $_postrow_val['POSTER_AVATAR']; ?></div><?php } ?>


				<div class="postdetails">
					<?php if ($_postrow_val['POSTER_JOINED']) {  ?><br /><b><?php echo ((isset($this->_rootref['L_JOINED'])) ? $this->_rootref['L_JOINED'] : ((isset($user->lang['JOINED'])) ? $user->lang['JOINED'] : '{ JOINED }')); ?>:</b> <?php echo $_postrow_val['POSTER_JOINED']; } if ($_postrow_val['POSTER_POSTS'] != ('')) {  ?><br /><b><?php echo ((isset($this->_rootref['L_POSTS'])) ? $this->_rootref['L_POSTS'] : ((isset($user->lang['POSTS'])) ? $user->lang['POSTS'] : '{ POSTS }')); ?>:</b> <?php echo $_postrow_val['POSTER_POSTS']; } if ($_postrow_val['POSTER_FROM']) {  ?><br /><b><?php echo ((isset($this->_rootref['L_LOCATION'])) ? $this->_rootref['L_LOCATION'] : ((isset($user->lang['LOCATION'])) ? $user->lang['LOCATION'] : '{ LOCATION }')); ?>:</b> <?php echo $_postrow_val['POSTER_FROM']; } if ($_postrow_val['S_PROFILE_FIELD1']) {  ?><!-- Use a construct like this to include admin defined profile fields. Replace FIELD1 with the name of your field. -->
						<br /><b><?php echo $_postrow_val['PROFILE_FIELD1_NAME']; ?>:</b> <?php echo $_postrow_val['PROFILE_FIELD1_VALUE']; ?>

					<?php } $_custom_fields_count = (isset($_postrow_val['custom_fields'])) ? sizeof($_postrow_val['custom_fields']) : 0;if ($_custom_fields_count) {for ($_custom_fields_i = 0; $_custom_fields_i < $_custom_fields_count; ++$_custom_fields_i){$_custom_fields_val = &$_postrow_val['custom_fields'][$_custom_fields_i]; ?>

						<br /><b><?php echo $_custom_fields_val['PROFILE_FIELD_NAME']; ?>:</b> <?php echo $_custom_fields_val['PROFILE_FIELD_VALUE']; ?>

					<?php }} ?>

				</div>
				<img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/spacer.gif" width="120" height="1" alt="" />
			</td>
			<td width="100%" height="25" class="row" valign="top">
				<?php if (! $this->_rootref['S_IS_BOT']) {  ?><div style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>;"><?php if ($_postrow_val['U_EDIT']) {  ?><a href="<?php echo $_postrow_val['U_EDIT']; ?>"><?php echo (isset($this->_rootref['EDIT_IMG'])) ? $this->_rootref['EDIT_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_QUOTE']) {  ?><a href="<?php echo $_postrow_val['U_QUOTE']; ?>"><?php echo (isset($this->_rootref['QUOTE_IMG'])) ? $this->_rootref['QUOTE_IMG'] : ''; ?></a><?php } ?></div><?php } ?>

				<div class="postsubject"><?php if ($this->_rootref['S_IS_BOT']) {  echo $_postrow_val['MINI_POST_IMG']; } else { ?><a href="<?php echo $_postrow_val['U_MINI_POST']; ?>"><?php if ($_postrow_val['POST_ICON_IMG']) {  ?><img src="<?php echo (isset($this->_rootref['T_ICONS_PATH'])) ? $this->_rootref['T_ICONS_PATH'] : ''; echo $_postrow_val['POST_ICON_IMG']; ?>" width="<?php echo $_postrow_val['POST_ICON_IMG_WIDTH']; ?>" height="<?php echo $_postrow_val['POST_ICON_IMG_HEIGHT']; ?>" alt="" /><?php } else { echo $_postrow_val['MINI_POST_IMG']; } ?></a><?php } ?>&nbsp;<?php echo $_postrow_val['POST_SUBJECT']; ?></div>

					<?php if ($_postrow_val['S_POST_UNAPPROVED'] || $_postrow_val['S_POST_REPORTED']) {  ?>

						<div class="gensmall"><?php if ($_postrow_val['S_POST_UNAPPROVED']) {  ?><span class="postapprove"><?php echo (isset($this->_rootref['UNAPPROVED_IMG'])) ? $this->_rootref['UNAPPROVED_IMG'] : ''; ?> <a href="<?php echo $_postrow_val['U_MCP_APPROVE']; ?>"><?php echo ((isset($this->_rootref['L_POST_UNAPPROVED'])) ? $this->_rootref['L_POST_UNAPPROVED'] : ((isset($user->lang['POST_UNAPPROVED'])) ? $user->lang['POST_UNAPPROVED'] : '{ POST_UNAPPROVED }')); ?></a></span><br /> <?php } if ($_postrow_val['S_POST_REPORTED']) {  ?><span class="postreported"><?php echo (isset($this->_rootref['REPORTED_IMG'])) ? $this->_rootref['REPORTED_IMG'] : ''; ?> <a href="<?php echo $_postrow_val['U_MCP_REPORT']; ?>"><?php echo ((isset($this->_rootref['L_POST_REPORTED'])) ? $this->_rootref['L_POST_REPORTED'] : ((isset($user->lang['POST_REPORTED'])) ? $user->lang['POST_REPORTED'] : '{ POST_REPORTED }')); ?></a></span><?php } ?></div>
					<?php } ?>


						<div class="postbody"><?php echo $_postrow_val['MESSAGE']; ?></div>

					<?php if ($_postrow_val['S_HAS_ATTACHMENTS']) {  ?>

						<br clear="all" /><br />

						<div class="attachwrapper"><div class="attachtitle"><?php echo ((isset($this->_rootref['L_ATTACHMENTS'])) ? $this->_rootref['L_ATTACHMENTS'] : ((isset($user->lang['ATTACHMENTS'])) ? $user->lang['ATTACHMENTS'] : '{ ATTACHMENTS }')); ?>:</div>
						<?php $_attachment_count = (isset($_postrow_val['attachment'])) ? sizeof($_postrow_val['attachment']) : 0;if ($_attachment_count) {for ($_attachment_i = 0; $_attachment_i < $_attachment_count; ++$_attachment_i){$_attachment_val = &$_postrow_val['attachment'][$_attachment_i]; ?>

						<div class="attachcontent"><?php echo $_attachment_val['DISPLAY_ATTACHMENT']; ?></div>
						<?php }} ?>

						</div>
					<?php } if ($_postrow_val['S_DISPLAY_NOTICE']) {  ?>

						<span class="gensmall error"><br /><br /><?php echo ((isset($this->_rootref['L_DOWNLOAD_NOTICE'])) ? $this->_rootref['L_DOWNLOAD_NOTICE'] : ((isset($user->lang['DOWNLOAD_NOTICE'])) ? $user->lang['DOWNLOAD_NOTICE'] : '{ DOWNLOAD_NOTICE }')); ?></span>
					<?php } if ($_postrow_val['SIGNATURE']) {  ?>

						<span class="postbody signature"><br /><span class="line">_________________</span><br /><?php echo $_postrow_val['SIGNATURE']; ?></span>
					<?php } if ($_postrow_val['EDITED_MESSAGE'] || $_postrow_val['EDIT_REASON']) {  if ($_postrow_val['EDIT_REASON']) {  ?>

							<br /><br />
							<div class="edited">
								<p class="gensmall"><?php echo $_postrow_val['EDITED_MESSAGE']; ?></p>
								<p class="genmed"><?php echo $_postrow_val['EDIT_REASON']; ?></p>
							</div>
						<?php } else { ?>

							<br /><br />
							<div class="edited">
    							<p class="gensmall"><?php echo $_postrow_val['EDITED_MESSAGE']; ?></p>
    						</div>
						<?php } } if ($_postrow_val['BUMPED_MESSAGE']) {  ?>

						<span class="gensmall"><br /><br /><?php echo $_postrow_val['BUMPED_MESSAGE']; ?></span>
					<?php } if (! $_postrow_val['S_HAS_ATTACHMENTS']) {  ?><br clear="all" /><br /><?php } ?>

			</td>
		</tr>

		<?php if (!($_postrow_val['S_ROW_COUNT'] & 1)  ) {  ?><tr class="row1"><?php } else { ?><tr class="row2"><?php } ?>


			<td class="postbottom" align="center"><?php echo $_postrow_val['POST_DATE']; ?></td>
			<td class="postbottom postbuttons" valign="middle">
				<?php if (! $this->_rootref['S_IS_BOT']) {  ?>

					<div style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>">
					<?php if ($_postrow_val['U_REPORT']) {  ?><a href="<?php echo $_postrow_val['U_REPORT']; ?>"><?php echo (isset($this->_rootref['REPORT_IMG'])) ? $this->_rootref['REPORT_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_INFO']) {  ?><a href="<?php echo $_postrow_val['U_INFO']; ?>"><?php echo (isset($this->_rootref['INFO_IMG'])) ? $this->_rootref['INFO_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_WARN']) {  ?><a href="<?php echo $_postrow_val['U_WARN']; ?>"><?php echo (isset($this->_rootref['WARN_IMG'])) ? $this->_rootref['WARN_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_DELETE']) {  ?><a href="<?php echo $_postrow_val['U_DELETE']; ?>"><?php echo (isset($this->_rootref['DELETE_IMG'])) ? $this->_rootref['DELETE_IMG'] : ''; ?></a> <?php } ?>

					</div>
				<?php } if ($_postrow_val['U_POST_AUTHOR']) {  ?><a href="<?php echo $_postrow_val['U_POST_AUTHOR']; ?>"><?php echo (isset($this->_rootref['PROFILE_IMG'])) ? $this->_rootref['PROFILE_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_PM']) {  ?><a href="<?php echo $_postrow_val['U_PM']; ?>"><?php echo (isset($this->_rootref['PM_IMG'])) ? $this->_rootref['PM_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_EMAIL']) {  ?><a href="<?php echo $_postrow_val['U_EMAIL']; ?>"><?php echo (isset($this->_rootref['EMAIL_IMG'])) ? $this->_rootref['EMAIL_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_MSN']) {  ?><a href="<?php echo $_postrow_val['U_MSN']; ?>"><?php echo (isset($this->_rootref['MSN_IMG'])) ? $this->_rootref['MSN_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_ICQ']) {  ?><a href="<?php echo $_postrow_val['U_ICQ']; ?>"><?php echo (isset($this->_rootref['ICQ_IMG'])) ? $this->_rootref['ICQ_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_YIM']) {  ?><a href="<?php echo $_postrow_val['U_YIM']; ?>"><?php echo (isset($this->_rootref['YIM_IMG'])) ? $this->_rootref['YIM_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_AIM']) {  ?><a href="<?php echo $_postrow_val['U_AIM']; ?>"><?php echo (isset($this->_rootref['AIM_IMG'])) ? $this->_rootref['AIM_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_JABBER']) {  ?><a href="<?php echo $_postrow_val['U_JABBER']; ?>"><?php echo (isset($this->_rootref['JABBER_IMG'])) ? $this->_rootref['JABBER_IMG'] : ''; ?></a> <?php } if ($_postrow_val['U_WWW']) {  ?><a href="<?php echo $_postrow_val['U_WWW']; ?>"><?php echo (isset($this->_rootref['WWW_IMG'])) ? $this->_rootref['WWW_IMG'] : ''; ?></a> <?php } ?>

			</td>
    	<?php } ?>

		</tr>
	<?php if ($this->_tpldata['DEFINE']['.']['CA_SPLIT_POSTS'] && ! $_postrow_val['S_LAST_ROW']) {  ?>

	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>

	<br />
	<?php } else if (! $this->_tpldata['DEFINE']['.']['CA_SKIP_LAST_SPACER'] || ! $_postrow_val['S_LAST_ROW']) {  ?>

	<tr>
		<td class="spacer" colspan="2" height="1"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<?php } }} else { ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_START'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_START'] : ''; ?>

	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_START'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_START'] : ''; echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; echo (isset($this->_tpldata['DEFINE']['.']['CA_CAP2_END'])) ? $this->_tpldata['DEFINE']['.']['CA_CAP2_END'] : ''; ?>

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
<?php } if (! $this->_rootref['S_IS_BOT']) {  ?>

	<tr>
		<td class="cat" colspan="2" align="center"><form name="viewtopic" method="post" action="<?php echo (isset($this->_rootref['S_TOPIC_ACTION'])) ? $this->_rootref['S_TOPIC_ACTION'] : ''; ?>"><span class="gensmall"><?php echo ((isset($this->_rootref['L_DISPLAY_POSTS'])) ? $this->_rootref['L_DISPLAY_POSTS'] : ((isset($user->lang['DISPLAY_POSTS'])) ? $user->lang['DISPLAY_POSTS'] : '{ DISPLAY_POSTS }')); ?>:</span> <?php echo (isset($this->_rootref['S_SELECT_SORT_DAYS'])) ? $this->_rootref['S_SELECT_SORT_DAYS'] : ''; ?>&nbsp;<span class="gensmall"><?php echo ((isset($this->_rootref['L_SORT_BY'])) ? $this->_rootref['L_SORT_BY'] : ((isset($user->lang['SORT_BY'])) ? $user->lang['SORT_BY'] : '{ SORT_BY }')); ?></span> <?php echo (isset($this->_rootref['S_SELECT_SORT_KEY'])) ? $this->_rootref['S_SELECT_SORT_KEY'] : ''; ?> <?php echo (isset($this->_rootref['S_SELECT_SORT_DIR'])) ? $this->_rootref['S_SELECT_SORT_DIR'] : ''; ?>&nbsp;<input class="btnlite" type="submit" value="<?php echo ((isset($this->_rootref['L_GO'])) ? $this->_rootref['L_GO'] : ((isset($user->lang['GO'])) ? $user->lang['GO'] : '{ GO }')); ?>" name="sort" /></form></td>
	</tr>
	<?php } ?>

	</table>
	<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_BLOCK_END'])) ? $this->_tpldata['DEFINE']['.']['CA_BLOCK_END'] : ''; ?>


	<table width="100%" cellspacing="1">
	<tr>
		<?php if (! $this->_rootref['S_IS_BOT']) {  ?>

			<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>" valign="middle" nowrap="nowrap">
				<?php if ($this->_rootref['S_DISPLAY_REPLY_INFO']) {  ?><a href="<?php echo (isset($this->_rootref['U_POST_REPLY_TOPIC'])) ? $this->_rootref['U_POST_REPLY_TOPIC'] : ''; ?>"><?php echo (isset($this->_rootref['REPLY_IMG'])) ? $this->_rootref['REPLY_IMG'] : ''; ?></a>&nbsp;<?php } if ($this->_rootref['S_QUICK_REPLY']) {  ?><a href="javascript:void(0);" onclick="var qr = document.getElementById('ca-qr'); qr.style.display = (qr.style.display == 'none') ? '' : 'none'; return false;"><img src="<?php echo (isset($this->_rootref['T_IMAGESET_LANG_PATH'])) ? $this->_rootref['T_IMAGESET_LANG_PATH'] : ''; ?>/quick_reply.gif" /></a><?php } ?>

			</td>
		<?php } if ($this->_rootref['TOTAL_POSTS']) {  ?>

			<td class="nav" valign="middle" nowrap="nowrap">&nbsp;<?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?><br /></td>
			<td class="gensmall" nowrap="nowrap">&nbsp;[ <?php echo (isset($this->_rootref['TOTAL_POSTS'])) ? $this->_rootref['TOTAL_POSTS'] : ''; ?> ]&nbsp;</td>
			<td class="gensmall" width="100%" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" nowrap="nowrap"><?php $this->_tpl_include('pagination.html'); ?></td>
		<?php } ?>

	</tr>
	</table>

</div>

<?php if ($this->_rootref['S_QUICK_REPLY']) {  $this->_tpl_include('quickreply_editor.html'); } ?>


<div id="pagefooter"></div>

<?php $this->_tpl_include('breadcrumbs.html'); if ($this->_rootref['S_DISPLAY_ONLINE_LIST']) {  ?>

	<br clear="all" />

	<table class="tablebg" width="100%" cellspacing="<?php echo (isset($this->_tpldata['DEFINE']['.']['CA_SPACING'])) ? $this->_tpldata['DEFINE']['.']['CA_SPACING'] : ''; ?>">
	<tr>
		<td class="cat"><h4><?php echo ((isset($this->_rootref['L_WHO_IS_ONLINE'])) ? $this->_rootref['L_WHO_IS_ONLINE'] : ((isset($user->lang['WHO_IS_ONLINE'])) ? $user->lang['WHO_IS_ONLINE'] : '{ WHO_IS_ONLINE }')); ?></h4></td>
	</tr>
	<tr>
		<td class="row1"><p class="gensmall"><?php echo (isset($this->_rootref['LOGGED_IN_USER_LIST'])) ? $this->_rootref['LOGGED_IN_USER_LIST'] : ''; ?></p></td>
	</tr>
	</table>
<?php } ?>


<br clear="all" />

<table width="100%" cellspacing="1">
<tr>
	<td width="40%" valign="top" nowrap="nowrap" align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_BEGIN'])) ? $this->_rootref['S_CONTENT_FLOW_BEGIN'] : ''; ?>"><?php if ($this->_rootref['S_TOPIC_MOD']) {  ?><form method="post" action="<?php echo (isset($this->_rootref['S_MOD_ACTION'])) ? $this->_rootref['S_MOD_ACTION'] : ''; ?>"><span class="gensmall"><?php echo ((isset($this->_rootref['L_QUICK_MOD'])) ? $this->_rootref['L_QUICK_MOD'] : ((isset($user->lang['QUICK_MOD'])) ? $user->lang['QUICK_MOD'] : '{ QUICK_MOD }')); ?>:</span> <?php echo (isset($this->_rootref['S_TOPIC_MOD'])) ? $this->_rootref['S_TOPIC_MOD'] : ''; ?> <input class="btnlite" type="submit" value="<?php echo ((isset($this->_rootref['L_GO'])) ? $this->_rootref['L_GO'] : ((isset($user->lang['GO'])) ? $user->lang['GO'] : '{ GO }')); ?>" /></form><?php } ?></td>
	<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>" valign="top" nowrap="nowrap"><span class="gensmall"><?php $_rules_count = (isset($this->_tpldata['rules'])) ? sizeof($this->_tpldata['rules']) : 0;if ($_rules_count) {for ($_rules_i = 0; $_rules_i < $_rules_count; ++$_rules_i){$_rules_val = &$this->_tpldata['rules'][$_rules_i]; echo $_rules_val['RULE']; ?><br /><?php }} ?></span></td>
</tr>
</table>

<br clear="all" />

<table width="100%" cellspacing="0">
<tr>
	<td><?php if ($this->_rootref['S_DISPLAY_SEARCHBOX']) {  $this->_tpl_include('searchbox.html'); } ?></td>
	<td align="<?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>"><?php $this->_tpl_include('jumpbox.html'); ?></td>
</tr>
</table>

<?php $this->_tpl_include('overall_footer.html'); ?>