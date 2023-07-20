<?php

namespace Drupal\custom_module_1\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;

class ExampleController extends ControllerBase {
  public function example() {
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);
    $ad = $currentUser->field_user_name->value;
    $surname = $currentUser->field_user_surname->value;

    return [
      '#type' => 'markup',
      '#markup' => '<div id="custom-id">' . $this->t('Hoşgeldin @ad @soyad', ['@ad' => $ad, '@soyad' => $surname]) . '</div>',
      '#attached' => [
        'library' => [
          'custom_module_1/my-css',
        ],
      ],
    ];
  }

  public function access(){
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);
    $departmans = $currentUser->field_user_department->getValue();
    foreach ($departmans as $key => $value) {
      if ($value["target_id"] == 5 ) {
        return AccessResult::allowed();
      }
    }
    return AccessResult::forbidden();
  }

  public function access2(){
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);

   // $departmans = $currentUser->field_user_department->getValue();
   // foreach ($departmans as $key => $value) {
    //  $taxonomy = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($value["target_id"]);
    //  dd($taxonomy);
    //  if ($value["target_id"] == 5 ) {
    //    return AccessResult::allowed();
    //  }
    //}

    $department = $currentUser->get('field_user_department')->referencedEntities();
    return AccessResult::forbidden();
  }



    public function access3(){
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);
    
   // $departmans = $currentUser->field_user_department->getValue();
   // foreach ($departmans as $key => $value) {
    //  $taxonomy = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($value["target_id"]);
    //  dd($taxonomy);
    //  if ($value["target_id"] == 5 ) {
    //    return AccessResult::allowed();
    //  }
    //}

    $department = $currentUser->get('field_user_department')->referencedEntities();
    foreach ($department as $key => $value) {
      $basvurular_acik = $value->field_basvurular_acik->value;
        if ($basvurular_acik  ) {
          return AccessResult::allowed();
      }
  }
  return AccessResult::forbidden();
    }

    public function access4($uid){
      $user = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
    
       $staus= $user->status->value;

       if($staus && \Drupal::currentUser()->isAnonymous()==false){
        return AccessResult::allowed();
       }
       else{
        return AccessResult::forbidden();
       }

  
    }
}