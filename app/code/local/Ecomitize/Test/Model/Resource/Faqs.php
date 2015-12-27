<?php

class Ecomitize_Test_Model_Resource_Faqs extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ecomitizetest/faqs_table', 'faq_id');
    }

}