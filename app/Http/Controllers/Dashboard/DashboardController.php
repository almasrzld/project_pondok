<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SantriDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmin = User::where('role', 'admin')->count();
        $totalSantri = SantriDetail::where('status_pendaftaran', 'verified')->count();
        $totalPendaftar = SantriDetail::count();
        $totalSantriAktif = SantriDetail::whereHas('pembayaran', function ($q) {
            $q->whereHas('jenisPembayaran', function ($jp) {
                $jp->where('nama', 'Daftar Ulang');
            })
            ->where('status_pembayaran', 'lunas');
        })->count();
        $santriTerbaru = SantriDetail::with('user')
            ->whereHas('pembayaran', function ($q) {
                $q->whereHas('jenisPembayaran', function ($jp) {
                    $jp->where('nama', 'Daftar Ulang');
                })
                ->where('status_pembayaran', 'lunas');
            })
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard.index', compact(
            'totalAdmin',
            'totalSantri',
            'totalSantriAktif',
            'totalPendaftar',
            'santriTerbaru'
        ));
    }
}
