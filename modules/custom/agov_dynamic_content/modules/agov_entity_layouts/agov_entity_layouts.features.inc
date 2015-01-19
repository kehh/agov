<?php
/**
 * @file
 * agov_entity_layouts.features.inc
 */

/**
 * Implements hook_paragraphs_info().
 */
function agov_entity_layouts_paragraphs_info() {
  $items = array(
    'entity_content' => array(
      'name' => 'Entity content',
      'bundle' => 'entity_content',
      'locked' => '1',
    ),
  );
  return $items;
}
