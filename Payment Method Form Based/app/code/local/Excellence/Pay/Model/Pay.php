<?php
class Excellence_Pay_Model_Pay extends Mage_Payment_Model_Method_Abstract
{
	protected $_code = 'pay';
	protected $_formBlockType = 'pay/form_pay';
	protected $_infoBlockType = 'pay/info_pay';

	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}
		$info = $this->getInfoInstance();
		$info->setCheckNo($data->getCheckNo())
		->setCheckDate($data->getCheckDate());
		return $this;
	}


	public function validate()
	{
		parent::validate();

		$info = $this->getInfoInstance();

		$no = $info->getCheckNo();
		$date = $info->getCheckDate();
		if(empty($no) || empty($date)){
			$errorCode = 'invalid_data';
			$errorMsg = $this->_getHelper()->__('Check No and Date are required fields');
		}

		if($errorMsg){
			Mage::throwException($errorMsg);
		}


		return $this;
	}
}
?>
