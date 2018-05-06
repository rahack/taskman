<?php

namespace App;

class Controller
{

    public function renderLayout ($body)
    {
        ob_start();
        require ROOTPATH . DS . 'views' . DS . 'layout' . DS . "layout.php";
        return ob_get_clean();
    }

    public function render ($viewName, array $params = [])
    {
        $viewFile = ROOTPATH . DS . 'views' . DS . $viewName . '.php';
        extract($params);
        ob_start();
        require $viewFile;
        $body = ob_get_clean();
        ob_end_clean();
        return $this->renderLayout($body);
    }

}