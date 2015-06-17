<?php
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer->startSetup();

$fieldList = array(
    'price',
    'special_price',
    'special_from_date',
    'special_to_date',
    'minimal_price',
    'cost',
    'tier_price',
    'weight',
    'tax_class_id',
    'group_price',
    'manufacturer',
    'country_of_manufacture',
    'msrp_enabled',
    'msrp_display_actual_price_type',
    'msrp'
);

// make these attributes applicable to downloadable products
foreach ($fieldList as $field) {
    $applyTo = split(',', $installer->getAttribute('catalog_product', $field, 'apply_to'));
    if (!in_array('excellence', $applyTo)) {
        $applyTo[] = 'excellence';
        $installer->updateAttribute('catalog_product', $field, 'apply_to', join(',', $applyTo));
    }
}

$installer->endSetup();
