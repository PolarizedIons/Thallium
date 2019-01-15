<?php
namespace Thallium\Routes\Paths\Parsers;

use Thallium\Routes\Paths\PathArgument;


if (!defined('THALLIUM')) exit(1);

class NumberArg extends PathArgument {
    public function match(string $value): ?array {
        if (! \is_numeric($value)) {
            return null;
        }
        return \is_int($value + 0) ? array($this->name, (int)$value) : null;
    }
}