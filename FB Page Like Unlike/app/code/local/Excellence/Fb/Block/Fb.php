<?php
class Excellence_Fb_Block_Fb extends Mage_Core_Block_Template
{
	protected function _construct()
	{
		parent::_construct();
		$signed_request =$this->parsePageSignedRequest();// Call function

		/*The signed_request on iframe tabs has a "pages" object, which holds a "liked" variable. If the user    viewing your tab has Liked your page, it is set to TRUE. If they have not, it is set to FALSE. So:
		 */
		if($signed_request['page']['liked']){
			$this->setTemplate('fb/like.phtml');
		} else{
			$this->setTemplate('fb/unlike.phtml');
		}
	}
	public function parsePageSignedRequest() {  //The signed request is encoded for security
		$facebook = Mage::getModel('fb/api_facebook');
		$signed_request = $facebook->getSignedRequest();
		return $signed_request;
	}
}