<?php

class Ecomitize_Test_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Parse html from wysiwyg editor
     * @param $html
     * @return string
     */
    public function filterHtml($html)
    {
        $helper    = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();

        return $processor->filter($html);
    }
}