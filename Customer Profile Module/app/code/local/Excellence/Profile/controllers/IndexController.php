<?php
class Excellence_Profile_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
		$this->loadLayout();     
		$this->renderLayout();
    }
}