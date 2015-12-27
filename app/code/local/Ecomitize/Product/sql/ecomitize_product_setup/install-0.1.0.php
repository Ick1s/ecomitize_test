<?php
$installer = $this;
/* @var $installer Mage_Eav_Model_Entity_Setup */

$installer->startSetup();

$data = array(
    'attribute_set' => 'Default',
    'group'         => 'General',
    'label'         => 'Custom Attribute',
    'visible'       => true,
    'type'          => 'text',
    'input'         => 'textarea',
    'system'        => true,
    'required'      => false,
    'user_defined'  => 1, //defaults to false; if true, define a group
);

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'custom_attribute', $data);
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'custom_attribute', 'is_wysiwyg_enabled', 1);

$installer->endSetup();