<?php

declare(strict_types=1);

namespace Drupal\tengstrom_text_partials\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Text Partial form.
 *
 * @property \Drupal\tengstrom_text_partials\TengstromTextPartialInterface $entity
 */
class TengstromTextPartialForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the text partial.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\tengstrom_text_partials\Entity\TengstromTextPartial::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['content'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Content'),
      '#default_value' => $this->entity->get('contentValue'),
      '#format' => $this->entity->get('contentFormat') ?: 'filtered_html',
      '#allowed_formats' => ['filtered_html'],
      '#hide_help' => TRUE,
      '#hide_guidelines' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new text partial %label.', $message_args)
      : $this->t('Updated text partial %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  protected function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    if ($this->entity instanceof EntityWithPluginCollectionInterface) {
      // Do not manually update values represented by plugin collections.
      $values = array_diff_key($values, $this->entity->getPluginCollections());
    }

    // @todo This relies on a method that only exists for config and content
    //   entities, in a different way. Consider moving this logic to a config
    //   entity specific implementation.
    foreach ($values as $key => $value) {
      if ($key === 'content') {
        $entity->set('contentValue', $value['value']);
        $entity->set('contentFormat', $value['format']);
      }
      else {
        $entity->set($key, $value);
      }
    }
  }

}
