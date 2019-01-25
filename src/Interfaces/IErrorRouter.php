<?php
namespace Thallium\Interfaces;

use Thallium\Interfaces\IErrorRoute;
use Thallium\Interfaces\IRequest;
use Thallium\Interfaces\IResponse;


if (!defined('THALLIUM')) exit(1);

interface IErrorRouter
{
    public function create(int $code, string $page);

    public function show(int $code, IRequest $request, IResponse $response);
}
