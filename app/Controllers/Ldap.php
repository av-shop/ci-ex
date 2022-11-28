<?php

namespace App\Controllers;

class Ldap extends BaseController
{
    public function index()
    {
        return view('ldap/list', array('users' => $this->directory_search()));
    }
    
    public function detalle($username)
    {
        return view('ldap/detail', array('user' => $this->directory_search($username)[0]));
    }
}