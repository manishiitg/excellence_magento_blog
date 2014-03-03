<?php

class Excellence_Manager_Model_Manager extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('manager/manager');
    }
}