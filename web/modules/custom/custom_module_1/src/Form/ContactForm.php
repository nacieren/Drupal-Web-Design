<?php

/**
 * @file
 * Contains Drupal\custom_module_1\Form\CustomModuleForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactForm extends FormBase {
    
    public function getFormId() {
        return 'custom_module_1_config_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['isim'] = [
            '#type' => 'textfield',
            '#title' => $this->t('isim'),
            '#required' => TRUE // bu alanı zorunlu yapar
        ];

        $form['mesaj'] =  [
            '#type' => 'textarea',
            '#title' => $this->t('mesaj'),
            '#required' => TRUE // bu alanı zorunlu yapar
        ];

        $form['submit'] =  [
            '#type' => 'submit',
            '#value' => $this->t('submit'),
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $isim = $form_state->getValue('isim');
        if ($isim == 'murat'){
            $form_state->setErrorByName('isim', $this->t('isminiz murat olamaz.'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->messenger()->addStatus($this->t('Message sent.'));
    }
}