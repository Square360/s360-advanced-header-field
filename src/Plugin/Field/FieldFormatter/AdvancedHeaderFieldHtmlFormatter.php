<?php

namespace Drupal\s360_advanced_header_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'advanced_header_field' html formatter.
 *
 * @FieldFormatter(
 *   id = "advanced_header_field_html",
 *   label = @Translation("HTML Markup"),
 *   field_types = {
 *     "advanced_header_field"
 *   }
 * )
 */
class AdvancedHeaderFieldHtmlFormatter extends LinkFormatter {

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
        // Get all the values from the item, so it can be added to without
        // overrwiting existing values.
        $item_value = $item->getValue();

        /** @var Drupal\Core\Field\FieldItemList $field_item_list */
        $field_item_list = $item->getParent();

        if ($field_item_list !== NULL) {
          /** @var Drupal\Core\Entity\Plugin\DataType\EntityAdapter $entity_adapter */
          $entity_adapter = $field_item_list->getParent();

          if ($entity_adapter !== NULL) {
            // Get the entity type from the adapter.
            $entity = $entity_adapter->getEntity();

            $entity_bundle = $entity->bundle();
            $entity_id = $entity->id();
            $item_value['heading_id'] = "heading-$entity_bundle-$entity_id";
          }
        }

        // Create a link with the URL and title.
        if ($item->uri !== 'route:<nolink>') {
          $item_value['heading_text'] = [
            '#type' => 'link',
            '#title' => $item->title,
            '#url' => $this->buildUrl($item),
            '#attributes' => [],
          ];

          if ($item->options['new_window']) {
            $item_value['heading_text']['#attributes']['target'] = '_blank';
          }
        }
        // No link, just text.
        else {
          $item_value['heading_text'] = $item->title;
        }

        $item_value['options']['tag'] = $this->getSettings()['tag'];

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
