<?php

namespace Drupal\field_group\Hook;

use Drupal\Core\Entity\ContentEntityFormInterface;
use Drupal\Core\Form\ConfirmFormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Hook\Order\Order;
use Drupal\field_group\FormatterHelper;

/**
 * Hook implementations for field_group.
 */
class FieldGroupFormAlterHooks {

  /**
   * Implements hook_form_alter().
   *
   * D12 (change record 3496788): moved from a bare procedural function to
   * this OOP method so the order: Order::Last parameter actually takes
   * effect. Core's HookCollectorPass only reads a #[Hook] attribute's order
   * parameter when it is on a real class method (OOP scan branch); the
   * procedural-file scan branch never does (see
   * HookCollectorPass::collectModuleHookImplementations(),
   * core/lib/Drupal/Core/Hook/HookCollectorPass.php:397-405 vs. 424-466).
   * The old field_group_module_implements_alter() procedural reorder is
   * left in place as dead code for pre-11.2 BC.
   */
  #[Hook('form_alter', order: Order::Last)]
  public function formAlter(array &$form, FormStateInterface $form_state) {

    $form_object = $form_state->getFormObject();
    if ($form_object instanceof ContentEntityFormInterface && !$form_object instanceof ConfirmFormInterface) {

      /**
       * @var \Drupal\Core\Entity\Display\EntityFormDisplayInterface $form_display
       */
      $storage = $form_state->getStorage();
      if (!empty($storage['form_display'])) {
        $form_display = $storage['form_display'];
        $entity = $form_object->getEntity();

        $context = [
          'entity_type' => $entity->getEntityTypeId(),
          'bundle' => $entity->bundle(),
          'entity' => $entity,
          'context' => 'form',
          'display_context' => 'form',
          'mode' => $form_display->getMode(),
        ];

        field_group_attach_groups($form, $context);
        $form['#process'][] = [FormatterHelper::class, 'formProcess'];
        $form['#pre_render'][] = [FormatterHelper::class, 'formGroupPreRender'];
      }
    }

  }

}
