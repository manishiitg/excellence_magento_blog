<?php

class Excellence_Ajax_Model_Mysql4_Ajax extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ajax_id refers to the key field in your database table.
        $this->_init('ajax/ajax', 'ajax_id');
    }
}