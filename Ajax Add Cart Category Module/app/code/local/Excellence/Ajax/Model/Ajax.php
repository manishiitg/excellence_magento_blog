<?php

class Excellence_Ajax_Model_Ajax extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ajax/ajax');
    }
}