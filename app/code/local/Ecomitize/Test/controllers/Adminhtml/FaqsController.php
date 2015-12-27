<?php

class  Ecomitize_Test_Adminhtml_FaqsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return $this
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('econitizetest/faqs')
            ->_addBreadcrumb(Mage::helper('cms')->__('Ecomitize'), Mage::helper('cms')->__('Ecomitize'))
            ->_addBreadcrumb(Mage::helper('cms')->__('FAQ\'s'), Mage::helper('cms')->__('FAQ\'s'));

        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Ecomitize'))->_title($this->__('FAQ\'s'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new FAQ
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit FAQ's
     */
    public function editAction()
    {
        $this->_title($this->__('Ecomitize'))->_title($this->__('FAQ\'s'));

        // 1. Get ID and create model
        $faqId = $this->getRequest()->getParam('faq_id');
        $model = Mage::getModel('ecomitizetest/faqs');

        // 2. Initial checking
        if ($faqId) {
            $model->load($faqId);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This FAQ no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getQuestion() : $this->__('New FAQ'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('current_faq', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($faqId ? Mage::helper('cms')->__('Edit FAQ') : Mage::helper('cms')->__('New FAQ'), $faqId ? Mage::helper('cms')->__('Edit FAQ') : Mage::helper('cms')->__('New FAQ'))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $faqId = $this->getRequest()->getParam('faq_id');
            $model = Mage::getModel('ecomitizetest/faqs')->load($faqId);
            if (!$model->getFaqId() && $faqId) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('This FAQ no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }

            // init model and set data

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('The FAQ has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('faq_id' => $model->getId()));

                    return;
                }
                // go to grid
                $this->_redirect('*/*/');

                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('faq_id' => $this->getRequest()->getParam('faq_id')));

                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($faqId = $this->getRequest()->getParam('faq_id')) {
            try {
                // init model and delete
                $model = Mage::getModel('ecomitizetest/faqs');
                $model->load($faqId);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('The FAQ has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');

                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('faq_id' => $faqId));

                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Unable to find a FAQ to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Massaction for changing status of selected FAQ's
     *
     */
    public function massStatusAction()
    {
        $faqIds = $this->getRequest()->getParam('faqs');
        if (!is_array($faqIds)) {
            // No faqs selected
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select FAQ\'s.'));
        } else {
            try {
                foreach ($faqIds as $faqId) {
                    $faq = Mage::getModel('ecomitizetest/faqs')
                        ->load($faqId)
                        ->setIsActive($this->getRequest()->getParam('is_active'));
                    $faq->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('Total of %d record(s) have been updated.', count($faqIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $ret = $this->getRequest()->getParam('ret') ? $this->getRequest()->getParam('ret') : 'index';
        $this->_redirect('*/*/' . $ret);
    }

    /**
     * Massaction for removing FAQ's
     *
     */
    public function massDeleteAction()
    {
        $faqIds = $this->getRequest()->getParam('faqs');
        if (!is_array($faqIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select FAQ\'s.'));
        } else {
            try {
                foreach ($faqIds as $faqId) {
                    $faq = Mage::getModel('ecomitizetest/faqs')->load($faqId);
                    $faq->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('Total of %d record(s) have been deleted.', count($faqIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/' . $this->getRequest()->getParam('ret', 'index'));
    }
}