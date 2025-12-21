<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $santri = $user->santriDetail;

        return view('pages.base.profil', compact('user', 'santri'));
    }

    public function edit()
    {
        $user = Auth::user();
        $santri = $user->santriDetail;

        return view('pages.base.profil-edit', compact('user', 'santri'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required'     => 'Nama wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.min'      => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        toastr()->success('Profil akun berhasil diperbarui');

        return redirect()->route('profile.index');
    }
}
