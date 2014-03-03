<?php
class Excellence_Pay_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	public function successAction()
	{
		$request = $_REQUEST;
		Mage::log($request, null, 'lps.log');
		$orderIncrementId = $request['Merchant_ref_number'];
		Mage::log($orderIncrementId);
		$order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
		Mage::log($order->getId());
		Mage::log($order->getId(), null, 'lps.log');
		try{
			if($request['Status_'] == 05){
				$comment = $order->sendNewOrderEmail()->addStatusHistoryComment('Bank Status : Declined By Bank')
				->setIsCustomerNotified(false)
				->save();
				$this->_forward('error');
			}
			elseif($request['Status_'] == 90){
				$comment = $order->sendNewOrderEmail()->addStatusHistoryComment('Bank Status : Comm. Failed')
				->setIsCustomerNotified(false)
				->save();
				$this->_forward('error');
			}elseif($request['Status_'] == 00){
				$comment = $order->sendNewOrderEmail()->addStatusHistoryComment('Bank Status : ----')
				->setIsCustomerNotified(false)
				->save();
				$payment = $order->getPayment();
				$grandTotal = $order->getBaseGrandTotal();
				if(isset($request['Transactionid'])){
					$tid = $request['Transactionid'];
				}
				else {
					$tid = -1 ;
				}
					
				$payment->setTransactionId($tid)
				->setPreparedMessage("Payment Sucessfull Result:")
				->setIsTransactionClosed(0)
				->registerAuthorizationNotification($grandTotal);
				$order->save();


				/*if ($invoice = $payment->getCreatedInvoice()) {
				 $message = Mage::helper('pay')->__('Notified customer about invoice #%s.', $invoice->getIncrementId());
				$comment = $order->sendNewOrderEmail()->addStatusHistoryComment($message)
				->setIsCustomerNotified(true)
				->save();
				}*/
				try {
					if(!$order->canInvoice())
					{
						Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
					}

					$invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();

					if (!$invoice->getTotalQty()) {
						Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
					}

					$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
					//Or you can use
					//$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE);
					$invoice->register();
					$transactionSave = Mage::getModel('core/resource_transaction')
					->addObject($invoice)
					->addObject($invoice->getOrder());

					$transactionSave->save();
					$message = Mage::helper('pay')->__('Notified customer about invoice #%s.', $invoice->getIncrementId());
					$comment = $order->sendNewOrderEmail()->addStatusHistoryComment($message)
					->setIsCustomerNotified(true)
					->save();
				}
				catch (Mage_Core_Exception $e) {

				}
				//Mage::getSingleton('checkout/session')->getQuote()->setIsActive(false)->save();
				//$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
				$url = Mage::getUrl('checkout/onepage/success', array('_secure'=>true));
				Mage::register('redirect_url',$url);
				$this->_redirectUrl($url);
			}
		}
		catch(Exception $e)
		{
			Mage::logException($e);
		}
	}

	protected function _getCheckout()
	{
		return Mage::getSingleton('checkout/session');
	}

	public function errorAction()
	{
		$request = $_REQUEST;
		Mage::log($request, null, 'lps.log');
		$gotoSection = false;
		$session = $this->_getCheckout();
		if ($session->getLastRealOrderId()) {
			$order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
			if ($order->getId()) {
				//Cancel order
				if ($order->getState() != Mage_Sales_Model_Order::STATE_CANCELED) {
					$order->registerCancellation($errorMsg)->save();
				}
				$quote = Mage::getModel('sales/quote')
				->load($order->getQuoteId());
				//Return quote
				if ($quote->getId()) {
					$quote->setIsActive(1)
					->setReservedOrderId(NULL)
					->save();
					$session->replaceQuote($quote);
				}

				//Unset data
				$session->unsLastRealOrderId();
				//Redirect to payment step
				$gotoSection = 'payment';
				$url = Mage::getUrl('checkout/onepage/index', array('_secure'=>true));
				Mage::register('redirect_url',$url);
				$this->_redirectUrl($url);
			}
		}

		return $gotoSection;
	}
}