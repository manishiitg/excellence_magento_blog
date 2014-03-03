<?php
class Excellence_Ajax_Block_Ajax extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAjax()     
     { 
        if (!$this->hasData('ajax')) {
            $this->setData('ajax', Mage::registry('ajax'));
        }
        return $this->getData('ajax');
        
    }
}