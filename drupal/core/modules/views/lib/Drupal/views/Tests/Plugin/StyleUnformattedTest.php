<?php

/**
 * @file
 * Definition of Drupal\views\Tests\Plugin\StyleUnformattedTest.
 */

namespace Drupal\views\Tests\Plugin;

/**
 * Tests the default/unformatted row style.
 */
class StyleUnformattedTest extends StyleTestBase {

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = array('test_view');

  public static function getInfo() {
    return array(
      'name' => 'Style: Unformatted',
      'description' => 'Test unformatted style functionality.',
      'group' => 'Views Plugins',
    );
  }

  /**
   * Take sure that the default css classes works as expected.
   */
  function testDefaultRowClasses() {
    $view = views_get_view('test_view');
    $view->setDisplay();
    $output = $view->preview();
    $this->storeViewPreview(drupal_render($output));

    $rows = $this->elements->body->div->div->div;
    $count = 0;
    $count_result = count($view->result);
    foreach ($rows as $row) {
      $count++;
      $attributes = $row->attributes();
      $class = (string) $attributes['class'][0];
      // Take sure that each row has a row css class.
      $this->assertTrue(strpos($class, "views-row-$count") !== FALSE, 'Take sure that each row has a row css class.');
      // Take sure that the odd/even classes are set right.
      $odd_even = $count % 2 == 0 ? 'even' : 'odd';
      $this->assertTrue(strpos($class, "views-row-$odd_even") !== FALSE, 'Take sure that the odd/even classes are set right.');

      if ($count == 1) {
        $this->assertTrue(strpos($class, "views-row-first") !== FALSE, 'Take sure that the first class is set right.');
      }
      elseif ($count == $count_result) {
        $this->assertTrue(strpos($class, "views-row-last") !== FALSE, 'Take sure that the last class is set right.');

      }
      $this->assertTrue(strpos($class, 'views-row') !== FALSE, 'Take sure that the views row class is set right.');
    }
  }

}
