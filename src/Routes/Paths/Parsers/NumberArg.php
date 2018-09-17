<?php
namespace PolarizedIons\Thallium\Routes\Paths\Parsers;

use PolarizedIons\Thallium\Routes\Paths\ArgParser;


if (!defined('THALLIUM')) exit(1);

class NumberArg extends ArgParser {
    public function match(string $value): ?array {
        if (! \is_numeric($value)) {
            return null;
        }
        return \is_int($value + 0) ? array($this->name, (int)$value) : null;
    }
}