<?php

class Ecomitize_Test_Model_Observer
{
    public function addFaqsToTopMenu($observer)
    {
        $nodeId = 'faqs-link';

        $helper   = Mage::helper('cms');
        $menu     = $observer->getMenu();
        $tree     = $menu->getTree();
        $category = $helper->__('FAQ\'s');

        $faqsData = array(
            'name'      => $category,
            'id'        => $nodeId,
            'url'       => Mage::getUrl('faqs'),
            'is_active' => Mage::app()->getRequest()->getRouteName() == 'faqs' ? true : false,
        );

        $faqNode = new Varien_Data_Tree_Node($faqsData, 'id', $tree, $menu);
        $menu->addChild($faqNode);
    }
}

?>