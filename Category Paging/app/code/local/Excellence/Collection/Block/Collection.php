<?php
class Excellence_Collection_Block_Collection extends Mage_Core_Block_Template
{

	public function __construct()
	{
		parent::__construct();
		$parent_id = Mage::app()->getStore()->getRootCategoryId();
		if($this->getRequest()->getParam('category_id',false)){
			$parent_id = $this->getRequest()->getParam('category_id');
		}
		$collection = Mage::getModel('catalog/category')->getCollection();
		$collection->addFieldToFilter('parent_id',$parent_id);
		$collection->addIsActiveFilter();
		$collection->addNameToResult();
		$collection->addUrlRewriteToResult();
		//$collection->setLoadProductCount(true);
		$this->setCollection($collection);
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$parent_id = Mage::app()->getStore()->getRootCategoryId();
		if($this->getRequest()->getParam('category_id',false)){
			$parent_id = $this->getRequest()->getParam('category_id');
		}
		$category = Mage::getModel('catalog/category')->load($parent_id);

		if ($headBlock = $this->getLayout()->getBlock('head')) {
			if ($title = $category->getMetaTitle()) {
				$headBlock->setTitle($title);
			}
			if ($description = $category->getMetaDescription()) {
				$headBlock->setDescription($description);
			}
			if ($keywords = $category->getMetaKeywords()) {
				$headBlock->setKeywords($keywords);
			}
		}
		$this->setTitle($category->getName());


		$toolbar = $this->getToolbarBlock();

		// called prepare sortable parameters
		$collection = $this->getCollection();

		// use sortable parameters
		if ($orders = $this->getAvailableOrders()) {
			$toolbar->setAvailableOrders($orders);
		}
		if ($sort = $this->getSortBy()) {
			$toolbar->setDefaultOrder($sort);
		}
		if ($dir = $this->getDefaultDirection()) {
			$toolbar->setDefaultDirection($dir);
		}
		$toolbar->setCollection($collection);

		$this->setChild('toolbar', $toolbar);
		$this->getCollection()->load();
		return $this;
	}
	public function getDefaultDirection(){
		return 'asc';
	}
	public function getAvailableOrders(){
		return array('name'=> 'Name','position'=>'Position','children_count'=>'Sub Category Count');
	}
	public function getSortBy(){
		return 'name';
	}
	public function getToolbarBlock()
	{
		$block = $this->getLayout()->createBlock('collection/toolbar', microtime());
		return $block;
	}
	public function getMode()
	{
		return $this->getChild('toolbar')->getCurrentMode();
	}

	public function getToolbarHtml()
	{
		return $this->getChildHtml('toolbar');
	}
}