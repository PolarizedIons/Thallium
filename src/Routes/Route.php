<?php
namespace PolarizedIons\Thallium\Routes;

use \PolarizedIons\Thallium\Core\Thallium;
use \PolarizedIons\Thallium\Interfaces\IRoute;
use \PolarizedIons\Thallium\Interfaces\IRequest;


if (!defined('THALLIUM')) exit(1);

class Route implements IRoute {
    private $method;
    private $path;
    private $exec;

    public function __construct($method, $path, $callback)
    {
        $this->method = $method;
        $this->path = $this->parsePath($path);
        $this->exec = $callback;
    }

    private function parsePath(string $path) {
        return $path; // TODO: temp
    }

    public function matches(IRequest $request): bool {
        return $request->method === $this->method &&
            $request->path === $this->path; // TODO: temp
    }

    public function run(IRequest $request) {
        ($this->exec)($request, Thallium::fetch('response'));
    }

}
