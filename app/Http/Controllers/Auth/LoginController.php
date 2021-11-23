<?php

namespace App\Http\Controllers\Auth;

class LoginController
{
    public function getLogin() {
        return view('auth/login');
    }

    public function getRegister(){
        return view('auth/register');
    }
}
