<?php

namespace Drupal\custom_module_1\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block_changed",
 *   admin_label = @Translation("Hello block plug"),
 *   category = @Translation("Hello World"),
 * )
 */
class CustomPlugin extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);
    $ad = $currentUser->field_user_name->value;
    $surname = $currentUser->field_user_surname->value;

    return [
        '#theme' => 'my_template',
        '#ad' => $ad,
        '#soyad' => $surname,
    ];
  }

}