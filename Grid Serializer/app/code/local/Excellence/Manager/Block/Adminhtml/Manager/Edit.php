<?php

class Excellence_Manager_Block_Adminhtml_Manager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'manager';
        $this->_controller = 'adminhtml_manager';
        
        $this->_updateButton('save', 'label', Mage::helper('manager')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('manager')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('manager_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'manager_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'manager_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('manager_data') && Mage::registry('manager_data')->getId() ) {
            return Mage::helper('manager')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('manager_data')->getTitle()));
        } else {
            return Mage::helper('manager')->__('Add Item');
        }
    }
}