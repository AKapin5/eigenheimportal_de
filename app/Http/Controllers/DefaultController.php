<?php

namespace App\Http\Controllers;

class DefaultController extends Controller
{
    public function home()
    {
        if (auth()->guest()) {
            return view('welcome');
        } else {
            $users = \App\Models\User::query()->paginate(1);
            return view('dashboard', compact('users'));
        }
    }
}
