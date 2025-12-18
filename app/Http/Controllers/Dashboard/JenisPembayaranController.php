<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $jenisPembayaran = JenisPembayaran::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'pages.dashboard.jenis-pembayaran.index',
            compact('jenisPembayaran')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:jenis_pembayarans,nama',
        ], [
            'nama.required' => 'Nama jenis pembayaran wajib diisi',
            'nama.unique'   => 'Nama jenis pembayaran sudah ada dalam database',
        ]);

        JenisPembayaran::create([
            'nama' => $request->nama,
        ]);

        toastr()->success('Jenis pembayaran berhasil ditambahkan');
        return redirect()->route('dashboard.jenis-pembayaran.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:jenis_pembayarans,nama,' . $id,
        ], [
            'nama.required' => 'Nama jenis pembayaran wajib diisi',
            'nama.unique'   => 'Nama jenis pembayaran sudah ada dalam database',
        ]);

        JenisPembayaran::findOrFail($id)->update([
            'nama' => $request->nama,
        ]);

        toastr()->success('Jenis pembayaran berhasil diperbarui');

        return back();
    }

    public function destroy($id)
    {
        JenisPembayaran::findOrFail($id)->delete();

        toastr()->success('Jenis pembayaran berhasil dihapus');
        return back();
    }
}
