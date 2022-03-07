<?php

namespace Drupal\s360_advanced_header_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\s360_advanced_header_field\Plugin\Field\FieldType\AdvancedHeaderFieldItem;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'advanced_header_field' string formatter.
 *
 * @FieldFormatter(
 *   id = "advanced_header_field_string",
 *   label = @Translation("Plain text"),
 *   field_types = {
 *     "advanced_header_field"
 *   }
 * )
 */
class AdvancedHeaderFieldStringFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = $this->viewValue($item);
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  private function viewValue(FieldItemInterface $item) {
    if ($item->title) {
      $options = $item->options;

      $heading_tag = AdvancedHeaderFieldItem::AVAILABLE_TAGS[$options['heading_tag']];

      return [
        '#type' => 'inline_template',
        '#template' => '{{ value|nl2br }}',
        '#context' => [
          'value' => ($item->title !== '')
          ? $heading_tag . ': ' . $item->title
          : '',
        ],
      ];
    }
  }

}
