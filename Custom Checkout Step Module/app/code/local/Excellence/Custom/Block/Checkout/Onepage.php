<?php
class Excellence_Custom_Block_Checkout_Onepage extends Mage_Checkout_Block_Onepage{

	public function getSteps()
	{
		$steps = array();

		if (!$this->isCustomerLoggedIn()) {
			$steps['login'] = $this->getCheckout()->getStepData('login');
		}

		//New Code Adding step excellence here
		$stepCodes = array('excellence','billing', 'shipping', 'excellence2', 'shipping_method', 'payment', 'excellence3','review');

		foreach ($stepCodes as $step) {
			$steps[$step] = $this->getCheckout()->getStepData($step);
		}
		return $steps;
	}

	public function getActiveStep()
	{
		//New Code, make step excellence active when user is already logged in
		return $this->isCustomerLoggedIn() ? 'excellence' : 'login';
	}

}