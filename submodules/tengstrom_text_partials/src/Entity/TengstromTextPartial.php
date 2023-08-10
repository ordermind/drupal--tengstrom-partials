<?php

declare(strict_types=1);

namespace Drupal\tengstrom_text_partials\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\tengstrom_text_partials\TengstromTextPartialInterface;

/**
 * Defines the text partial entity type.
 *
 * @ConfigEntityType(
 *   id = "tengstrom_text_partial",
 *   label = @Translation("Text Partial"),
 *   label_collection = @Translation("Text Partials"),
 *   label_singular = @Translation("text partial"),
 *   label_plural = @Translation("text partials"),
 *   label_count = @PluralTranslation(
 *     singular = "@count text partial",
 *     plural = "@count text partials",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\tengstrom_text_partials\TengstromTextPartialListBuilder",
 *     "form" = {
 *       "add" = "Drupal\tengstrom_text_partials\Form\TengstromTextPartialForm",
 *       "edit" = "Drupal\tengstrom_text_partials\Form\TengstromTextPartialForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "tengstrom_text_partial",
 *   admin_permission = "administer tengstrom_text_partial",
 *   links = {
 *     "collection" = "/admin/structure/tengstrom-text-partial",
 *     "add-form" = "/admin/structure/tengstrom-text-partial/add",
 *     "edit-form" = "/admin/structure/tengstrom-text-partial/{tengstrom_text_partial}",
 *     "delete-form" = "/admin/structure/tengstrom-text-partial/{tengstrom_text_partial}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "contentValue",
 *     "contentFormat"
 *   }
 * )
 */
class TengstromTextPartial extends ConfigEntityBase implements TengstromTextPartialInterface {

  /**
   * The text partial ID.
   */
  protected string $id;

  /**
   * The text partial label.
   */
  protected string $label;

  /**
   * The tengstrom_text_partial content.
   */
  protected string $contentValue;
  protected string $contentFormat;

}
