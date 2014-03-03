<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Excellence_Remove_OnepageController extends Mage_Checkout_OnepageController
{
	public function saveShippingMethodAction()
	{
		if ($this->_expireAjax()) {
			return;
		}
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost('shipping_method', '');
			$result = $this->getOnepage()->saveShippingMethod($data);
			/*
			 $result will have erro data if shipping method is empty
			 */
			if(!$result) {
				Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
				array('request'=>$this->getRequest(),
                            'quote'=>$this->getOnepage()->getQuote()));
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

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
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}
}