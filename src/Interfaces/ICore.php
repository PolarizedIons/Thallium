<?php
namespace PolarizedIons\Thallium\Interfaces;

if (!defined('THALLIUM')) exit(1);


interface ICore
{
    public function manage(string $key, $component);
    public function fetch(string $key);
    public function run();

    public function router(): IRouter;
    public function get($route, $callback): IRoute;
}
