<?php

declare(strict_types=1);

namespace Drupal\tengstrom_partials\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Controller\ControllerBase;
use Drupal\tengstrom_general\Repository\EntityRepositoryInterface;
use Drupal\tengstrom_text_partials\Entity\TengstromTextPartial;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TengstromPartialsController extends ControllerBase {

  public function __construct(
    protected EntityRepositoryInterface $entityRepository,
    protected ConfigEntityListBuilder $entityListBuilder
  ) {}

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tengstrom_general.entity_repository'),
      ConfigEntityListBuilder::createInstance(
        $container,
        $container->get('entity_type.manager')->getDefinition('tengstrom_text_partial')
      )
    );
  }

  public function list(): array {
    $entities = $this->entityRepository->fetchEntitiesOfType('tengstrom_text_partial');

    $list = [
      '#type' => 'accordion_table',
      '#header' => ['title' => $this->t('Title'), 'operations' => $this->t('Operations')],
      '#rows' => array_map(function (TengstromTextPartial $entity) {
        return [
          'data' => [
            'title' => $entity->label(),
            'operations' => [
              'data' => [
                '#type' => 'operations',
                '#links' => $this->entityListBuilder->getOperations($entity),
              ],
            ],
          ],
        ];
      }, array_values($entities)),
      '#separate_operations' => TRUE,
    ];

    return $list;

  }

}
