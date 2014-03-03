<?php

class Excellence_Manager_Block_Adminhtml_Manager_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('manager_form', array('legend'=>Mage::helper('manager')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('manager')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

     
      if ( Mage::getSingleton('adminhtml/session')->getManagerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getManagerData());
          Mage::getSingleton('adminhtml/session')->setManagerData(null);
      } elseif ( Mage::registry('manager_data') ) {
          $form->setValues(Mage::registry('manager_data')->getData());
      }
      return parent::_prepareForm();
  }
}