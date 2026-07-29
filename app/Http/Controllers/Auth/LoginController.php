<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginAttempt;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $ip = $request->ip();

        if (LoginAttempt::isBlocked($ip)) {
            return back()->with('error', 'Terlalu banyak percobaan login ganda. Silakan tunggu 15 menit.')->withInput($request->only('email'));
        }

        $input = trim($request->input('email'));
        $password = $request->input('password');

        // Check matching email or username or admin variants
        $user = \App\Models\User::where('email', strtolower($input))
            ->orWhere('name', $input)
            ->orWhere('email', 'admin@desapebadaran.id')
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            Auth::login($user);
            LoginAttempt::reset($ip);

            $user->last_login_at = now();
            $user->save();

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        LoginAttempt::recordAttempt($ip, $input);

        return back()->with('error', 'Email / Username atau password yang Anda masukkan salah.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
