<?php
class Excellence_Custom_Model_Checkout_Type_Onepage extends Mage_Checkout_Model_Type_Onepage{
	public function saveExcellence($data){
		if (empty($data)) {
			return array('error' => -1, 'message' => $this->_helper->__('Invalid data.'));
		}
		$this->getQuote()->setExcellenceLike($data['like']);
		$this->getQuote()->collectTotals();
		$this->getQuote()->save();

		$this->getCheckout()
		->setStepData('excellence', 'allow', true)
		->setStepData('excellence', 'complete', true)
		->setStepData('billing', 'allow', true);

		return array();
	}
	public function saveExcellence2($data){
		if (empty($data)) {
			return array('error' => -1, 'message' => $this->_helper->__('Invalid data.'));
		}
		$this->getQuote()->setExcellenceLike2($data['like']);
		$this->getQuote()->collectTotals();
		$this->getQuote()->save();

		$this->getCheckout()
		->setStepData('excellence2', 'allow', true)
		->setStepData('excellence2', 'complete', true)
		->setStepData('shipping_method', 'allow', true);

		return array();
	}
	public function saveExcellence3($data){
		if (empty($data)) {
			return array('error' => -1, 'message' => $this->_helper->__('Invalid data.'));
		}
		$this->getQuote()->setExcellenceLike3($data['like']);
		$this->getQuote()->collectTotals();
		$this->getQuote()->save();

		$this->getCheckout()
		->setStepData('excellence3', 'allow', true)
		->setStepData('excellence3', 'complete', true);

		return array();
	}
}