<?php

/**
 * @file
 * Provides a cache implementation to be used in conjunction with the
 * mobile_switch module.
 *
 * This is only intended to be used as a replacement for the page cache
 * although it can be used as the default cache.
 * It appends the override from the URL or cookie and whether or not
 * the request was from a mobile device to the cache id.
 */

class MobileSwitchDatabaseCache extends DrupalDatabaseCache implements DrupalCacheInterface {

  /**
   * Overrides DrupalDatabaseCache::getMultiple().
   */
  function getMultiple(&$cids) {
    if (is_array($cids)) {
      foreach ($cids as $key => $cid) {
        $cids[$key] = $cid . $this->getExtraCid();
      }
    }
    return parent::getMultiple($cids);
  }

  /**
   * Overrides DrupalDatabaseCache::set().
   */
  function set($cid, $data, $expire = CACHE_PERMANENT) {
    $cid .= $this->getExtraCid();
    return parent::set($cid, $data, $expire);
  }

  protected function getExtraCid() {
    $extra = '';
    if (function_exists('_mobile_switch_block_get_cookie') && _mobile_switch_block_get_cookie()) {
      $extra .= ':' . _mobile_switch_block_get_cookie();
    }
    if (function_exists('mobile_switch_mobile_detect')) {
      $browser = mobile_switch_mobile_detect();
      $extra .= (is_array($browser) && $browser['ismobiledevice']) ? ':mobile' : ':notmobile';
    }
    return $extra;
  }

}
