<?php
namespace Thallium\Routes\Paths\Parsers;

use Thallium\Routes\Paths\PathArgument;


if (!defined('THALLIUM')) exit(1);

class CaptureArg extends PathArgument {
    public function match(string $value): ?array {
        return array($this->name, $value);
    }
}