<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KaryawanAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // First, check if the user exists
        $karyawan = Karyawan::where('email', $request->email)->first();

        if (!$karyawan) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        if (!$karyawan->is_verified) {
            return back()->withErrors([
                'email' => 'Email tidak terverifikasi oleh admin.',
            ])->withInput();
        }

        if (!$karyawan->password) {
            return back()->withErrors([
                'email' => 'Silahkan melakukan registrasi terlebih dahulu.',
            ])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('admin/dashboard');
            }
            return redirect()->intended('karyawan/dashboard');
        }

        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->withInput();
    }

    public function showRegisterForm()
    {
        $jabatans = Jabatan::all();
        return view('auth.register', compact('jabatans'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:25'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // First, find the karyawan record
        $karyawan = Karyawan::where('email', $request->email)->first();

        // Debug check conditions
        if (!$karyawan) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        if (!$karyawan->is_verified) {
            return back()->withErrors([
                'email' => 'Email belum diverifikasi oleh admin.',
            ])->withInput();
        }

        if ($karyawan->password) {
            return back()->withErrors([
                'email' => 'Email sudah terdaftar dan memiliki password.',
            ])->withInput();
        }

        // If all checks pass, update the password
        $karyawan->update([
            'password' => Hash::make($request->password)
        ]);

        Auth::login($karyawan);

        return redirect()->intended($karyawan->role === 'admin' ? 'admin/dashboard' : 'karyawan/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
