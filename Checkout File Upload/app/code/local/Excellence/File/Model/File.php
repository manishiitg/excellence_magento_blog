<?php

class Excellence_File_Model_File extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('file/file');
	}
	public function resetUniqId(){
		Mage::getSingleton('core/session')->setFileUniq(false);
	}
	public function getUniqueId($quote){
		$uniq = Mage::getSingleton('core/session')->getFileUniq();
		if($uniq){
		}else{
			$uniq =substr(md5(uniqid()), 0,8);
			Mage::getSingleton('core/session')->setFileUniq($uniq);
		}
		return $uniq;
	}
	public function saveFile($quote_id,$filename,$type){
		$this->getResource()->deleteFile($quote_id,$filename,$type);
		$this->setFilename($filename);
		$this->setQuoteId($quote_id);
		$this->setType($type);
		$this->save();
	}
}