<?php
class Excellence_Pay_Block_Info_Pay extends Mage_Payment_Block_Info
{
	protected function _prepareSpecificInformation($transport = null)
	{
		if (null !== $this->_paymentSpecificInformation) {
			return $this->_paymentSpecificInformation;
		}
		$info = $this->getInfo();
		$transport = new Varien_Object();
		$transport = parent::_prepareSpecificInformation($transport);
		$transport->addData(array(
			Mage::helper('payment')->__('Credit Card No Last 4') => $info->getCcLast4(),
			Mage::helper('payment')->__('Card Type') => $info->getCcType(),
			Mage::helper('payment')->__('Exp Date') => $info->getCcExpMonth() . ' / '.$info->getCcExpYear(),
			Mage::helper('payment')->__('Card Owner') => $info->getCcOwner(),
		));
		return $transport;
	}
}