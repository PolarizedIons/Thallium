<?php
namespace Thallium\Net;

use \Thallium\Interfaces\IResponse;
use \Thallium\Interfaces\IView;
use \Thallium\Routes\View;

if (!defined('THALLIUM')) exit(1);

class Response implements IResponse {
    private $body;
    private $headers;
    private $view;

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

    public function echo(string $value) {
            $this->body .= $value;
    }

    public function template($name): IView {
        $this->view = new View($name);
        return $this->view;
    }

    public function render() {
        if (isset($this->view)) {
            $this->body .= $this->view->render();
            return $this->body;
        }
    }

    public function render_file(string $template_path) {
        \ob_start();
        include $template_path;
        $this->body .= \ob_get_clean();
    }
}
