<?php

require 'Acumbamail/acumbamail.class.php';

class Acumbamail_Subscription_Block_Subscription 
extends Mage_Page_Block_Html {
    
    public function testBlock() {
        Mage::log("Testing template block");
    }

    public function _toHtml() {
        $auth_token = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_auth');
        $form_id = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_form');
        $this->api = new AcumbamailAPI(0, $auth_token);
        
        $form_details = $this->api->getFormDetails($form_id);
        $html_text = "";

        if ($form_details['classic'] === 'yes') {
            $html_text .= "<div id=" . $form_details['div_id'] . "></div>";
        }

        $html_text .= '<script type="text/javascript" src="'. $form_details['js_link'].'"></script>';
        Mage::log("Html devuelto: " . $html_text);
        Mage::log("Action: " . Mage::app()->getFrontController()->getAction()->getFullActionName('-'));
        /* debug_print_backtrace();*/
        return $html_text;
    }
}
