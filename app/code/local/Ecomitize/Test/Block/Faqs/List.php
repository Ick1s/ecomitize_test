<?php

class Ecomitize_Test_Block_Faqs_List extends Mage_Core_Block_Template
{
    protected $_collection;

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('faq.pager');
    }

    /**
     * @return $this
     */
    public function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $pager  = $this->getLayout()->createBlock('page/html_pager', 'faq.pager');
        $config = Mage::getStoreConfig('ecomitizetest/config/list_per_page_values');
        if (!empty($config)) {
            $config = explode(',', $config);

            foreach ($config as $key => $limit) {
                $key              = $limit;
                $limitArray[$key] = $limit;
            }
            $pager->setAvailableLimit($limitArray);
        }

        $pager->setCollection($this->getFaqsCollection());
        $this->setChild('faq.pager', $pager);

        return $this;
    }

    /**
     * @return Ecomitize_Test_Model_Resource_Faqs_Collection
     */
    public function getFaqsCollection()
    {
        if (!$this->_collection) {
            $faqCollection = Mage::getModel('ecomitizetest/faqs')->getCollection();
            $faqCollection->addFieldToFilter('is_active', true)
                ->setOrder('faq_id', 'DESC');

            $this->_collection = $faqCollection;
        }

        return $this->_collection;
    }
}
