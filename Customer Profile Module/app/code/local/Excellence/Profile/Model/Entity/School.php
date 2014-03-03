<?php
class Excellence_Profile_Model_Entity_School extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	public function getAllOptions()
	{
		if ($this->_options === null) {
			$this->_options = array();
			$this->_options[] = array(
                    'value' => '',
                    'label' => 'Choose Option..'
			);
			$this->_options[] = array(
                    'value' => 1,
                    'label' => 'School1'
			);
			$this->_options[] = array(
                    'value' => 2,
                    'label' => 'School2'
			);
			$this->_options[] = array(
                    'value' => 3,
                    'label' => 'School3'
			);
			
		}

		return $this->_options;
	}
}