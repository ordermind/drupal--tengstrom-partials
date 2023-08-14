<?php

declare(strict_types=1);

namespace Drupal\tengstrom_text_partials\Form;

use Drupal\Core\Entity\EntityForm;
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

    $content = $this->entity->get('content');

    $form['content'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Content'),
      '#default_value' => $content['value'] ?? '',
      '#format' => $content['format'] ?? 'filtered_html',
      '#allowed_formats' => ['filtered_html'],
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

}
