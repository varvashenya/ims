<?php

/**
 * @file
 * Contains \Drupal\devel\Form\SettingsForm.
 */

namespace Drupal\improved_multi_select\Form;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a form that configures devel settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'ims_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('ims.settings');

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('ims.settings')
//      ->set('query_display', $values['query_display'])
//      ->set('query_sort', $values['query_sort'])
//      ->set('execution', $values['execution'])
//      ->set('api_url', $values['api_url'])
//      ->set('timer', $values['timer'])
//      ->set('memory', $values['memory'])
//      ->set('redirect_page', $values['redirect_page'])
//      ->set('page_alter', $values['page_alter'])
//      ->set('raw_names', $values['raw_names'])
//      ->set('error_handlers', $values['error_handlers'])
//      ->set('krumo_skin', $values['krumo_skin'])
//      ->set('rebuild_theme', $values['rebuild_theme'])
      ->set('use_uncompressed_jquery', $values['use_uncompressed_jquery'])
      ->save();
  }

}
