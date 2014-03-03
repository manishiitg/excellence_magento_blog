<?php
class Excellence_Email_Block_Email extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getEmail()     
     { 
        if (!$this->hasData('email')) {
            $this->setData('email', Mage::registry('email'));
        }
        return $this->getData('email');
        
    }
}