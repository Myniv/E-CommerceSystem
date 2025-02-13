<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function development(): string
    {
        return view('welcome_message');
    }
    public function production(): string
    {
        return view('production_page');
    }
    public function aboutUs(): string
    {
        return view('about_us');
    }
}
