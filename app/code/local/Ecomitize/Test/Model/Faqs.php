<?php

class Ecomitize_Test_Model_Faqs extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 2;

    protected function _construct()
    {
        $this->_init('ecomitizetest/faqs');
    }

    /**
     * Statuses for FAQ's
     * @return mixed
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED  => Mage::helper('cms')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('cms')->__('Disabled'),
        ));

        return $statuses->getData();
    }

}