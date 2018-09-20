<?php
namespace Thallium\Routes;

use \Thallium\Core\Thallium;
use \Thallium\Interfaces\IRoute;
use \Thallium\Interfaces\IRequest;
use \Thallium\Interfaces\IResponse;
use \Thallium\Routes\Paths\Path;


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
        return ($this->method === '*' || $request->getMethod() === $this->method) && $this->path->match($request);
    }

    public function run(IRequest $request, IResponse $response) {
        ($this->exec)($request, $response);
    }
}
