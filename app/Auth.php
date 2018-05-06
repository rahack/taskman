<?php

namespace App;

class Auth
{
    private $_login = "admin";
    private $_password = "123";

    public function __construct()
    {
        session_start();
    }

    public function isAuth()
    {
        if (isset($_SESSION["is_auth"])) {
            return $_SESSION["is_auth"];
        } else {
            return false;
        }
    }

    public function auth($login, $passwors)
    {
        if ($login == $this->_login && $passwors == $this->_password) {
            $_SESSION["is_auth"] = true;
            $_SESSION["login"] = $login;
            return true;
        }
        else {
            $_SESSION["is_auth"] = false;
            return false;
        }
    }

    public function getLogin()
    {
        if ($this->isAuth()) {
            return $_SESSION["login"];
        }
        return '';
    }


    public function out()
    {
        $_SESSION = array();
        session_destroy();
    }
}