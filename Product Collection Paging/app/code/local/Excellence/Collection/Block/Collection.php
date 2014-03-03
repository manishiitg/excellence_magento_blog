<?php
class Excellence_Collection_Block_Collection extends Mage_Catalog_Block_Product_List
{

	protected function _getProductCollection()
	{
		if (is_null($this->_productCollection)) {
			$collection = Mage::getModel('catalog/product')->getCollection();
			$collection
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents();

			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			$this->_productCollection = $collection;

		}
		return $this->_productCollection;
	}
}