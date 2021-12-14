<?php

namespace Drupal\s360_advanced_header_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'advanced_header_field' formatter.
 *
 * @FieldFormatter(
 *   id = "advanced_header_field_string_markup",
 *   label = @Translation("HTML Markup"),
 *   field_types = {
 *     "advanced_header_field"
 *   }
 * )
 */
class HtmlMarkupFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'tag' => 'header',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['tag'] = [
      '#type' => 'select',
      '#title' => $this->t('HTML Tag'),
      '#options' => [
        'header' => $this->t('Semantic (header)'),
        'div' => $this->t('Generic (div)'),
      ],
      '#default_value' => $this->getSetting('tag') ?? 'header',
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();

    $summary = [];
    $summary[] = $this->t('Render as @tag', ['@tag' => ucfirst($settings['tag'])]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      if ($item->title !== '') {
        $tag = $this->getSettings()['tag'];

        // Get all the values from the item, so it can be added to without
        // overrwiting existing values.
        $item_value = $item->getValue();

        // Create a link with the URL and title, otherwise create a span.
        $item_value['heading_text'] = [
          '#type' => 'link',
          '#title' => $item->title,
          '#url' => $this->buildUrl($item),
          '#attributes' => [],
        ];

        if ($item->uri !== 'route:<nolink>') {
          if ($item->options['new_window']) {
            $item_value['heading_text']['#attributes']['target'] = '_blank';
          }
        }

        $item_value['options']['tag'] = $tag;

        // Remove keys from the $item_value that aren't needed anymore.
        unset($item_value['title']);
        unset($item_value['options']['new_window']);

        // Update the item's value.
        $item->setValue($item_value);

        $element[$delta] = [
          '#item' => $item,
          '#theme' => 'advanced_header_field',
        ];
      }
    }

    return $element;
  }

}
