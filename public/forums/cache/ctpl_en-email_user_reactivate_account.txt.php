<?php if (!defined('IN_PHPBB')) exit; ?>Subject: Reactivate your account on "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>"

A board administrator requested that your account be reactivated. Your account is currently inactive.
Please follow the steps listed here to reactivate your account.

Please keep this e-mail for your records. Your account information is as follows:

----------------------------
Username: <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>

----------------------------

Your password has been securely stored in our database and cannot be retrieved. In the event that it is forgotten, you will be able to reset it using the email address associated with your account.

Please visit the following link to reactivate your account:

<?php echo (isset($this->_rootref['U_ACTIVATE'])) ? $this->_rootref['U_ACTIVATE'] : ''; ?>



<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>