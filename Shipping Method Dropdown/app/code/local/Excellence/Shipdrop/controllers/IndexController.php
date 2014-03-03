<?php
class Excellence_Shipdrop_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/shipdrop?id=15 
    	 *  or
    	 * http://site.com/shipdrop/id/15 	
    	 */
    	/* 
		$shipdrop_id = $this->getRequest()->getParam('id');

  		if($shipdrop_id != null && $shipdrop_id != '')	{
			$shipdrop = Mage::getModel('shipdrop/shipdrop')->load($shipdrop_id)->getData();
		} else {
			$shipdrop = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($shipdrop == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$shipdropTable = $resource->getTableName('shipdrop');
			
			$select = $read->select()
			   ->from($shipdropTable,array('shipdrop_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$shipdrop = $read->fetchRow($select);
		}
		Mage::register('shipdrop', $shipdrop);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}