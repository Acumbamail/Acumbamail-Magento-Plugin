<?php

class Acumbamail_Subscription_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('subscription/adminhtml_subscription'));
        $this->renderLayout();
    }

    public function saveAction() {
        $configuredAuthToken = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_auth');
        $acumbamailAuthToken = $this->getRequest()->getParam('acumbamail_auth');

        if ($configuredAuthToken != $acumbamailAuthToken) {
            Mage::getConfig()->saveConfig('acumbamail_form/acumbamail_group/acumbamail_auth', $acumbamailAuthToken, 'default', 0);
        }

        $acumbamailList = $this->getRequest()->getParam('acumbamail_list');
        if ($acumbamailList != -1 && $acumbamailList != '') {
            Mage::getConfig()->saveConfig('acumbamail_form/acumbamail_group/acumbamail_list', $acumbamailList, 'default', 0);
        }

        $acumbamailForm = $this->getRequest()->getParam('acumbamail_form');
        if ($acumbamailForm != -1 && $acumbamailForm != '') {
            Mage::getConfig()->saveConfig('acumbamail_form/acumbamail_group/acumbamail_form', $acumbamailForm, 'default', 0);
        }

        $this->_redirect('subscription/adminhtml_configuration');
    }

    public function resetAction() {
        Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_auth');
        Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_list');
        Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_form');
        
        $this->_redirect('subscription/adminhtml_configuration');
    }
}
