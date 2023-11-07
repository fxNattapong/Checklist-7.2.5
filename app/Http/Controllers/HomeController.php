<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    public function Home() {
        $data = [];
        $data['title'] = "Home Page";

        return view('Home', compact('data'));
    }

    public function Login() {
        $data = [];
        $data['title'] = "Register Page";

        return view('Login', compact('data'));
    }

    public function Register() {
        $data = [];
        $data['title'] = "Register Page";

        echo Session::get('alert');
        $status = Session::get('alert');
        if($status === '1') {
            $data['status'] = '1';
        }
        
        return view('Register', compact('data'));
    }

    public function Template() {
        $data = [];
        $data['title'] = 'Template';

        return view('DarkSideBar', compact('data'));
    }
}
