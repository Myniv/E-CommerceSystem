<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function aboutUs(): string
    {
        return view('about_us');
    }
}
