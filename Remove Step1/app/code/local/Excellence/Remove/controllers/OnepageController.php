<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Excellence_Remove_OnepageController extends Mage_Checkout_OnepageController
{
	public function indexAction()
	{
		if (!Mage::helper('checkout')->canOnepageCheckout()) {
			Mage::getSingleton('checkout/session')->addError($this->__('The onepage checkout is disabled.'));
			$this->_redirect('checkout/cart');
			return;
		}
		$quote = $this->getOnepage()->getQuote();
		if (!$quote->hasItems() || $quote->getHasError()) {
			$this->_redirect('checkout/cart');
			return;
		}
		if (!$quote->validateMinimumAmount()) {
			$error = Mage::getStoreConfig('sales/minimum_order/error_message');
			Mage::getSingleton('checkout/session')->addError($error);
			$this->_redirect('checkout/cart');
			return;
		}

		Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
		Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_secure'=>true)));
		$this->getOnepage()->initCheckout();
		$this->loadLayout();
		$this->_initLayoutMessages('customer/session');
		$this->getLayout()->getBlock('head')->setTitle($this->__('Checkout'));

		//If you want guest checkout by default
		$method = Mage_Checkout_Model_Type_Onepage::METHOD_GUEST;
		$this->getOnepage()->saveCheckoutMethod($method);
		
		//If you want register checkout by default, uncomment code below
		/*
		 $method = Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER;
		 $this->getOnepage()->saveCheckoutMethod($method);
		*/
		

		//If you want only logged in users to be able to checkout, uncomment code below
		/*
		if(!Mage::getModel('customer/session')->isLoggedIn()){
			$this->_redirect('customer/account/login');
		}else{
			$method = Mage_Checkout_Model_Type_Onepage::METHOD_CUSTOMER;
			$this->getOnepage()->saveCheckoutMethod($method);
		}
		*/

		$this->renderLayout();
	}
}