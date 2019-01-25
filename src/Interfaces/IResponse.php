<?php
namespace Thallium\Interfaces;


if (!defined('THALLIUM')) exit(1);

interface IResponse {
    public function sendHeaders();
    public function sendBody();

    public function echo(string $ouput);
    public function render_file(string $template_path);
}
