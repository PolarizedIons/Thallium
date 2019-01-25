<?php

define('THALLIUM', true);
define('THALLIUM_DEBUG', true);
define('THALLIUM_PUBLIC', realpath(__DIR__));
define('THALLIUM_SRC', realpath(__DIR__ . '/../src'));
define('THALLIUM_APP', realpath(__DIR__ . '/../app'));

require_once '../vendor/autoload.php';

use \Thallium\Core\Thallium;
$app = Thallium::init();

$app->get('/', function($req, $res) {
    $res->echo( 'hello index!<br>' );
    // $res->render_file(THALLIUM_APP . '/' . 'testpage.php');
    $view = $res->template('testpage.php');
    $view->set('name', "Stephan");
});

$app->get('/about', function($req, $res) {
    $res->echo(  'hello about!' );
});

$app->get('/hello/{name}', function($req, $res) {
    $res->echo(  'Hello ' . $req->getParam('name') );
});

Thallium::get('/item/{num#number}', function($req, $res) {
    $res->echo( var_dump($req) );
    $res->echo(  'Item ' . $req->getParam('num') );
});

Thallium::all('/bodytest', function($req, $res) {
    $res->echo( '' . var_dump($req) );
    $res->echo( ''. var_dump($req->getBody()) );
    // var_dump($_POST);
    // var_dump(file_get_contents('php://input'));
    $res->echo( 'SUCCESS!' );
});

$app->react();
