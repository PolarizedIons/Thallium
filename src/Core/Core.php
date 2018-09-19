<?php
namespace PolarizedIons\Thallium\Core;

use PolarizedIons\Thallium\Routes\Router;
use PolarizedIons\Thallium\Routes\Request;
use PolarizedIons\Thallium\Routes\Response;
use PolarizedIons\Thallium\Interfaces\ICore;
use PolarizedIons\Thallium\Interfaces\IRouter;
use PolarizedIons\Thallium\Interfaces\IRoute;


if (!defined('THALLIUM')) exit(1);

class Core implements ICore {
    private $components;
    private static $bootstrapped = false;

    public function __construct()
    {
        if (! $this::$bootstrapped) {
            require_once(THALLIUM_SRC . '/bootstrap.php');
            $this::$bootstrapped = true;
        }

        $this->components = array();

        $this->store('core', $this);
        $this->store('router', function() { return new Router; });
        $this->store('request', function() { return Request::createFromGlobals(); });
        $this->store('response', function() { return new Response; });
    }

    public function store(string $key, $component) {
        $this->components[$key] = $component;
    }

    public function fetch(string $key) {
        if (! array_key_exists($key, $this->components)) {
            return null;
        }

        $component = $this->components[$key];
        if (is_callable($component)) {
            $component = $this->components[$key] = $component();
        }

        return $component;
    }

    public function react() {
        $request = $this->fetch('request');
        $response = $this->fetch('response');
        $this->router()->routeRequest($request, $response);
    }



    public function router(): IRouter {
        return $this->fetch('router');
    }

    public function get($route, $callback): IRoute {
        return $this->router()->get($route, $callback);
    }

    public function post($route, $callback): IRoute {
        return $this->router()->post($route, $callback);
    }

    public function put($route, $callback): IRoute {
        return $this->router()->put($route, $callback);
    }

    public function delete($route, $callback): IRoute {
        return $this->router()->delete($route, $callback);
    }

    public function patch($route, $callback): IRoute {
        return $this->router()->patch($route, $callback);
    }

    public function option($route, $callback): IRoute {
        return $this->router()->option($route, $callback);
    }

    public function all($route, $callback): IRoute {
        return $this->router()->all($route, $callback);
    }
}
