<?php
namespace Thallium\Routes\Paths;


if (!defined('THALLIUM')) exit(1);

abstract class PathArgument {
    protected $name;
    protected $type;
    protected $options;

    public function __construct(string $name, string $type, array $options) {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    public abstract function match(string $value): ?array;
}