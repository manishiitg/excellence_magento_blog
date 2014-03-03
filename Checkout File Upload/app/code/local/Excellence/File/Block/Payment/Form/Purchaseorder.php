<?php
class Excellence_File_Block_Payment_Form_Purchaseorder extends Mage_Payment_Block_Form_Purchaseorder{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('file/payment/form/purchaseorder.phtml');
	}
}