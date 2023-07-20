<?php

namespace Drupal\custom_module_1\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
class CustomTable extends ControllerBase {
 
    public function example() {


    $rows = [
    [Markup::create('<strong>test 1</strong>'),'test'],
    [Markup::create('<s>test 2</s>'), 'test'],
    [Markup::create('<div>test 3</div>'), 'test'],
    [Markup::create('<strong>test 1</strong>'),'test'],
    [Markup::create('<s>test 2</s>'), 'test'],
    [Markup::create('<div>test 3</div>'), 'test'],
    [Markup::create('<strong>test 1</strong>'),'test'],
    [Markup::create('<s>test 2</s>'), 'test'],
    [Markup::create('<div>test 3</div>'), 'test'],
    [Markup::create('<strong>test 1</strong>'),'test'],
    [Markup::create('<s>test 2</s>'), 'test'],
    [Markup::create('<div>test 3</div>'), 'test'],
    ];
    $header = [
    'title' => t('Title'),
    'content' => t('Content'),
    ];
    // $build['table'] = [
    // '#type' => 'table',
    // '#header' => $header,
    // '#rows' => $rows,
    // '#empty' => t('No content has been found.'),
    // '#tableselect' => TRUE,
    // ];
   
    $current_page = \Drupal::service('pager.manager')->createPager(0,50)->getCurrentPage();

    $build['page'] = [
        '#theme' => 'subscriptions',
        '#data' => $this->buildPager($rows, 10),
        '#cache' => [
          'max-age' => 0,
        ],
      ];

    $build['pager'] = [
        '#type' => 'pager',
      ];
    return $build;
  
    }
  
    private function buildPager($result, $limit = 10) {
        $total = count($result);
        // Initialize pager and gets current page.
        /* @var $pager_manager \Drupal\Core\Pager\PagerManagerInterface */
        $pager_manager = \Drupal::service('pager.manager');
        $current_page = $pager_manager->createPager($total, $limit)->getCurrentPage();
        // Split the items up into chunks:
        $chunks = array_chunk($result, $limit);
        // Get the items for our current page:
        return $chunks[$current_page];
      }
}