<?php

namespace Drupal\contacts\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\profile\Entity\ProfileType;

/**
 * Form controller for profile forms.
 */
class NotesEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $profile_type = ProfileType::load($this->entity->bundle());

    $this->entity->save();

    drupal_set_message($this->t('Notes for %label have been saved.', ['%label' => $profile_type->label()]));

    $form_state->setRedirect('page_manager.page_view_contacts_dashboard_contact', [
      'user' => $this->entity->getOwnerId(),
      'subpage' => 'notes',
    ]);
  }

}
