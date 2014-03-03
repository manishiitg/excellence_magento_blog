<?php
class Excellence_Pickup_Model_Sales_Order extends Mage_Sales_Model_Order{
	public function getShippingDescription(){
		$desc = parent::getShippingDescription();
		$pickupObject = $this->getPickupObject();
		if($pickupObject){
			$desc .= '<br/><b>Store</b>: '.$pickupObject->getStore();
			$desc .= '<br/><b>Name</b>: '.$pickupObject->getName();
			$desc .= '<br/>';
		}
		return $desc;
	}
}