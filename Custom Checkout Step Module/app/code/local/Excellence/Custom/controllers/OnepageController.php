<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Excellence_Custom_OnepageController extends  Mage_Checkout_OnepageController{
	public function saveExcellenceAction(){
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost('excellence', array());

			$result = $this->getOnepage()->saveExcellence($data);

			if (!isset($result['error'])) {
				$result['goto_section'] = 'billing';
			}

			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
	public function saveExcellence2Action(){
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost('excellence2', array());

			$result = $this->getOnepage()->saveExcellence2($data);

			if (!isset($result['error'])) {
				$result['goto_section'] = 'shipping_method';
				$result['update_section'] = array(
                    'name' => 'shipping-method',
                    'html' => $this->_getShippingMethodsHtml()
				);
			}

			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
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
				/* check quote for virtual */
				if ($this->getOnepage()->getQuote()->isVirtual()) {
					$result['goto_section'] = 'payment';
					$result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
					);
				} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
					$result['goto_section'] = 'excellence2';  //Goes to our step
					$result['allow_sections'] = array('shipping');
					$result['duplicateBillingInfo'] = 'true';
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
				$result['goto_section'] = 'excellence2'; //Go to our step
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}

	public function savePaymentAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		try {
			if (!$this->getRequest()->isPost()) {
				$this->_ajaxRedirectResponse();
				return;
			}

			// set payment to quote
			$result = array();
			$data = $this->getRequest()->getPost('payment', array());
			$result = $this->getOnepage()->savePayment($data);

			if (empty($result['error'])) {
				$result['goto_section'] = 'excellence3';
				$result['update_section'] = array(
                    'name' => 'excellence3',
                    'html' => $this->_getExcellence3Html()
				);
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
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
	public function saveExcellence3Action(){
		if ($this->_expireAjax()) {
			return;
		}

		// get section and redirect data
		$redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();

		if (!isset($result['error'])) {
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

		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
	protected function _getExcellence3Html()
	{
		$layout = $this->getLayout();
		$update = $layout->getUpdate();
		$update->load('checkout_onepage_excellence3');
		$layout->generateXml();
		$layout->generateBlocks();
		$output = $layout->getOutput();
		return $output;
	}
}