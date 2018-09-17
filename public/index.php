<?php

define('THALLIUM', true);

define('THALLIUM_DEBUG', true);
define('THALLIUM_PUBLIC', realpath(__DIR__));
define('THALLIUM_ROOT', realpath(THALLIUM_PUBLIC . DIRECTORY_SEPARATOR . '..'));
define('THALLIUM_SRC', realpath(THALLIUM_ROOT . DIRECTORY_SEPARATOR . 'src'));

require_once THALLIUM_SRC . '/bootstrap.php';

use \PolarizedIons\Thallium\Core\Thallium;
new Thallium;
