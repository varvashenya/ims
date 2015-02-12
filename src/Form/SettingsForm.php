<?php

/**
 * @file
 * Contains \Drupal\improved_multi_select\Form\SettingsForm.
 */

namespace Drupal\improved_multi_select\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures improved_multi_select settings.
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
  protected function getEditableConfigNames() {
    return ['improved_multi_select.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('improved_multi_select.settings');

    $form['isall'] = [
      '#type' => 'checkbox',
      '#title' => t('Replace all multi-select lists'),
      '#default_value' => $config->get('isall'),
    ];

    $form['url'] = [
      '#type' => 'textarea',
      '#title' => t('Replace multi-select lists on specific pages'),
      '#description' => t("Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", [
        '%blog' => 'blog',
        '%blog-wildcard' => 'blog/*',
        '%front' => '<front>'
      ]),
      '#default_value' => $config->get('url'),
    ];

    $form['selectors'] = [
      '#type' => 'textarea',
      '#title' => t('Replace multi-select with specified selectors'),
      '#description' => t('Enter jQuery selectors (one selector per line). Example: select[multiple]'),
      '#default_value' => $config->get('selectors'),
    ];

    $form['vertical_tabs'] = array(
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-filtertype',
    );
    $form['button'] = [
      '#tree' => TRUE,
      'filtertypewrapper' => [
        '#type' => 'details',
        '#group' => 'vertical_tabs',
        '#title' => t('Filter functionality'),
        '#tree' => FALSE,
        'filtertype' => [
          '#type' => 'radios',
          '#description' => t('Choose how you would like the filter textfield to function.'),
          '#options' => [
            'partial' => t('Partial match: Shows options that contain the filter text.'),
            'exact' => t('Exact match: Shows options that exactly match the filter text.'),
            'anywords' => t('Any words: Shows options that contain any of the individual words in the filter text. Only exact word matches count.'),
            'anywords_partial' => t('Any words (partial): Shows options that contain any of the individual words in the filter text. Partial word matches count.'),
            'allwords' => t('All words: Shows options that contain all of the individual words in the filter text (in any order). Only exact word matches count.'),
            'allwords_partial' => t('All words (partial): Shows options that contain all of the individual words in the filter text (in any order). Partial word matches count.'),
          ],
          '#default_value' => $config->get('filtertype'),
        ],
        'orderable' => [
          '#type' => 'checkbox',
          '#title' => t('Allow re-ordering of selected items'),
          '#description' => t('If checked, the user will be able to re-order the selected items using "Move up" and "Move down" buttons. Also, when adding items they will remain in the order they were added instead of keeping the order of the original field.')
            . '<br /><b>' . t('Note: items sorting should supported by form backend.') . '</b>',
          '#default_value' => $config->get('orderable'),
        ],
        'groupresetfilter' => [
          '#type' => 'checkbox',
          '#title' => t('Reset filter when selecting a group'),
          '#description' => t('If checked and a select has optgroups, when a group is selected the filter text field is cleared. If unchecked, any existing filter will be applied only to items of the selected group.'),
          '#default_value' => $config->get('groupresetfilter'),
        ],
      ],

      'text' => [
        '#type' => 'details',
        '#group' => 'vertical_tabs',
        '#title' => t('Button text'),
        '#description' => t('Set the text used for the improved multi-select buttons.'),
        'add' => [
          '#type' => 'textfield',
          '#title' => t('Add button'),
          '#default_value' => $config->get('button.text.add'),
        ],
        'addall' => [
          '#type' => 'textfield',
          '#title' => t('Add all button'),
          '#default_value' => $config->get('button.text.addall'),
        ],
        'del' => [
          '#type' => 'textfield',
          '#title' => t('Remove button'),
          '#default_value' => $config->get('button.text.del'),
        ],
        'delall' => [
          '#type' => 'textfield',
          '#title' => t('Remove all button'),
          '#default_value' => $config->get('button.text.delall'),
        ],
        'moveup' => [
          '#type' => 'textfield',
          '#title' => t('Move up button'),
          '#default_value' => $config->get('button.text.moveup'),
          // Hide the settings when the move buttons are disabled.
          '#states' => ['invisible' => [':input[name="orderable"]' => ['checked' => FALSE],],],
        ],
        'movedown' => [
          '#type' => 'textfield',
          '#title' => t('Move down button'),
          '#default_value' => $config->get('button.text.movedown'),
          // Hide the settings when the move buttons are disabled.
          '#states' => ['invisible' => [':input[name="orderable"]' => ['checked' => FALSE],],],
        ],
      ],

      'hint' => [
        '#type' => 'details',
        '#group' => 'vertical_tabs',
        '#title' => t('Button hint'),
        '#description' => t('Set the text used for the improved multi-select buttons.'),
        'add' => [
          '#type' => 'textfield',
          '#title' => t('Add button'),
          '#default_value' => $config->get('button.hint.add'),
        ],
        'addall' => [
          '#type' => 'textfield',
          '#title' => t('Add all button'),
          '#default_value' => $config->get('button.hint.addall'),
        ],
        'del' => [
          '#type' => 'textfield',
          '#title' => t('Remove button'),
          '#default_value' => $config->get('button.hint.del'),
        ],
        'delall' => [
          '#type' => 'textfield',
          '#title' => t('Remove all button'),
          '#default_value' => $config->get('button.hint.delall'),
        ],
        'moveup' => [
          '#type' => 'textfield',
          '#title' => t('Move up button'),
          '#default_value' => $config->get('button.hint.moveup'),
          // Hide the settings when the move buttons are disabled.
          '#states' => ['invisible' => [':input[name="orderable"]' => ['checked' => FALSE],],],
        ],
        'movedown' => [
          '#type' => 'textfield',
          '#title' => t('Move down button'),
          '#default_value' => $config->get('button.hint.movedown'),
          '#states' => ['invisible' => [':input[name="orderable"]' => ['checked' => FALSE],],],
        ],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values_to_save = [
      'isall',
      'url',
      'selectors',
      'filtertype',
      'orderable',
      'groupresetfilter',
      'button',
    ];

    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      if (array_search($key, $values_to_save) === FALSE) {
        unset($values[$key]);
      }
    }

    $this->config('improved_multi_select.settings')->setData($values)->save();
  }

}
