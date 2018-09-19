<?php
namespace Thallium\Interfaces;

use Thallium\Interfaces\IRouter;
use Thallium\Interfaces\IRequest;
use Thallium\Interfaces\IResponse;


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
