<?php

class Excellence_File_Model_Mysql4_File_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('file/file');
    }
}