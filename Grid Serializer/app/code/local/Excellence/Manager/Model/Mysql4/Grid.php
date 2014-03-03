<?php

class Excellence_Manager_Model_Mysql4_Grid extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		// Note that the manager_id refers to the key field in your database table.
		$this->_init('manager/grid', 'id');
	}
	public function addGridPosition($collection,$manager_id){
		$table2 = $this->getMainTable();
		$cond = $this->_getWriteAdapter()->quoteInto('e.entity_id = t2.customer_id','');
		$collection->getSelect()->joinLeft(array('t2'=>$table2), $cond);
		$collection->getSelect()->group('e.entity_id');
// 		echo $collection->getSelect();
	}
}