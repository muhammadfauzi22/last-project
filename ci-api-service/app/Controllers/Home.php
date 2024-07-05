<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function login()
    {
        return view('user\login');
    }

    public function test()
    {
        return view('test_page');
    }
}
