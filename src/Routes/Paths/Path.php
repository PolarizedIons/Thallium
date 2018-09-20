<?php
namespace Thallium\Routes\Paths;

use \Thallium\Interfaces\IRequest;
use \Thallium\Routes\Paths\ArgParser;
use \Thallium\Routes\Paths\Parsers\StaticArg;
use \Thallium\Routes\Paths\Parsers\CaptureArg;
use \Thallium\Routes\Paths\Parsers\NumberArg;


if (!defined('THALLIUM')) exit(1);

class Path {
    private static $ARG_DEFAULT_PARSER = 'capture';
    private static $ARG_PARSER = [
        'capture' => CaptureArg::class,
        'static' => StaticArg::class,
        'number' => NumberArg::class,
    ];
    private static $ARG_REGEX = "/{([a-zA-Z]+)(?:#([[a-zA-Z]+)(?::([a-zA-Z1-9,=]+))?)?}/";

    private $fullPath;
    private $segments;

    public function __construct(string $path) {
        $urlSegments = \array_filter(\explode('/', $path));
        $this->fullPath = \implode('/', $urlSegments) ?: '/';

        $this->segments = array();
        foreach($urlSegments as $segment) {
            $matches = array();
            if (preg_match_all($this::$ARG_REGEX, $segment, $matches, PREG_UNMATCHED_AS_NULL) === 0) {
                array_push($this->segments, $this->createArgParser($segment, 'static'));
                continue;
            }

            $matches = array_map(function ($el) { return $el[0]; }, $matches);
            if ($matches[2] === null) {
                $matches[2] = "*";
            }
            if ($matches[3] === null) {
                $matches[3] = [];
            }
            else {
                $optionPairs = \explode(',', $matches[3]);
                $matches[3] = array_map(function ($el) { return \explode('=', $el); }, $optionPairs);
            }

            array_push($this->segments, $this->createArgParser($matches[1], $matches[2], $matches[3]));
        }

        if (! $this->segments) {
            $this->segments = [$this->createArgParser('', 'static')];
        }
    }

    private function createArgParser(string $name, string $type = '*', array $options = []) {
        if ($type === "*") {
            $type = $this::$ARG_DEFAULT_PARSER;
        }

        if (! array_key_exists($type, $this::$ARG_PARSER)) {
            return null;
        }

        $cls = $this::$ARG_PARSER[$type];
        $r = new \ReflectionClass($cls);
        return $r->newInstanceArgs([$name, $type, $options]);
    }

    public function match(IRequest $request): bool {
        if ($this->fullPath === '/' && $request->getPath() === '/') {
            return true;
        }

        $path = \array_values(\array_filter(\explode('/', $request->getPath())));

        // TODO: this is kinda hacky
        if (sizeof($path) != sizeof($this->segments)) {
            return false;
        }

        $params = array();
        for ($i = 0; $i < sizeof($path); $i++) {
            $arg = $this->segments[$i];
            $match = $arg->match($path[$i]);

            if ($match === null) {
                return false;
            }
            if (! $match[0]) {
                continue;
            }

            $params[$match[0]] = $match[1];
        }

        $request->addParams($params);
        return true;
    }
}
