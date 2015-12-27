<?php

$installer = $this;
$tableFaqs = $installer->getTable('ecomitizetest/faqs_table');

$installer->startSetup();

$installer->getConnection()->dropTable($tableFaqs);
$table = $installer->getConnection()
    ->newTable($tableFaqs)
    ->addColumn('faq_id', Varien_Db_Ddl_Table::TYPE_INTEGER, NULL, array(
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ))
    ->addColumn('question', Varien_Db_Ddl_Table::TYPE_VARCHAR, '255', array(
        'nullable' => false,
    ))
    ->addColumn('answer', Varien_Db_Ddl_Table::TYPE_TEXT, NULL, array(
        'nullable' => false,
    ))
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, '6', array(
        'nullable' => false,
        'default'  => '1',
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();