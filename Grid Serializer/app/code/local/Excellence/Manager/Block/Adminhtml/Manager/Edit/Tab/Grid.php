<?php
class Excellence_Manager_Block_Adminhtml_Manager_Edit_Tab_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('customerGrid');
		$this->setUseAjax(true); // Using ajax grid is important
		$this->setDefaultSort('entity_id');
		$this->setDefaultFilter(array('in_products'=>1)); // By default we have added a filter for the rows, that in_products value to be 1
		$this->setSaveParametersInSession(false);  //Dont save paramters in session or else it creates problems
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('customer/customer_collection')
		//		->addNameToSelect()
		//		->addAttributeToSelect('email')
		//		->addAttributeToSelect('created_at')
		//		->addAttributeToSelect('group_id')
		//		->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
		//		->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
		//		->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
		//		->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
		//		->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left')
		;


		$tm_id = $this->getRequest()->getParam('id');
		if(!isset($tm_id)) {
			$tm_id = 0;
		}
		Mage::getResourceModel('manager/grid')->addGridPosition($collection,$tm_id);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _addColumnFilterToCollection($column)
	{
		// Set custom filter for in product flag
		if ($column->getId() == 'in_products') {
			$ids = $this->_getSelectedCustomers();
			if (empty($ids)) {
				$ids = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$ids));
			} else {
				if($productIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$ids));
				}
			}
		} else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}

	protected function _prepareColumns()
	{

		    $this->addColumn('in_products', array(
                'header_css_class'  => 'a-center',
                'type'              => 'checkbox',
                'name'              => 'customer',
                'values'            => $this->_getSelectedCustomers(),
                'align'             => 'center',
                'index'             => 'entity_id'
            ));
            $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
            ));
            $this->addColumn('name', array(
            'header'    => Mage::helper('customer')->__('Name'),
            'index'     => 'name'
            ));
            $this->addColumn('email', array(
            'header'    => Mage::helper('customer')->__('Email'),
            'width'     => '150',
            'index'     => 'email'
            ));

            $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();

            $this->addColumn('group', array(
            'header'    =>  Mage::helper('customer')->__('Group'),
            'width'     =>  '100',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
            ));

            $this->addColumn('Telephone', array(
            'header'    => Mage::helper('customer')->__('Telephone'),
            'width'     => '100',
            'index'     => 'billing_telephone'
            ));

            $this->addColumn('billing_postcode', array(
            'header'    => Mage::helper('customer')->__('ZIP'),
            'width'     => '90',
            'index'     => 'billing_postcode',
            ));

            $this->addColumn('billing_country_id', array(
            'header'    => Mage::helper('customer')->__('Country'),
            'width'     => '100',
            'type'      => 'country',
            'index'     => 'billing_country_id',
            ));

            $this->addColumn('billing_region', array(
            'header'    => Mage::helper('customer')->__('State/Province'),
            'width'     => '100',
            'index'     => 'billing_region',
            ));

            $this->addColumn('customer_since', array(
            'header'    => Mage::helper('customer')->__('Customer Since'),
            'type'      => 'datetime',
            'align'     => 'center',
            'index'     => 'created_at',
            'gmtoffset' => true
            ));

            $this->addColumn('position', array(
            'header'            => Mage::helper('catalog')->__('Position'),
            'name'              => 'position',
            'width'             => 60,
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'editable'          => true,
            'edit_only'         => true
            ));

            return parent::_prepareColumns();
	}

	protected function _getSelectedCustomers()   // Used in grid to return selected customers values.
	{
		$customers = array_keys($this->getSelectedCustomers());
		return $customers;
	}

	public function getGridUrl()
	{
		return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/customergrid', array('_current'=>true));
	}
	public function getSelectedCustomers()
	{
		// Customer Data
		$tm_id = $this->getRequest()->getParam('id');
		if(!isset($tm_id)) {
			$tm_id = 0;
		}
		$collection = Mage::getModel('manager/grid')->getCollection();
		$collection->addFieldToFilter('manager_id',$tm_id);
		$custIds = array();
		foreach($collection as $obj){
			$custIds[$obj->getCustomerId()] = array('position'=>$obj->getPosition());
		}
		return $custIds;
	}


}