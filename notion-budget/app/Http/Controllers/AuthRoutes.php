<?php

namespace App\Http\Controllers;

class AuthRoutes
{
    public function profile()
    {
        return view('profile');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function workspace()
    {
        return view('workspace');
    }
}
