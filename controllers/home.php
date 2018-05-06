<?php

namespace Controllers;

use App;

class Home extends \App\Controller
{
    public function index()
    {
        $rows = \Models\Tasks::getAll();
        $login = App::$auth->getLogin();
        return $this->render('home', array('rows' => $rows, 'login' => $login));
    }
}