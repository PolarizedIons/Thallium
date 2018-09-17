<?php
namespace PolarizedIons\Thallium\Core;

use PolarizedIons\Thallium\Core\Core;
use PolarizedIons\Thallium\Interfaces\ICore;

if (!defined('THALLIUM')) exit(1);

class Thallium {
    private static $core;

    public static function init(): ICore {
        self::$core = new Core;
        return self::$core;
    }

    public static function manage(string $key, $component) {
        self::$core->manage($key, $component);
    }

    public static function fetch($key)
    {
        return self::$core->fetch($key);
    }


    public static function router(): IRouter {
        return self::$core->router();
    }

    public function get($route, $callback): IRoute {
        return self::router()->get($route, $callback);
    }

    public function post($route, $callback): IRoute {
        return self::router()->post($route, $callback);
    }

    public function put($route, $callback): IRoute {
        return self::router()->put($route, $callback);
    }

    public function delete($route, $callback): IRoute {
        return self::router()->delete($route, $callback);
    }

    public function option($route, $callback): IRoute {
        return self::router()->option($route, $callback);
    }
}
