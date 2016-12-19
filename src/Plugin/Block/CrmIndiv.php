<?php

/**
 * @file
 * Contains \Drupal\contacts\Plugin\Block\CustomText.
 */

namespace Drupal\contacts\Plugin\Block;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\ContextAwarePluginInterface;

/**
 * Provides a block to view a custom text content.
 *
 * @Block(
 *   id = "crm_indiv",
 *   admin_label = @Translation("Individual"),
 *   category = @Translation("CRM"),
 * )
 */
class CrmIndiv extends BlockBase implements ContextAwarePluginInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'fields' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['fields'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Display fields'),
      '#options' => [
        'crm_address' =>  'Address',
        'crm_dob' =>  'Date of Birth',
        'crm_email' => 'Email',
        'crm_gender' => 'Gender',
        'crm_name' => 'Name',
        'crm_photo' => 'Photo',
      ],
      '#default_value' => $this->configuration['fields'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['fields'] = $form_state->getValue('fields');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    if (empty($this->getContexts())) {
      return $build;
    }

    $user = $this->getContextValue('entity');

    if (empty($user->profile_crm_indiv->entity)) {
      return $build;
    }

    // Set the blocks title.
    if (!empty($this->configuration['label_display'])) {
      $build['title'] = [
        '#markup' => '<h2>' . $this->configuration['label'] . '</h2>',
      ];
    }

    $profile = $user->profile_crm_indiv->entity;
    $profile_context = new Context(new ContextDefinition('entity:profile', $this->t('Indiv Profile')), $profile);
    $this->setContext('profile', $profile_context);

    // Set the cache data appropriately.
    $build['#cache']['contexts'] = $this->getCacheContexts();
    $build['#cache']['tags'] = $this->getCacheTags();
    $build['#cache']['max-age'] = $this->getCacheMaxAge();

    foreach (NestedArray::filter($this->configuration['fields']) as $field_name) {
      /** @var \Drupal\Core\Field\FieldItemListInterface $field */
      $field = $profile->{$field_name};
      $display_settings = [];
      $build[$field_name] = $field->view($display_settings);
    }

    return $build;
  }

}
