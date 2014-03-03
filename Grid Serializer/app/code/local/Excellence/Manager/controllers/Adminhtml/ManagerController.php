<?php

class Excellence_Manager_Adminhtml_ManagerController extends Mage_Adminhtml_Controller_action
{

	public function customerAction(){
		$this->loadLayout();
		$this->getLayout()->getBlock('customer.grid')
		->setCustomers($this->getRequest()->getPost('customers', null));
		$this->renderLayout();
	}
	public function customergridAction(){
		$this->loadLayout();
		$this->getLayout()->getBlock('customer.grid')
		->setCustomers($this->getRequest()->getPost('customers', null));
		$this->renderLayout();
	}


	protected function _initAction() {
		$this->loadLayout()
		->_setActiveMenu('manager/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
		->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('manager/manager')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('manager_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('manager/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('manager/adminhtml_manager_edit'))
			->_addLeft($this->getLayout()->createBlock('manager/adminhtml_manager_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('manager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('manager/manager');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));

			try {

				$model->save();
				$manager_id = $model->getId();
				if(isset($data['links'])){
					$customers = Mage::helper('adminhtml/js')->decodeGridSerializedInput($data['links']['customers']); //Save the array to your database

					$collection = Mage::getModel('manager/grid')->getCollection();
					$collection->addFieldToFilter('manager_id',$manager_id);
					foreach($collection as $obj){
						$obj->delete();
					}
					foreach($customers as $key => $value){
						$model2 = Mage::getModel('manager/grid');
						$model2->setManagerId($manager_id);
						$model2->setCustomerId($key);
						$model2->setPosition($value['position']);
						$model2->save();
					}
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('manager')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('manager')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('manager/manager');

				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() {
		$managerIds = $this->getRequest()->getParam('manager');
		if(!is_array($managerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($managerIds as $managerId) {
					$manager = Mage::getModel('manager/manager')->load($managerId);
					$manager->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($managerIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

}