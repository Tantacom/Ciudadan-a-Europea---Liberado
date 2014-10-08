<?php
/**
 * @file
 * Administrative page callbacks for the Mobile Switch module.
 */

/**
 * Form constructor for the Basic settings form.
 *
 * @ingroup forms
 */
function mobile_switch_settings_form() {
  $module_path = drupal_get_path('module', 'mobile_switch');
  drupal_add_js($module_path . '/js/mobile_switch.admin.js', array('scope' => 'footer'));

  $form = array();
  $active_themes = array_merge(array('none' => t('Do not use')), mobile_switch_get_themes());

  // Check the imported/fetched Mobile Detect class version number.
  $version = variable_get('mobile_detect_import_version', 0);

  $form['global_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Theme settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE
  );
  $form['global_settings']['mobile_switch_mobile_theme'] = array(
    '#type' => 'select',
    '#title' => t('Mobile theme'),
    '#description' => t('Which theme should be used as default theme when a mobile device detected.'),
    '#options' => $active_themes,
    '#default_value' => variable_get('mobile_switch_mobile_theme', 'none')
  );
  $form['global_settings']['mobile_switch_tablet_usage'] = array(
    '#type' => 'select',
    '#title' => t('Tablet device'),
    '#description' => t('Use the mobile theme when a mobile device tablet detected.'),
    '#options' => array(
      TRUE => t('Yes'),
      FALSE => t('No')
    ),
    '#default_value' => variable_get('mobile_switch_tablet_usage', 1),
    // #states not usable here; it exists problems with mobile jQuery.
  );
  $form['global_settings']['mobile_switch_admin_usage'] = array(
    '#type' => 'select',
    '#title' => t('Administration usage'),
    '#description' => t('Use the mobile theme on administration pages when a mobile device detected.'),
    '#options' => array(
      FALSE => t('No'),
      TRUE => t('Yes')
    ),
    '#default_value' => variable_get('mobile_switch_admin_usage', 0),
    // #states not usable here; it exists problems with mobile jQuery.
  );

  $form['#submit'][] = 'mobile_switch_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Form constructor for the Advanced settings form.
 *
 * @ingroup forms
 */
function mobile_switch_advanced_settings_form() {
  if (variable_get('mobile_switch_mobile_theme', 'none') === 'none') {
    return mobile_switch_theme_message();
  }

  $module_path = drupal_get_path('module', 'mobile_switch');
  drupal_add_js($module_path . '/js/mobile_switch.admin.js', array('scope' => 'footer'));

  $form['preventing'] = array(
    '#type' => 'fieldset',
    '#title' => t('Preventing'),
    '#description' => t('Prevention of mobile devices. This allows to bypass mobile devices the automatic switching to the mobile theme.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#states' => array(
      'invisible' => array(
        ':input[name="mobile_switch_mobile_theme"]' => array('value' => 'none')
      )
    )
  );
  $form['preventing']['mobile_switch_prevent_devices'] = array(
    '#type' => 'select',
    '#title' => t('Use preventing'),
    '#options' => array(
      FALSE => t('No'),
      TRUE => t('Yes'),
    ),
    '#default_value' => variable_get('mobile_switch_prevent_devices', 0)
  );
  $description['mobile_switch_prevent_devices_strings'] = t("Configure user agent string parts. Use letters, single white spaces or underscores - no other characters! Do not use the '*' wildcard character! Enter one string per line. Example string parts: <pre>htc_flyer\niPad\nSony Tablet S\nXOOM</pre> The string detection is case insensitive.");
  $description['mobile_switch_prevent_devices_strings'] .= ' ' . t('Get a user agent string: In the !development-settings under <em>Developer modus</em> -> <em>Advanced developer modus settings</em> use the <em>Display user agent</em> option.', array('!development-settings' => l(t('Development settings'), 'admin/config/user-interface/mobile-switch/development')));
  $form['preventing']['mobile_switch_prevent_devices_strings'] = array(
    '#type' => 'textarea',
    '#title' => t('Mobile devices identification for preventing'),
    '#description' => $description['mobile_switch_prevent_devices_strings'],
    '#default_value' => variable_get('mobile_switch_prevent_devices_strings', ''),
    '#required' => FALSE,
    // #states not usable here; it exists problems with mobile jQuery.
    '#element_validate' => array('_mobile_switch_prevent_devices_strings_validate')
  );

  $form['#submit'][] = 'mobile_switch_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Form constructor for the Development settings form.
 *
 * @ingroup forms
 */
function mobile_switch_development_settings_form() {
  if (variable_get('mobile_switch_mobile_theme', 'none') === 'none') {
    return mobile_switch_theme_message();
  }

  $module_path = drupal_get_path('module', 'mobile_switch');
  drupal_add_js($module_path . '/js/mobile_switch.admin.js', array('scope' => 'footer'));

  $form['development'] = array(
    '#type' => 'fieldset',
    '#title' => t('Development'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#prefix' => '<div class="development-settings">' . t('Mobile Switch can help to develop a mobile site.') . '</div>',
    '#states' => array(
      'invisible' => array(
        ':input[name="mobile_switch_mobile_theme"]' => array('value' => 'none')
      )
    )
  );
  $form['development']['mobile_switch_developer'] = array(
    '#type' => 'select',
    '#title' => t('Developer modus'),
    '#description' => t('Extends the browser detection for desktop emulators such as <em>Opera mobile</em>, <em>Fennec</em> or more other. Don\'t use it on production sites.'),
    '#options' => array(
      FALSE => t('No'),
      TRUE => t('Yes')
    ),
    '#default_value' => variable_get('mobile_switch_developer', 0)
  );
  $advanced_collapsed = FALSE;
  if (variable_get('mobile_switch_display_useragent', 0) || variable_get('mobile_switch_display_mobiledetectinfo', 0)) {
    $advanced_collapsed = TRUE;
  }
  $form['development']['advanced'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced developer modus settings'),
    '#collapsible' => TRUE,
    '#collapsed' => $advanced_collapsed ? FALSE : TRUE
  );
  $form['development']['advanced']['mobile_switch_emulator_strings'] = array(
    '#type' => 'textarea',
    '#title' => t('Mobile emulator identification'),
    '#description' => t("Configure user agent string parts. Use letters, single white spaces or underscores - no other characters! Do not use the '*' wildcard character! Enter one string per line. As example the default string parts: <pre>Fennec\nAndroid\nTablet\nMobi</pre> The string detection is case insensitive."),
    '#default_value' => variable_get('mobile_switch_emulator_strings', "Fennec\nAndroid\nTablet\nMobi"),
    '#required' => TRUE,
    '#element_validate' => array('_mobile_switch_emulator_strings_validate')
  );
  $form['development']['advanced']['mobile_switch_display_useragent'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display user agent'),
    '#description' => t('Use this function to display a message that contains a user agent string. Do not forget to turn off this option. For the display is required: the permissions %administer-site-configuration or %administer-themes.', array('%administer-site-configuration' => t('Administer site configuration'), '%administer-themes' => t('Administer themes'))),
    '#default_value' => variable_get('mobile_switch_display_useragent', 0)
  );
  $form['development']['advanced']['mobile_switch_display_mobiledetectinfo'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display Mobile Detect informations'),
    '#description' => t('Use this function to display detailed Mobile Detect informations. Do not forget to turn off this option. For the display is required: the permissions %administer-site-configuration or %administer-themes.', array('%administer-site-configuration' => t('Administer site configuration'), '%administer-themes' => t('Administer themes'))),
    '#default_value' => variable_get('mobile_switch_display_mobiledetectinfo', 0)
  );
  $form['development']['mobile_switch_deskbrowser'] = array(
    '#type' => 'select',
    '#title' => t('Desktop browser'),
    '#description' => t('Use the %mobile-theme with desktop browsers. Do not forget to turn off this option on production sites.', array('%mobile-theme' => t('Mobile theme'))),
    '#options' => array(
      FALSE => t('No'),
      TRUE => t('Yes')
    ),
    '#default_value' => variable_get('mobile_switch_deskbrowser', 0)
  );

  $form['#submit'][] = 'mobile_switch_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Helper function to display a message.
 *
 * The message are displayed on the Advanced and Development form if no
 * mobile theme enabled.
 *
 * @see mobile_switch_advanced_settings_form()
 * @see mobile_switch_development_settings_form()
 */
function mobile_switch_theme_message() {
  $message = t('Please configure the !basic-settings and enable a mobile theme.', array('!basic-settings' => l(t('Basic settings'), 'admin/config/user-interface/mobile-switch')));
  $enable['mobile_switch_theme_message']['#markup'] = $message;

  return $enable;
}

/**
 * Form submission handler for multiple mobile switch setting forms.
 *
 * @see mobile_switch_settings_form()
 * @see mobile_switch_advanced_settings_form()
 * @see mobile_switch_development_settings_form()
 */
function mobile_switch_settings_form_submit($form, &$form_state) {
  // It exist problems if used a "mobile jQuery" based theme as mobile theme.
  // This problems cannot be solved here.
  drupal_flush_all_caches();
  drupal_set_message(t('Caches cleared.'), 'status');
}

/**
 * Render API callback: Validates the user agent string parts.
 *
 * Ensures that only letters and no blank lines has been entered.
 *
 * This function is assigned as an #element_validate callback in
 * mobile_switch_settings_form().
 */
function _mobile_switch_prevent_devices_strings_validate($element, &$form_state) {
  if (preg_match("/[^a-z][^\na-z]|[a-z][^\na-z]$|.{0}\n$/i", $element['#value'])) {
    form_error($element, t('%title: Use only the described characters and no blank lines.', array('%title' => t($element['#title']))));
  }
}

/**
 * Render API callback: Validates the user agent string parts.
 *
 * Ensures that only letters and no blank lines has been entered.
 *
 * This function is assigned as an #element_validate callback in
 * mobile_switch_settings_form().
 */
function _mobile_switch_emulator_strings_validate($element, &$form_state) {
  if (preg_match("/[^a-z][^\na-z]|[a-z][^\na-z]$|.{0}\n$/i", $element['#value'])) {
    form_error($element, t('%title: Use only the described characters and no blank lines.', array('%title' => t($element['#title']))));
  }
}
