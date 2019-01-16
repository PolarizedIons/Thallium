<?php
namespace Thallium\Interfaces;

if (!defined('THALLIUM')) exit(1);


interface ICore
{
    public function store(string $key, $component);
    public function fetch(string $key);
    public function react();

    public function router(): IRouter;
    public function errorRouter(): IErrorRouter;

    public function get($route, $callback): IRoute;
}
