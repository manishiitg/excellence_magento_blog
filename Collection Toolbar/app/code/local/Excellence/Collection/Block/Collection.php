<?php
class Excellence_Collection_Block_Collection extends Mage_Core_Block_Template
{

	public function __construct()
	{
		parent::__construct();
		$collection = Mage::getModel('collection/collection')->getCollection();
		$this->setCollection($collection);
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();

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
		return array('created_time'=> 'Created Time','update_time'=>'Updated Time','collection_id'=>'ID');
	}
	public function getSortBy(){
		return 'collection_id';
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