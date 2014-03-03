<?php

class Excellence_Collection_Model_Mysql4_Collection extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the collection_id refers to the key field in your database table.
        $this->_init('collection/collection', 'collection_id');
    }
}