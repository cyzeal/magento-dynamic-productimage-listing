<?php
/*
 * Mage_Catalog_Model_Resource_Setup
 */
$installer = $this;
$installer->startSetup();

$helper = Mage::helper('montareno_catalog');

$attributeOptions = array(
	'group' => 'Images',
	'sort_order' => 1,
	'label' => $helper->getAttributeLabel(),
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	'input' => 'text',
	'unique' => false,
	'required' => false,
	'frontend_class' => 'validate-digits',
	'apply_to' => $helper->getProductTypes(),
	'used_in_product_listing' => true
);

$installer->addAttribute(
	Mage_Catalog_Model_Product::ENTITY,
	$helper->getAttributeCode(),
	$attributeOptions
);

$installer->endSetup();