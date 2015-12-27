<?php

class Ecomitize_Test_Block_Adminhtml_Faqs_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('edit_form');
        $this->setTitle(Mage::helper('cms')->__('FAQ Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('current_faq');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save', array('faq_id' => $this->getRequest()->getParam('faq_id'))), 'method' => 'post')
        );

        $form->setHtmlIdPrefix('faq_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('cms')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getFaqId()) {
            $fieldset->addField('faq_id', 'hidden', array(
                'name' => 'faq_id',
            ));
        }

        $fieldset->addField('question', 'text', array(
            'name'     => 'question',
            'label'    => Mage::helper('cms')->__('Question'),
            'title'    => Mage::helper('cms')->__('Question'),
            'required' => true,
        ));

        $fieldset->addField('answer', 'editor', array(
            'name'     => 'answer',
            'label'    => Mage::helper('cms')->__('Answer'),
            'title'    => Mage::helper('cms')->__('Answer'),
            'required' => true,
            'config'   => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'    => Mage::helper('cms')->__('Status'),
            'title'    => Mage::helper('cms')->__('Status'),
            'name'     => 'is_active',
            'required' => true,
            'options'  => array(
                '1' => Mage::helper('cms')->__('Enabled'),
                '2' => Mage::helper('cms')->__('Disabled'),
            ),
        ));
        if (!$model->getFaqId()) {
            $model->setData('is_active', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
