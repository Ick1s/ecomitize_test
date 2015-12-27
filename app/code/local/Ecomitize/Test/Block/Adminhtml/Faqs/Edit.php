<?php

class Ecomitize_Test_Block_Adminhtml_Faqs_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'faq_id';
        $this->_blockGroup = 'ecomitizetest';
        $this->_controller = 'adminhtml_faqs';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('cms')->__('Save FAQ'));
        $this->_updateButton('delete', 'label', Mage::helper('cms')->__('Delete FAQ'));

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class'   => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_faq')->getId()) {
            return Mage::helper('cms')->__("Edit FAQ '%s'", $this->escapeHtml(Mage::registry('current_faq')->getFaqId()));
        } else {
            return Mage::helper('cms')->__('New FAQ');
        }
    }
}
