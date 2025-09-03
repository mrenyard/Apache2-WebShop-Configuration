<?php
/**
 * Check conditions are right for Debug mode and if so enable.
 */
if (strpos($_SERVER["HTTP_HOST"], 'dev.') === 0) {
  if ((ini_get('display_errors')) || (ini_get('display_startup_errors'))) {
    define('DEV_MODE', \TRUE);
  }
}
