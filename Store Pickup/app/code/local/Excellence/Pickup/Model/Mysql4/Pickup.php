<?php

class Excellence_Pickup_Model_Mysql4_Pickup extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pickup_id refers to the key field in your database table.
        $this->_init('pickup/pickup', 'id');
    }
}