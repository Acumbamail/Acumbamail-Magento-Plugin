<?php
class Acumbamail_Subscription_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function configurationAction()
    {
        header('Content-Type: text/plain');
        echo $config = Mage::getConfig()
                           ->loadModulesConfiguration('system.xml')
                           ->getNode()
                           ->asXML();
        exit;
    }

    public function paramsAction() {
        echo '

        ';
        foreach($this->getRequest()->getParams() as $key=>$value) {
            echo '
            Param: '.$key.'
            ';
            echo '
            Value: '.$value.'
            ';
            echo '

        ';
        }
    }
}
