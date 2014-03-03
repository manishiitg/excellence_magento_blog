<?php
class Excellence_Test_Block_Test extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getTest()     
     { 
        if (!$this->hasData('test')) {
            $this->setData('test', Mage::registry('test'));
        }
        return $this->getData('test');
        
    }
}