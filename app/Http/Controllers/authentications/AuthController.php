<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // 🟢 REGISTER USER BARU
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator,admin',
            'nip' => 'required|string|max:20|unique:users',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip, // 👈 ini ditambah
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'operator',
        ]);

        Auth::login($user); // langsung login setelah register

        return redirect()->route('dashboard-analytics-pages')->with('success', 'Register sukses, selamat datang!');
    }

    // 🟡 LOGIN USER
    public function login(Request $request)
{
    // 1️⃣ Validasi input biasa (nip, password, captcha wajib diisi)
    $request->validate([
        'nip' => 'required|string',
        'password' => 'required|string',
        'g-recaptcha-response' => 'required', // cukup required, verifikasi manual
    ]);

    // 2️⃣ Verifikasi reCAPTCHA ke Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET_KEY'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    $body = $response->json();

    if (!isset($body['success']) || $body['success'] !== true) {
        return redirect()->back()->withErrors(['captcha' => 'Captcha tidak valid.']);
    }

    // 3️⃣ Validasi kredensial login
    $credentials = $request->only('nip', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'operator') {
            return redirect()->route('dashboard-analytics-pages');
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['role' => 'Role tidak dikenali.']);
        }
    }

    return redirect()->back()->withErrors(['nip' => 'NIP atau password salah.']);
}


    // 🔴 LOGOUT USER
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth-login-basic');
    }

    // 📄 HALAMAN REGISTER
    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
    }

    // 📄 HALAMAN LOGIN
    public function showLoginForm()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
    }
}
