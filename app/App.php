<?php

class App
{
    public static $router;
    public static $db;
    public static $kernel;
    public static $auth;

    public static function init()
    {
        spl_autoload_register(['static','loadClass']);
        static::bootstrap();
        set_exception_handler(['App','handleException']);
    }

    public static function bootstrap()
    {
        static::$router = new App\Router();
        static::$kernel = new App\Kernel();
        static::$db = new App\Db();
        static::$auth = new App\Auth();
    }

    public static function loadClass($className)
    {
        $className = str_replace('\\', DS, $className);
        if (file_exists(ROOTPATH . DS . $className . '.php')) {
            require_once ROOTPATH . DS . $className . '.php';
        } else if (file_exists(ROOTPATH . DS . lcfirst($className) . '.php')) {
            require_once ROOTPATH . DS . lcfirst($className) . '.php';
        }
    }

    public static function handleException(Throwable $e)
    {
        if($e instanceof \App\Exceptions\InvalidRouteException) {
            echo static::$kernel->launchAction('Error', 'error404', ['errorObject' => $e]);
        }else{
            echo static::$kernel->launchAction('Error', 'error500', ['errorObject' => $e]);
        }
    }
}