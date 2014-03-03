<?php
class Excellence_Custom_Model_Sales_Order extends Mage_Sales_Model_Order{
	public function hasCustomFields(){
		$var = $this->getSsn();
		if($var && !empty($var)){
			return true;
		}else{
			return false;
		}
	}
	public function getFieldHtml(){
		$var = $this->getSsn();
		$html = '<b>SSN:</b>'.$var.'<br/>';
		return $html;
	}
}