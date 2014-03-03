<?php
class Excellence_Pay_Model_Pay extends Mage_Payment_Model_Method_Cc
{
	protected $_code = 'pay';
	protected $_formBlockType = 'pay/form_pay';
	protected $_infoBlockType = 'pay/info_pay';

	//protected $_isGateway               = true;
	protected $_canAuthorize            = false;
	protected $_canCapture              = false;
	//protected $_canCapturePartial       = true;
	protected $_canRefund               = false;


	protected $_canSaveCc = false; //if made try, the actual credit card number and cvv code are stored in database.

	//protected $_canRefundInvoicePartial = true;
	//protected $_canVoid                 = true;
	//protected $_canUseInternal          = true;
	//protected $_canUseCheckout          = true;
	//protected $_canUseForMultishipping  = true;
	//protected $_canFetchTransactionInfo = true;
	//protected $_canReviewPayment        = true;


	public function process($data){

		if($data['cancel'] == 1){
		 $order->getPayment()
		 ->setTransactionId(null)
		 ->setParentTransactionId(time())
		 ->void();
		 $message = 'Unable to process Payment';
		 $order->registerCancellation($message)->save();
		}
	}

	/** For capture **/
	public function capture(Varien_Object $payment, $amount)
	{
		$order = $payment->getOrder();
		$result = $this->callApi($payment,$amount,'authorize');
		if($result === false) {
			$errorCode = 'Invalid Data';
			$errorMsg = $this->_getHelper()->__('Error Processing the request');
		} else {
			Mage::log($result, null, $this->getCode().'.log');
			//process result here to check status etc as per payment gateway.
			// if invalid status throw exception

			if($result['status'] == 1){
				$payment->setTransactionId($result['transaction_id']);
				$payment->setIsTransactionClosed(1);
				$payment->setTransactionAdditionalInfo(Mage_Sales_Model_Order_Payment_Transaction::RAW_DETAILS,array('key1'=>'value1','key2'=>'value2'));
			}else{
				Mage::throwException($errorMsg);
			}

			// Add the comment and save the order
		}
		if($errorMsg){
			Mage::throwException($errorMsg);
		}

		return $this;
	}


	/** For authorization **/
	public function authorize(Varien_Object $payment, $amount)
	{
		$order = $payment->getOrder();
		$result = $this->callApi($payment,$amount,'authorize');
		if($result === false) {
			$errorCode = 'Invalid Data';
			$errorMsg = $this->_getHelper()->__('Error Processing the request');
		} else {
			Mage::log($result, null, $this->getCode().'.log');
			//process result here to check status etc as per payment gateway.
			// if invalid status throw exception

			if($result['status'] == 1){
				$payment->setTransactionId($result['transaction_id']);
				/*
				 * This marks transactions as closed or open
				*/
				$payment->setIsTransactionClosed(1);
				/*
				 * This basically makes order status to be payment review and no invoice is created.
				* and adds a default comment like
				* Authorizing amount of $17.00 is pending approval on gateway. Transaction ID: "1335419269".
				*
				*/
				//$payment->setIsTransactionPending(true);
				/*
				 * This basically makes order status to be processing and no invoice is created.
				* add a default comment to order like
				* Authorized amount of $17.00. Transaction ID: "1335419459".
				*/
				//$payment->setIsTransactionApproved(true);

				/*
				 * This method is used to display extra informatoin on transaction page
				*/
				$payment->setTransactionAdditionalInfo(Mage_Sales_Model_Order_Payment_Transaction::RAW_DETAILS,array('key1'=>'value1','key2'=>'value2'));


				$order->addStatusToHistory($order->getStatus(), 'Payment Sucessfully Placed with Transaction ID'.$result['transaction_id'], false);
				$order->save();
			}else{
				Mage::throwException($errorMsg);
			}

			// Add the comment and save the order
		}
		if($errorMsg){
			Mage::throwException($errorMsg);
		}

		return $this;
	}

	public function processBeforeRefund($invoice, $payment){
		return parent::processBeforeRefund($invoice, $payment);
	}
	public function refund(Varien_Object $payment, $amount){
		$order = $payment->getOrder();
		$result = $this->callApi($payment,$amount,'refund');
		if($result === false) {
			$errorCode = 'Invalid Data';
			$errorMsg = $this->_getHelper()->__('Error Processing the request');
			Mage::throwException($errorMsg);
		}
		return $this;

	}
	public function processCreditmemo($creditmemo, $payment){
		return parent::processCreditmemo($creditmemo, $payment);
	}

	private function callApi(Varien_Object $payment, $amount,$type){

		//call your authorize api here, incase of error throw exception.
		//only example code written below to show flow of code

		/*
		 $order = $payment->getOrder();
		$types = Mage::getSingleton('payment/config')->getCcTypes();
		if (isset($types[$payment->getCcType()])) {
		$type = $types[$payment->getCcType()];
		}
		$billingaddress = $order->getBillingAddress();
		$totals = number_format($amount, 2, '.', '');
		$orderId = $order->getIncrementId();
		$currencyDesc = $order->getBaseCurrencyCode();

		$url = $this->getConfigData('gateway_url');
		$fields = array(
				'api_username'=> $this->getConfigData('api_username'),
				'api_password'=> $this->getConfigData('api_password'),
				'customer_firstname'=> $billingaddress->getData('firstname'),
				'customer_lastname'=> $billingaddress->getData('lastname'),
				'customer_phone'=> $billingaddress->getData('telephone'),
				'customer_email'=> $billingaddress->getData('email'),
				'customer_ipaddress'=> $_SERVER['REMOTE_ADDR'],
				'bill_firstname'=> $billingaddress->getData('firstname'),
				'bill_lastname'=> $billingaddress->getData('lastname'),
				'Bill_address1'=> $billingaddress->getData('street'),
				'bill_city'=> $billingaddress->getData('city'),
				'bill_country'=> $billingaddress->getData('country_id'),
				'bill_state'=> $billingaddress->getData('region'),
				'bill_zip'=> $billingaddress->getData('postcode'),
				'customer_cc_expmo'=> $payment->getCcExpMonth(),
				'customer_cc_expyr'=> $payment->getCcExpYear(),
				'customer_cc_number'=> $payment->getCcNumber(),
				'customer_cc_type'=> strtoupper($type),
				'customer_cc_cvc'=> $payment->getCcCid(),
				'merchant_ref_number'=> $order->getIncrementId(),
				'currencydesc'=>$currencyDesc,
				'amount'=>$totals
		);

		$fields_string="";
		foreach($fields as $key=>$value) {
		$fields_string .= $key.'='.$value.'&';
		}
		$fields_string = substr($fields_string,0,-1);
		//open connection
		$ch = curl_init($url);
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
		curl_setopt($ch, CURLOPT_HEADER ,0); // DO NOT RETURN HTTP HEADERS
		curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1); // RETURN THE CONTENTS OF THE CALL
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Timeout on connect (2 minutes)
		//execute post
		$result = curl_exec($ch);
		curl_close($ch);
		*/

		return array('status'=>1,'transaction_id' => time() , 'fraud' => rand(0,1));
	//return array('status'=>rand(0, 1),'transaction_id' => time() , 'fraud' => rand(0,1));
	}

	/*
	public function getOrderPlaceRedirectUrl()
	{
		if((int)$this->_getOrderAmount() > 0){
			return Mage::getUrl('pay/index/index', array('_secure' => true));
		}else{
			return false;
		}
	}
	private function _getOrderAmount()
	{
		$info = $this->getInfoInstance();
		if ($this->_isPlacedOrder()) {
			return (double)$info->getOrder()->getQuoteBaseGrandTotal();
		} else {
			return (double)$info->getQuote()->getBaseGrandTotal();
		}
	}
	private function _isPlacedOrder()
	{
		$info = $this->getInfoInstance();
		if ($info instanceof Mage_Sales_Model_Quote_Payment) {
			return false;
		} elseif ($info instanceof Mage_Sales_Model_Order_Payment) {
			return true;
		}
	}
	*/
}
?>
