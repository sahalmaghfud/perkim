<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi data
        // Diubah: validasi dari 'email' menjadi 'name'
        $credentials = $request->validate([
            'name' => ['required', 'string'], // Menggunakan 'name' dan tipe 'string'
            'password' => ['required'],
        ]);

        // Cek kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // Diubah: Pesan error dan input lama dikembalikan untuk field 'name'
        return back()->withErrors([
            'name' => 'Nama pengguna atau password salah.',
        ])->onlyInput('name');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Memproses permintaan untuk mengganti password pengguna.
     */
    public function changePassword(Request $request)
    {
        // 1. Validasi semua input dari formulir
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru harus minimal 8 karakter.'
        ]);

        $user = Auth::user();

        // 2. Cek apakah password saat ini yang dimasukkan sudah benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini yang Anda masukkan salah.'
            ]);
        }

        // 3. Jika benar, update password di database dengan yang baru
        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // 4. Kembalikan ke halaman ganti password dengan pesan sukses
        return back()->with('status', 'Password Anda telah berhasil diubah!');
    }
}
