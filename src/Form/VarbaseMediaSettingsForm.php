<?php

namespace Drupal\varbase_media\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\InstallStorage;
use Symfony\Component\Yaml\Yaml;

/**
 * Provides form for managing module settings.
 */
class VarbaseMediaSettingsForm extends ConfigFormBase {

  /**
   * Get the from ID.
   */
  public function getFormId() {
    return 'varbase_media_settings';
  }

  /**
   * Get the editable config names.
   */
  protected function getEditableConfigNames() {
    return ['varbase_media.settings'];
  }

  /**
   * Build the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('varbase_media.settings');

    $form['use_blazy_blurry'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use Blazy Blurry'),
      '#default_value' => $config->get('use_blazy_blurry'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit Form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Save Varbase Media settings.
    $use_blazy_blurry = (bool) $form_state->getValue('use_blazy_blurry');
    $this->config('varbase_media.settings')
      ->set('use_blazy_blurry', $use_blazy_blurry)
      ->save();

    // Have the Blazy Blurry image style in the active config.
    if ($use_blazy_blurry) {
      $module_path = \Drupal::service('module_handler')->getModule('varbase_media')->getPath();
      $optional_install_path = $module_path . '/' . InstallStorage::CONFIG_OPTIONAL_DIRECTORY;

      $image_style_config_path = $optional_install_path . '/' . 'image.style.blazy_blurry.yml';
      $image_style_config_content = file_get_contents($image_style_config_path);
      $image_style_config_data = (array) Yaml::parse($image_style_config_content);
      $image_style_config_factory = \Drupal::configFactory()->getEditable('image.style.blazy_blurry');
      $image_style_config_factory->setData($image_style_config_data)->save(TRUE);
    }

    parent::submitForm($form, $form_state);
  }

}
