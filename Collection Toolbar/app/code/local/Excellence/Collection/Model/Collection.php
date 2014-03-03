<?php

class Excellence_Collection_Model_Collection extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('collection/collection');
    }
}