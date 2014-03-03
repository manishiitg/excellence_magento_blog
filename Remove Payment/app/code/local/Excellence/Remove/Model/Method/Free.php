<?php
class Excellence_Remove_Model_Method_Free extends Mage_Payment_Model_Method_Free{
	public function isAvailable($quote = null)
	{
		return true;
	}
}