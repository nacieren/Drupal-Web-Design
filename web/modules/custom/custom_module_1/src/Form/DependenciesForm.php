<?php

/**
 * @file
 * Contains Drupal\custom_module_1\Form\CustomModuleForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DependenciesForm extends FormBase {
    
    public function getFormId() {
        return 'custom_module_1_dependencies_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['#prefix'] = '<div id="ajax_form_multistep_form">';
        $form['#suffix'] = '</div>';

        $form['proje_tipi'] = array(
            '#title' => t('Proje Tipi'),
            '#type' => 'select',
            '#description' => 'Select the desired pizza crust size.',
            '#options' => array(
                 0 => t('--- SELECT ---'),
                'APPLICATION' => t('Application'),
                'DEVELOPMENT' => t('Development'),
                'ENHANCEMENT' => t('Enhancement')
            ),
            '#ajax' => array(
                // We pass in the wrapper we created at the start of the form
                'wrapper' => 'ajax_form_multistep_form',
                // We pass a callback function we will use later to render the form for the user
                'callback' => '::ajax_form_multistep_form_ajax_callback',
                'event' => 'change',

              )
          );
        
          

          $form['proje_suresi'] = array(
            '#title' => t('Proje Süresi'),
            '#type' => 'select',
            '#description' => 'Select the desired pizza crust size.',
            '#options' => array(
            ),
            '#states' => [
                // Show this textfield only if the radio 'other' is selected above.
                'visible' => [
                  // Don't mistake :input for the type of field or for a css selector --
                  // it's a jQuery selector. 
                  // You can always use :input or any other jQuery selector here, no matter 
                  // whether your source is a select, radio or checkbox element.
                  // in case of radio buttons we can select them by thier name instead of id.
                  ':input[name="proje_tipi"]' => ['!value' => 0],
                ],
              ],
          );

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

    public function ajax_form_multistep_form_ajax_callback(array &$form, FormStateInterface $form_state) {
        \Drupal::logger('my_module')->error(print_r($form_state->getValue("proje_tipi"),true));
        $proje_tipi=$form_state->getValue("proje_tipi");
        if($proje_tipi=="APPLICATION"){
            $options=array(
                '3ay',
                '6ay',
                '9ay',
                '12ay'
            );   
        }
        elseif($proje_tipi=="DEVELOPMENT"){
            $options=array(
                '1hafta',
                '2hafta',
                '3hafta',
                '4hafta'
            );
        }
        else{
            $options=array(
                '1yıl',
                '2yıl',
                '3yıl',
                '4yıl'
            );
        }
        $form['proje_suresi']["#options"] = $options;
        return $form;
      }
}