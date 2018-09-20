<?php

define('THALLIUM', true);
define('THALLIUM_DEBUG', true);
define('THALLIUM_PUBLIC', realpath(__DIR__));
define('THALLIUM_SRC', realpath(__DIR__ . '/../src'));

require_once '../vendor/autoload.php';

use \Thallium\Core\Thallium;
$app = Thallium::init();

$app->get('/', function($req, $res) {
    echo 'hello index!';
});

$app->get('/about', function($req, $res) {
    echo 'hello about!';
});

$app->get('/hello/{name}', function($req, $res) {
    echo 'Hello ' . $req->getParam('name');
});

Thallium::get('/item/{num#number}', function($req, $res) {
    var_dump($req);
    echo 'Item ' . $req->getParam('num');
});

Thallium::all('/bodytest', function($req, $res) {
    var_dump($req);
    var_dump($req->getBody());
    // var_dump($_POST);
    // var_dump(file_get_contents('php://input'));
    echo 'SUCCESS!';
});

$app->react();
