<?php
if (!defined('THALLIUM')) exit(1);

if (THALLIUM_DEBUG) {
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors', 'On');
    ini_set('error_reporting', -1);
    ini_set('log_errors', 'On');
}
else {
    ini_set('display_errors', 'Off');
    ini_set('display_startup_errors', 'Off');
    ini_set('error_reporting', E_ALL);
    ini_set('log_errors', 'On');
}

require_once THALLIUM_ROOT . '/vendor/autoload.php';

/**
 * Error handling lib
 */
if (THALLIUM_DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
