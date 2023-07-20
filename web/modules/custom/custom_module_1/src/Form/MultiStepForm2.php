<?php

/**
 * @file
 * Contains Drupal\custom_module_1\Form\CustomModuleForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MultiStepForm2 extends FormBase {
    
    public function getFormId() {
        return 'multi_step_form_2';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
       
        if($form_state->get('step') == NULL){
            $form_state->set('step',1);
        }

        $step =  $form_state->get('step');
        $form['info'] =  [
            '#markup' => "$step of 3",
        ];
        if($form_state->get('step') == 1){
           
            
            $form['isim'] = [
                '#type' => 'textfield',
                '#title' => $this->t('isim'),
                '#required' => TRUE // bu alanı zorunlu yapar
            ];
        }

        if($form_state->get('step') == 2){
            
            $form['mesaj'] =  [
                '#type' => 'textarea',
                '#title' => $this->t('mesaj'),
                '#required' => TRUE // bu alanı zorunlu yapar
            ];
        }

        if($form_state->get('step') == 3){
            $ad = $form_state->get('isim');
            $mesaj = $form_state->getValue('mesaj');
            $form['info'] =  [
                '#markup' => "İsminiz: <br> $ad <br> Mesajınız: <br> $mesaj",
            ];
        }
    

        $form['submit'] =  [
            '#type' => 'submit',
            '#value' => $this->t('next'),
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

    if($form_state->get('step') == 1){
        $form_state->set('isim', $form_state->getValue('isim'));
    }
      $step =  $form_state->get('step') + 1;
            $form_state->set('step', $step);
            $form_state->setRebuild();
    }
}