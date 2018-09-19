<?php
namespace PolarizedIons\Thallium\Interfaces;

use PolarizedIons\Thallium\Interfaces\IRouter;
use PolarizedIons\Thallium\Interfaces\IRequest;
use PolarizedIons\Thallium\Interfaces\IResponse;


if (!defined('THALLIUM')) exit(1);

interface IRouter
{
    public function routeRequest(IRequest $request, IResponse $response);

    public function get(string $path, $callback): IRoute;
    public function post(string $path, $callback): IRoute;
    public function put(string $path, $callback): IRoute;
    public function delete(string $path, $callback): IRoute;
    public function patch(string $path, $callback): IRoute;
    public function option(string $path, $callback): IRoute;
    public function all(string $path, $callback): IRoute;
}
