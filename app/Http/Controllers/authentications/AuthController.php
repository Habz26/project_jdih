<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🟢 Register user baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:operator,admin',
            'nip' => 'required|string|max:20|unique:users', // validasi NIP (ubah ke nullable jika opsional)
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

    // 🟡 Login user
    public function login(Request $request)
    {
        $credentials = $request->only('nip', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user->role === 'admin') {
                return redirect()->route('dashboard-analytics-pages');
            } elseif ($user->role === 'operator') {
                return redirect()->route('dashboard-analytics-pages');
            } else {
                auth()->logout();
                return redirect()
                    ->back()
                    ->withErrors(['role' => 'Role tidak dikenali.']);
            }
        }

        return redirect()
            ->back()
            ->withErrors(['nip' => 'NIP atau password salah.']);

    }

    // 🔴 Logout user
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth-login-basic');
    }

    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
    }

    public function showLoginForm()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
        // pastikan view ini ada
    }
}
