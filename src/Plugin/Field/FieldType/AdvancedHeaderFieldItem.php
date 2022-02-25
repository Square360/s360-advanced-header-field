<?php

namespace Drupal\s360_advanced_header_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;
use Drupal\link\LinkItemInterface;
use Drupal\link\Plugin\Field\FieldType\LinkItem;

/**
 * Plugin implementation of the 'advanced_header_field' field type.
 *
 * @FieldType(
 *   id = "advanced_header_field",
 *   label = @Translation("Advanced Header Field"),
 *   description = @Translation("Advanced Header Field"),
 *   category = @Translation("Custom"),
 *   default_widget = "advanced_header_field",
 *   default_formatter = "advanced_header_field_html",
 *   cardinality = 1,
 * )
 */
class AdvancedHeaderFieldItem extends LinkItem {

  const AVAILABLE_TAGS = [
    'h2' => 'H2',
    'h3' => 'H3',
    'h4' => 'H4',
    'h5' => 'H5',
    'h6' => 'H6',
  ];

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'custom_styles' => '',
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'title' => DRUPAL_REQUIRED,
      'link_type' => LinkItemInterface::LINK_GENERIC,
      'allowed_tags' => [],
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    $schema['columns']['subtitle'] = [
      'description' => 'Optional subtitle for the header.',
      'type' => 'varchar',
      'length' => 255,
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['uri'] = DataDefinition::create('uri')
      ->setLabel(t('URI'))
      ->setRequired(FALSE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = parent::storageSettingsForm($form, $form_state, $has_data);

    $element['custom_styles'] = [
      '#type' => 'textarea',
      '#rows' => 10,
      '#default_value' => $this->getSetting('custom_styles'),
      '#title' => $this->t('Custom Styles'),
      '#description' => $this->t('<p>Possible styles that can be applied to the header field. Enter one value per line, in the format <strong>name|label</strong>.</p>'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::fieldSettingsForm($form, $form_state);

    $element['allowed_tags'] = [
      '#type' => 'checkboxes',
      '#options' => AdvancedHeaderFieldItem::AVAILABLE_TAGS,
      '#title' => $this->t('Allowed Tags'),
      '#required' => TRUE,
      '#default_value' => $this->getSetting('allowed_tags') ?? [],
      '#element_validate' => [
        [get_called_class(), 'fieldSettingsFormAllowedTagsValidate'],
      ],
    ];

    return $element;
  }

  /**
   * Formats the allowed_tags setting.
   */
  private static function fieldSettingsFormAllowedTagsValidate(array &$element, FormStateInterface $form_state) {
    $values = $form_state->getValue($element['#parents']);

    $values = array_keys($element['#value']);

    $form_state->setValueForElement($element, $values);
  }

}
