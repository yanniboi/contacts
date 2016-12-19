<?php

/**
 * @file
 * Contains \Drupal\contacts\Plugin\Block\CustomText.
 */

namespace Drupal\contacts\Plugin\Block;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormState;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\ContextAwarePluginInterface;

/**
 * Provides a block to view a custom text content.
 *
 * @Block(
 *   id = "crm_notes",
 *   admin_label = @Translation("Notes"),
 *   category = @Translation("CRM"),
 * )
 */
class CrmNotes extends BlockBase implements ContextAwarePluginInterface {

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
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $entity = $this->getContextValue('entity');
    return \Drupal::formBuilder()->getForm('Drupal\contacts\Form\NotesForm', $entity);
  }

}


/*

$entity_type_manager = \Drupal::entityTypeManager();
    $form_object = \Drupal::classResolver()->getInstanceFromDefinition('Drupal\contacts\Form\NotesForm');

    $form_object
      ->setEntity($entity)
      ->setStringTranslation(\Drupal::service('string_translation'))
      ->setModuleHandler(\Drupal::moduleHandler())
      ->setEntityTypeManager($entity_type_manager)
      ->setEntityManager(\Drupal::entityManager());


    $form_state = (new FormState());



 *
 */