<?php
namespace Thallium\Routes\Paths;

use \Thallium\Interfaces\IRequest;
use \Thallium\Routes\Paths\PathParser;


if (!defined('THALLIUM')) exit(1);

class Path {
    private static $ARG_REGEX = "/{([a-zA-Z]+)(?:#([[a-zA-Z]+)(?::([a-zA-Z1-9,=]+))?)?}/";

    private $fullPath;
    private $segments;
    private $pathParser;

    public function __construct(string $path) {
        // Get rid of any double slashes, and make sure we have at least one if the path is the root
        $urlSegments = \array_filter(\explode('/', $path));
        $this->fullPath = \implode('/', $urlSegments) ?: '/';

        $this->pathParser = new PathParser($urlSegments);

        $this->segments = $this->pathParser->getSegments();
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
