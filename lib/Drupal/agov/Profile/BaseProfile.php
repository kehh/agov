<?php

/**
 * @file
 *
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at previousnext dot com dot au
 * @copyright Copyright(c) 2014 Previous Next Pty Ltd
 */

namespace Drupal\agov\Profile;

use Drupal\agov\Profile\ProfileInterface;

/**
 * Class BaseProfile
 *
 * @package Drupal\agov\Profile
 */
class BaseProfile implements ProfileInterface {

  /**
   * Install the Profile.
   *
   * The Installer will call this to run the installation process.
   */
  public function installProfile() {
    // TODO: Implement installProfile() method.
  }

}
