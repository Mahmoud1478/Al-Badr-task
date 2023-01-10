<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function loginForm() :View
    {
        return view('admin.auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email'=> ['required','email'],
            'password'=> ['required']
        ]);
        if(!auth('admin')->attempt($data, isset($request->remember_me))){
            return redirect()->back()->with('error', 'wrong credentials');
        };
        return redirect()->route('admin.dashboard');
    }

    public function logout(): RedirectResponse
    {
        auth('admin')->logout();
        session()->invalidate();
        return redirect('/');
    }
}
