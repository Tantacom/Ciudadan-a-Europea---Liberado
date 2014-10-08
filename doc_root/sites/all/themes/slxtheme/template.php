<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 * 
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "slxtheme" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "slxtheme".
 * 2. Uncomment the required function to use.
 */


function slxtheme_menubar($vars) {
  $output = '';
  $output .= '<div id="' . $vars['menubar_id'] . '" class="' . $vars['classes'] . '"' . $vars['attributes'] . '>';
  $output .= '<nav ' . $vars['content_attributes'] . '>';
  if ($vars['menubar_id'] =='primary-menu-bar') $output .= render(menu_tree('main-menu'));
    else $output .= $vars['menu'];
  $output .= '</nav></div>';
  return $output;
}

function slxtheme_menu_link__main_menu(array $variables) {

  $element = $variables['element'];
  if ($element['#original_link']['depth'] == 2) {
    static $count = 0;
    $zebra = ($count % 2) ? 'even' : 'odd';
    $count++;
    $element['#attributes']['class'][] = $zebra;
    $element['#attributes']['class'][] = 'item-'.$count;
  }

  $sub_menu = '';
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], array_merge($element['#localized_options'], array('absolute' => TRUE)));
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function slxtheme_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];
  $url = file_create_url($file->uri);
  $icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }
  
  $tamanio = explode('length=',$options['attributes']['type']);
    
  return '<span class="file">' . ' ' . l($link_text, $url, $options) . $icon . ' ('._slxtheme_formatBytes($tamanio[1],2).')</span>';
}

function slxtheme_file_icon($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'slxtheme') . '/img';
  $mime = check_plain($file->filemime);
  $icon_url = file_icon_url($file, $icon_directory);
  return '<img alt="" class="file-icon" src="' . $icon_url . '" title="' . $mime . '" />';
}

function _slxtheme_formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'Kb', 'Mb', 'Gb', 'Tb');
  
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
  
    $bytes /= pow(1024, $pow);
  
    return round($bytes, $precision) . ' ' . $units[$pow]; 
}

/**
 * Returns HTML for a date element formatted as a single date.
 */
function slxtheme_date_display_single($variables) {
  $date = $variables['date'];
  $timezone = $variables['timezone'];
  $attributes = $variables['attributes'];

  // Wrap the result with the attributes.
  return '<time class="date-display-single"' . drupal_attributes($attributes) . '>' . $date . $timezone . '</time>';
}

/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions

function slxtheme_process_block(&$vars) {
}
// */

/**
 * Preprocess variables for block.tpl.php
 */
function slxtheme_preprocess_block(&$vars) {
  unset($vars['content_attributes_array']['class']);
  $vars['content_attributes_array']['class'][] = 'block-content';
}

/**
 * Override or insert variables for the page templates.
 */
function slxtheme_preprocess_page(&$vars) {
    // dsm($vars);
    if (isset($vars['node']) && ($vars['node']->type == 'noticias' || $vars['node']->type == 'pagina_basica')) $vars['page']['css'] = 'withRelated';
    if (isset($vars['theme_hook_suggestions']) && $vars['theme_hook_suggestions'][0] == 'page__actualidad_del_viajero') $vars['page']['css'] = 'withRelated';
    // print_r($_POST);
    // $vars['post'] = $_POST;
}
/* -- Delete this line if you want to use these functions
function slxtheme_process_page(&$vars) {
}
// */

function slxtheme_breadcrumb($vars) {
  global $theme_key;
  $theme_name = 'slxtheme';

  $breadcrumb = $vars['breadcrumb'];

    if (at_get_setting('breadcrumb_home', $theme_name) == 0) {
      //array_shift($breadcrumb);
    }

    // Remove the rather pointless breadcrumbs for reset password and user
    // register pages, they link to the page you are on.
    if (arg(0) === 'user' && (arg(1) === 'password' || arg(1) === 'register')) {
      array_pop($breadcrumb);
    }

    if (!empty($breadcrumb)) {
      $output = '<ul class="breadcrumb"><li>';
      foreach ($breadcrumb as $key => $val) {
          $output .= '<li>' . $val . '</li>';
      }
      $output.= '<li>' .drupal_get_title(). '</li></ul>';

      return $output;
    }
}


/*function slxtheme_preprocess_views_view(&$vars) {
  //dsm($vars);
  if (isset($vars['view']->name)) {
    $function = 'slxtheme_preprocess_views_view_fields__' . $vars['view']->name . '__' . $vars['view']->current_display;
   
    if (function_exists($function)) {
     $function($vars);
    }
  }
}

function slxtheme_preprocess_views_view_fields__noticias__page(&$vars) {
  $viewname = 'noticias_rss';
  $display_id = 'page'; // or any other display
  $view = views_get_view($viewname);
  $view->set_display($display_id);
  print $view->preview();
  dsm($view);
}
*/
/**
 * Preprocess variables for the html template.
 */
/* -- Delete this line to enable.
function slxtheme_preprocess_html(&$vars) {
  global $theme_key;

  // Two examples of adding custom classes to the body.
  
  // Add a body class for the active theme name.
  // $vars['classes_array'][] = drupal_html_class($theme_key);

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  // $vars['classes_array'][] = css_browser_selector();

}
// */


/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function slxtheme_process_html(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function slxtheme_preprocess_node(&$vars) {
}
function slxtheme_process_node(&$vars) {
}
// */


/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function slxtheme_preprocess_comment(&$vars) {
}
function slxtheme_process_comment(&$vars) {
}
// */



