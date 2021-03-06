<?php
namespace Thallium\Core;

use Thallium\Core\Core;
use Thallium\Interfaces\ICore;
use Thallium\Interfaces\IRoute;
use Thallium\Interfaces\IRouter;
use Thallium\Interfaces\IErrorRouter;


if (!defined('THALLIUM')) exit(1);

class Thallium {
    private static $core;

    public static $version = "0.0.1";

    public static function init(): ICore {
        self::$core = new Core;
        return self::$core;
    }

    public static function core(): ICore {
        return self::$core->fetch('core');
    }

    public static function store(string $key, $component) {
        self::core()->store($key, $component);
    }

    public static function fetch($key) {
        return self::core()->fetch($key);
    }

    public static function react() {
        self::core()->react();
    }


    public static function router(): IRouter {
        return self::core()->router();
    }

    public static function errorRouter(): IErrorRouter {
        return self::core()->errorRouter();
    }

    public static function get($route, $callback): IRoute {
        return self::router()->get($route, $callback);
    }

    public static function post($route, $callback): IRoute {
        return self::router()->post($route, $callback);
    }

    public static function put($route, $callback): IRoute {
        return self::router()->put($route, $callback);
    }

    public static function delete($route, $callback): IRoute {
        return self::router()->delete($route, $callback);
    }

    public static function patch($route, $callback): IRoute {
        return self::router()->patch($route, $callback);
    }

    public static function option($route, $callback): IRoute {
        return self::router()->option($route, $callback);
    }

    public static function all($route, $callback): IRoute {
        return self::router()->all($route, $callback);
    }
}
