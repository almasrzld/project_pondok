<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.dashboard.akun.index', compact('users'));
    }

    public function create()
    {
        return view('pages.dashboard.akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,santri',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib diisi',
            'role.in' => 'Role tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        toastr()->success('Akun berhasil ditambahkan');

        return redirect()
            ->route('dashboard.akun.index');
    }

    public function edit(User $akun)
    {
        return view('pages.dashboard.akun.edit', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $akun->id,
            'role' => 'required|in:admin,santri',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib diisi',
        ]);

        if ($akun->role === 'admin') {
            $request->merge(['role' => 'admin']);
        }

        $akun->update($request->only('name', 'email', 'role'));

        toastr()->success('Akun berhasil diperbarui');

        return redirect()
            ->route('dashboard.akun.index');
    }

    public function destroy(User $akun)
    {
        $akun->delete();

        toastr()->success('Akun berhasil dihapus');

        return back();
    }
}

