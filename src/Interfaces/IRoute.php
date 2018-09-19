<?php
namespace Thallium\Interfaces;


if (!defined('THALLIUM')) exit(1);

interface IRoute
{
    public function matches(IRequest $request): bool;
    public function run(IRequest $request, IResponse $response);
}
