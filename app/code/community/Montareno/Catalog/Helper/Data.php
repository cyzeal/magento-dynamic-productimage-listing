<?php
class Montareno_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{
	const ATTRIBUTE_LABEL = 'Product Listing Preview Child';
	const ATTRIBUTE_CODE = 'available_simple_id';
	protected $_productTypes = array();
	
	public function __construct(){
		$this->_productTypes = array(
			Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE,
			Mage_Catalog_Model_Product_Type::TYPE_BUNDLE
		);	
	}
	
	public function getAttributeCode(){
		return self::ATTRIBUTE_CODE;	
	}
	public function getProductTypes(){
		return implode(',',$this->_productTypes);	
	}
	public function getProductTypeArray(){
		return $this->_productTypes;	
	}
	public function getAttributeLabel(){
		return self::ATTRIBUTE_LABEL;	
	}
} 