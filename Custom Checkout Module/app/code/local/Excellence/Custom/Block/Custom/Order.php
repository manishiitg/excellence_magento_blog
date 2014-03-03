<?php
class Excellence_Custom_Block_Custom_Order extends Mage_Core_Block_Template{
	public function getCustomVars(){
		$model = Mage::getModel('custom/custom_order');
		return $model->getByOrder($this->getOrder()->getId());
	}
	public function getOrder()
	{
		return Mage::registry('current_order');
	}
}