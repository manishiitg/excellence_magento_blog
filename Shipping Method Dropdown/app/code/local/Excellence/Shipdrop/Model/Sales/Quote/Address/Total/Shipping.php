<?php
class Excellence_Shipdrop_Model_Sales_Quote_Address_Total_Shipping extends Mage_Sales_Model_Quote_Address_Total_Shipping{
	public function fetch(Mage_Sales_Model_Quote_Address $address)
	{
		$amount = $address->getShippingAmount();
		$title = Mage::helper('sales')->__('Shipping & Handling');
		if ($address->getShippingDescription()) {
			$title .= ' (' . $address->getShippingDescription() . ')';
		}
		$address->addTotal(array(
				'code' => $this->getCode(),
				'title' => $title,
				'value' => $address->getShippingAmount()
		));
		return $this;
	}
}