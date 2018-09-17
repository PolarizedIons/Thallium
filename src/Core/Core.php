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

    public function __construct()
    {
        $this->components = array();

        $this->manage('core', $this);
        $this->manage('router', function() { return new Router; });
        $this->manage('request', function() { return Request::createFromGlobals(); });
        $this->manage('response', function() { return new Response; });
    }

    public function manage(string $key, $component) {
        if (! is_callable($component)) {
            $component = function() use($component) {
                return $component;
            };
        }

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

    public function run() {
        $this->router()->matchRoute($this->fetch('request'));
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

    public function option($route, $callback): IRoute {
        return $this->router()->option($route, $callback);
    }

}
