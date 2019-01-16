<?php
namespace Thallium\Routes\Paths;

use \Thallium\Interfaces\IRequest;
use \Thallium\Routes\Paths\PathParser;


if (!defined('THALLIUM')) exit(1);

class Path {
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
        // If the root was requested & this is the root path, return true.
        if ($this->fullPath === '/' && $request->getPath() === '/') {
            return true;
        }

        // Get rid of any 'empty' segments in the requested path
        $path = \array_values(\array_filter(\explode('/', $request->getPath())));

        // If the amount of segments in the requested path doesn't math this one,
        // we know it won't match
        if (sizeof($path) != sizeof($this->segments)) {
            return false;
        }

        $params = array();
        for ($i = 0; $i < sizeof($path); $i++) {
            $arg = $this->segments[$i];
            $match = $arg->match($path[$i]);

            // Argument didn't match, this is not the path they're looking for.
            if ($match === null) {
                return false;
            }
            if (! $match[0]) {
                continue;
            }

            // Store the 'name' and captured value of the arguments in the path
            $params[$match[0]] = $match[1];
        }

        // Save the arguments from above in the request
        $request->addParams($params);

        // We found our match
        return true;
    }
}
