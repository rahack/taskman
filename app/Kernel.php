<?php

namespace App;

use App;

class Kernel
{
    public $defaultControllerName = 'home';
    public $defaultActionName = "index";

    public function launch()
    {
        list($controllerName, $actionName, $params) = App::$router->resolve();
        echo $this->launchAction($controllerName, $actionName, $params);
    }

    public function launchAction($controllerName, $actionName, $params)
    {
        $controllerName = empty($controllerName) ? $this->defaultControllerName : $controllerName;
        if(!file_exists(ROOTPATH . DS . 'controllers' . DS . $controllerName . '.php')){
            throw new \App\Exceptions\InvalidRouteException();
        }
        require_once ROOTPATH . DS . 'controllers' . DS . $controllerName . '.php';
        if(!class_exists("\\Controllers\\".ucfirst($controllerName))){
            throw new \App\Exceptions\InvalidRouteException();
        }
        $controllerName = "\\Controllers\\".ucfirst($controllerName);
        $controller = new $controllerName;
        $actionName = empty($actionName) ? $this->defaultActionName : $actionName;
        if (!method_exists($controller, $actionName)) {
            throw new \App\Exceptions\InvalidRouteException();
        }
        return $controller->$actionName($params);
    }
}