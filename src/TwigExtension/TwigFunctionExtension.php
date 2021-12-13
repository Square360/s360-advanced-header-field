<?php

namespace Drupal\s360_advanced_header_field\TwigExtension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Class TwigFilterExtension stuff.
 */
class TwigFunctionExtension extends AbstractExtension {

  /**
   * Declare your custom twig filter here.
   *
   * @return array|TwigFunction[]
   *   Something.
   */
  public function getFunctions() {
    return [
      new TwigFunction('get_header_classes', [$this, 'getHeaderClasses'], [
        'needs_context' => TRUE,
      ]),
    ];
  }

  /**
   * Create an a string array of any additional classes.
   *
   * @param array $context
   *   The element.
   *
   * @return array
   *   An array of any additional classes, empty otherwise.
   */
  public function getHeaderClasses(array $context) {
    $options = $context['elements']['#item']->options;
    $base_class = $context['attributes']->offsetGet('class')->offsetGet(0);

    $classes = [];

    if ($options['size']) {
      $classes[] = $base_class . '--size-' . $options['size'];
    }

    if ($options['styles']) {
      // Add a class for all styles.
      foreach ($options['styles'] as $style) {
        $classes[] = $base_class . '--style-' . $style;
      }
    }

    // "visually-hidden" is a utility class so it doesn't need a BEM class name.
    if ($options['visually_hidden']) {
      $classes[] = 'visually-hidden';
    }

    return $classes;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 's360_advanced_header_field.function';
  }

}
