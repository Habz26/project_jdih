<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
            'nip' => 'required|string|max:20|unique:users', // validasi NIP
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'operator',
        ]);

        // Login langsung setelah register
        Auth::login($user);

        // 🔁 Arahkan berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/analytics')->with('success', 'Registrasi sukses, selamat datang Admin!');
        } elseif ($user->role === 'operator') {
            return redirect('/manage/analytics')->with('success', 'Registrasi sukses, selamat datang Operator!');
        }

        // Jika role tidak dikenali
        return redirect()->route('auth-login-basic')->withErrors(['role' => 'Role tidak dikenali.']);
    }

    // 🟡 LOGIN USER
    public function login(Request $request)
    {
        $credentials = $request->only('nip', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();

            // 🔁 Arahkan sesuai role
            if ($user->role === 'admin') {
                return redirect('/analytics');
            } elseif ($user->role === 'operator') {
                return redirect('/manage/analytics');
            } else {
                auth()->logout();
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
