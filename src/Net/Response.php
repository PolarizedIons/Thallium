<?php
namespace Thallium\Net;

use \Thallium\Interfaces\IResponse;

if (!defined('THALLIUM')) exit(1);

class Response implements IResponse {
    private $body;
    private $headers;

    public function __construct() {
        $this->body = '';
        $this->headers = array();
    }


    public function sendHeaders() {
        // TODO
    }

    public function sendBody() {
        echo $this->body;
    }

    public function send(string $value) {
        $this->body .= $value;
    }

    public function render_file(string $template_path) {
        \ob_start();
        include $template_path;
        $this->body .= \ob_get_clean();
    }
}
