<?php
/**
 * @file
 * agov_styles.features.inc
 */

/**
 * Implements hook_eck_bundle_info().
 */
function agov_styles_eck_bundle_info() {
  $items = array(
    'style_style' => array(
      'machine_name' => 'style_style',
      'entity_type' => 'style',
      'name' => 'style',
      'label' => 'Style',
    ),
  );
  return $items;
}

/**
 * Implements hook_eck_entity_type_info().
 */
function agov_styles_eck_entity_type_info() {
  $items = array(
    'style' => array(
      'name' => 'style',
      'label' => 'Style',
      'properties' => array(
        'human_readable_name' => array(
          'label' => 'Human-readable name',
          'type' => 'text',
          'behavior' => 'title',
        ),
      ),
    ),
  );
  return $items;
}
