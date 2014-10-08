<?php
/**
 * @file
 * Mobile Detect class import functions.
 */

/**
 * Helper function to update the Mobile Detect class file.
 *
 * @param $cron
 *   Optional import environment. If false, display status messages to
 *   the user in addition to logging information with the watchdog.
 */
function _mobile_detect_import_import($cron = TRUE) {
  $current_version_path = 'https://raw.github.com/serbanghita/Mobile-Detect/master/Mobile_Detect.php';

  // Check the local Mobile Detect class version number.
  $local_version = variable_get('mobile_detect_import_version', 0);

  // Retrieve the current Mobile Detect class version number using HTTPS.
  $current_version = $current_file = drupal_http_request($current_version_path);

  // Log an error if the Mobile Detect class version number could not
  // be retrieved.
  if (isset($current_version->error)) {
    // Log a message with the watchdog.
    watchdog('Mobile Detect Import', "Couldn't check version: %error", array('%error' => $current_version->error), WATCHDOG_ERROR);

    // Display a message to the user if the update process
    // was triggered manually.
    if ($cron == FALSE) {
      drupal_set_message(t("Couldn't check Mobile Detect class version: %error", array('%error' => $current_version->error)), 'error');
    }

    return;
  }

  $pattern = '@version\s+([0-9a-zA-Z\.-]+)@';

  $current_version = str_replace(array("\r\n", "\n", "\r"), '|', $current_version->data);
  $current_version_arr = explode("|", $current_version);

  foreach ($current_version_arr as $val) {
    if (preg_match($pattern, $val, $matches)) {
      $current_version = $matches[1];
      break;
    }
  }

  // Compare the current and local version numbers to determine if the
  // Mobile Detect class requires updating.
  if ($current_version == $local_version) {
    // Log a message with the watchdog.
    watchdog('Mobile Detect Import', 'No new version of the Mobile Detect class to import.');

    // Display a message to the user if the update process was triggered
    // manually.
    if ($cron == FALSE) {
      drupal_set_message(t('No new version of the Mobile Detect class to import.'));
    }

    return;
  }

  // Import a new Mobile Detect class file to the files directory.
  if ($current_file->data) {
    $filename = 'Mobile_Detect.php';
    $path = 'public://Mobile_Detect';
    $uri = $path . '/' . $filename;

    file_prepare_directory($path, FILE_CREATE_DIRECTORY);
    if (!file_exists($uri) && !file_unmanaged_save_data($current_file->data, $uri, FILE_EXISTS_REPLACE)) {
      return FALSE;
    }

    // Update the local Mobile Detect class version.
    variable_set('mobile_detect_import_version', $current_version);

    if (variable_get('mobile_detect_import_file_uri', FALSE) == FALSE) {
      variable_set('mobile_detect_import_file_uri', drupal_realpath($uri));
    }

    // Log a message with the watchdog.
    watchdog('Mobile Detect Import', 'The new version %version of the Mobile Detect class imported to the files directory.', array('%version' => $current_version));

    // Display a message to the user if the update process was triggered
    // manually.
    if ($cron == FALSE) {
      drupal_set_message(t('The new version %version of the Mobile Detect class imported to the files directory.', array('%version' => $current_version)));
    }
  }
}
