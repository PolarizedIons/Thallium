<?php
namespace Thallium\Routes\Paths\Parsers;

use Thallium\Routes\Paths\ArgParser;


if (!defined('THALLIUM')) exit(1);

class StaticArg extends ArgParser {
    public function match(string $value): ?array {
        return $this->name === $value ? array('', $value) : null;
    }
}