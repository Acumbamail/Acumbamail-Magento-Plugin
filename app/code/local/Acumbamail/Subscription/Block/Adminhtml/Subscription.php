<?php
class Acumbamail_Subscription_Block_Adminhtml_Subscription extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->objectId = 'acumbamail_form';
        $this->_blockGroup = 'subscription';
        $this->_controller = 'adminhtml_form';

        $resetUrl = $this->getResetUrl();
        $this->_updateButton('reset', 'onclick', "setLocation('".$resetUrl."')");
    }

    public function getResetUrl()
    {
        return $this->getUrl('*/*/reset', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }
    
    public function getHeaderText()
    {
        return Mage::helper('subscription')->__('Módulo Subscripciones a Acumbamail');
    }
}
