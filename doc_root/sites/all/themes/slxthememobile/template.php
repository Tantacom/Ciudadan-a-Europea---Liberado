<?php

function slxthememobile_menubar($vars) {
  $output = '';
  $output .= '<div id="' . $vars['menubar_id'] . '" class="' . $vars['classes'] . '"' . $vars['attributes'] . '>';
  $output .= '<nav ' . $vars['content_attributes'] . '>';
  if ($vars['menubar_id'] =='primary-menu-bar') $output .= render(menu_tree('main-menu'));
    else $output .= $vars['menu'];
  $output .= '</nav></div>';
  return $output;
}


function slxthememobile_file_link($variables) {
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
    
  return '<span class="file">' . ' ' . l($link_text, $url, $options) . $icon . ' ('._slxthememobile_formatBytes($tamanio[1],2).')</span>';
}

function slxthememobile_file_icon($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'slxtheme') . '/img';
  $mime = check_plain($file->filemime);
  $icon_url = file_icon_url($file, $icon_directory);
  return '<img alt="" class="file-icon" src="' . $icon_url . '" title="' . $mime . '" />';
}

function _slxthememobile_formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'Kb', 'Mb', 'Gb', 'Tb');
  
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
  
    $bytes /= pow(1024, $pow);
  
    return round($bytes, $precision) . ' ' . $units[$pow]; 
}


/**
 * Preprocess variables for block.tpl.php
 */
function slxthememobile_preprocess_block(&$vars) {
  unset($vars['content_attributes_array']['class']);
  $vars['content_attributes_array']['class'][] = 'block-content';
}





