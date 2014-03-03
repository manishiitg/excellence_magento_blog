<?php
class Excellence_Collection_Block_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar{
	public function getPagerHtml()
	{
		$pagerBlock = $this->getLayout()->createBlock('page/html_pager');

		if ($pagerBlock instanceof Varien_Object) {

			/* @var $pagerBlock Mage_Page_Block_Html_Pager */
			$pagerBlock->setAvailableLimit($this->getAvailableLimit());

			$pagerBlock->setUseContainer(false)
			->setShowPerPage(false)
			->setShowAmounts(false)
			->setLimitVarName($this->getLimitVarName())
			->setPageVarName($this->getPageVarName())
			->setLimit($this->getLimit())
			->setCollection($this->getCollection());
			return $pagerBlock->toHtml();
		}
		return '';
	}
}