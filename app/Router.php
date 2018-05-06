<?php
namespace App;

class Router
{
    public function resolve()
    {
        $route = null;
        if(($pos = strpos($_SERVER['REQUEST_URI'], '?')) !== false) {
            $route = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }
        $route = is_null($route) ? $_SERVER['REQUEST_URI'] : $route;
        if (substr($route, 0 , 1) == '/') {
            $route = substr($route, 1);
        }
        $route = explode('/', $route);
        $result[0] = array_shift($route);
        $result[1] = array_shift($route);
        $result[2] = $route;
        return $result;
    }
}