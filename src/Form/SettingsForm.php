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
    dpm($config->get());

    $form['isall'] = array(
      '#type' => 'checkbox',
      '#title' => t('Replace all multi-select lists'),
      '#default_value' => $config->get('isall', FALSE),
    );

    $form['url'] = array(
      '#type' => 'textarea',
      '#title' => t('Replace multi-select lists on specific pages'),
      '#description' => t("Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", array('%blog' => 'blog', '%blog-wildcard' => 'blog/*', '%front' => '<front>')),
      '#default_value' => $config->get('url', ''),
    );

    $form['selectors'] = array(
      '#type' => 'textarea',
      '#title' => t('Replace multi-select with specified selectors'),
      '#description' => t('Enter jQuery selectors (one selector per line). Example: select[multiple]'),
      '#default_value' => $config->get('selectors', ''),
    );

    $form['filtertype'] = array(
      '#type' => 'radios',
      '#title' => t('Filter functionality'),
      '#description' => t('Choose how you would like the filter textfield to function.'),
      '#options' => array(
        'partial' => t('Partial match: Shows options that contain the filter text.'),
        'exact' => t('Exact match: Shows options that exactly match the filter text.'),
        'anywords' => t('Any words: Shows options that contain any of the individual words in the filter text. Only exact word matches count.'),
        'anywords_partial' => t('Any words (partial): Shows options that contain any of the individual words in the filter text. Partial word matches count.'),
        'allwords' => t('All words: Shows options that contain all of the individual words in the filter text (in any order). Only exact word matches count.'),
        'allwords_partial' => t('All words (partial): Shows options that contain all of the individual words in the filter text (in any order). Partial word matches count.'),
      ),
      '#default_value' => $config->get('filtertype', 'partial'),
    );

    $form['orderable'] = array(
      '#type' => 'checkbox',
      '#title' => t('Allow re-ordering of selected items'),
      '#description' => t('If checked, the user will be able to re-order the selected items using "Move up" and "Move down" buttons. Also, when adding items they will remain in the order they were added instead of keeping the order of the original field.'),
      '#default_value' => $config->get('orderable', FALSE),
    );

    $form['groupresetfilter'] = array(
      '#type' => 'checkbox',
      '#title' => t('Reset filter when selecting a group'),
      '#description' => t('If checked and a select has optgroups, when a group is selected the filter text field is cleared. If unchecked, any existing filter will be applied only to items of the selected group.'),
      '#default_value' => $config->get('groupresetfilter', FALSE),
    );

    $form['button_text'] = array(
      '#type' => 'fieldset',
      '#title' => t('Button text'),
      '#description' => t('Set the text used for the improved multi-select buttons.'),
    );
    $form['button_text']['buttontext_add'] = array(
      '#type' => 'textfield',
      '#title' => t('Add button'),
      '#default_value' => $config->get('buttontext_add', '>'),
    );
    $form['button_text']['buttontext_addall'] = array(
      '#type' => 'textfield',
      '#title' => t('Add all button'),
      '#default_value' => $config->get('buttontext_addall', '»'),
    );
    $form['button_text']['buttontext_del'] = array(
      '#type' => 'textfield',
      '#title' => t('Remove button'),
      '#default_value' => $config->get('buttontext_del', '<'),
    );
    $form['button_text']['buttontext_delall'] = array(
      '#type' => 'textfield',
      '#title' => t('Remove all button'),
      '#default_value' => $config->get('buttontext_delall', '«'),
    );
    $form['button_text']['buttontext_moveup'] = array(
      '#type' => 'textfield',
      '#title' => t('Move up button'),
      '#default_value' => $config->get('buttontext_moveup', 'Move up'),
      '#states' => array(
        // Hide the settings when the move buttons are disabled.
        'invisible' => array(
          ':input[name="orderable"]' => array('checked' => FALSE),
        ),
      ),
    );
    $form['button_text']['buttontext_movedown'] = array(
      '#type' => 'textfield',
      '#title' => t('Move down button'),
      '#default_value' => $config->get('buttontext_movedown', 'Move down'),
      '#states' => array(
        // Hide the settings when the move buttons are disabled.
        'invisible' => array(
          ':input[name="orderable"]' => array('checked' => FALSE),
        ),
      ),
    );


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values_to_save = array(
      'isall',
      'url',
      'selectors',
      'filtertype',
      'orderable',
      'groupresetfilter',
      'buttontext_add',
      'buttontext_addall',
      'buttontext_del',
      'buttontext_delall',
      'buttontext_moveup',
      'buttontext_movedown',
    );

    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      if (!array_search($key, $values_to_save)) {
        unset($values[$key]);
      }
    }

    $this->config('ims.settings')->setData($values)->save();
  }

}
