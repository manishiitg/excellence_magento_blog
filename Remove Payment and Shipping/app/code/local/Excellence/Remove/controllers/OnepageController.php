<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Excellence_Remove_OnepageController extends Mage_Checkout_OnepageController
{
	public function saveBillingAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			//            $postData = $this->getRequest()->getPost('billing', array());
			//            $data = $this->_filterPostData($postData);
			$data = $this->getRequest()->getPost('billing', array());
			$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

			if (isset($data['email'])) {
				$data['email'] = trim($data['email']);
			}
			$result = $this->getOnepage()->saveBilling($data, $customerAddressId);

			if (!isset($result['error'])) {

				if ($this->getOnepage()->getQuote()->isVirtual() || isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {

					if(!$this->getOnepage()->getQuote()->isVirtual()){
						$method = 'freeshipping_freeshipping';
						$result = $this->getOnepage()->saveShippingMethod($method);
					}

					if (!isset($result['error'])) {

						try{
							$data = array('method'=>'free');
							$result = $this->getOnepage()->savePayment($data);
							$redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
							if (empty($result['error']) && !$redirectUrl) {
								$this->loadLayout('checkout_onepage_review');
								$result['goto_section'] = 'review';
								$result['update_section'] = array(
				                    'name' => 'review',
				                    'html' => $this->_getReviewHtml()
								);
							}
							if ($redirectUrl) {
								$result['redirect'] = $redirectUrl;
							}
							if(!$this->getOnepage()->getQuote()->isVirtual()){
								$result['allow_sections'] = array('shipping');
								$result['duplicateBillingInfo'] = 'true';
							}
						} catch (Mage_Payment_Exception $e) {
							if ($e->getFields()) {
								$result['fields'] = $e->getFields();
							}
							$result['error'] = $e->getMessage();
						} catch (Mage_Core_Exception $e) {
							$result['error'] = $e->getMessage();
						} catch (Exception $e) {
							Mage::logException($e);
							$result['error'] = $this->__('Unable to set Payment Method.');
						}
					}
				} else {
					$result['goto_section'] = 'shipping';
				}
			}

			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}

	public function saveShippingAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost('shipping', array());
			$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
			$result = $this->getOnepage()->saveShipping($data, $customerAddressId);

			if (!isset($result['error'])) {
				$method = 'freeshipping_freeshipping';
				$result = $this->getOnepage()->saveShippingMethod($method);

				if (!isset($result['error'])) {

					try{
						$data = array('method'=>'free');
						$result = $this->getOnepage()->savePayment($data);
						$redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
						if (empty($result['error']) && !$redirectUrl) {
							$this->loadLayout('checkout_onepage_review');
							$result['goto_section'] = 'review';
							$result['update_section'] = array(
	                    'name' => 'review',
	                    'html' => $this->_getReviewHtml()
							);
						}
						if ($redirectUrl) {
							$result['redirect'] = $redirectUrl;
						}
					} catch (Mage_Payment_Exception $e) {
						if ($e->getFields()) {
							$result['fields'] = $e->getFields();
						}
						$result['error'] = $e->getMessage();
					} catch (Mage_Core_Exception $e) {
						$result['error'] = $e->getMessage();
					} catch (Exception $e) {
						Mage::logException($e);
						$result['error'] = $this->__('Unable to set Payment Method.');
					}
				}
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
}