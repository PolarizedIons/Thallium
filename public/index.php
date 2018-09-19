<?php

define('THALLIUM', true);

define('THALLIUM_DEBUG', true);
define('THALLIUM_PUBLIC', realpath(__DIR__));
define('THALLIUM_ROOT', realpath(THALLIUM_PUBLIC . DIRECTORY_SEPARATOR . '..'));
define('THALLIUM_SRC', realpath(THALLIUM_ROOT . DIRECTORY_SEPARATOR . 'src'));

require_once THALLIUM_SRC . '/bootstrap.php';

use \PolarizedIons\Thallium\Core\Thallium;
$app = Thallium::init();

$app->get('/', function($req, $res) {
    echo 'hello index!';
});

$app->get('/about', function($req, $res) {
    echo 'hello about!';
});

$app->get('/hello/{name}', function($req, $res) {
    echo 'Hello ' . $req->params['name'];
});

Thallium::get('/item/{num#number}', function($req, $res) {
    echo 'Item ' . $req->params['num'];
});

$app->run();
