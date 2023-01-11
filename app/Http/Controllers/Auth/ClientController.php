<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Jobs\OTPJop;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function loginForm() :View
    {
        return view('clients.auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email'=> ['required','email'],
            'password'=> ['required']
        ]);
        if(! Auth::guard('client')->attempt($data, isset($request->remember_me))){
            return redirect()->back()->with('error', 'wrong credentials');
        };
        return redirect('/welcome');
    }

    public function registerForm()
    {
        return view('clients.auth.register');
    }
    public function register(ClientRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['image'] = Upload::file($data['image'],'clients');
        if ($request->hasFile('drive_licence')){
            $data['drive_licence'] = Upload::file($data['drive_licence'],'clients','licence_');
        }
        $client = Client::create($data);
        $client->send_otp($client->otp()->create());
        auth('client')->login($client);
        return redirect('/welcome');
    }

    public function logout(): RedirectResponse
    {
        auth('client')->logout();
        session()->invalidate();
        return redirect('/');
    }
    public function verify(){
        return view('clients.verify',[
            'client' => \auth('client')->user()
        ]);
    }
    public function try_verify(Request $request)
    {
        $request->validate([
            'code' => ['required','min:5','max:5']
        ]);
        $client = auth('client')->user();
        if ($client->otp->check($request->code)){
            $client->markEmailAsVerified();
            $client->otp()->delete();
            return redirect('/welcome');
        }
        return redirect()->back()->with('error','code is wrong');
    }
    public function resend_otp()
    {
        $client = auth('client')->user();
        $client->otp()->delete();
        $otp = $client->otp()->create();
        $client->send_otp($otp);
        return response()->json([
            'msg' => 'code resent successfully'
        ]);
    }
}
