<?php
class Excellence_File_Model_Order extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('file/order');
	}
	public function saveFile($order_id,$filename,$type){
		$this->getResource()->deleteFile($order_id,$filename,$type);
		$this->setFilename($filename);
		$this->setOrderId($order_id);
		$this->setType($type);
		$this->save();
	}
	public function getFiles($order){
		$collection = Mage::getModel('file/order')->getCollection();
		$collection->addFieldToFilter('order_id',$order->getId());
		return $collection;
	}
}