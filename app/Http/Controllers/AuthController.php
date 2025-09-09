<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReCaptchaServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
            'g-recaptcha-response' => 'required',
        ]);

        // cek apakah email ada
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->onlyInput('email');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->onlyInput('email');
        }

        $captcha = ReCaptchaServices::verify($request->input('g-recaptcha-response'));

        if (!$captcha['success'] ?? false  || ($captcha['score'] ?? 0) < 0.5) {
            return back()->withErrors(['captcha' => 'Verifikasi ReCaptcha gagal, coba lagi.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
