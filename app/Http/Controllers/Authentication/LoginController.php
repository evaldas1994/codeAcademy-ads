<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'mail' => ['required', 'mail'],
                'password' => ['required'],
            ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        //redirect

        return back()->withErrors([
            'mail' => 'Email or password is incorrect.',
        ]);
    }
}
