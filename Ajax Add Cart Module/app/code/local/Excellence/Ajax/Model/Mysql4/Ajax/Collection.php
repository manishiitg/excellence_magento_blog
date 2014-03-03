<?php

class Excellence_Ajax_Model_Mysql4_Ajax_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ajax/ajax');
    }
}