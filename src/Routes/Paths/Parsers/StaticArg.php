<?php
namespace Thallium\Routes\Paths\Parsers;

use Thallium\Routes\Paths\PathArgument;


if (!defined('THALLIUM')) exit(1);

class StaticArg extends PathArgument {
    public function match(string $value): ?array {
        return $this->name === $value ? array('', $value) : null;
    }
}