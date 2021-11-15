<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    public function getLogin() {
        return view('auth/login');
    }

    public function getRegister(){
        return view('auth/register');
    }
}
