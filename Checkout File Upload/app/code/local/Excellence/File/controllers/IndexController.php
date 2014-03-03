<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Excellence_File_IndexController extends Mage_Checkout_OnepageController
{
	public function uploadAction()
	{
		Mage::log($_FILES);
			

		if ($data = $this->getRequest()->getPost()) {
				
			$type = 'file';
			if(isset($_FILES[$type]['name']) && $_FILES[$type]['name'] != '') {
				try {
					$uploader = new Varien_File_Uploader($type);
					//$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					$path = Mage::getBaseDir('media') . DS . 'uploads' . DS;
					$uploader->save($path, $_FILES[$type]['name'] );
					$filename = $uploader->getUploadedFileName();
						
				} catch (Exception $e) {
				}

			}
			echo $filename;
		}
	}
}