<?php

class Excellence_Manager_Block_Adminhtml_Manager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('managerGrid');
      $this->setDefaultSort('manager_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('manager/manager')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('manager_id', array(
          'header'    => Mage::helper('manager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'manager_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('manager')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('manager')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('manager')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('manager')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('manager_id');
        $this->getMassactionBlock()->setFormFieldName('manager');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('manager')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('manager')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}