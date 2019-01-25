<?php
namespace Thallium\Routes;

use \Thallium\Interfaces\IView;

if (!defined('THALLIUM')) exit(1);

class View implements IView {
    private $template_path;
    private $data;

    public function __construct($template_path) {
        if (! \file_exists($template_path)) {
            if (\file_exists(THALLIUM_APP . '/' . $template_path)) {
                $template_path = THALLIUM_APP . '/' . $template_path;
            }
            else {
                throw new \Exception("Template " . $template_path . " not found", 1);

            }
        }

        $this->template_path = $template_path;
        $this->data = [];
    }

    public function set(string $key, $value) {
        $this->data[$key] = $value;
    }

    protected function get_file_content() {
        extract($this->data);
        \ob_start();
        require $this->template_path;
        return \ob_get_clean();
    }

    public function render() {
        $output = $this->get_file_content();
        
        foreach ($this->data as $key => $value) {
            $toReplace = "[@$key]";
            $output = \str_replace($toReplace, $value, $output);
        }

        return $output;
    }
}
