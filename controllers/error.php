<?php

namespace Controllers;

class Error extends \App\Controller
{
    public function index()
    {
        return $this->render('error');
    }

    public function error404($params) {
        $params['customMessage'] = 'Path not found';
        return $this->render('error', $params);
    }

    public function error500($params) {
        return $this->render('error', $params);
    }
}