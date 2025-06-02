<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ], [
            'email.unique' => 'Email ini sudah digunakan. Silakan gunakan email lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $res = $user->save();

        if ($res) {
            return back()->with('success', 'Kamu berhasil membuat user!');
        } else {
            return back()->with('fail', 'Terjadi kesalahan, coba lagi.');
        }
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Set session nama user untuk SweetAlert
            $request->session()->flash('login_success', Auth::user()->name);

            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }


    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Buat link reset lengkap dengan email sebagai query parameter
        $resetLink = url('/reset-password/' . $token) . '?email=' . urlencode($request->email);

        // Kirim email dengan token, email, dan resetLink
        Mail::send('emails.forgot', [
            'token' => $token,
            'email' => $request->email,
            'resetLink' => $resetLink,
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Kami telah mengirimkan tautan reset kata sandi ke email Anda!');
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'confirmed',
            ],
            'token' => 'required'
        ]);

        // Cari data reset berdasarkan email dan token
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        // Jika token tidak valid
        if (!$reset) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa.']);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token sudah kedaluwarsa.']);
        }

        // Cek apakah user masih ada
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // Update password user
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token reset password yang sudah dipakai
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Redirect ke halaman login
        return redirect('/login')->with('success', 'Password kamu berhasil direset!');
    }
    public function logout(Request $request)
    {
        $userName = Auth::user()->name;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Pakai flash message seperti pada login
        $request->session()->flash('logout_success', $userName);

        return redirect('/login');
    }
}
