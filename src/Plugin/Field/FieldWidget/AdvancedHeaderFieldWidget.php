<?php

namespace Drupal\s360_advanced_header_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\s360_advanced_header_field\Plugin\Field\FieldType\AdvancedHeaderFieldItem;

/**
 * Plugin implementation of the 'advanced_header_field' widget.
 *
 * @FieldWidget(
 *   id = "advanced_header_field",
 *   label = @Translation("Advanced Header Field"),
 *   field_types = {
 *     "advanced_header_field"
 *   }
 * )
 */
class AdvancedHeaderFieldWidget extends LinkWidget {

  // Define all the default sizes.
  const DEFAULT_SIZES = [
    'h1' => 'Heading 1',
    'h2' => 'Heading 2',
    'h3' => 'Heading 3',
    'h4' => 'Heading 4',
    'h5' => 'Heading 5',
    'h6' => 'Heading 6',
  ];

  // Define all default styles.
  const DEFAULT_STYLES = [];

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $item = $items[$delta];

    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['#attributes'] = [
      'class' => ['s360-advanced-header-field'],
    ];
    $element['#type'] = 'details';
    $element['#open'] = TRUE;

    // Rename the title field's title.
    $element['title']['#title'] = 'Heading text';

    // Make the title required based on the field.
    $element['title']['#required'] = $element['#required'];

    // Start heading group.
    $element['text'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Text'),
      '#attributes' => [
        'class' => ['s360-advanced-header-field__text'],
      ],
    ];

    $semantic_tag_options = array_intersect_key(AdvancedHeaderFieldItem::AVAILABLE_TAGS, array_flip($this->getFieldSetting('allowed_tags')));

    $element['text']['heading_tag'] = [
      '#title' => $this->t('Semantic tag'),
      '#type' => 'select',
      '#options' => $semantic_tag_options,
      '#default_value' => $item->options['heading_tag'] ?? 'h2',
    ];

    // Move the 'title' element into the text.
    $element['text']['title'] = $element['title'];

    $element['text']['subtitle'] = [
      '#title' => $this->t('Subtitle text'),
      '#type' => 'textfield',
      '#default_value' => $item->subtitle ?? '',
    ];

    // Start options group.
    $element['options'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Options'),
      '#attributes' => [
        'class' => ['s360-advanced-header-field__options'],
      ],
    ];

    // Start display options.
    $element['options']['display_options'] = [
      '#type' => 'details',
      '#title' => $this->t('Display options'),
      '#open' => (
        (isset($item->options['visually_hidden']) && $item->options['visually_hidden']) ||
        (isset($item->options['center']) && $item->options['center']) ||
        (isset($item->options['uppercase']) && $item->options['uppercase']) ||
        (isset($item->options['size']) && $item->options['size']) ||
        (isset($item->options['styles']) && $item->options['styles'])
      ) ?? FALSE,
      '#attributes' => [
        'class' => ['s360-advanced-header-field__options-display-options'],
      ],
    ];

    $element['options']['display_options']['visually_hidden'] = [
      '#title' => $this->t('Visually hidden'),
      '#type' => 'checkbox',
      '#default_value' => $item->options['visually_hidden'] ?? FALSE,
      '#description' => $this->t('When checked the text will be hidden from display, but not screen readers.'),
    ];

    $element['options']['display_options']['size'] = [
      '#title' => $this->t('Size'),
      '#type' => 'select',
      '#options' => AdvancedHeaderFieldWidget::DEFAULT_SIZES,
      '#empty_option' => $this->t('- Select -'),
      '#default_value' => $item->options['size'] ?? '',
    ];

    if (count($this->getStyleOptions())) {
      $element['options']['display_options']['styles'] = [
        '#title' => $this->t('Styles'),
        '#type' => 'checkboxes',
        '#options' => $this->getStyleOptions(),
        '#default_value' => $item->options['styles'] ?? [],
        '#attributes' => [
          'class' => ['s360-advanced-header-field__options-display-options-styles'],
        ],
      ];
    }

    // Start link group.
    $element['options']['link_options'] = [
      '#type' => 'details',
      '#title' => $this->t('Link options'),
      '#open' => (
        (isset($item->options['new_window']) && $item->options['new_window']) ||
        $element['uri']['#default_value'] !== '<nolink>'
      ) ?? FALSE,
      '#attributes' => [
        'class' => ['s360-advanced-header-field__options-link-options'],
      ],
    ];

    // Move the 'uri' element into the link_options.
    $element['options']['link_options']['uri'] = $element['uri'];
    $element['options']['link_options']['new_window'] = [
      '#title' => $this->t('Open link in new window.'),
      '#type' => 'checkbox',
      '#default_value' => $item->options['new_window'] ?? FALSE,
      '#description' => $this->t("Check this to force link to open in new window."),
    ];

    // Since we've moved the title and uri into groups, hide the original.
    unset($element['title']);
    unset($element['uri']);

    $element['#element_validate'][] = [get_called_class(), 'processFields'];
    $element['#element_validate'][] = [get_called_class(), 'processOptions'];

    return $element;
  }

  /**
   * Update field values.
   */
  public static function processFields(&$element, FormStateInterface $form_state, $form) {
    $values = $form_state->getValue($element['#parents']);

    // Change empty uri to '<nolink>'.
    if ($element['options']['link_options']['uri']['#value'] === '') {
      $values['uri'] = '<nolink>';
    }
    // Set the uri with the uri's value from the link_options.
    else {
      $values['uri'] = $element['options']['link_options']['uri']['#value'];
    }

    // Set the title with the title's value from the text.
    $values['title'] = $element['text']['title']['#value'];
    $values['subtitle'] = $element['text']['subtitle']['#value'];

    $form_state->setValueForElement($element, $values);
  }

  /**
   * Copy custom values into the option field.
   */
  public static function processOptions(&$element, FormStateInterface $form_state, $form) {
    $values = $form_state->getValue($element['#parents']);

    $values['options'] = [
      'heading_tag' => $element['text']['heading_tag']['#value'],

      'visually_hidden' => $element['options']['display_options']['visually_hidden']['#value'],
      'size' => $element['options']['display_options']['size']['#value'],
      'styles' => isset($element['options']['display_options']['styles'])
      ? array_keys($element['options']['display_options']['styles']['#value'])
      : [],

      'new_window' => $element['options']['link_options']['new_window']['#value'],
    ];

    $form_state->setValueForElement($element, $values);
  }

  /**
   * Creates an array of available styles.
   *
   * @return array
   *   An associative array of available styles.
   */
  private function getStyleOptions() {
    $style_options = [];

    // Add the DEFAULT_STYLES to $style_options array.
    $style_options = AdvancedHeaderFieldWidget::DEFAULT_STYLES;

    // Get the custom_styles and apply some function to normalize them.
    $custom_styles = explode("\n", $this->getFieldSetting('custom_styles'));
    $custom_styles = array_map('trim', $custom_styles);
    $custom_styles = array_filter($custom_styles, 'strlen');

    foreach ($custom_styles as $custom_style) {
      $matches = [];

      if (preg_match('/(.*)\|(.*)/', $custom_style, $matches)) {
        $key = trim($matches[1]);
        $value = trim($matches[2]);
      }

      $style_options[$key] = $value;
    }

    return $style_options;
  }

}
