<?php

class Ecomitize_Test_Block_Widget_Faqs extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface
{
    /**
     * Produce faqs list rendered as html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html   = '';
        $helper = $this->helper('ecomitizetest');
        $faqs   = $this->getFaqs();
        if ((count($faqs) == 0)) {
            return $html;
        }

        $html .= '<div class="faq-title"><h2>' . $this->__('FAQ\'s') . '</h2></div>';
        $html .= '<div class="faq-content">';
        $html .= '<div class="faq-list">';
        $html .= '<ul>';
        foreach ($faqs as $faq) {
            $html .= '<li>';
            $html .= '<div class="question">' . $faq->getQuestion() . '</div>';
            $html .= '<div class="answer">' . $helper->filterHtml($faq->getAnswer()) . '</div>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    public function getFaqs()
    {
        $faqsIds    = $this->getData('faqs_options');
        $ids        = explode(',', $faqsIds);
        $collection = Mage::getModel('ecomitizetest/faqs')
            ->getCollection()
            ->addFieldToFilter('faq_id', array('in' => $ids));

        return $collection;
    }
}