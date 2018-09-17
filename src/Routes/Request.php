<?php
namespace PolarizedIons\Thallium\Routes;

use PolarizedIons\Thallium\Interfaces\IRequest;


if (!defined('THALLIUM')) exit(1);

class Request implements IRequest {
    public $method;
    public $path;
    public $params = array();

    public function __construct($method, $path)
    {
        $this->method = $method;
        $this->path = $path;
    }

    public static function createFromGlobals(): Request {
        return new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
