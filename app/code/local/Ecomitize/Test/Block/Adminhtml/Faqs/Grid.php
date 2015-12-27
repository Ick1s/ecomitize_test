<?php

class Ecomitize_Test_Block_Adminhtml_Faqs_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Ecomitize_Test_Block_Adminhtml_Faqs_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faqsGrid');
        $this->setDefaultSort('faq_id');
        $this->setDefaultDir('ASC');
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ecomitizetest/faqs')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('faq_id', array(
            'header' => Mage::helper('cms')->__('FAQ\'s Id'),
            'align'  => 'center',
            'index'  => 'faq_id',
            'width'  => '30',
        ));

        $this->addColumn('question', array(
            'header' => Mage::helper('cms')->__('Questions'),
            'index'  => 'question',
        ));

        $this->addColumn('answer', array(
            'header' => Mage::helper('cms')->__('Answers'),
            'index'  => 'answer',
        ));

        $this->addColumn('is_active', array(
            'header'  => Mage::helper('cms')->__('Status'),
            'index'   => 'is_active',
            'type'    => 'options',
            'width'   => '100',
            'align'   => 'center',
            'options' => array(
                2 => Mage::helper('cms')->__('Disabled'),
                1 => Mage::helper('cms')->__('Enabled'),
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('faq_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('faq_id');
        $this->getMassactionBlock()->setFormFieldName('faqs');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => $this->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('cms')->__('Are you sure?'),
        ));

        $statuses = Mage::getSingleton('ecomitizetest/faqs')->getAvailableStatuses();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'      => Mage::helper('cms')->__('Change status'),
            'url'        => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name'   => 'is_active',
                    'type'   => 'select',
                    'class'  => 'required-entry',
                    'label'  => Mage::helper('cms')->__('Status'),
                    'values' => $statuses,
                ),
            ),
        ));

        return $this;
    }

}