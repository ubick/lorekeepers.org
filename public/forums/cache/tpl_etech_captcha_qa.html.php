<?php if (!defined('IN_PHPBB')) exit; ?><tr>
		<th colspan="2" valign="middle"><?php echo (isset($this->_rootref['QA_CONFIRM_QUESTION'])) ? $this->_rootref['QA_CONFIRM_QUESTION'] : ''; ?></th>
	</tr>
	<tr>
		<td class="row1"><b class="genmed"><?php echo (isset($this->_rootref['QA_CONFIRM_QUESTION'])) ? $this->_rootref['QA_CONFIRM_QUESTION'] : ''; ?>:</b><br /></td>
		<td class="row2"><input class="post" type="text" name="qa_answer" size="80" /></td>
		<input type="hidden" name="qa_confirm_id" id="confirm_id" value="<?php echo (isset($this->_rootref['QA_CONFIRM_ID'])) ? $this->_rootref['QA_CONFIRM_ID'] : ''; ?>" /></td>
	</tr>