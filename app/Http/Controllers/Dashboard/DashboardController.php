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
        $totalSantri = User::where('role', 'santri')->count();
        $totalPendaftar = SantriDetail::distinct('user_id')
            ->count('user_id'); 

        return view('pages.dashboard.index', compact(
            'totalAdmin',
            'totalSantri',
            'totalPendaftar'
        ));
    }
}
