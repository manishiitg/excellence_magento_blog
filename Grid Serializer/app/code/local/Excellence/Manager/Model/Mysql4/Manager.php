<?php

class Excellence_Manager_Model_Mysql4_Manager extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the manager_id refers to the key field in your database table.
        $this->_init('manager/manager', 'manager_id');
    }
}