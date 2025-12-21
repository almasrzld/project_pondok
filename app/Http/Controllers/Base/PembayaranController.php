<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $santri = auth()->user()->santriDetail;

        if (!$santri) {
            toastr()->error('Data santri tidak ditemukan');
            return redirect()->back();
        }

        $pembayaranList = $santri->pembayaran()
            ->with('jenisPembayaran')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.base.pembayaran', compact(
            'santri',
            'pembayaranList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembayaran_id'    => 'required|exists:pembayaran,id',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'pembayaran_id.required' => 'Pilih tagihan terlebih dahulu',
            'pembayaran_id.exists' => 'Tagihan tidak ditemukan',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berformat jpg, jpeg, atau png',
            'bukti_pembayaran.max' => 'Ukuran maksimal file adalah 2MB',
        ]);

        $santri = auth()->user()->santriDetail;

        $pembayaran = Pembayaran::where('id', $request->pembayaran_id)
            ->where('santri_id', $santri->id)
            ->firstOrFail();

        if (!$pembayaran) {
            toastr()->error('Data pembayaran tidak ditemukan');
            return redirect()->back();
        }

        if ($pembayaran->status_pembayaran === 'lunas') {
            toastr()->warning('Tagihan ini sudah lunas');
            return redirect()->back();
        }

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $pembayaran->update([
            'bukti_pembayaran' => $buktiPath,
            'status_pembayaran' => 'pending',
            'updated_at' => now(),
        ]);

        toastr()->success('Bukti pembayaran berhasil diunggah. Menunggu verifikasi');

        return redirect()->route('pembayaran');
    }
}
