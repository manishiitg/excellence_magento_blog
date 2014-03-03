<?php

class Excellence_Email_Model_Email extends Varien_Object
{

	const XML_PATH_TEST_EMAIL = 'customer/account_share/custom_template';
	const XML_PATH_TEST_EMAIL_IDENTITY = 'customer/account_share/custom_identity';
	const XML_PATH_COPY_TO = 'customer/account_share/copy_to';
	const XML_PATH_COPY_TO_METHOD = 'customer/account_share/copy_to_method';

	public function sendTestEmail($to,$name){
		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);

		$storeId = Mage::app()->getStore()->getId();

		Mage::getModel('core/email_template')
		->setDesignConfig(array('area' => 'frontend', 'store' => $storeId))
		->sendTransactional(
		Mage::getStoreConfig(self::XML_PATH_TEST_EMAIL, $storeId),
		Mage::getStoreConfig(self::XML_PATH_TEST_EMAIL_IDENTITY, $storeId),
		$to,
		$name,
		array('variable1'=>'Manish','object' => $this,'html'=>'manish<b>test</b>')
		);

		$translate->setTranslateInline(true);
	}

	public function getObjectText(){
		return 'This is my text';
	}
	public function getCanShow(){
		return true;
	}
	public function shouldShow(){
		return true;
	}
	public function shouldShow2(){
		return false;
	}
	public function getName($show,$name){
		if($show){
			return 'My Name is '.$name;
		}else{
			return 'My Name is manish';
		}
	}
	public function sendTestEmail1($to,$name){
		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);

		$storeId = Mage::app()->getStore()->getId();

		$fromEmail = Mage::getStoreConfig('customer/account_share/custom_identity');

		$copyTo = $this->_getEmails(self::XML_PATH_COPY_TO);
		$copyMethod = Mage::getStoreConfig(self::XML_PATH_COPY_TO_METHOD, $storeId);

		$mailer = Mage::getModel('core/email_template_mailer');
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo($to, $name);
		if ($copyTo && $copyMethod == 'bcc') {
			// Add bcc to customer email
			foreach ($copyTo as $email) {
				$emailInfo->addBcc($email);
			}
		}
		$mailer->addEmailInfo($emailInfo);

		// Email copies are sent as separated emails if their copy method is 'copy'
		if ($copyTo && $copyMethod == 'copy') {
			foreach ($copyTo as $email) {
				$emailInfo = Mage::getModel('core/email_info');
				$emailInfo->addTo($email);
				$mailer->addEmailInfo($emailInfo);
			}
		}

		$templateId = Mage::getStoreConfig(self::XML_PATH_TEST_EMAIL, $storeId);
		// Set all required params and send emails
		$mailer->setSender(Mage::getStoreConfig(self::XML_PATH_TEST_EMAIL_IDENTITY, $storeId));
		$mailer->setStoreId($storeId);
		$mailer->setTemplateId($templateId);
		$mailer->setTemplateParams(array(
		)
		);
		$mailer->send();

		return $this;
	}
	protected function _getEmails($configPath)
	{
		$data = Mage::getStoreConfig($configPath, $this->getStoreId());
		if (!empty($data)) {
			return explode(',', $data);
		}
		return false;
	}
}