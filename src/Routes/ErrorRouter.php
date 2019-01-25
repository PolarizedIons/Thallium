<?php
namespace Thallium\Routes;

use Thallium\Interfaces\IErrorRouter;
use Thallium\Interfaces\IErrorRoute;
use Thallium\Interfaces\IRequest;
use Thallium\Interfaces\IResponse;


if (!defined('THALLIUM')) exit(1);

class ErrorRouter implements IErrorRouter {
    private $routes = array();

    public function __construct() {
        $this->create(404, dirname(__FILE__) . '/ErrorPages/404.php');
    }

    public function create(int $code, string $page) {
        $this->routes[$code] = $page;
    }

    public function show(int $code, IRequest $request, IResponse $response) {
        if (! array_key_exists($code, $this->routes)) {
            $code = 500;
        }

        $response->render_file($this->routes[$code]);
    }
}
