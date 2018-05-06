<?php

namespace Controllers;

use App;

class User extends \App\Controller
{
    public function auth()
    {
        if (isset($_POST["login"]) && isset($_POST["password"])) {
            if (!App::$auth->auth($_POST["login"], $_POST["password"])) {

            }
        }
        header('Location: /');
    }

    public function out()
    {
        App::$auth->out();
        header('Location: /');
    }
}