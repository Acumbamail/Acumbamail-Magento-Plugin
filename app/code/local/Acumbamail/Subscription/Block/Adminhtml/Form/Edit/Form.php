<?php

require 'lib/Acumbamail/acumbamail.class.php';

class Acumbamail_Subscription_Block_Adminhtml_Form_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
	    'id' => 'edit_form',
	    'action' => $this->getUrl('*/*/save'),
	    'method' => 'post',
	    'enctype' => 'multipart/form-data'
	)
	);

        $api = new AcumbamailAPI(0, Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_auth'));

        $form->setUseContainer(true);
        $this->setForm($form);
        $this->prepareFormFields($form, $api);

        return parent::_prepareForm();
    }

    private function prepareFormFields($form, $api) {
        $helper = Mage::helper('subscription');
        $fieldset = $form->addFieldset('form_form', array('legend'=>$helper->__('Auth Token')));
        $this->prepareAuthTokenField($fieldset, $api);
        $this->prepareListSelectionField($fieldset, $api);
        $this->prepareFormSelectionField($fieldset, $api);
    }

    private function prepareAuthTokenField($fieldset, $api) {
        $helper = Mage::helper('subscription');
        $auth_token = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_auth');
        $fieldset->addField('acumbamail_auth', 'text', array(
	    'label' => $helper->__('Auth Token'),
	    'class' => 'required-entry',
	    'required' => false,
	    'name' => 'acumbamail_auth',
	    'value' => $auth_token,
	));
    }

    private function prepareListSelectionField($fieldset, $api) {
        $helper = Mage::helper('subscription');
        $auth_token = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_auth');
        $acumbamail_list = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_list');

        if ($auth_token != '') {
            $lists = $api->getLists();
            if ($lists != '' or count($lists)) {
                $select_values = array(-1 => '-- Seleccione lista --');
                $selected_value = -1;

                foreach ($lists as $key => $list) {
      	            $select_values[$key] = $list['name'];
	            if ($acumbamail_list == $key) {
	                $selected_value = $acumbamail_list;
	            }
                }

                $fieldset->addField('select_list', 'select', array(
		    'label' => $helper->__('Lista'),
		    'class' => 'required-entry',
		    'required' => false,
		    'name' => 'acumbamail_list',
		    'readonly' => false,
		    'value' => $selected_value,
		    'values' => $select_values,
	        ));
            }
            else {
                $fieldset->addField('note_list', 'note', array(
                    'text' => $helper->__('Su usuario no posee ninguna lista o el auth token introducido no es válido'),
                ));
                Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_list');
                Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_form');
            }
        }
    }

    private function prepareFormSelectionField($fieldset, $api) {
        $helper = Mage::helper('subscription');
        $acumbamail_list = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_list');
        $acumbamail_form = Mage::getStoreConfig('acumbamail_form/acumbamail_group/acumbamail_form');

        if ($acumbamail_list != '' && $acumbamail_list != -1) {
            $forms = $api->getForms($acumbamail_list);
            Mage::log("Formularios: " . $forms);
            if (count($forms)) {
                $select_values = array(-1 => '-- Seleccione Formulario --');
                $selected_value = -1;

                foreach ($forms as $key => $form) {
      	            $select_values[$key] = $form['name'];
      	            if ($acumbamail_form == $key) {
      	                $selected_value = $acumbamail_form;
      	            }
                }

                $fieldset->addField('select_form', 'select', array(
      		    'label' => $helper->__('Formulario'),
      		    'class' => 'required-entry',
      		    'required' => false,
      		    'name' => 'acumbamail_form',
      		    'readonly' => false,
      		    'value' => $selected_value,
      		    'values' => $select_values,
      	        ));

            }
            else {
                $fieldset->addField('note_form', 'note', array(
                    'text' => $helper->__('La lista seleccionada no posee ningún formulario'),
                ));
                Mage::getConfig()->deleteConfig('acumbamail_form/acumbamail_group/acumbamail_form');
            }
        }
    }
}
