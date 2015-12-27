<?php

class Ecomitize_Test_Block_Adminhtml_Faqs extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    protected function _construct()
    {
        $helper            = Mage::helper('ecomitizetest');
        $this->_blockGroup = 'ecomitizetest';
        $this->_controller = 'adminhtml_faqs';

        $this->_headerText     = $helper->__('FAQ\'s Management');
        $this->_addButtonLabel = $helper->__('Add FAQ\'s');

        parent::_construct();
    }

}
