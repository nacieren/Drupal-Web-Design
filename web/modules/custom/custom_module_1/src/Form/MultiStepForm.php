<?php
/**
 * @param array $form
 * @param FormStateInterface $form_state
 * @return array
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MultiStepForm extends FormBase {
    public function getFormId() {
        return 'custom_module_1_multistep_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
    if ($form_state->has('page') && $form_state->get('page') == 2) {
        return self::formPageTwo($form, $form_state);
    }

    $form_state->set('page', 1);

    $form['description'] = [
        '#type' => 'item',
        '#title' => $this->t('Page @page',['@page'=>$form_state->get('page')]),
    ];

    $form['first_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('First Name'),
        '#default_value' => $form_state->getValue('first_name', ''),
        '#required' => TRUE,
    ];

    $form['last_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Last Name'),
        '#default_value' => $form_state->getValue('last_name', ''),
    ];


    $form['actions'] = [
        '#type' => 'actions',
    ];

    $form['actions']['next'] = [
        '#type' => 'submit',
        '#button_type' => 'primary',
        '#value' => $this->t('Next'),
        '#submit' => ['::submitPageOne'],
        '#validate' => ['::validatePageOne'],
    ];

    return $form;

    }

    /**
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function validatePageOne(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('first_name');
    if (strlen($title) < 5) {
        $form_state->setErrorByName('first_name', $this->t('The first name must be at least 5 characters long.'));
    }
    }

    /**
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function submitPageOne(array &$form, FormStateInterface $form_state) {
    $form_state
        ->set('page_values', [
        'first_name' => $form_state->getValue('first_name'),
        'last_name' => $form_state->getValue('last_name'),
        ])
        ->set('page', 2)
        ->setRebuild(TRUE);
    }
    }