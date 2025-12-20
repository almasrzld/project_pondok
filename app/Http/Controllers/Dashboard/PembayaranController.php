<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\SantriDetail;
use App\Models\JenisPembayaran;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayaran = Pembayaran::with(['santri.user', 'jenisPembayaran'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('santri.user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status_pembayaran', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.dashboard.pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $santris = SantriDetail::with('user')
            ->where('status_pendaftaran', 'verified')
            ->get();

        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();

        return view(
            'pages.dashboard.pembayaran.create',
            compact('santris', 'jenisPembayaran')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id'           => 'required|exists:santri_detail,id',
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'bulan'               => 'required|string|max:20',
            'tahun'               => 'required|digits:4',
            'tanggal_bayar'       => 'required|date',
        ], [
            'santri_id.required'           => 'Santri wajib dipilih',
            'santri_id.exists'             => 'Santri tidak ditemukan',
            'jenis_pembayaran_id.required' => 'Jenis pembayaran wajib dipilih',
            'jenis_pembayaran_id.exists'   => 'Jenis pembayaran tidak ditemukan',
            'bulan.required'               => 'Bulan wajib diisi',
            'tahun.required'               => 'Tahun wajib diisi',
            'tahun.digits'                 => 'Tahun harus berupa 4 digit angka',
            'tanggal_bayar.required'       => 'Tanggal bayar wajib diisi',
            'tanggal_bayar.date'           => 'Tanggal bayar harus berupa tanggal yang valid',
        ]);

        $jenisPembayaran = JenisPembayaran::findOrFail($request->jenis_pembayaran_id);

        Pembayaran::create([
            'santri_id'           => $request->santri_id,
            'admin_id'            => auth()->id(),
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'bulan'               => $request->bulan,
            'tahun'               => $request->tahun,
            'jumlah'              => $jenisPembayaran->harga,
            'tanggal_bayar'       => $request->tanggal_bayar,
            'status_pembayaran'   => 'pending',
        ]);

        toastr()->success('Pembayaran berhasil ditambahkan');

        return redirect()->route('dashboard.pembayaran.index');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $santris = SantriDetail::with('user')
            ->where('status_pendaftaran', 'verified')
            ->get();

        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();

        return view(
            'pages.dashboard.pembayaran.edit',
            compact('pembayaran', 'santris', 'jenisPembayaran')
        );
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'jenis_pembayaran_id' => 'required|exists:jenis_pembayarans,id',
            'bulan'               => 'required|string|max:20',
            'tahun'               => 'required|digits:4',
            'tanggal_bayar'       => 'required|date',
            'status_pembayaran'   => 'required|in:pending,lunas',
        ], [
            'jenis_pembayaran_id.required' => 'Jenis pembayaran wajib dipilih',
            'jenis_pembayaran_id.exists'   => 'Jenis pembayaran tidak ditemukan',
            'bulan.required'               => 'Bulan wajib diisi',
            'tahun.required'               => 'Tahun wajib diisi',
            'tahun.digits'                 => 'Tahun harus berupa 4 digit angka',
            'tanggal_bayar.required'       => 'Tanggal bayar wajib diisi',
            'tanggal_bayar.date'           => 'Tanggal bayar harus berupa tanggal yang valid',
            'status_pembayaran.required'   => 'Status pembayaran wajib diisi',
            'status_pembayaran.in'         => 'Status pembayaran tidak valid',
        ]);

        $jenisPembayaran = JenisPembayaran::findOrFail($request->jenis_pembayaran_id);

        $pembayaran->update([
            'jenis_pembayaran_id' => $request->jenis_pembayaran_id,
            'bulan'               => $request->bulan,
            'tahun'               => $request->tahun,
            'jumlah'              => $jenisPembayaran->harga,
            'tanggal_bayar'       => $request->tanggal_bayar,
            'status_pembayaran'   => $request->status_pembayaran,
        ]);

        toastr()->success('Pembayaran berhasil diperbarui');

        return redirect()->route('dashboard.pembayaran.index');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        toastr()->success('Pembayaran berhasil dihapus');

        return redirect()->route('dashboard.pembayaran.index');
    }
}
