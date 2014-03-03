<?php
class Excellence_Custom_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/custom?id=15 
    	 *  or
    	 * http://site.com/custom/id/15 	
    	 */
    	/* 
		$custom_id = $this->getRequest()->getParam('id');

  		if($custom_id != null && $custom_id != '')	{
			$custom = Mage::getModel('custom/custom')->load($custom_id)->getData();
		} else {
			$custom = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($custom == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$customTable = $resource->getTableName('custom');
			
			$select = $read->select()
			   ->from($customTable,array('custom_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$custom = $read->fetchRow($select);
		}
		Mage::register('custom', $custom);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}