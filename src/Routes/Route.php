<?php
namespace PolarizedIons\Thallium\Routes;

use \PolarizedIons\Thallium\Core\Thallium;
use \PolarizedIons\Thallium\Interfaces\IRoute;
use \PolarizedIons\Thallium\Interfaces\IRequest;
use \PolarizedIons\Thallium\Routes\Paths\Path;


if (!defined('THALLIUM')) exit(1);

class Route implements IRoute {
    private $method;
    private $path;
    private $exec;

    public function __construct($method, $path, $callback)
    {
        $this->method = $method;
        $this->path = new Path($path);
        $this->exec = $callback;
    }

    public function matches(IRequest $request): bool {
        return $request->method === $this->method && $this->path->match($request);
    }

    public function run(IRequest $request) {
        ($this->exec)($request, Thallium::fetch('response'));
    }
}