<?php
class Excellence_File_Model_Observer {
	public function saveQuoteAfter($evt){
		$quote = $evt->getQuote();

		$post = Mage::app()->getRequest()->getPost();

		if(isset($post['file_upload_path'])){
			$quote_id = $quote->getId();
			$filename = $post['file_upload_path'];
			$type = $post['file_upload_type'];
			Mage::log($quote_id.'xx'.$filename);
			Mage::getModel('file/file')->saveFile($quote_id,$filename,$type);
		}

	}
	public function placeOrderAfter($evt)
	{
		$order = $evt->getOrder();
		$quote = $evt->getQuote();

		$quote_id = $quote->getId();
		$order_id = $order->getId();

		$collection = Mage::getModel('file/file')->getCollection();
		$collection->addFieldToFilter('quote_id',$quote_id);

		Mage::log('Observer Place Order After Quote ID:' . $quote_id);

		foreach($collection as $object){
			Mage::getModel('file/order')->saveFile($order_id,$object->getFilename(),$object->getType());
			$object->delete();
		}
		Mage::getModel('file/file')->resetUniqId();
	}
}