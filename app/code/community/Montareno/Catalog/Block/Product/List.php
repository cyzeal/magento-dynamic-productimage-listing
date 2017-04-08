<?php 
class Montareno_Catalog_Block_Product_List extends Mage_Catalog_Block_Product_List {
	
	protected $_simplePreviewAttributeCode;
	public function __construct(){
		$this->_attributeCode = Mage::helper('montareno_catalog')->getAttributeCode();	
	}
	public function getImageSrc(Mage_Catalog_Model_Product $_product, $imageSize=135){
		
		$imageFile = NULL;
		if(	in_array($_product->getTypeId(), $this->_helper->getProductTypeArray()) 
			&& ( $simpleProductId = $_product->getData($this->_simplePreviewAttributeCode) )
		){
			$imageFile = Mage::getResourceSingleton('catalog/product')->getAttributeRawValue($simpleProductId, 'small_image', Mage::app()->getStore());
		}
		// Wlll return default value if $imageFile is null
		return $this->helper('catalog/image')->init($_product, 'small_image', $imageFile)->resize($imageSize);
		
	}
	
}
?>