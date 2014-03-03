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

				if($data['use_for_shipping'] != 0){
				$method = 'freeshipping_freeshipping';
				$result = $this->getOnepage()->saveShippingMethod($method);
				}

				if (!isset($result['error'])) {

					if ($this->getOnepage()->getQuote()->isVirtual()) {
						$result['goto_section'] = 'payment';
						$result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
						);
					} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
						$result['goto_section'] = 'payment';
						$result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
						);

						$result['allow_sections'] = array('shipping');
						$result['duplicateBillingInfo'] = 'true';
					} else {
						$result['goto_section'] = 'shipping';
					}
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

					$result['goto_section'] = 'payment';
					$result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
					);
				}
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
}