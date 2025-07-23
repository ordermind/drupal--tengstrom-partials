<?php

declare(strict_types=1);

namespace Drupal\tengstrom_text_partials;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the partial content entity type.
 */
class TengstromTextPartialAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $organization, $operation, AccountInterface $currentUser) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission(
          $currentUser,
          'view tengstrom_text_partial'
        );

      case 'update':
        return AccessResult::allowedIfHasPermissions(
          $currentUser,
          ['edit tengstrom_text_partial', 'administer tengstrom_text_partial'],
          'OR'
        );

      case 'delete':
        return AccessResult::allowedIfHasPermissions(
          $currentUser,
          ['delete tengstrom_text_partial', 'administer tengstrom_text_partial'],
          'OR'
        );

      default:
        // No opinion.
        return AccessResult::neutral();
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $currentUser, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions(
      $currentUser,
      ['create tengstrom_text_partial', 'administer tengstrom_text_partial'],
      'OR'
    );
  }

}
