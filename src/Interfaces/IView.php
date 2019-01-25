<?php
namespace Thallium\Interfaces;


if (!defined('THALLIUM')) exit(1);

interface IView
{
    public function set(string $key, $value);
    public function render();
}
