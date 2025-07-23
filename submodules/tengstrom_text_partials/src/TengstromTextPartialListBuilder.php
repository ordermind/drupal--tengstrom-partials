<?php

declare(strict_types=1);

namespace Drupal\tengstrom_text_partials;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of text partials.
 */
class TengstromTextPartialListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\tengstrom_text_partials\TengstromTextPartialInterface $entity */
    $row['label'] = $entity->label();

    return $row + parent::buildRow($entity);
  }

  public function render(): array {
    $build = parent::render();

    $build['table']['#type'] = 'accordion_table';
    $build['table']['#separate_operations'] = TRUE;

    return $build;
  }

}
