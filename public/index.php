<?php

define('THALLIUM', true);
define('THALLIUM_DEBUG', true);
define('THALLIUM_PUBLIC', realpath(__DIR__));
define('THALLIUM_SRC', realpath(__DIR__ . '/../src'));

require_once '../vendor/autoload.php';

use \Thallium\Core\Thallium;
$app = Thallium::init();

$app->get('/', function($req, $res) {
    $res->send( 'hello index!<br>' );
    $res->render_file(__DIR__ . '/' . 'testpage.php');
});

$app->get('/about', function($req, $res) {
    $res->send(  'hello about!' );
});

$app->get('/hello/{name}', function($req, $res) {
    $res->send(  'Hello ' . $req->getParam('name') );
});

Thallium::get('/item/{num#number}', function($req, $res) {
    $res->send( var_dump($req) );
    $res->send(  'Item ' . $req->getParam('num') );
});

Thallium::all('/bodytest', function($req, $res) {
    $res->send( '' . var_dump($req) );
    $res->send( ''. var_dump($req->getBody()) );
    // var_dump($_POST);
    // var_dump(file_get_contents('php://input'));
    $res->send( 'SUCCESS!' );
});

$app->react();
