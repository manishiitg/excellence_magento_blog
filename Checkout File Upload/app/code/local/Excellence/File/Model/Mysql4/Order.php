<?php

class Excellence_File_Model_Mysql4_Order extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		// Note that the file_id refers to the key field in your database table.
		$this->_init('file/order_file', 'id');
	}
	public function deleteFile($order_id,$filename,$type){
		$table = $this->getMainTable();
			
		$where = $this->_getReadAdapter()->quoteInto('order_id = ? and ',$order_id).
		$this->_getReadAdapter()->quoteInto('`type` = ? ',$type);
		$select = $this->_getReadAdapter()->select()->from($table)->where($where);

		Mage::log($select.'');
		$rows = $this->_getReadAdapter()->fetchAll($select);
		if(sizeof($rows) > 0){
			$this->_getWriteAdapter()->delete($table,$where);
		}
	}
}