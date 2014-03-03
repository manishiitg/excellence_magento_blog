<?php

class Excellence_Pickup_Model_Mysql4_Pickup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pickup/pickup');
    }
}