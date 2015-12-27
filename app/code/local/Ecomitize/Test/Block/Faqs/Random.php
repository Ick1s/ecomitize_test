<?php

class Ecomitize_Test_Block_Faqs_Random extends Mage_Core_Block_Template
{
    protected $_collection;

    /**
     * Retrieve status for homepage block
     * @return mixed
     */
    public function getStatus()
    {
        return  Mage::getStoreConfig('ecomitizetest/config/homepage_block');
    }
    /**
     * Check if current url is url for home page
     * @return mixed
     */
    public function getIsHomePage()
    {
        return $this->getUrl('') == $this->getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true));;
    }

    /**
     * Retrieve custom faq for homepage
     * @return mixed
     */
    public function getRandomFaq()
    {
        if (!$this->_collection) {
            $faqCollection = Mage::getModel('ecomitizetest/faqs')->getCollection();
            $faqCollection->addFieldToFilter('is_active', true)
                ->setOrder('faq_id', 'DESC');

            $this->_collection = $faqCollection->getItems();
        }
        shuffle($this->_collection);
        $firstItem = $this->_collection[0];

        return $firstItem;
    }
}