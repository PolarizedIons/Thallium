<?php
namespace Thallium\Routes\Paths;

use \Thallium\Routes\Paths\Parsers\StaticArg;
use \Thallium\Routes\Paths\Parsers\CaptureArg;
use \Thallium\Routes\Paths\Parsers\NumberArg;

if (!defined('THALLIUM')) exit(1);

class PathParser {
    private static $ARG_DEFAULT_PARSER = 'capture';
    private static $ARG_PARSER = [
        'capture' => CaptureArg::class,
        'static' => StaticArg::class,
        'number' => NumberArg::class,
    ];

    private $segments;

    public function __construct(array $segments) {
        $this->segments = array();

        foreach ($segments as $segment) {
            array_push($this->segments, $this->parseArg($segment));
        }
    }

    public function getSegments(): array {
        return $this->segments;
    }

    private function parseArg(string $arg): PathArgument {
        $name = '';
        $type = '';
        $options = '';

        // Parse the arguments, each by using a "string reader" approach.
        // with the special case of if it doesn't start with a '{', it is a
        // static type argument

        // {id#number:foo=bar,bar=baz}
        // Phases of parsing; 0 = name, 1 = type, 2 = options
        $phase = 0;
        $endedProperly = false;
        $i = 0;
        for (; $i < \strlen($arg); $i++) {
            $char = \substr($arg, $i, 1);

            // Parsing arg id
            if ($phase === 0) {
                if ($i === 0) {
                    if ($char === '{') {
                        continue;
                    }
                    else {
                        $type = 'static';
                        $endedProperly = true;
                    }
                }

                else if ($char === '#') {
                    $phase = 1;

                    if ($type === 'static') {
                        break;
                    }
                    continue;
                }
                else if ($char === '}') {
                    $endedProperly = true;
                    $i++;
                    break;
                }


                $name .= $char;
            }

            // Parsing arg type
            else if ($phase === 1) {
                if ($char === ':') {
                    $phase = 2;
                    continue;
                }
                else if ($char === '}')
                {
                    $endedProperly = true;
                    $i++;
                    break;
                }

                $type .= $char;
            }

            // Parsing arg options
            else if ($phase === 2) {
                if ($char === '}') {
                    $endedProperly = true;
                    break;
                }

                $options .= $char;
            }
        }

        // Make sure the argument has a type
        if ($type === '') {
            $type = $this::$ARG_DEFAULT_PARSER;
        }

        // Put the options into an array
        $options = explode(',', $options);

        // Error checking
        $charsLeft = \strlen($arg) - $i;
        if ($charsLeft !== 0) {
            $left = \substr($arg, $i);
            throw new \Exception("There were $charsLeft characters left in argument '$arg': '$left'", 1);
        }
        else if (! $endedProperly) {
            throw new \Exception("Did not end argument properly", 1);
        }
        else if (! array_key_exists($type, $this::$ARG_PARSER)) {
            throw new \Exception("'$type' is not a valid argument type");
        }

        // We did it - create a argument class of type
        return $this->createArgument($name, $type, $options);
    }

    private function createArgument(string $name, string $type = '*', array $options = []) {
        $cls = $this::$ARG_PARSER[$type];
        $r = new \ReflectionClass($cls);
        return $r->newInstanceArgs([$name, $type, $options]);
    }
}
