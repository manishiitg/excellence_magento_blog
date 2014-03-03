<?php
class Excellence_Custom_Block_Adminhtml_Custom_Order extends Mage_Adminhtml_Block_Sales_Order_Abstract{
	public function getCustomVars(){
		$model = Mage::getModel('custom/custom_order');
		return $model->getByOrder($this->getOrder()->getId());
	}
}