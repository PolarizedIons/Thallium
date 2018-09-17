<?php
namespace PolarizedIons\Thallium\Routes\Paths\Parsers;

use PolarizedIons\Thallium\Routes\Paths\ArgParser;


if (!defined('THALLIUM')) exit(1);

class CaptureArg extends ArgParser {
    public function match(string $value): ?array {
        return array($this->name, $value);
    }
}