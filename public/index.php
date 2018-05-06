<?php

define('ROOTPATH', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);

require ROOTPATH . '/App/App.php';

App::init();
App::$kernel->launch();