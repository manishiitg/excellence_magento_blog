<?php
class Excellence_Shipdrop_Model_Observer {
	public function setShipping($evt){

		$controller = $evt->getControllerAction();
		
		
		
		
		if(!Mage::getSingleton('checkout/type_onepage')->getQuote()->getShippingAddress()->getCountryId()  && Mage::getSingleton('checkout/type_onepage')->getQuote()->getItemsCount()){
			$country_id = 'IN';
			$region_id = false;

			$country = Mage::getModel('directory/country')->loadByCode($country_id);
			$regions = $country->getRegions();
			if(sizeof($regions) > 0){
				$region = $regions->getFirstItem();
				$region_id = $region->getId();
			}

			
			$customerSession=Mage::getSingleton("customer/session");
			if($customerSession->isLoggedIn()){
				$customerAddress=$customerSession->getCustomer()->getDefaultShippingAddress();
				if($customerAddress->getId()){
					$customerCountry=$customerAddress->getCountryId();
					$region_id = $customerAddress->getRegionId();
					$region = $customerAddress->getRegion();
					$quote = Mage::getSingleton('checkout/type_onepage')->getQuote();
					$shipping = $quote->getShippingAddress();
					$shipping->setCountryId($customerCountry);
					if($region_id){
						$shipping->setRegionId($region_id);
					}
					if($region){
						$shipping->setRegion($region);
					}
					$quote->save();
					$controller->getResponse()->setRedirect(Mage::getUrl('*/*/*',array('_current'=>true)));
				}else{
					$quote = Mage::getSingleton('checkout/type_onepage')->getQuote();
					$shipping = $quote->getShippingAddress();
					$shipping->setCountryId($country_id);
					if($region_id){
						$shipping->setRegionId($region_id);
					}
					$quote->save();
					$controller->getResponse()->setRedirect(Mage::getUrl('*/*/*',array('_current'=>true)));
				}
			}else{
				$quote = Mage::getSingleton('checkout/type_onepage')->getQuote();
				$shipping = $quote->getShippingAddress();
				$shipping->setCountryId($country_id);
				if($region_id){
					$shipping->setRegionId($region_id);
				}
				$quote->save();
				$controller->getResponse()->setRedirect(Mage::getUrl('*/*/*',array('_current'=>true)));
			}
		}

	}
}