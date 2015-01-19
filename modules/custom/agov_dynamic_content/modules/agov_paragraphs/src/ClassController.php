<?php

/**
 * @file
 * Contains a ClassController
 *
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at previousnext dot com dot au
 * @copyright Copyright(c) 2015 Previous Next Pty Ltd
 */

namespace Drupal\agov_paragraphs;


/**
 * Class ClassController
 * @package Drupal\agov_paragraphs
 */
class ClassController {

  /**
   * The entity classes.
   *
   * @var array
   *   An array of classes.
   */
  protected $classes = array();

  /**
   * Lazy loader.
   *
   * @return static
   *   This.
   * @static
   */
  static public function init() {
    return new static();
  }

  /**
   * Assigns classes to the entity.
   *
   * @param object $entity
   *   The entity object.
   * @param string $type
   *   The type of entity being rendered (i.e. node, user, comment).
   * @param string $view_mode
   *   The view mode the entity is rendered in.
   * @param string $langcode
   *   The language code used for rendering.
   */
  public function resolveClasses($entity, $type, $view_mode, $langcode) {

    if ($type == 'paragraphs_item') {

      // Ensure every paragraph gets a unique identifying class, just in case.
      $this->setClass('paragraphs-item__' . drupal_html_class($entity->item_id));

      // Process any paragraphs with class settings.
      // These come from the field "field_pbundle_css_classes".
      if (isset($entity->field_pbundle_css_classes[$langcode][0]['value']) && !empty($entity->field_pbundle_css_classes[$langcode][0]['value'])) {
        $this->setClass(check_plain($entity->field_pbundle_css_classes[$langcode][0]['value']));
      }

      // Process Paragraphs with Style settings.
      $this->processStyleClasses($entity, $langcode);

      // Process any Paragraphs with layout settings.
      // These come from the field "field_pbundle_container_layout".
      $this->processLayoutClasses($entity, $langcode);

      $entity->content['#attributes']['class'][] = $this->getClasses();
    }
  }

  /**
   * Get the classes.
   *
   * @return string
   *   A string of classes.
   */
  public function getClasses() {

    return implode(' ', $this->classes);
  }

  /**
   * Set a class.
   *
   * @param string $class
   *   The class.
   */
  public function setClass($class) {

    if (!in_array($class, $this->classes)) {
      $this->classes[] = $class;
    }
  }

  /**
   * Process Style entity classes.
   *
   * @param object $entity
   *   The entity object.
   * @param string $langcode
   *   The language code used for rendering.
   */
  protected function processStyleClasses($entity, $langcode) {

    if (isset($entity->field_pbundle_style[$langcode][0]) && !empty($entity->field_pbundle_style[$langcode][0])) {

      // Styles are defined by the Style entity.
      $style_entities = entity_load('style', array($entity->field_pbundle_style[$langcode][0]['target_id']));
      if (!empty($style_entities)) {
        foreach ($style_entities as $style_entity) {

          if (isset($style_entity->field_style_classes[$langcode][0]['value']) && !empty($style_entity->field_style_classes[$langcode][0]['value'])
          ) {
            foreach ($style_entity->field_style_classes[$langcode] as $style_item) {
              $this->setClass(check_plain($style_item['value']));
            }
          }
        }
      }
    }
  }

  /**
   * Process layout entity classes.
   *
   * @param object $entity
   *   The entity object.
   * @param string $langcode
   *   The language code used for rendering.
   */
  protected function processLayoutClasses($entity, $langcode) {

    if (isset($entity->field_pbundle_container_layout[$langcode][0]) && !empty($entity->field_pbundle_container_layout[$langcode][0])) {

      // Container arrangements are defined by the Arrangement entity.
      $arrangements = entity_load('arrangement', array($entity->field_pbundle_container_layout[$langcode][0]['target_id']));
      $arrangement = reset($arrangements);

      $layout_class = 'paragraphs-layout__' . drupal_html_class($arrangement->field_machine_name[$langcode][0]['value']);

      // Any other usage should apply to the root element. This may not work
      // in any given case, since the element children may not be the right
      // kind to get the layout classes.
      if ($entity->bundle == 'container') {
        // Containers apply layout to the container_content field.
        $entity->content['field_pbundle_container_content']['#attributes']['class'][] = $layout_class;
      }
      elseif ($entity->bundle == 'view') {
        // Views apply layout to the view field.
        $entity->content['field_pbundle_view']['#attributes']['class'][] = $layout_class;
      }
      else {
        $this->setClass($layout_class);
      }
    }
  }

  /**
   * Set class names on an element.
   *
   * @param array $variables
   *   The array of variables
   * @param string $element_kind
   *   The element kind. Should usually be 'element' or 'elements'.
   */
  public function setElementClasses(&$variables, $element_kind) {

    if (isset($variables[$element_kind]['#attributes']['class'])
      && !empty($variables[$element_kind]['#attributes']['class'])
      && is_array($variables[$element_kind]['#attributes']['class'])
    ) {
      foreach ($variables[$element_kind]['#attributes']['class'] as $class_name) {
        if (!isset($variables['classes_array'][$class_name])) {
          $variables['classes_array'][] = $class_name;
        }
      }
    }
  }
}
