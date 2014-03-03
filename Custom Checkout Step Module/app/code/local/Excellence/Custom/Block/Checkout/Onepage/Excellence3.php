<?php
class Excellence_Custom_Block_Checkout_Onepage_Excellence3 extends Mage_Checkout_Block_Onepage_Abstract{
	protected function _construct()
	{
		$this->getCheckout()->setStepData('excellence3', array(
            'label'     => Mage::helper('checkout')->__('Excellence  Review'),
            'is_show'   => $this->isShow()
		));
		parent::_construct();
	}
}