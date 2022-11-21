<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    /**
     * Mostrar el login o el Dashboard según la sesión.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return view('auth.login');
    }
}
