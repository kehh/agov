<?php

/**
 * @file
 * Contains a
 *
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at previousnext dot com dot au
 * @copyright Copyright(c) 2015 Previous Next Pty Ltd
 */

namespace Drupal\agov_entity_layouts;


/**
 * Class HookEntityView
 * @package Drupal\agov_entity_layouts
 */
class HookEntityView {

  /**
   * The content buffer.
   *
   * @var array
   */
  protected $contentBuffer = array();

  /**
   * Lazy constructor.
   *
   * @static
   * @return static
   *   Returns an instance of HookEntityView
   */
  static public function init() {

    return new static();
  }

  /**
   * Callback for hook_entity_view().
   *
   * @param object $entity
   *   The entity.
   * @param string $type
   *   The entity type.
   * @param string $view_mode
   *   The view mode.
   * @param string $langcode
   *   The langcode
   */
  public function entityView($entity, $type, $view_mode, $langcode) {
    $this->contentBuffer = $entity->content;

    if ($view_mode == 'full') {
      if (isset($entity->field_layout_mode[LANGUAGE_NONE][0]['value']) && !empty($entity->field_layout_mode[LANGUAGE_NONE][0]['value'])) {
        $layout_mode = check_plain($entity->field_layout_mode[LANGUAGE_NONE][0]['value']);

        if ($layout_mode == 'paragraphs') {
          $this->processParagraphsEntity($entity, $type, $langcode);

        }
        else {
          unset($entity->content['field_paragraph_content']);
        }
      }
    }
  }

  /**
   * Process the Paragraphs entity.
   *
   * @param object $entity
   *   The entity.
   * @param string $type
   *   The entity type.
   * @param string $langcode
   *   The langcode
   */
  protected function processParagraphsEntity($entity, $type, $langcode) {

    // Replace the entity content with the content of the paragraphs
    // field.
    $entity->content = field_view_field($type, $entity, 'field_paragraph_content', array('label' => 'hidden'), $langcode);

    // If there is an 'entity_content' paragraph item, replace its content
    // with the current entity.
    if (isset($entity->content['#items'])) {
      foreach ($entity->content['#items'] as $paragraphs_index) {
        foreach (array_keys($entity->content) as $content_row_id) {
          if (!is_array($entity->content[$content_row_id])) {
            continue;
          }

          if (isset($entity->content[$content_row_id]['entity']['paragraphs_item'][$paragraphs_index['value']]) && $entity->content[$content_row_id]['entity']['paragraphs_item'][$paragraphs_index['value']]['#bundle'] == 'entity_content') {
            $entity->content[$content_row_id]['entity']['paragraphs_item'][$paragraphs_index['value']]['content'] = $this->contentBuffer;
          }
        }
      }
    }
  }
}
