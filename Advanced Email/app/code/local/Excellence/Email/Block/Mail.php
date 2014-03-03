<?php
class Excellence_Email_Block_Mail extends Mage_Core_Block_Template
{
	protected function _construct()
	{
		 $this->setTemplate('email/mail.phtml');
	}
}