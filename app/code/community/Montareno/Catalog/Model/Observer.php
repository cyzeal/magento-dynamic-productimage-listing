<?php
class Montareno_Catalog_Model_Observer {
	
	protected $_helper;
	public function __construct(){
		$this->_helper = Mage::helper('montareno_catalog');	
	}
	
	protected function _updateParentPreviewIfNeeded($_product){
		
		// Check if product is a simple prodct and out of stock
		if($_product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE && !(int)$_product->getStockItem()->getIsInStock()){
			
			$simpleId = $_product->getId();
			$parentIds = array();
			// Get an array of simple product's parent product ID (configuranle, bundled...)
			
			foreach($this->_helper->getProductTypeArray() as $type){
				if($type == 'bundle'){
					$typeInstance = 'bundle/product_type';	
				/* Adjust this if using custom product types:
				} elseif($type == 'custom'){
					$typeInstance = 'my_custom/product_type';
				*/
				} else {
					$typeInstance = 'catalog/product_type_'.$type;
				}
				$parentIds = array_merge($parentIds, Mage::getModel($typeInstance)->getParentIdsByChild($simpleId));
			}
			
			if($parentIds){
				
				$attributeCode = $this->_helper->getAttributeCode();
				
				// Get collection of all parents that have our simple product's ID as their
				// 'Product Listing Preview Child' attribute value...
				$parentCollection = Mage::getModel('catalog/product')->getCollection()
					->addAttributeToSelect('name')
					->addFieldToFilter($attributeCode, $simpleId)
					->addFieldToFilter('entity_id', array('in' => $parentIds));
				
				foreach($parentCollection as $_parent){
					// Get the next available child product of this parent
					$simpleCollection = $_parent->getTypeInstance()->getUsedProductCollection($_parent, Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
					//Filter out all child products that are out of stock
					Mage::getSingleton('cataloginventory/stock')
   						->addInStockFilterToCollection($simpleCollection);
						
					$newSimple = $simpleCollection->getFirstItem();
					if($newSimple && $newSimple->getId()){
						// If we found any, update parent:
						$_parent->setData($attributeCode, $newSimple->getId());
						$_parent->save();	
					}
				}
				
			}	
		}
	}
	
	public function catalogInventorySave(Varien_Event_Observer $observer)
	{
		$_item = $observer->getEvent()->getItem();
		$this->_updateParentPreviewIfNeeded($_item->getProduct());
	}
	
	public function updateQuoteInventory(Varien_Event_Observer $observer)
	{
		$quote = $observer->getEvent()->getQuote();
		foreach ($quote->getAllItems() as $_item) {
			$this->_updateParentPreviewIfNeeded($_item->getProduct());			
		}
	}
	
	public function cancelOrderItem(Varien_Event_Observer $observer)
	{
		$_product = $observer->getEvent()->getItem()->getProduct();
		$this->_updateParentPreviewIfNeeded($_product);
	}
	
	public function refundOrderInventory(Varien_Event_Observer $observer)
	{
		$creditmemo = $observer->getEvent()->getCreditmemo();
		foreach ($creditmemo->getAllItems() as $_item) {
			$this->_updateParentPreviewIfNeeded($_item->getProduct());
		}
	}
}