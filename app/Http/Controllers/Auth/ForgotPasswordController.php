<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Link reset password berhasil dikirim ke email Anda. Silakan cek inbox atau folder spam'
            );
        }

        if ($status === Password::INVALID_USER) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar di sistem',
            ]);
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan, silakan coba lagi',
        ]);
    }
}
