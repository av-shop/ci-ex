<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        $this->require_valid_user();
        return view('auth/user');
    }
    
    public function admin()
    {
        $this->require_group('administradores');
        return view('auth/admin');
    }
}