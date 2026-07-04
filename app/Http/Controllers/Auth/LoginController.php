<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input + reCAPTCHA
        $request->validate([
            'email'                 => ['required', 'email'],
            'password'              => ['required'],
            'g-recaptcha-response'  => ['required', function ($attribute, $value, $fail) {
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);

                if (!$response->json('success')) {
                    $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                }
            }],
        ], [
            'email.required'                => 'Email wajib diisi.',
            'email.email'                   => 'Format email tidak valid.',
            'password.required'             => 'Password wajib diisi.',
            'g-recaptcha-response.required' => 'Harap centang reCAPTCHA terlebih dahulu.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'Admin'          => redirect()->route('admin.dashboard'),
            'Manajer Gudang' => redirect()->route('manager.dashboard'),
            'Staff Gudang'   => redirect()->route('staff.dashboard'),
            default          => redirect()->route('login'),
        };
    }
}