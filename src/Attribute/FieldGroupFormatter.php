<?php

declare(strict_types=1);

namespace Drupal\field_group\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines a FieldGroupFormatter attribute object.
 *
 * Formatters handle the display of fieldgroups.
 *
 * Additional annotation keys for formatters can be defined in
 * hook_field_group_formatter_info_alter().
 *
 * @see \Drupal\field_group\FieldGroupFormatterPluginManager
 * @see \Drupal\field_group\FieldGroupFormatterInterface
 *
 * @ingroup field_formatter
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class FieldGroupFormatter extends Plugin {

  /**
   * Constructs a FieldGroupFormatter attribute.
   *
   * @param string $id
   *   The plugin ID.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $label
   *   The human-readable name of the formatter type.
   * @param array $supported_contexts
   *   (optional) Contexts the formatter supports (form / view).
   * @param array $format_types
   *   (optional) The different format types available for this formatter.
   * @param int|null $weight
   *   (optional) The weight of this formatter relative to other formatters
   *   in the Field UI when selecting a formatter for a given group.
   * @param class-string|null $deriver
   *   (optional) The deriver class.
   */
  public function __construct(
    public readonly string $id,
    public readonly TranslatableMarkup $label,
    public readonly array $supported_contexts = [],
    public readonly array $format_types = [],
    public readonly ?int $weight = NULL,
    public readonly ?string $deriver = NULL,
  ) {}

}
