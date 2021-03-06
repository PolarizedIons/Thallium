<?php
namespace Thallium\Routes;

use Thallium\Core\Thallium;
use Thallium\Interfaces\IRouter;
use Thallium\Interfaces\IRequest;
use Thallium\Interfaces\IResponse;
use Thallium\Interfaces\IRoute;


if (!defined('THALLIUM')) exit(1);

class Router implements IRouter {
    private $routes = array();

    public function create(string $method, string $path, $callback): IRoute {
        $route = new Route($method, $path, $callback);
        array_push($this->routes, $route);
        return $route;
    }

    public function routeRequest(IRequest $request, IResponse $response) {
        foreach ($this->routes as $route) {
            if ($route->matches($request)) {
                $route->run($request, $response);
                return;
            }
        }

        Thallium::errorRouter()->show(404, $request, $response);
    }

    public function get(string $path, $callback): IRoute {
        return $this->create('GET', $path, $callback);
    }

    public function post(string $path, $callback): IRoute {
        return $this->create('POST', $path, $callback);
    }

    public function put(string $path, $callback): IRoute {
        return $this->create('PUT', $path, $callback);
    }

    public function delete(string $path, $callback): IRoute {
        return $this->create('DELETE', $path, $callback);
    }

    public function patch(string $path, $callback): IRoute {
        return $this->create('PATCH', $path, $callback);
    }

    public function option(string $path, $callback): IRoute {
        return $this->create('OPTION', $path, $callback);
    }

    public function all(string $path, $callback): IRoute {
        return $this->create('*', $path, $callback);
    }
}
