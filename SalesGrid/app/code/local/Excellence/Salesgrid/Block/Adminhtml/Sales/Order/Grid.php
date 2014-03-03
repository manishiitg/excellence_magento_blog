<?php
class Excellence_Salesgrid_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{


	protected function _addColumnFilterToCollection($column)
	{
		if ($this->getCollection()) {
			if ($column->getId() == 'shipping_telephone') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.telephone';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_city') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.city';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_region') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.region';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_postcode') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.post';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if($column->getId() == 'product_count'){
				$cond = $column->getFilter()->getCondition();
				$field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
				$this->getCollection()->getSelect()->having($this->getCollection()->getResource()->getReadConnection()->prepareSqlCondition($field, $cond));
				return $this;
			}else if($column->getId() == 'skus'){
				$cond = $column->getFilter()->getCondition();
				$field = 't6.sku';
				$this->getCollection()->joinSkus();
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else{
				return parent::_addColumnFilterToCollection($column);
			}
		}
	}

	protected function _prepareColumns()
	{
		$this->addColumnAfter('shipping_description', array(
				'header' => Mage::helper('sales')->__('Shipping Method'),
				'index' => 'shipping_description',
		),'shipping_name'
		);
		$this->addColumnAfter('method', array(
				'header' => Mage::helper('sales')->__('Payment Method'),
				'index' => 'method',
				'type'  => 'options',
				'options' => Mage::helper('payment')->getPaymentMethodList()
		),'shipping_description');

		$this->addColumnAfter('shipping_city', array(
				'header' => Mage::helper('sales')->__('Shipping City'),
				'index' => 'shipping_city',
		),'method');

		$this->addColumnAfter('shipping_telephone', array(
				'header' => Mage::helper('sales')->__('Shipping Telephone'),
				'index' => 'shipping_telephone',
		),'method');

		$this->addColumnAfter('shipping_region', array(
				'header' => Mage::helper('sales')->__('Shipping Region'),
				'index' => 'shipping_region',
		),'method');

		$this->addColumnAfter('shipping_postcode', array(
				'header' => Mage::helper('sales')->__('Shipping Postcode'),
				'index' => 'shipping_postcode',
		),'method');

		$this->addColumnAfter('product_count', array(
				'header' => Mage::helper('sales')->__('Product Count'),
				'index' => 'product_count',
				'type' => 'number'
		),'increment_id');

		$this->addColumnAfter('skus', array(
				'header' => Mage::helper('sales')->__('Product Purchased'),
				'index' => 'skus',
		),'increment_id');

		return parent::_prepareColumns();

	}


}