<?php
class Excellence_Manager_Block_Adminhtml_Manager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_manager';
    $this->_blockGroup = 'manager';
    $this->_headerText = Mage::helper('manager')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('manager')->__('Add Item');
    parent::__construct();
  }
}