<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function redirectUser()
    {
        if (auth()->user()->roles->pluck('name')->first() == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user');
        }
    }
}
